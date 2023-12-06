<?php

namespace Tests\Feature\Classes;

use App\Classes\File;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery\MockInterface;
use Tests\TestCase;

class FileTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_can_upload_file(): void
    {
        $mock = $this->mock(File::class, function (MockInterface $mock) {
            $mock->shouldReceive('upload')->once();
        });


    }
}
