<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Support\Facades\Validator;


class SettingsController extends Controller
{
    // routes will require auth
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $user = auth()->user();
        $countries = Country::get();

        return view('account/settings', compact('user', 'countries'));
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'string|min:2|max:255',
            'b_day' => 'numeric|min:1|max:31|nullable',
            'b_month' => 'numeric|min:1|max:12|nullable',
            'b_year' => 'numeric|min:1900|max:2019|nullable',
            'country' => 'string|max:255|nullable'
        ]);

        if ($validator->fails()) {
            return response()->
            json($validator->errors(), 422); ;
        }

        auth()->user()->update($validator->valid());

        return $validator->valid();
    }
}
