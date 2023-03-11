<?php

namespace App\Http\Controllers\Admin\Cates;

use App\Http\Controllers\Controller;
use App\Http\Traits\ProcessModelData;
use App\Models\Cates\SsdGroup;
use Illuminate\Http\Request;

class SsdGroupController extends Controller
{
    use ProcessModelData;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ssdGroups = SsdGroup::all();
        return view('admin.ssdGroup.index')->with(['ssdGroups' => $ssdGroups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $isUpdate = false;
        return view('admin.ssdGroup.create')->with(['isUpdate' => $isUpdate]);
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

        // Save SsdGroup
        $ssdGroup = SsdGroup::create($proData);

        // Save Cate
        $cateData = $this->processCate($ssdGroup, 8);
        $ssdGroup->cate()->create($cateData);

        return redirect()->route('admin.ssdGroup.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cates\SsdGroup  $ssdGroup
     * @return \Illuminate\Http\Response
     */
    public function show(SsdGroup $ssdGroup)
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
        $ssdGroup = SsdGroup::find($id);
        $isUpdate = true;

        return view('admin.ssdGroup.create')->with([
            'ssdGroup' => $ssdGroup,
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
        $ssdGroup = SsdGroup::find($request->id);
        $proData = $request->all();

        $proData = $this->processCateName($proData, 'GB');

        // Save SsdGroup
        $ssdGroup->update($proData);

        // Save Cate
        $cateData = $this->processCate($ssdGroup, 8);
        $ssdGroup->cate()->update($cateData);

        return redirect()->route('admin.ssdGroup.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cates\SsdGroup  $ssdGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ssdGroup = SsdGroup::find($request->id);
        $ssdGroup->cate()->delete();
        $ssdGroup->delete();
        return redirect()->route('admin.ssdGroup.index');
    }
}
