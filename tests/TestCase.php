<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Sign a given user in test environment.
     *
     * @param null $user
     * @return $this
     */
    protected function signIn($user = null)
    {
        $user = $user ?: create('App\User');

        $this->actingAs($user);

        return $this;
    }
}
