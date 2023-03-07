<?php

namespace App\Http\Controllers\Admin\Cates;

use App\Http\Controllers\Controller;
use App\Http\Traits\ProcessModelData;
use App\Models\Cates\Gpu;
use Illuminate\Http\Request;

class GpuController extends Controller
{
    use ProcessModelData;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gpus = Gpu::all();
        return view('admin.gpu.index')->with(['gpus' => $gpus]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $isUpdate = false;
        return view('admin.gpu.create')->with(['isUpdate' => $isUpdate]);
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

        // Save GPU
        $cpu = Gpu::create($proData);

        return redirect()->route('admin.gpu.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cates\Gpu  $gpu
     * @return \Illuminate\Http\Response
     */
    public function show(Gpu $gpu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cates\Gpu  $gpu
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $gpu = Gpu::find($id);
        $isUpdate = true;

        return view('admin.gpu.create')->with([
            'gpu' => $gpu,
            'isUpdate' => $isUpdate
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cates\Gpu  $gpu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $gpu = Gpu::find($request->id);
        $proData = $this->processData($request);

        // Save Cpu
        $gpu->update($proData);

        return redirect()->route('admin.gpu.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cates\Gpu  $gpu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $gpu = Gpu::find($request->id);
        $gpu->delete();
        return redirect()->route('admin.gpu.index');
    }
}
