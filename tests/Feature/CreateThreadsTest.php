<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function an_authenticated_user_can_create_a_new_forum_threads()
    {
        $this->actingAs(create('App\User'));

        $thread = make('App\Thread');

        $response = $this->post(route('threads.store'), $thread->toArray());

        $this->get($response->headers->get('Location'))
             ->assertSee($thread->title)
             ->assertSee($thread->body);
    }

    /** @test */
    function guest_may_not_create_threads()
    {
        $this->withExceptionHandling();

        $this->get(route('threads.create'))
            ->assertRedirect('/login');

        $this->post(route('threads.store'))
            ->assertRedirect('/login');
    }

    /** @test */
    function guest_cannot_see_the_create_thread_page()
    {
        $this->withExceptionHandling()
             ->get(route('threads.create'))
             ->assertRedirect('/login');
    }

    /** @test */
    function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
             ->assertSessionHasErrors('title');
    }

    /** @test */
    function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    function a_thread_requires_a_valid_channel()
    {
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    /**
     * Publish a thread with the data given.
     *
     * @param array $overrides
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    private function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->post('threads', $thread->toArray());
    }
}