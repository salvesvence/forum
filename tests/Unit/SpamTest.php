<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Inspections\Spam;

class SpamTest extends TestCase
{
    /** @test */
    public function it_check_invalid_keywords()
    {
        $spam = new Spam;

        $this->assertFalse($spam->detect('Innocent reply here'));

        $this->expectException(\Exception::class);

        $spam->detect('yahoo reply support');
    }

    /** @test */
    public function it_check_for_any_key_held_down()
    {
        $spam = new Spam;

        $this->expectException('Exception');

        $spam->detect('Hello world aaaaaaaaa');
    }
}
