<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Client;
use App\Models\Gateway;
use App\Models\Product;
use App\Models\Transaction;

class TransactionFeatureTest extends TestCase{
    use RefreshDatabase;

    public function testCreateATransactionSuccessfully(){
        $client = Client::create(['name' => 'Cliente Teste', 'email' => 'cliente@teste.com']);
        $gateway = Gateway::create(['name' => 'Gateway Mock', 'is_active' => true, 'priority' => 1]);
        $product = Product::create(['name' => 'Produto Teste','amount' => 5000]);

        $payload = [
            'client_id' => $client->id,
            'gateway_id' => $gateway->id,
            'amount' => 10000,
            'card_last_numbers' => '1234',
            'products' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2
                ]
            ]
        ];

        $response = $this->postJson('/api/transactions',$payload);

        $response->assertStatus(201);//Status 201 (created)

        $this->assertDatabaseHas('transactions',[
            'client_id' => $client->id,
            'gateway_id' => $gateway->id,
            'amount' => 10000,
            'status' => 'pending'
        ]);

        $this->assertDatabaseHas('transaction_products', [
            'product_id' => $product->id,
            'quantity' => 2
        ]);
    }
    
    public function testeListAllTransactions(){
        $client = Client::create(['name' => 'Cliente Lista', 'email' => 'lista@teste.com']);
        $gateway = Gateway::create(['name' => 'Gateway Lista', 'is_active' => true, 'priority' => 1]);

        Transaction::create([
            'client_id' => $client->id,
            'gateway_id' => $gateway->id,
            'amount' => 15000,
            'card_last_numbers' => '4321',
            'status' => 'paid'
        ]);

        $response = $this->getJson('/api/transactions');
        
        $responseData = $response->json('data');

        $this->assertNotNull($responseData, 'A chave data veio nula!'); 
        $this->assertNotEmpty($responseData, 'A chave data está vazia!');
        $response->assertJsonCount(1, 'data');

        $response->assertStatus(200) 
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['id', 'client_id', 'gateway_id', 'amount', 'status', 'created_at']
                     ]
                 ]);
    }
}
