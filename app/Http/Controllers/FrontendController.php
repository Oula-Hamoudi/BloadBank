<?php

namespace App\Http\Controllers;



use App\Models\User;
use Illuminate\Http\Request;



class FrontendController extends Controller
{
  public function index()
  {
    return view('frontend.index');
  }

}
