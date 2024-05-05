<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_submit_comment_edit_form()
    {
        // Create a comment
        $comment = Comment::factory()->create();

        // Acting as an authenticated user (if authentication is required)
        $user = // Create or get a user instance here
        $this->actingAs($user);

        // Submit the comment edit form
        $response = $this->put(route('comments.update', $comment), [
            'body' => 'Updated comment body',
        ]);

        // Assert that the comment was updated in the database
        $this->assertDatabaseHas('comments', [
            'id' => $comment->id,
            'body' => 'Updated comment body',
        ]);

        // Assert redirect to the comment's show page or any other appropriate page
        $response->assertRedirect(route('comments.show', $comment));
    }

    /** @test */
    public function user_cannot_submit_comment_edit_form_for_other_users_comment()
    {
        // Create comments for different users
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $comment1 = Comment::factory()->create(['user_id' => $user1->id]);
        $comment2 = Comment::factory()->create(['user_id' => $user2->id]);

        // Acting as an authenticated user (if authentication is required)
        $this->actingAs($user1);

        // Attempt to submit the comment edit form for another user's comment
        $response = $this->put(route('comments.update', $comment2), [
            'body' => 'Updated comment body',
        ]);

        // Assert that the user is redirected or receives a forbidden response
        $response->assertForbidden();
    }

    /** @test */
    public function guest_cannot_access_comment_edit_page()
    {
        // Create a comment
        $comment = Comment::factory()->create();

        // Visit the comment edit page as a guest user
        $response = $this->get(route('comments.edit', $comment));

        // Assert that the user is redirected to the login page or receives a forbidden response
        $response->assertRedirect(route('login'));
    }

    // Add more test methods as needed to cover other functionality such as error handling, etc.
}
