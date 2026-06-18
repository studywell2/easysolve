<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $conversations = Conversation::where('school_id', $user->school_id)
            ->whereHas('participants', fn($q) => $q->where('user_id', $user->id))
            ->with(['participants', 'messages' => fn($q) => $q->latest()->limit(1)])
            ->orderByDesc('last_message_at')
            ->paginate(15);

        return view('school.messages.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        $this->authorizeAccess($conversation);

        $conversation->load(['participants', 'messages.sender']);
        $conversation->markAsRead(auth()->user());

        return view('school.messages.show', compact('conversation'));
    }

    public function create(Request $request)
    {
        $user = auth()->user();
        $schoolId = $user->school_id;

        // Determine who the user can message
        if ($user->canManageSchool()) {
            // Managers can message parents and other managers
            $recipients = User::where('school_id', $schoolId)
                ->whereIn('role', ['owner', 'admin', 'teacher', 'parent'])
                ->where('id', '!=', $user->id)
                ->orderBy('first_name')
                ->get();
        } else {
            // Parents/students can message managers
            $recipients = User::where('school_id', $schoolId)
                ->whereIn('role', ['owner', 'admin', 'teacher'])
                ->orderBy('first_name')
                ->get();
        }

        return view('school.messages.create', compact('recipients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'body' => 'required|string|max:5000',
        ]);

        $user = auth()->user();
        $recipient = User::findOrFail($validated['recipient_id']);

        // Ensure both users belong to the same school
        if ($recipient->school_id !== $user->school_id) {
            abort(403);
        }

        // Check if a conversation already exists between these two users
        $conversation = Conversation::where('school_id', $user->school_id)
            ->whereHas('participants', fn($q) => $q->where('user_id', $user->id))
            ->whereHas('participants', fn($q) => $q->where('user_id', $recipient->id))
            ->where('subject', $validated['subject'])
            ->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'school_id' => $user->school_id,
                'subject' => $validated['subject'],
                'created_by' => $user->id,
                'last_message_at' => now(),
            ]);

            $conversation->participants()->attach([$user->id, $recipient->id]);
        }

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $user->id,
            'body' => $validated['body'],
        ]);

        $conversation->update(['last_message_at' => now()]);

        return redirect()->route('school.messages.show', $conversation)->with('success', 'Message sent.');
    }

    public function reply(Request $request, Conversation $conversation)
    {
        $this->authorizeAccess($conversation);

        $validated = $request->validate([
            'body' => 'required|string|max:5000',
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => auth()->id(),
            'body' => $validated['body'],
        ]);

        $conversation->update(['last_message_at' => now()]);

        return redirect()->route('school.messages.show', $conversation);
    }

    private function authorizeAccess(Conversation $conversation): void
    {
        if ($conversation->school_id !== auth()->user()->school_id) {
            abort(403);
        }

        if (!$conversation->participants()->where('user_id', auth()->id())->exists()) {
            abort(403);
        }
    }
}
