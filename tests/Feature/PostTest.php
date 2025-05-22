<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $post;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->post = Post::factory()->create(['user_id' => $this->user->id]);
    }

    // Home Route Tests
    public function test_home_route_requires_authentication()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Login');
        $response->assertSee('Register'); 
    }

    public function test_authenticated_user_can_access_home()
    {
        $response = $this->actingAs($this->user)->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('home');
    }

    public function test_home_only_shows_users_own_posts()
    {
        $otherUser = User::factory()->create();
        $otherPost = Post::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($this->user)->get('/');
        $response->assertSee($this->post->title);
        $response->assertDontSee($otherPost->title);
    }

    // Post Creation Tests
    public function test_post_create_route_requires_authentication()
    {
        $response = $this->get('/posts/create');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_create_form()
    {
        $response = $this->actingAs($this->user)->get('/posts/create');
        $response->assertStatus(200);
        $response->assertViewIs('posts.create');
    }

    public function test_user_can_create_post()
    {
        $response = $this->actingAs($this->user)->post('/posts', [
            'title' => 'Test Post',
            'content' => 'This is a test post content',
            'published_date' => now()->format('Y-m-d'),
        ]);

        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseHas('posts', ['title' => 'Test Post']);
    }

    // Post Viewing Tests
    public function test_guest_can_view_public_post()
    {
        $publicPost = Post::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'active',
            'published_date' => now()->subDay(),
        ]);

        $response = $this->get('/posts/' . $publicPost->id);
        $response->assertStatus(200);
        $response->assertViewIs('posts.show');
    }

    // Post Editing Tests
    public function test_post_edit_route_requires_authentication()
    {
        $response = $this->get('/posts/' . $this->post->id . '/edit');
        $response->assertRedirect('/login');
    }

    public function test_owner_can_view_edit_form()
    {
        $response = $this->actingAs($this->user)
            ->get('/posts/' . $this->post->id . '/edit');
        
        $response->assertStatus(200);
        $response->assertViewIs('posts.edit');
    }

    public function test_non_owner_cannot_edit_post()
    {
        $otherUser = User::factory()->create();
        
        $response = $this->actingAs($otherUser)
            ->get('/posts/' . $this->post->id . '/edit');
        
        $response->assertForbidden();
    }

    public function test_owner_can_update_post()
    {
        $response = $this->actingAs($this->user)
            ->put('/posts/' . $this->post->id, [
                'title' => 'Updated Title',
                'content' => 'Updated content',
                'published_date' => now()->format('Y-m-d'),
            ]);

        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseHas('posts', [
            'id' => $this->post->id,
            'title' => 'Updated Title'
        ]);
    }

    // Post Deletion Tests
    public function test_owner_can_delete_post()
    {
        $response = $this->actingAs($this->user)
            ->delete('/posts/' . $this->post->id);

        $response->assertRedirect(route('home'));
        $this->assertDatabaseMissing('posts', ['id' => $this->post->id]);
    }

    public function test_non_owner_cannot_delete_post()
    {
        $otherUser = User::factory()->create();
        
        $response = $this->actingAs($otherUser)
            ->delete('/posts/' . $this->post->id);
        
        $response->assertForbidden();
        $this->assertDatabaseHas('posts', ['id' => $this->post->id]);
    }

    // Draft Status Tests
    public function test_post_can_be_saved_as_draft()
    {
        $response = $this->actingAs($this->user)->post('/posts', [
            'title' => 'Draft Post',
            'content' => 'This is a draft post',
            'published_date' => now()->format('Y-m-d'),
            'save_as_draft' => '1',
        ]);

        $this->assertDatabaseHas('posts', [
            'title' => 'Draft Post',
            'status' => 'draft'
        ]);
    }

    public function test_post_status_defaults_to_active_if_not_draft()
    {
        $response = $this->actingAs($this->user)->post('/posts', [
            'title' => 'Active Post',
            'content' => 'This is an active post',
            'published_date' => now()->format('Y-m-d'),
        ]);

        $this->assertDatabaseHas('posts', [
            'title' => 'Active Post',
            'status' => 'active'
        ]);
    }
}