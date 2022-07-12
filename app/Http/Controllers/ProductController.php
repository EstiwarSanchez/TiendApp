<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreproductRequest;
use App\Http\Requests\UpdateproductRequest;
use App\Models\Brand;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->successResponse(___(
                'List of :resource obtained',
                [
                    'resource' => __('Brands')
                ]
            ), Product::selectOptions($request->search ?? '', ['id', 'name'], $request->limit ?? 5));
        }

        return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $brands = Brand::getBrand()->get();
        $sizes = Size::all();
        return view('products.create',[
            'ajax' => $request->ajax(),
            'brands' => $brands,
            'sizes' => $sizes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreproductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreproductRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try{
            $product = Product::create($validated);
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return $this->errorResponse(__('The record could not be saved'), 422, 'Error');
        }

        return $this->successResponse(__('Product created successfully'), $product);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, product $product)
    {
        $brands = Brand::getBrand()->get();
        $sizes = Size::all();
        return view('products.edit',[
            'ajax' => $request->ajax(),
            'product' => $product,
            'brands' => $brands,
            'sizes' => $sizes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateproductRequest  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateproductRequest $request, product $product)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try{
            $product->name = $validated['name'];
            $product->size_id = $validated['size_id'];
            $product->brand_id = $validated['brand_id'];
            $product->observations = $validated['observations'];
            $product->inventory_quantity = $validated['inventory_quantity'];
            $product->boarding_date = $validated['boarding_date'];
            $product->save();
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return $this->errorResponse(__('The record could not be saved'), 422, 'Error');
        }

        return $this->successResponse(__('Product updated successfully'), $product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(product $product)
    {
        DB::beginTransaction();
        try {
            $product->delete = 1;
            $product->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse(__('The record could not be saved'), 422, 'Error');
        }

        return $this->successResponse(__('Product deleted successfully'), $product);
    }
}
