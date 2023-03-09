<?php

namespace App\Http\Controllers\Admin\Cates;

use App\Http\Controllers\Controller;
use App\Http\Traits\ProcessModelData;
use App\Models\Cates\Series;
use App\Models\Cates\Manufacture;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    use ProcessModelData;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $series = Series::all();
        $series->load('manufacture');
        return view('admin.series.index')->with(['series' => $series]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $isUpdate = false;
        $manufactures = Manufacture::all();
        return view('admin.series.create')->with([
            'isUpdate' => $isUpdate,
            'manufactures' => $manufactures,
        ]);
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

        // Save Series
        $series = Series::create($proData);

        return redirect()->route('admin.series.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cates\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function show(Series $series)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cates\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $series = Series::find($id);
        $manufactures = Manufacture::all();
        $isUpdate = true;

        return view('admin.series.create')->with([
            'series' => $series,
            'manufactures' => $manufactures,
            'isUpdate' => $isUpdate
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cates\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $series = Series::find($request->id);
        $proData = $this->processData($request);

        // Save Series
        $series->update($proData);

        return redirect()->route('admin.series.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cates\Series  $series
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $series = Series::find($request->id);
        $series->delete();
        return redirect()->route('admin.series.index');
    }
}
