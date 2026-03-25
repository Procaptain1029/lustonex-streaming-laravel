<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\ChatExtendedNotification;
use App\Notifications\NewChatMessageNotification;

class ChatController extends Controller
{
    
    public function index()
    {
        $user = auth()->user();

        // Limpiar mensajes de chats expirados antes de listar
        if ($user->isFan() || $user->isModel()) {
            $expiredConversations = $user->conversations()
                ->where('is_unlocked', true)
                ->whereNotNull('unlocked_until')
                ->where('unlocked_until', '<', now())
                ->get();

            foreach ($expiredConversations as $conv) {
                // Borrar el historial de mensajes
                $conv->messages()->delete();
                
                // Marcar como no desbloqueado
                $conv->update([
                    'is_unlocked' => false,
                    'last_message_at' => null // Opcional, para que no suba
                ]);
            }
        }

        $query = $user->conversations()
            ->with(['users', 'messages' => function($q) {
                $q->latest()->limit(1);
            }]);

        // Si es fan, solo mostrar los desbloqueados
        if ($user->isFan()) {
            $query->where('is_unlocked', true)
                  ->where(function($q) {
                      $q->whereNull('unlocked_until')
                        ->orWhere('unlocked_until', '>=', now());
                  });
        }

        $conversations = $query->orderBy('last_message_at', 'desc')
            ->paginate(10)
            ->through(function($conversation) {
                $otherUser = $conversation->getOtherParticipant(auth()->id());
                $lastMessage = $conversation->messages->first();
                
                return [
                    'id' => $conversation->id,
                    'other_user' => $otherUser,
                    'last_message' => $lastMessage,
                    'unread_count' => $conversation->getUnreadCount(auth()->id()),
                    'updated_at' => $conversation->last_message_at ?? $conversation->updated_at,
                    'unlocked_until' => $conversation->unlocked_until
                ];
            });
        
        $viewName = $user->isModel() ? 'model.chat.index' : 'chat.index';
        return view($viewName, compact('conversations'));
    }
    
    
    public function show($conversationId)
    {
        $conversation = Conversation::with(['users', 'messages.user.profile'])
            ->findOrFail($conversationId);
        
        
        if (!$conversation->users->contains(auth()->id())) {
            abort(403, __('chat.errors.no_access'));
        }

        // Check expiration for fans
        if (auth()->user()->isFan()) {
            if (!$conversation->is_unlocked || ($conversation->unlocked_until && $conversation->unlocked_until->isPast())) {
                // Si expira justo ahora mientras intenta entrar, borrar mensajes
                if ($conversation->messages()->exists()) {
                     $conversation->messages()->delete();
                     $conversation->update(['is_unlocked' => false]);
                }

                $otherUser = $conversation->getOtherParticipant(auth()->id());
                return redirect()->route('profiles.show', $otherUser->id)
                               ->with('error', __('chat.errors.expired_redirect'));
            }
        }
        
        
        $this->markConversationAsRead($conversation);
        
        $otherUser = $conversation->getOtherParticipant(auth()->id());
        $messages = $conversation->messages()->orderBy('created_at', 'asc')->get();
        
        $viewName = auth()->user()->isModel() ? 'model.chat.show' : 'chat.show';
        return view($viewName, compact('conversation', 'otherUser', 'messages'));
    }
    
    
    public function create($userId)
    {
        $otherUser = User::findOrFail($userId);
        
        
        $existing = $this->findExistingConversation(auth()->id(), $userId);
        
        if ($existing) {
            return redirect()->route('chat.show', $existing->id);
        }
        
        
        $conversation = Conversation::create([
            'type' => 'private',
            'last_message_at' => now(),
        ]);
        
        $conversation->participants()->createMany([
            ['user_id' => auth()->id()],
            ['user_id' => $userId],
        ]);
        
        return redirect()->route('chat.show', $conversation->id);
    }
    
    
    public function sendMessage(Request $request, $conversationId)
    {
        $validated = $request->validate([
            'message' => 'required_without:image|string|max:5000|nullable',
            'image' => 'nullable|image|max:10240|mimes:jpeg,png,jpg,gif,webp',
        ]);
        
        $conversation = Conversation::findOrFail($conversationId);
        
        
        if (!$conversation->users->contains(auth()->id())) {
            return response()->json(['error' => __('chat.errors.unauthorized')], 403);
        }

        // Check expiration for fans
        if (auth()->user()->isFan()) {
            if (!$conversation->is_unlocked || ($conversation->unlocked_until && $conversation->unlocked_until->isPast())) {
                return response()->json(['error' => __('chat.errors.expired')], 403);
            }
        }
        
        $type = 'text';
        $content = $validated['message'] ?? '';
        $metadata = null;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('chat/attachments', 'public');
            $type = 'image';
            $content = $content ?: '[Imagen]';
            $metadata = [
                'file_path' => $path,
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'url' => \Illuminate\Support\Facades\Storage::url($path),
            ];
        }

        $message = $conversation->messages()->create([
            'user_id' => auth()->id(),
            'message' => $content,
            'type' => $type,
            'metadata' => $metadata,
        ]);
        
        $conversation->update(['last_message_at' => now()]);
        
        // Notify recipient
        $recipient = $conversation->getOtherParticipant(auth()->id());
        if ($recipient) {
            $recipient->notify(new NewChatMessageNotification($message, auth()->user()));
        }
        
        $message->load('user.profile');
        
        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }
    
    
    protected function markConversationAsRead($conversation)
    {
        $participant = $conversation->participants()
            ->where('user_id', auth()->id())
            ->first();
        
        if ($participant) {
            $participant->update(['last_read_at' => now()]);
            
            
            $conversation->messages()
                ->where('user_id', '!=', auth()->id())
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        }
    }
    
    
    protected function findExistingConversation($userId1, $userId2)
    {
        return Conversation::whereHas('participants', function($q) use ($userId1) {
                $q->where('user_id', $userId1);
            })
            ->whereHas('participants', function($q) use ($userId2) {
                $q->where('user_id', $userId2);
            })
            ->where('type', 'private')
            ->first();
    }
    
    
    public function unreadCount()
    {
        $count = auth()->user()->conversations()
            ->get()
            ->sum(function($conversation) {
                return $conversation->getUnreadCount(auth()->id());
            });
        
        return response()->json(['count' => $count]);
    }
    
    public function getMessages($conversationId)
    {
        $conversation = Conversation::findOrFail($conversationId);
        
        
        if (!$conversation->users->contains(auth()->id())) {
            return response()->json(['error' => __('chat.errors.unauthorized')], 403);
        }
        
        $messages = $conversation->messages()
            ->with('user.profile')
            ->orderBy('created_at', 'asc')
            ->get();
            
        
        
        
        return response()->json([
            'success' => true, 
            'messages' => $messages
        ]);
    }

    /**
     * Extend conversation for another 24 hours.
     */
    public function extend(Request $request, $conversationId)
    {
        $conversation = Conversation::findOrFail($conversationId);
        
        if (!$conversation->users->contains(auth()->id())) {
            return response()->json(['success' => false, 'message' => __('chat.errors.unauthorized')], 403);
        }

        $fan = auth()->user();
        $model = $conversation->getOtherParticipant($fan->id);

        if (!$model || !$model->isModel()) {
             return response()->json(['success' => false, 'message' => __('chat.errors.model_not_found')], 404);
        }

        $price = $model->profile->chat_unlock_price ?? 0;

        if ($fan->tokens < $price) {
            return response()->json([
                'success' => false, 
                'message' => __('chat.errors.insufficient_tokens', ['price' => $price])
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Processing payment
            $fan->decrement('tokens', $price);
            $model->increment('tokens', $price);

            // Extension logic
            $currentExpiration = $conversation->unlocked_until;
            $baseDate = ($currentExpiration && $currentExpiration->isFuture()) ? $currentExpiration : now();
            $newExpiration = $baseDate->addHours(24);

            $conversation->update([
                'is_unlocked' => true,
                'unlocked_until' => $newExpiration
            ]);

            // Record Transactions
            \App\Models\TokenTransaction::create([
                'user_id' => $fan->id,
                'type' => 'spent',
                'amount' => $price,
                'description' => __('chat.transactions.extension_fan', ['name' => $model->name]),
                'balance_after' => $fan->fresh()->tokens,
            ]);

            \App\Models\TokenTransaction::create([
                'user_id' => $model->id,
                'type' => 'earned',
                'amount' => $price,
                'description' => __('chat.transactions.extension_model', ['name' => $fan->name]),
                'balance_after' => $model->fresh()->tokens,
            ]);

            DB::commit();

            // Notify both parties
            $fan->notify(new ChatExtendedNotification($conversation, $model, 'fan'));
            $model->notify(new ChatExtendedNotification($conversation, $fan, 'model'));

            return response()->json([
                'success' => true,
                'message' => __('chat.success.extended'),
                'new_expiration' => $newExpiration->format('d/m/Y H:i'),
                'tokens_left' => $fan->fresh()->tokens
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => __('chat.errors.extension_failed', ['error' => $e->getMessage()])
            ], 500);
        }
    }
}
