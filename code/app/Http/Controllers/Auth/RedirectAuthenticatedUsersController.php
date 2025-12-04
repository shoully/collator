<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RedirectAuthenticatedUsersController extends Controller
{
    public function home()
    {
        // Redirect to project selection first - users must select a project before accessing dashboard
        return redirect()->route('project.select');
    }
}
