<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMediaRequest;
use CloudinaryLabs\CloudinaryLaravel\CloudinaryEngine;
use CloudinaryLabs\CloudinaryLaravel\Model\Media;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ImageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMediaRequest $request
     * @return Response
     */
    public function store(StoreMediaRequest $request)
    {
        $path = $request->validated('image')->store('products');

        return response($path, 200)->header('Content-Type', 'text/plain');
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return StreamedResponse
     */
    public function show(Request $request)
    {
        $path = $request->query('path', '');

        if (!Storage::exists($path)) {
            abort(404);
        }

        return Storage::download($path, Str::afterLast($path, '/'), [
            'Content-Disposition' => 'inline',
            'filename' => Str::afterLast($path, '/'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return Response
     */
    public function destroy(Request $request)
    {
        $media = $request->query('media');

        if (Storage::exists($media)) {
            Storage::delete($media);

            return response()->noContent();
        }

        $media = Media::where('file_url', $media)->firstOrFail();

        resolve(CloudinaryEngine::class)->destroy($media->getFileName());

        $media->delete();

        return response()->noContent();
    }
}
