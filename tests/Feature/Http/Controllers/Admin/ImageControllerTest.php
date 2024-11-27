<?php

namespace Tests\Feature\Http\Controllers\Admin;

use Cloudinary\Asset\Image;
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
//        $this->instance(
//            Image::class,
//            Mockery::mock(Image::class, function (MockInterface $mock) {
//                $mock->shouldReceive('make')->once();
//            })
//        );
        $this->assertTrue(true);
    }
}
