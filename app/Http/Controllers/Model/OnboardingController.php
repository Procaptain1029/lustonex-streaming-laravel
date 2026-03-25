<?php

namespace App\Http\Controllers\Model;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class OnboardingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'role:model']);
    }


    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile) {

            $profile = Profile::create([
                'user_id'             => $user->id,
                'display_name'        => $user->name,
                'bio'                 => __('admin.flash.model.default_bio'),
                'subscription_price'  => 19.99,
                'profile_completed'   => false,
                'verification_status' => 'pending'
            ]);
        }


        if ($profile->isOnboardingComplete() && $profile->verification_status === 'approved') {
            return redirect()->route('model.dashboard');
        }


        if ($profile->verification_status === 'under_review') {
            return redirect()->route('model.dashboard')
                ->with('info', __('admin.flash.model.under_review_no_edit'));
        }

        $nextStep = $profile->getNextStep() ?? 1;

        return redirect()->route('model.onboarding.step', ['step' => $nextStep]);
    }


    public function step($step)
    {
        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile) {
            return redirect()->route('model.onboarding.index');
        }


        if (!in_array($step, [1, 2, 3])) {
            return redirect()->route('model.onboarding.index');
        }


        if ($step > 1 && !$profile->step1_completed) {
            return redirect()->route('model.onboarding.step', ['step' => 1]);
        }
        if ($step > 2 && !$profile->step2_completed) {
            return redirect()->route('model.onboarding.step', ['step' => 2]);
        }

        $progress = $profile->getOnboardingProgress();

        return view('model.onboarding.step' . $step, compact('profile', 'progress', 'step'));
    }


    public function processStep1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'display_name' => 'required|string|max:255',
            'bio' => 'required|string|max:1000',
            'country' => 'required|string|max:100',
            'ethnicity' => 'required|string',
            'body_type' => 'required|string',
            'hair_color' => 'required|string',
            'subscription_price' => 'required|numeric|min:5|max:5000',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'terms_accepted' => 'required|accepted',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        $profile = $user->profile;

        $updateData = $request->only([
            'display_name',
            'bio',
            'country',
            'ethnicity',
            'body_type',
            'hair_color',
            'subscription_price'
        ]);


        if ($request->hasFile('avatar')) {
            if ($profile->avatar) {
                Storage::disk('public')->delete($profile->avatar);
            }
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $updateData['avatar'] = $avatarPath;
        }


        if ($request->hasFile('cover_image')) {
            if ($profile->cover_image) {
                Storage::disk('public')->delete($profile->cover_image);
            }
            $coverPath = $request->file('cover_image')->store('covers', 'public');
            $updateData['cover_image'] = $coverPath;
        }

        $updateData['step1_completed'] = true;
        $updateData['terms_accepted'] = true;
        $updateData['last_profile_update'] = now();

        $profile->update($updateData);

        return redirect()->route('model.onboarding.step', ['step' => 2])
            ->with('success', __('admin.flash.onboarding.step1_success'));
    }


    public function processStep2(Request $request)
    {

        \Log::info('OnboardingController@processStep2 - Inicio', [
            'user_id' => Auth::id(),
            'request_data' => $request->except(['id_document_front', 'id_document_back']),
            'has_front_file' => $request->hasFile('id_document_front'),
            'has_back_file' => $request->hasFile('id_document_back'),
            'all_files' => array_keys($request->allFiles()),
            'content_length' => $request->header('Content-Length'),
            'content_type' => $request->header('Content-Type'),
            'php_max_upload' => ini_get('upload_max_filesize'),
            'php_post_max' => ini_get('post_max_size')
        ]);

        try {
            $validator = Validator::make($request->all(), [
                'legal_name' => 'required|string|max:255',
                'date_of_birth' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
                'id_document_type' => 'required|string|in:cedula,pasaporte,licencia',
                'id_document_front' => 'required|file|mimes:jpeg,png,jpg,pdf|max:10240',
                'id_document_back' => 'required|file|mimes:jpeg,png,jpg,pdf|max:10240',
                'id_document_selfie' => 'required|file|mimes:jpeg,png,jpg|max:10240',
                'age_verified' => 'required|accepted',
            ]);

            if ($validator->fails()) {
                \Log::warning('OnboardingController@processStep2 - Validación falló', [
                    'user_id' => Auth::id(),
                    'errors' => $validator->errors()->toArray()
                ]);
                return back()->withErrors($validator)->withInput();
            }

            $user = Auth::user();
            $profile = $user->profile;

            if (!$profile) {
                \Log::error('OnboardingController@processStep2 - Perfil no encontrado', [
                    'user_id' => Auth::id()
                ]);
                return back()->with('error', __('admin.flash.onboarding.profile_not_found'));
            }


            if (!$request->hasFile('id_document_front') || !$request->hasFile('id_document_back') || !$request->hasFile('id_document_selfie')) {
                \Log::error('OnboardingController@processStep2 - Archivos faltantes', [
                    'user_id' => Auth::id(),
                    'has_front' => $request->hasFile('id_document_front'),
                    'has_back' => $request->hasFile('id_document_back'),
                    'has_selfie' => $request->hasFile('id_document_selfie')
                ]);
                return back()->with('error', __('admin.flash.onboarding.docs_required'));
            }


            $frontFile = $request->file('id_document_front');
            $backFile = $request->file('id_document_back');
            $selfieFile = $request->file('id_document_selfie');

            if (!$frontFile->isValid() || !$backFile->isValid() || !$selfieFile->isValid()) {
                \Log::error('OnboardingController@processStep2 - Archivos inválidos', [
                    'user_id' => Auth::id(),
                    'front_valid' => $frontFile->isValid(),
                    'back_valid' => $backFile->isValid(),
                    'selfie_valid' => $selfieFile->isValid(),
                    'front_error' => $frontFile->getError(),
                    'back_error' => $backFile->getError(),
                    'selfie_error' => $selfieFile->getError()
                ]);
                return back()->with('error', __('admin.flash.onboarding.invalid_files'));
            }

            \Log::info('OnboardingController@processStep2 - Archivos válidos', [
                'user_id' => Auth::id(),
                'front_size' => $frontFile->getSize(),
                'back_size' => $backFile->getSize(),
                'selfie_size' => $selfieFile->getSize(),
                'front_mime' => $frontFile->getMimeType(),
                'back_mime' => $backFile->getMimeType(),
                'selfie_mime' => $selfieFile->getMimeType()
            ]);


            if ($profile->id_document_front) {
                Storage::disk('public')->delete($profile->id_document_front);
                \Log::info('OnboardingController@processStep2 - Documento frontal anterior eliminado', [
                    'user_id' => Auth::id(),
                    'old_path' => $profile->id_document_front
                ]);
            }
            if ($profile->id_document_back) {
                Storage::disk('public')->delete($profile->id_document_back);
                \Log::info('OnboardingController@processStep2 - Documento trasero anterior eliminado', [
                    'user_id' => Auth::id(),
                    'old_path' => $profile->id_document_back
                ]);
            }
            if ($profile->id_document_selfie) {
                Storage::disk('public')->delete($profile->id_document_selfie);
                \Log::info('OnboardingController@processStep2 - Selfie anterior eliminada', [
                    'user_id' => Auth::id(),
                    'old_path' => $profile->id_document_selfie
                ]);
            }


            $frontPath = $frontFile->store('documents', 'public');
            $backPath = $backFile->store('documents', 'public');
            $selfiePath = $selfieFile->store('documents', 'public');

            if (!$frontPath || !$backPath || !$selfiePath) {
                \Log::error('OnboardingController@processStep2 - Error al subir archivos', [
                    'user_id' => Auth::id(),
                    'front_path' => $frontPath,
                    'back_path' => $backPath,
                    'selfie_path' => $selfiePath
                ]);
                return back()->with('error', __('admin.flash.onboarding.upload_error'));
            }

            \Log::info('OnboardingController@processStep2 - Archivos subidos exitosamente', [
                'user_id' => Auth::id(),
                'front_path' => $frontPath,
                'back_path' => $backPath,
                'selfie_path' => $selfiePath
            ]);


            $profile->update([
                'legal_name' => $request->legal_name,
                'date_of_birth' => $request->date_of_birth,
                'id_document_type' => $request->id_document_type,
                'id_document_front' => $frontPath,
                'id_document_back' => $backPath,
                'id_document_selfie' => $selfiePath,
                'age_verified' => true,
                'step2_completed' => true,
            ]);

            \Log::info('OnboardingController@processStep2 - Perfil actualizado exitosamente', [
                'user_id' => Auth::id(),
                'profile_id' => $profile->id
            ]);

            return redirect()->route('model.onboarding.step', ['step' => 3])
                ->with('success', __('admin.flash.onboarding.step2_success'));

        } catch (\Exception $e) {
            \Log::error('OnboardingController@processStep2 - Excepción capturada', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', __('admin.flash.onboarding.unexpected_error', ['message' => $e->getMessage()]));
        }
    }


    public function processStep3(Request $request)
    {
        $user = Auth::user();
        $profile = $user->profile;


        if (!$profile->step1_completed || !$profile->step2_completed) {
            return redirect()->route('model.onboarding.index')
                ->with('error', __('admin.flash.onboarding.complete_prev_steps'));
        }

        $profile->update([
            'step3_completed' => true,
            'onboarding_completed_at' => now(),
            'verification_status' => 'under_review',
            'profile_completed' => true,
        ]);

        // Send confirmation email
        try {
            \Illuminate\Support\Facades\Mail::to($user)->send(new \App\Mail\ModelApplicationReceived($user));
        } catch (\Exception $e) {
            \Log::error('Error enviando correo de solicitud recibida: ' . $e->getMessage());
        }

        return redirect()->route('model.dashboard')
            ->with('success', __('admin.flash.onboarding.step3_success'));
    }
}
