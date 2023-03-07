<?php

namespace App\Http\Controllers\Admin\Cates;

use App\Http\Controllers\Controller;
use App\Http\Traits\ProcessModelData;
use App\Models\Cates\HddGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HddGroupController extends Controller
{
    use ProcessModelData;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $hddGroups = HddGroup::all();
        return view('admin.hddGroup.index')->with(['hddGroups' => $hddGroups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $isUpdate = false;
        return view('admin.hddGroup.create')->with(['isUpdate' => $isUpdate]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $proData = $request->all();

        if ($this->isExactVal($proData)) {
            $proData['name'] = $proData['value'] . 'GB';
        }
        if ($this->isMinVal($proData)) {
            $proData['name'] = 'From ' . $proData['min'] . 'GB';
        }
        if ($this->isMaxVal($proData)) {
            $proData['name'] = 'To ' . $proData['max'] . 'GB';
        }
        if ($this->isRangeVal($proData)) {
            $proData['name'] = 'From ' . $proData['min'] . 'GB' . ' to ' . $proData['max'] . 'GB';
        }

        $proData['slug'] = Str::slug($request->name);

        // Save RamGroup
        $ramGroup = HddGroup::create($proData);

        return redirect()->route('admin.hddGroup.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cates\HddGroup  $hddGroup
     * @return \Illuminate\Http\Response
     */
    public function show(HddGroup $hddGroup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cates\HddGroup  $hddGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(HddGroup $hddGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cates\HddGroup  $hddGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HddGroup $hddGroup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cates\HddGroup  $hddGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $hddGroup = HddGroup::find($request->id);
        $hddGroup->delete();
        return redirect()->route('admin.hddGroup.index');
    }
}
