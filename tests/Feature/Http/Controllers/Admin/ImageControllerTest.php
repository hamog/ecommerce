<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Services\Image;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class ImageControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_image_can_be_mocked(): void
    {
        $mock = $this->instance(
            Image::class,
            Mockery::mock(Image::class, function (MockInterface $mock) {
                $mock->shouldReceive('make');
            })
        );
        $this->assertTrue($mock instanceof Image);
    }
}
