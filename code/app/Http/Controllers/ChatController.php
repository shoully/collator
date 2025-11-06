<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Http\Controllers\HomeController;

class ChatController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'mentor' => 'required|exists:users,id',
            'mentee' => 'required|exists:users,id',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        $user = Auth::user();
        
        // Authorization: User must be either the mentor or mentee
        if ($user->id != $request->mentor && $user->id != $request->mentee) {
            abort(403, 'You can only send messages in conversations you are part of');
        }

        $chat = Chat::create([
            'message' => $request->message,
            'mentor' => $request->mentor,
            'mentee' => $request->mentee,
            'project_id' => $request->project_id,
        ]);

        // If AJAX request, return JSON response
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'chat' => [
                    'id' => $chat->id,
                    'message' => $chat->message,
                    'mentor' => $chat->mentor,
                    'mentee' => $chat->mentee,
                    'created_at' => $chat->created_at->format('Y-m-d H:i:s'),
                    'is_sender' => $user->id == $chat->mentor,
                ]
            ]);
        }

        return (new HomeController)->afterandreturn($request);
    }

    /**
     * Get chat messages for a conversation or project
     */
    public function getMessages(Request $request)
    {
        $user = Auth::user();
        
        // If project_id is provided, show all messages in that project
        if ($request->project_id) {
            $request->validate([
                'project_id' => 'required|exists:projects,id',
            ]);
            
            // Verify user has access to this project
            $project = \App\Models\Project::find($request->project_id);
            if (!$project) {
                abort(404, 'Project not found');
            }
            
            $canAccess = false;
            if ($user->type === 'Mentor' && $project->owner == $user->id) {
                $canAccess = true;
            } elseif ($user->type === 'Mentee') {
                // Mentees can access if assigned to them or if it's from their mentor
                if ($project->mentee == $user->id) {
                    $canAccess = true;
                } elseif ($project->mentee === null) {
                    $mentorIds = \App\Models\Mentoring::where('mentee', $user->id)->pluck('mentor')->toArray();
                    if (in_array($project->owner, $mentorIds) || count($mentorIds) == 0) {
                        $canAccess = true;
                    }
                }
            }
            
            if (!$canAccess) {
                abort(403, 'You do not have access to this project');
            }
            
            // Get all chats for this project
            $chats = Chat::where('project_id', $request->project_id)
                ->orderBy('created_at', 'asc')
                ->get();
        } else {
            // Legacy: Get chats for specific mentor/mentee conversation
            $request->validate([
                'mentor' => 'required|exists:users,id',
                'mentee' => 'required|exists:users,id',
            ]);
            
            // Authorization: User must be either the mentor or mentee
            if ($user->id != $request->mentor && $user->id != $request->mentee) {
                abort(403, 'You can only view messages in conversations you are part of');
            }

            // Get chats for this conversation (both directions)
            $chats = Chat::where(function($query) use ($request) {
                $query->where(function($q) use ($request) {
                    $q->where('mentee', $request->mentee)
                      ->where('mentor', $request->mentor);
                })->orWhere(function($q) use ($request) {
                    $q->where('mentee', $request->mentor)
                      ->where('mentor', $request->mentee);
                });
            })->orderBy('created_at', 'asc')->get();
        }

        $messages = $chats->map(function($chat) use ($user) {
            return [
                'id' => $chat->id,
                'message' => $chat->message,
                'mentor' => $chat->mentor,
                'mentee' => $chat->mentee,
                'mentor_name' => $chat->mentorUser->name ?? 'Mentor',
                'mentee_name' => $chat->menteeUser->name ?? 'Mentee',
                'created_at' => $chat->created_at->format('Y-m-d H:i:s'),
                'is_sender' => $user->id == $chat->mentor,
            ];
        });

        return response()->json([
            'success' => true,
            'messages' => $messages
        ]);
    }
}
