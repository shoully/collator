<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Development;
class HomeController extends Controller
{
  public function index()
    {
     $development = new Development;
  $development = Development::latest()->get();
  return view('welcome', ['developments' => $development,]);
    //
      }
}
