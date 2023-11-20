<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;
use App\Models\Brand;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class BrandController extends Controller
{
    /**
     * Create a new controller instance
     */
    public function __construct()
    {
        $this->authorizeResource(Brand::class, 'brand');
    }


    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Renderable
     */
    public function index(Request $request): Renderable
    {
        $brands = QueryBuilder::for(Brand::class)
            ->allowedFilters([AllowedFilter::scope('search', 'whereScout')])
            ->paginate()
            ->appends($request->query());

        return view('admin.brands.index', [
            'brands' => $brands,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Renderable
     */
    public function create(): Renderable
    {
        return view('admin.brands.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreBrandRequest $request
     * @return RedirectResponse
     */
    public function store(StoreBrandRequest $request): RedirectResponse
    {
        Brand::query()->create($request->validated());

        return to_route('admin.brands.index')->with(
            'success',
            'Brand was successfully created',
        );
    }


    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Brand $brand
     * @return Renderable
     */
    public function edit(Brand $brand): Renderable
    {
        return view('admin.brands.edit', [
            'brand' => $brand,
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBrandRequest $request
     * @param Brand $brand
     * @return RedirectResponse
     */
    public function update(UpdateBrandRequest $request, Brand $brand): RedirectResponse
    {
        $brand->update($request->validated());

        return to_route('admin.brands.index')->with(
            'success',
            'Brand was successfully updated',
        );
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Brand $brand
     * @return RedirectResponse
     */
    public function destroy(Brand $brand): RedirectResponse
    {
        $brand->delete();

        return to_route('admin.brands.index')->with(
            'success',
            'Brand was successfully deleted',
        );
    }

}
