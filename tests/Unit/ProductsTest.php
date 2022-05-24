<?php

namespace Tests\Unit;

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
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/products', [
            'name' => 'Banana',
            'category' => 'Fruit',
            'description' => 'Lorem ipsum dolor sit',
            'producer' => 'John',
            'price' => '7.23',
        ]);

        $response->assertStatus(201);
    }

    /**
     * Test: try to add new product without data
     *
     */
    public function test_try_to_store_new_product_without_data()
    {
        $response = $this->withHeaders([
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
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->put('/api/products/2', [
            'name' => 'Raspberry',
            'category' => 'Fruit',
            'description' => 'Lorem ipsum',
            'producer' => 'Frank',
            'price' => '4.76',
        ]);

        $response->assertStatus(200);
    }


    /**
     * Test: remove product by id
     *
     */
    public function test_remove_product()
    {
        $response = $this->delete('/api/products/1');

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
