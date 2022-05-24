<?php

namespace Tests\Unit;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostsTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test: return all posts from db
     *
     */
    public function test_return_all_posts()
    {
        $response = $this->get('/api/posts');

        $response->assertStatus(200);
    }

    /**
     * Test: add new post with headers
     *
     */
    public function test_stores_new_product_with_headers()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/posts', [
            'title' => 'Test title',
            'description' => 'Lorem ipsum dolor sit',
            'content' => 'Test content',
            'read_time' => '8'
        ]);

        $response->assertStatus(201);
    }

    /**
     * Test: try to add new post without data
     *
     */
    public function test_try_to_store_new_post_without_data()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->post('/api/posts', [
            'title' => '',
            'description' => '',
            'content' => '',
            'read_time' => ''
        ]);

        $response->assertStatus(422);
    }

    /**
     * Test: udpate post by id
     *
     */
    public function test_update_post()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->put('/api/posts/2', [
            'title' => 'Test title',
            'description' => 'Lorem ipsum dolor sit',
            'content' => 'Test content',
            'read_time' => '28'
        ]);

        $response->assertStatus(200);
    }


    /**
     * Test: remove post by id
     *
     */
    public function test_remove_post()
    {
        $response = $this->delete('/api/posts/1');

        $response->assertStatus(200);
    }
}
