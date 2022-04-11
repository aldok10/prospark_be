<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;

class ProductTest extends TestCase
{
    /**
     * Authenticate user.
     *
     * @return void
     */
    protected function authenticate()
    {
        $user = User::create([
            'name' => 'test',
            'email' => rand(12345,678910).'test@gmail.com',
            'password' => \Hash::make('pretest_prospark'),
        ]);

        if (!auth()->attempt(['email'=>$user->email, 'password'=>'pretest_prospark'])) {
            return response(['message' => 'Login credentials are invaild']);
        }

        return $accessToken = auth()->user()->createToken('authToken')->accessToken;
    }

    /**
     * test create product.
     *
     * @return void
     */
    public function test_create_product()
    {
        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('POST','api/product',[
            'name' => 'Test product',
            'description' => 'test-sku',
            'price' => rand(12345,678910),
            'stock' => rand(12345,678910)
        ]);

        //Write the response in laravel.log
        \Log::info('test_create_product', [$response->getContent()]);

        $response->assertStatus(200);
    }

    /**
     * test update product.
     *
     * @return void
     */
    public function test_update_product()
    {
        $token = $this->authenticate();

        $product = Product::factory()->create();

        \Log::info("'api/product/' . $product->id", [$product]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('PUT','api/product/' . $product->id, [
            'name' => 'Test product111',
            'description' => 'test-sku',
            'price' => rand(12345,678910),
            'stock' => rand(12345,678910)
        ]);

        //Write the response in laravel.log
        \Log::info('test_update_product', [$response->getContent()]);

        $response->assertStatus(200);
    }

    /**
     * test find product.
     *
     * @return void
     */
    public function test_find_product()
    {
        $token = $this->authenticate();

        $product = Product::factory()->create();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET','api/product/' . $product->id);

        //Write the response in laravel.log
        \Log::info('test_find_product', [$response->getContent()]);

        $response->assertStatus(200);
    }

    /**
     * test get all products.
     *
     * @return void
     */
    public function test_get_all_product()
    {
        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('GET','api/product');

        //Write the response in laravel.log
        \Log::info('test_get_all_product', [$response->getContent()]);

        $response->assertStatus(200);
    }

    /**
     * test delete products.
     *
     * @return void
     */
    public function test_delete_product()
    {
        $token = $this->authenticate();

        $product = Product::factory()->create();

        \Log::info("'api/product/' . $product->id", [$product]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '. $token,
        ])->json('DELETE','api/product/' . $product->id);

        //Write the response in laravel.log
        \Log::info('test_delete_product', [$response->getContent()]);

        $response->assertStatus(200);
    }
}
