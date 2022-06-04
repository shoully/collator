<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RedirectAuthenticatedUsersController extends Controller
{
    public function home()
    {
        if (auth()->user()->type == 'Mentor') {
            return redirect('/adminDashboard');
        }
        elseif(auth()->user()->type == 'Mentee'){
            return redirect('/userDashboard');
        }
        elseif(auth()->user()->type == 'guest'){
            return redirect('/guestDashboard');
        }
        else{
            return auth()->logout();
        }
    }
}
