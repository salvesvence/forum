<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class SubscribeToThreadsTest extends TestCase
{
    use DatabaseMigrations;
    
    /** @test */
    public function a_user_subscribe_to_threads()
    {
        $this->signIn();

        $thread = create('App\Model');

        $this->post($thread->path() . '/subscriptions');

        $thread->replies()->create([
            'user_id' => auth()->id(),
            'body' => 'Some reply here.',
        ]);

        $this->assertCount(1, auth()->user()->notifications);
    }
}
