<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Database\Seeders\CategorySeeder;
use Database\Seeders\TagSeeder;
use Database\Seeders\PrivacySeeder;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_all_posts_on_index_page()
    {

        $this->seed(CategorySeeder::class); // Run the CategorySeeder
        $this->seed(TagSeeder::class); // Run the TagSeeder
        $this->seed(PrivacySeeder::class); // Run the PrivacySeeder

        // Create some dummy posts
        Post::factory()->count(3)->create();
        // Post::factory(30)->has(Comment::factory(15))->for($user)->create();

        // Visit the index page
        $response = $this->get(route('posts.index'));

        // Assert that the index page loads successfully
        $response->assertStatus(200);

        // Assert that the posts are displayed on the page
        $response->assertViewHas('posts');

        // Assert that the posts are passed to the view
        $posts = $response->original->getData()['posts'];
        $this->assertCount(3, $posts); // Assuming we created 3 posts
    }

    /** @test */
    public function it_stores_a_new_post()
    {
        // Create dummy post data
        $postData = [
            'title' => 'Test Post',
            'body' => 'This is a test post.',
            'category_id' => 1,
            'tag_id' => 1,
            'privacy_id' => 1,
        ];

        // Submit a POST request to store the post
        $response = $this->post(route('posts.store'), $postData);

        // Assert that the post was stored in the database
        $this->assertDatabaseHas('posts', $postData);

        // Assert redirect to the newly created post's show page or any other appropriate page
        $response->assertRedirect(route('posts.show', Post::first()));
    }

    /** @test */
    public function it_displays_the_post_on_show_page()
    {

        $this->seed(CategorySeeder::class); // Run the CategorySeeder
        $this->seed(TagSeeder::class); // Run the TagSeeder
        $this->seed(PrivacySeeder::class); // Run the PrivacySeeder

        // Create a dummy post
        $post = Post::factory()->create();

        // Visit the show page
        $response = $this->get(route('posts.show', $post));

        // Assert that the show page loads successfully
        $response->assertStatus(200);

        // Assert that the post is displayed on the page
        $response->assertSee($post->title);
        $response->assertSee($post->body);
        // Add assertions for other post details as needed
    }

    /** @test */
    public function it_displays_the_edit_post_form()
    {

        $this->seed(CategorySeeder::class); // Run the CategorySeeder
        $this->seed(TagSeeder::class); // Run the TagSeeder
        $this->seed(PrivacySeeder::class); // Run the PrivacySeeder

        // Create a dummy post
        $post = Post::factory()->create();

        // Visit the edit page
        $response = $this->get(route('posts.edit', $post));

        // Assert that the edit page loads successfully
        $response->assertStatus(200);

        // Assert that the post data is pre-filled in the edit form
        $response->assertSee($post->title);
        $response->assertSee($post->body);
        // Add assertions for other post fields as needed
    }

    /** @test */
    public function it_updates_an_existing_post()
    {
        // Create a dummy post
        $post = Post::factory()->create();

        // New post data for updating
        $updatedData = [
            'title' => 'Updated Title',
            'body' => 'Updated Body',
            // Add other updated fields here
        ];

        // Submit a PUT request to update the post
        $response = $this->put(route('posts.update', $post), $updatedData);

        // Assert that the post was updated in the database
        $this->assertDatabaseHas('posts', $updatedData);

        // Assert redirect to the post's show page or any other appropriate page
        $response->assertRedirect(route('posts.show', $post));
    }

    /** @test */
    public function it_deletes_an_existing_post()
    {
        // Create a dummy post
        $post = Post::factory()->create();

        // Submit a DELETE request to delete the post
        $response = $this->delete(route('posts.destroy', $post));

        // Assert that the post was deleted from the database
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);

        // Assert redirect to the index page or any other appropriate page
        $response->assertRedirect(route('posts.index'));
    }
}
