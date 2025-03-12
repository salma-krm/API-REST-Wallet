<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
   public function create(Request $request)
   {
      DB::beginTransaction();
      try {

         $receiver  = User::where('email', '=', $request['email'])->first();
         if (!$receiver) {
            return response()->json([
               'erour' => 'this email not fund',
            ]);
         }
         $wallets = Wallet::where('user_id', '=', $receiver->id)->first();
         $sender_id = Auth()->user()->id;
         $wallet = Wallet::where('user_id', '=', $sender_id)->first();
         $balance = $wallet->balance;
         $receiver_id = $wallet->id;
         if ($balance < ($request['amount'])) {
            return response()->json([
               'amount' => $request->amount . ' la balance is supereiur the balance  '  . $balance,
               'balance' => $balance,

            ]);
         }
         if (!($balance >= ($request['amount']))) {
            return response()->json([
               'transaction' => "not working",
            ]);
         }
         $balance_recerver = $wallets->balance;
         $balance_recerver += $request->amount;
         wallet::where('user_id', $receiver->id)->update(['balance' => $balance_recerver]);
         $balance -= $request->amount;
         wallet::where('user_id', $sender_id)->update(['balance' => $balance]);


         $transaction = $request->validate([
            'amount' => 'required',
            'description' => 'required',
            'email' => 'required',
         ]);

         $transaction = Transaction::create([
            'description' => $transaction['description'],
            'amount' => $transaction['amount'],
            'sender_id' => $sender_id,
            'receiver_id' => $receiver_id,
            'date' => now(),
         ]);

         // return response()->json([
         //    'transaction' => $transaction,
         // ]);

         DB::commit();
         return ["return"=>"bsqhsq"];

      } catch (\Exception $e) {
         DB::rollBack();
         return response()->json([
            'erour' => $e->getmessage(),
         ]);
      }
   }
}
