<?php

namespace App\Http\Controllers;

use App\Models\Size;
use App\Http\Requests\StoreSizeRequest;
use App\Http\Requests\UpdateSizeRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SizeController extends BaseController
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
                    'resource' => __('Sizes')
                ]
            ), Size::selectOptions($request->search ?? '', ['id', 'name'], $request->limit ?? 5));
        }

        return view('sizes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('sizes.create',[
            'ajax' => $request->ajax()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSizeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSizeRequest $request)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try{
            $size = Size::create($validated);
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return $this->errorResponse(__('The record could not be saved'), 422, 'Error');
        }

        return $this->successResponse(__('Size created successfully'), $size);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Size $size)
    {
        return view('sizes.edit', [
            'ajax' => $request->ajax(),
            'size' => $size
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSizeRequest  $request
     * @param  \App\Models\Size  $size
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSizeRequest $request, Size $size)
    {
        $validated = $request->validated();

        DB::beginTransaction();
        try {
            $size->name = $validated['name'];
            $size->description = $validated['description'];
            $size->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse(__('The record could not be saved'), 422, 'Error');
        }

        return $this->successResponse(__('Size updated successfully'), $size);
    }
}
