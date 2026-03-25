<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalController extends Controller
{
    public function terms()
    {
        return view('pages.legal', [
            'title' => __('legal.terms.title'),
            'content' => __('legal.terms.content'),
            'breadcrumb' => __('legal.terms.breadcrumb')
        ]);
    }

    public function privacy()
    {
        return view('pages.legal', [
            'title' => __('legal.privacy.title'),
            'content' => __('legal.privacy.content'),
            'breadcrumb' => __('legal.privacy.breadcrumb')
        ]);
    }

    public function cookies()
    {
        return view('pages.legal', [
            'title' => __('legal.cookies.title'),
            'content' => __('legal.cookies.content'),
            'breadcrumb' => __('legal.cookies.breadcrumb')
        ]);
    }

    public function modelContract()
    {
        return view('pages.legal', [
            'title' => __('legal.model_contract.title'),
            'content' => __('legal.model_contract.content'),
            'breadcrumb' => __('legal.model_contract.breadcrumb')
        ]);
    }

    public function studioContract()
    {
        return view('pages.legal', [
            'title' => __('legal.studio_contract.title'),
            'content' => __('legal.studio_contract.content'),
            'breadcrumb' => __('legal.studio_contract.breadcrumb')
        ]);
    }

    public function affiliateAgreement()
    {
        return view('pages.legal', [
            'title' => __('legal.affiliate_agreement.title'),
            'content' => __('legal.affiliate_agreement.content'),
            'breadcrumb' => __('legal.affiliate_agreement.breadcrumb')
        ]);
    }

    public function moderationPolicy()
    {
        return view('pages.legal', [
            'title' => __('legal.moderation_policy.title'),
            'content' => __('legal.moderation_policy.content'),
            'breadcrumb' => __('legal.moderation_policy.breadcrumb')
        ]);
    }

    public function protectionPolicy()
    {
        return view('pages.legal', [
            'title' => __('legal.protection_policy.title'),
            'content' => __('legal.protection_policy.content'),
            'breadcrumb' => __('legal.protection_policy.breadcrumb')
        ]);
    }

    public function modelRelease()
    {
        return view('pages.legal', [
            'title' => __('legal.model_release.title'),
            'content' => __('legal.model_release.content'),
            'breadcrumb' => __('legal.model_release.breadcrumb')
        ]);
    }

    public function taxPolicy()
    {
        return view('pages.legal', [
            'title' => __('legal.tax_policy.title'),
            'content' => __('legal.tax_policy.content'),
            'breadcrumb' => __('legal.tax_policy.breadcrumb')
        ]);
    }

    public function dmca()
    {
        return view('pages.legal', [
            'title' => __('legal.dmca.title'),
            'content' => __('legal.dmca.content'),
            'breadcrumb' => __('legal.dmca.breadcrumb')
        ]);
    }

    public function compliance()
    {
        return view('pages.legal', [
            'title' => __('legal.compliance.title'),
            'content' => __('legal.compliance.content'),
            'breadcrumb' => __('legal.compliance.breadcrumb')
        ]);
    }
}
