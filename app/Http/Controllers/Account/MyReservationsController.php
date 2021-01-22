<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Repositories\ReservationsRepository;

class MyReservationsController extends Controller
{
    // routes will require auth
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $user = auth()->user();

        $reservations = $user->reservation()->get();

        foreach($reservations as $reservation){
            $reservation["h"] = ReservationsRepository::get_hotel($reservation["reservation"]["booking"]["hotel"]["code"], $reservation);
        }

        return view('account/my_reservations', [
            'reservations' => $reservations
            ]);
    }
}
