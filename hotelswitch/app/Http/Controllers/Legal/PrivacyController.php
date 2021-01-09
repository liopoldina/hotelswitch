<?php

namespace App\Http\Controllers\Legal;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PrivacyController extends Controller
{
    public function index()
    {

       return view('Legal.privacy_index');
  
    }
    
}
