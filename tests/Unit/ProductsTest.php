<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Product;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProductsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test: return all products from db
     *
     */
    public function test_return_all_products()
    {
        $response = $this->get('/api/products');

        $response->assertStatus(200);
    }

    /**
     * Test: add new product with headers
     *
     */
    public function test_stores_new_product_with_headers()
    {
        $user = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/products', [
            'name' => $product->name,
            'category' =>  $product->category,
            'description' =>  $product->description,
            'producer' =>  $product->producer,
            'price' =>  $product->price
        ]);

        $response->assertStatus(201);
    }

    /**
     * Test: try to add new product without data
     *
     */
    public function test_try_to_store_new_product_without_data()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/products', [
            'name' => '',
            'category' => '',
            'description' => '',
            'producer' => '',
            'price' => '',
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test: udpate product by id
     *
     */
    public function test_update_product()
    {
        $user = User::factory()->create();
        $id = Product::factory()->create()->id;

        $response = $this->actingAs($user)->withHeaders([
            'Accept' => 'application/json',
        ])->put('/api/products/'.$id, [
            'name' => "TEST",
            'category' => "TEST",
            'description' => "TEST",
            'producer' => "TEST",
            'price' => "1.50",
        ]);

        $response->assertStatus(200);
    }


    /**
     * Test: remove product by id
     *
     */
    public function test_remove_product()
    {
        $user = User::factory()->create();
        $id = Product::factory()->create()->id;

        $response = $this->actingAs($user)->delete('/api/products/'.$id);

        $response->assertStatus(200);
    }

    /**
     * Test: sort product by price (asc)
     *
     */
    public function test_sort_product_by_price_asc()
    {
        $response = $this->get('/api/products/sort/asc');

        $response->assertStatus(200);
    }

    /**
     * Test: sort product by price (desc)
     *
     */
    public function test_sort_product_by_price_desc()
    {
        $response = $this->get('/api/products/sort/desc');

        $response->assertStatus(200);
    }

    /**
     * Test: sort product by price (unkonw method)
     *
     */
    public function test_sort_product_by_price_unkonw_method()
    {
        $response = $this->get('/api/products/sort/xd');

        $response->assertStatus(400);
    }
}
