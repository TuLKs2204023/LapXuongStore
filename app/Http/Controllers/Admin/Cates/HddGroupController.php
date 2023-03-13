<?php

namespace App\Http\Controllers\Admin\Cates;

use App\Http\Controllers\Controller;
use App\Http\Traits\ProcessModelData;
use App\Models\Cates\HddGroup;
use Illuminate\Http\Request;

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
        $proData = $this->processCateName($proData, 'GB');

        // Save HddGroup
        $hddGroup = HddGroup::create($proData);

        // Save Cate
        $cateData = $this->processCate($hddGroup, 7);
        $hddGroup->cate()->create($cateData);

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
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $hddGroup = HddGroup::find($id);
        $isUpdate = true;

        return view('admin.hddGroup.create')->with([
            'hddGroup' => $hddGroup,
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
        $hddGroup = HddGroup::find($request->id);
        $proData = $request->all();

        $proData = $this->processCateName($proData, 'GB');

        // Save HddGroup
        $hddGroup->update($proData);

        // Save Cate
        $cateData = $this->processCate($hddGroup, 7);
        $hddGroup->cate()->update($cateData);

        return redirect()->route('admin.hddGroup.index');
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
        $hddGroup->cate()->delete();
        $hddGroup->delete();
        return redirect()->route('admin.hddGroup.index');
    }
}
