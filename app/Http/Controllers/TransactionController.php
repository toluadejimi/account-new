<?php

namespace App\Http\Controllers;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Bank;
use Illuminate\Support\Facades\md5;
use App\Services\Reference;
use Datatables;
use Carbon\Carbon;





use Illuminate\Http\Request;

class TransactionController extends Controller
{
    


public function local_transfer(Request $request){


    $user_balance = User::where('id', Auth::id())
    ->first()->wallet;


    $user = User::all();

    $bens = User::where('id', 5)->get();


    $transaction = Transaction::
    where([
        'user_id' => Auth::id(),
        ])->paginate(5);

    
        $current_week = Transaction::
        where(['user_id' => Auth::id(),'type' => 'Transfer'])
        ->sum('amount');

    return view('local-transfer', compact('user', 'user_balance','transaction', 'current_week','bens'));
    
}





Public function local_transfer_now(Request $request)
{

    $input = $request->validate([
        'amount' => ['required', 'string'],
        'r_account_no' => ['required', 'string'],
        'user_pin' => ['required', 'string'],
    ]);


    $pin = Auth::user()->pin;
    $user_balance = Auth::user()->wallet;

if ($user_balance > $request->amount) {

    if(Hash::check($request->user_pin, $pin )) {
        


        $debit = $user_balance - $request->amount;

        $update = User::where('id',Auth::user()->id)
        ->update(['wallet' => $debit]);
     

        $transaction = new Transaction();
        $transaction->trx_id = Str::random(10);
        $transaction->type = 'Transfer';
        $transaction->r_account_no = $request->r_account_no;
        $transaction->note = 'Local Transfer';
        $transaction->amount = $request->amount;
        $transaction->user_id = Auth::user()->id;
        $transaction->save();


        $ben_amount = User::where('id', 5)
        ->first()->ben_wallet;

        $update = (int)$ben_amount + (int)$request->amount;
        
        $credit = User::where('id', 5)
        ->update(["ben_wallet" => $request->amount]);

        return back()->with('message','Your transfer has been proccessed');



    }else{
        return back()->with('error','Opps!! Invalid transfer pin');
    }







    
} return back()->with('error','Insufficent Balance');
} 



Public function int_transfer_now(Request $request)
{

    $input = $request->validate([
        'amount' => ['required', 'string'],
        'bank_name' => ['required', 'string'],
        'r_account_no' => ['required', 'string'],
    ]);


    $pin = Auth::user()->pin;
    $user_balance = Auth::user()->wallet;

if ($user_balance > $request->amount) {

    if(Hash::check($request->user_pin, $pin )) {
        


        $debit = $user_balance - $request->amount;

        $update = User::where('id',Auth::user()->id)
        ->update(['wallet' => $debit]);
     

        $transaction = new Transaction();
        $transaction->trx_id = Str::random(10);
        $transaction->type = 'Transfer';
        $transaction->bank_name = $request->bank_name;
        $transaction->swift_code = $request->swift_code;
        $transaction->bank_address = $request->bank_address;
        $transaction->r_account_no = $request->r_account_no;
        $transaction->note = 'Local Transfer';
        $transaction->amount = $request->amount;
        $transaction->user_id = Auth::user()->id;
        $transaction->save();


        $ben_amount = User::where('id', 5)
        ->first()->ben_wallet;

        $update = (int)$ben_amount + (int)$request->amount;
        
        $credit = User::where('id', 5)
        ->update(["ben_wallet" => $request->amount]);

        return back()->with('message','Your transfer has been proccessed');



    }else{
        return back()->with('error','Opps!! Invalid transfer pin');
    }
    
} return back()->with('error','Insufficent Balance');
} 




public function statement(Request $request){

    $banks = Bank::all();

    $user_balance = User::where('id', Auth::id())
    ->first()->wallet;


    $user = User::all();

    $transaction = Transaction::
    where([
        'user_id' => Auth::id(),
        ])->paginate(5);

    
        $current_week = Transaction::
        where(['user_id' => Auth::id(),'type' => 'Transfer'])
        ->sum('amount');

    return view('statement', compact('user', 'user_balance','transaction', 'current_week', 'banks'));
    
}


public function loan(Request $request){

    $banks = Bank::all();

    $user_balance = User::where('id', Auth::id())
    ->first()->wallet;


    $user = User::all();

    $transaction = Transaction::
    where([
        'user_id' => Auth::id(),
        ])->paginate(5);

    
        $current_week = Transaction::
        where(['user_id' => Auth::id(),'type' => 'Transfer'])
        ->sum('amount');

    return view('loan', compact('user', 'user_balance','transaction', 'current_week', 'banks'));
    
}

public function contact(Request $request){

    $banks = Bank::all();

    $user_balance = User::where('id', Auth::id())
    ->first()->wallet;


    $user = User::all();

    $transaction = Transaction::
    where([
        'user_id' => Auth::id(),
        ])->paginate(5);

    
        $current_week = Transaction::
        where(['user_id' => Auth::id(),'type' => 'Transfer'])
        ->sum('amount');

    return view('contact', compact('user', 'user_balance','transaction', 'current_week', 'banks'));
    
}

public function contact_now(Request $request){

    return back()->with('message','Thanks for contacting us. One of our representative will get back to you,');

}




public function get_statement(Request $request){

    $pin = Auth::user()->pin;
    $user_balance = Auth::user()->wallet;

    if(Hash::check($request->user_pin, $pin )) {

    return back()->with('message','Your Statment has been sent yo your registred email address');
    }    return back()->with('error','Invalid Pin');

}




public function int_transfer(Request $request){

    $banks = Bank::all();

    $user_balance = User::where('id', Auth::id())
    ->first()->wallet;


    $user = User::all();

    $transaction = Transaction::
    where([
        'user_id' => Auth::id(),
        ])->paginate(5);

    
        $current_week = Transaction::
        where(['user_id' => Auth::id(),'type' => 'Transfer'])
        ->sum('amount');

    return view('int-transfer', compact('user', 'user_balance','transaction', 'current_week', 'banks'));
    
}






public function other_transfer(Request $request){

    $banks = Bank::all();

    $user_balance = User::where('id', Auth::id())
    ->first()->wallet;


    $user = User::all();

    $transaction = Transaction::
    where([
        'user_id' => Auth::id(),
        ])->paginate(5);

    
        $current_week = Transaction::
        where(['user_id' => Auth::id(),'type' => 'Transfer'])
        ->sum('amount');

    return view('other-transfer', compact('user', 'user_balance','transaction', 'current_week', 'banks'));
    
}

Public function other_transfer_now(Request $request)
{

    $input = $request->validate([
        'amount' => ['required', 'string'],
        'r_account_no' => ['required', 'string'],
        'user_pin' => ['required', 'string'],
    ]);


    $pin = Auth::user()->pin;
    $user_balance = Auth::user()->wallet;

if ($user_balance > $request->amount) {

    if(Hash::check($request->user_pin, $pin )) {
        


        $debit = $user_balance - $request->amount;

        $update = User::where('id',Auth::user()->id)
        ->update(['wallet' => $debit]);
     

        $transaction = new Transaction();
        $transaction->trx_id = Str::random(10);
        $transaction->type = 'Transfer';
        $transaction->r_account_no = $request->r_account_no;
        $transaction->bank_name = $request->bank_name;
        $transaction->account_name = $request->account_name;
        $transaction->note = 'Other Bank Transfer';
        $transaction->amount = $request->amount;
        $transaction->user_id = Auth::user()->id;
        $transaction->save();

        return back()->with('message','Your transfer has been proccessed');



    }else{
        return back()->with('error','Opps!! Invalid transfer pin');
    }







    
} return back()->with('error','Insufficent Balance');
}




Public function search(Request $request)
{
    return Datatables::of(Transaction::query())->make(true);
} 






public function transactions(Request $request){


    $user_balance = Wallet::where('user_id', Auth::id())
    ->first()->amount;

    $money_in = Transaction::where([
        'user_id' => Auth::id(),
        'status' => 1,

        ])->get()->sum('amount');

   
    
        $money_out = Transaction::where([
            'user_id' => Auth::id(),
            'status' => 1,
            'type' => 'Withdrawal',

            ])->get()->sum('amount');

        
            $sucessful_trx = Transaction::where([
                'user_id' => Auth::id(),
                'status' => 1,
    
                ])->get()->count();

                $failed_trx = Transaction::where([
                    'user_id' => Auth::id(),
                    'status' => 3,
        
                    ])->get()->count();

    


    $user = User::all();

    $transaction = Transaction::
    where([
        'user_id' => Auth::id(),
        ])->get();

    return view('transaction', compact('user', 'user_balance','transaction', 'money_in', 'money_out', 'sucessful_trx', 'failed_trx'));
    
}













}
