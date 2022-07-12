<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorebrandRequest;
use App\Http\Requests\UpdatebrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandController extends BaseController
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
            ), Brand::selectOptions($request->search ?? '', ['id', 'name'], $request->limit ?? 5));
        }

        return view('brands.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('brands.create',[
            'ajax' => $request->ajax()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorebrandRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try{
            $brand = Brand::create($validated);
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return $this->errorResponse(__('The record could not be saved'), 422, 'Error');
        }

        return $this->successResponse(__('Brand created successfully'), $brand);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Brand $brand)
    {
        return view('brands.edit', [
            'ajax' => $request->ajax(),
            'brand' => $brand
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatebrandRequest $request, Brand $brand)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            $brand->name = $validated['name'];
            $brand->reference = $validated['reference'];
            $brand->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse(__('The record could not be saved'), 422, 'Error');
        }

        return $this->successResponse(__('Brand updated successfully'), $brand);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
        DB::beginTransaction();
        try {
            $brand->delete = 1;
            $brand->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse(__('The record could not be saved'), 422, 'Error');
        }

        return $this->successResponse(__('Brand deleted successfully'), $brand);
    }
}
