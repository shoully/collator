<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class CommunicationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // This is a dummy implementation to serve the UI prototype.
        // It brings together data that would normally come from the Chat 
        // and Meeting models.

        return Inertia::render('Communications/Index', [
            'user' => $user,
        ]);
    }
}
