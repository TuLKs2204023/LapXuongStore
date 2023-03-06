<?php

namespace App\Http\Controllers\Admin\Cates;

use App\Http\Controllers\Controller;
use App\Http\Traits\ProcessModelData;
use App\Models\Cates\Resolution;
use Illuminate\Http\Request;

class ResolutionController extends Controller
{
    use ProcessModelData;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $resolutions = Resolution::all();
        return view('admin.resolution.index')->with(['resolutions' => $resolutions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $isUpdate = false;
        return view('admin.resolution.create')->with(['isUpdate' => $isUpdate]);
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

        // Save Resolution
        $resolution = Resolution::create($proData);

        return redirect()->route('admin.resolution.index');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cates\Resolution  $resolution
     * @return \Illuminate\Http\Response
     */
    public function show(Resolution $resolution)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cates\Resolution  $resolution
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $resolution = Resolution::find($id);
        $isUpdate = true;

        return view('admin.resolution.create')->with([
            'resolution' => $resolution,
            'isUpdate' => $isUpdate
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cates\Resolution  $resolution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resolution $resolution)
    {
        $proData = $this->processData($request);

        // Save Resolution
        $resolution = Resolution::create($proData);

        return redirect()->route('admin.resolution.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cates\Resolution  $resolution
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $resolution = Resolution::find($request->id);
        $resolution->delete();
        return redirect()->route('admin.resolution.index');
    }
}
