<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PostTest extends TestCase
{
   
    /** @test */
    public function it_can_create_a_post()
    {
        $user = User::find(1);
        
        // Authenticate the user
        Sanctum::actingAs($user);

        // Make the request as the authenticated user
        $response = $this->postJson('/api/posts', [
            'title' => 'New Test Post',
            'content' => 'New Content of the post',
        ]);

        // Assert that the response status is 201
        $response->assertStatus(201);
        
        // Optionally, verify the post creation
        $this->assertDatabaseHas('posts', [
            'title' => 'New Test Post',
            'content' => 'New Content of the post',
            'user_id' => $user->id,
        ]);
    }
    
}
