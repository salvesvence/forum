<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function an_unauthenticated_user_may_not_participate_in_forum_threads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = create('App\Thread');
        $reply = create('App\Reply');

        $this->post("threads/$thread->id/replies", $reply->toArray());

        $this->get($thread->path())->assertSee($reply->body);
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->be($user = create('App\User'));

        $thread = create('App\Thread');
        $reply = create('App\Reply');

        $this->post("threads/$thread->id/replies", $reply->toArray());

        $this->get($thread->path())->assertSee($reply->body);
    }
}
