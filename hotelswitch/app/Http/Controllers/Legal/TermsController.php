<?php

namespace App\Http\Controllers\Legal;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TermsController extends Controller
{
    public function index()
    {

       return view('Legal.terms_index');
  
    }
    
}
