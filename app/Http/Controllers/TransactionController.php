<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TransactionController extends Controller{
    public function store(StoreTransactionRequest $request){
        
        return DB::transaction(function () use ($request) {
            
            $transaction = Transaction::create([
                'client_id' => $request->client_id,
                'gateway_id' => $request->gateway_id,
                'amount' => $request->amount,
                'card_last_numbers' => $request->card_last_numbers,
                'status' => 'pending'
            ]);

            $productsToSync = [];
            foreach($request->products as $product){
                $productsToSync[$product['product_id']] = ['quantity' => $product['quantity']];
            }
            $transaction->products()->sync($productsToSync);

            try{
                $response = Http::post('http://localhost:3001/transactions',[
                    'amount' => $request->amount,
                    'card_number' => '000000000000'.$request->card_last_numbers,
                ]);

                if($response->successful()){
                    $transaction->update([
                        'external_id' => $response->json('id') ?? uniqid('mock_'),
                        'status' => 'paid'
                    ]);
                }  
            }catch(\Exception $e){
                $transaction->update(['status' => 'failed']);
            }

            return response()->json([
                'message' => 'Transação processada',
                'data' => $transaction->load('products')
            ],201);
        });
    }
}