<?php

namespace App\Http\Controllers\Admin\Cates;

use App\Http\Controllers\Controller;
use App\Http\Traits\ProcessModelData;
use App\Models\Cates\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    use ProcessModelData;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = Color::all();
        return view('admin.color.index')->with(['colors' => $colors]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $isUpdate = false;
        return view('admin.color.create')->with(['isUpdate' => $isUpdate]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $proData = $this->processData($request);

        // Save color
        $color = Color::create($proData);

        // Save Cate
        $cateData = $this->processCate($color, 9);
        $color->cate()->create($cateData);

        return redirect()->route('admin.color.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cates\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function show(Color $color)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cates\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $color = Color::find($id);
        $isUpdate = true;

        return view('admin.color.create')->with([
            'color' => $color,
            'isUpdate' => $isUpdate
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cates\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $color = Color::find($request->id);
        $proData = $this->processData($request);

        // Save color
        $color->update($proData);

        // Save Cate
        $cateData = $this->processCate($color, 9);
        $color->cate()->update($cateData);

        return redirect()->route('admin.color.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cates\Color  $color
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $color = Color::find($request->id);
        if (count($color->products) > 0) {
            return ['status' => 'aborted'];
        }
        $color->cate()->delete();
        $color->delete();
        return ['status' => 'success'];
    }
}
