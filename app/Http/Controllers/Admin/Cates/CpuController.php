<?php

namespace App\Http\Controllers\Admin\Cates;

use App\Http\Controllers\Controller;
use App\Models\Cates\Cpu;
use Illuminate\Http\Request;
use App\Http\Traits\ProcessModelData;

class CpuController extends Controller
{

    use ProcessModelData;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cpus = Cpu::all();
        return view('admin.cpu.index')->with(['cpus' => $cpus]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $isUpdate = false;
        return view('admin.cpu.create')->with(['isUpdate' => $isUpdate]);
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

        // Save Cpu
        $cpu = Cpu::create($proData);

        // Save Cate
        $cateData = $this->processCate($cpu, 3);
        $cpu->cate()->create($cateData);

        return redirect()->route('admin.cpu.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $cpu = Cpu::find($id);
        $isUpdate = true;

        return view('admin.cpu.create')->with([
            'cpu' => $cpu,
            'isUpdate' => $isUpdate
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $cpu = Cpu::find($request->id);
        $proData = $this->processData($request);

        // Save Cpu
        $cpu->update($proData);

        // Save Cate
        $cateData = $this->processCate($cpu, 3);
        $cpu->cate()->update($cateData);

        return redirect()->route('admin.cpu.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $cpu = Cpu::find($request->id);
        $cpu->cate()->delete();
        $cpu->delete();
        return redirect()->route('admin.cpu.index');
    }
}
