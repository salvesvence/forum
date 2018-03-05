<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function an_unauthenticated_user_can_not_create_a_new_forum_threads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = make('App\Thread');

        $this->post(route('threads.store'), $thread->toArray());
    }

    /** @test */
    function an_authenticated_user_can_create_a_new_forum_threads()
    {
        $this->actingAs(create('App\User'));

        $thread = make('App\Thread');

        $this->post(route('threads.store'), $thread->toArray());

        $this->get($thread->path())
             ->assertSee($thread->title)
             ->assertSee($thread->body);
    }
}