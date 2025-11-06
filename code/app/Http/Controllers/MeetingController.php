<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Meeting;
use App\Http\Controllers\HomeController;

class MeetingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'date' => 'required|date',
            'URL' => 'nullable|url|max:255',
            'mentor' => 'required|exists:users,id',
            'mentee' => 'required|exists:users,id',
            'project_id' => 'nullable|exists:projects,id',
        ]);

        $user = Auth::user();
        
        // Authorization: Only mentees can request meetings, and they must be the mentee
        if ($user->type !== 'Mentee' || $user->id != $request->mentee) {
            abort(403, 'Only mentees can request meetings');
        }

        $meeting = Meeting::create([
            'description' => $request->description,
            'notes' => $request->notes ?? '',
            'date' => $request->date,
            'URL' => $request->URL ?? '',
            'status' => 'requested',
            'mentor' => $request->mentor,
            'mentee' => $request->mentee,
            'project_id' => $request->project_id,
        ]);

        return (new HomeController)->afterandreturn($request);
    }

    public function updateStatus(Meeting $meeting, Request $request)
    {
        $user = Auth::user();
        
        // Authorization: Only the mentor or mentee can update meeting status
        if ($user->id != $meeting->mentee && $user->id != $meeting->mentor) {
            abort(403, 'You can only update meetings you are part of');
        }

        $request->validate([
            'status' => 'required|in:ongoing,declined,done',
        ]);

        $meeting->status = $request->status;
        $meeting->save();

        return (new HomeController)->afterandreturn($request);
    }

    public function remove(Meeting $meeting, Request $request)
    {
        $user = Auth::user();
        
        // Authorization: Only the mentee who requested it or the mentor can delete it
        if ($user->id != $meeting->mentee && $user->id != $meeting->mentor) {
            abort(403, 'You can only delete meetings you are part of');
        }

        $meeting->delete();
        return (new HomeController)->afterandreturn($request);
    }
}
