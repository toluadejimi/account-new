<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\EMoney;


use App\Models\Transaction;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;


class DashboardController extends Controller
{










    public function user_dashboard(Request $request){

        $transaction = Transaction::where('user_id', Auth::id())
        ->paginate(10);


        $transaction_count = Transaction::where('user_id', Auth::id())
        ->count();

        $ben_wallet = User::where('id', 5)
        ->first()->ben_wallet;

        $ben_name = User::where('id', Auth::id())
        ->first()->ben_name;

        $all_sales= Transaction::where('user_id', Auth::id())
        ->get()->sum('amount');
       
        $all_transactions = Transaction::all()->count();

        $weekly_total = Transaction::select("*")

        ->whereBetween('created_at', 

                [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]

            )

        ->get()->sum('amount');

        $user_balance = User::where('id', Auth::id())
        ->first()->wallet ;


       // Transaction::orderBy('id','DESC')->take(10)->get();



        return view('/user-dashboard', compact('transaction','transaction_count','ben_wallet','ben_name', 'weekly_total','all_transactions','all_sales','user_balance'));
    }
    



    
    
    
}
