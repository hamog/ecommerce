<?php

namespace Tests\Feature\Console\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InspireTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_can_run_inspire_command(): void
    {
        $this->artisan('inspire')
            ->assertExitCode(0);
    }
}
