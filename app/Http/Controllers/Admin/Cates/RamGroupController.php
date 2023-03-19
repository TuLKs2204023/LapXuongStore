<?php

namespace App\Http\Controllers\Admin\Cates;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cates\RamGroup;
use App\Http\Traits\ProcessModelData;

class RamGroupController extends Controller
{

    use ProcessModelData;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ramGroups = RamGroup::all();
        return view('admin.ramGroup.index')->with(['ramGroups' => $ramGroups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $isUpdate = false;
        return view('admin.ramGroup.create')->with(['isUpdate' => $isUpdate]);
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

        // Save RamGroup
        $ramGroup = RamGroup::create($proData);

        // Save Cate
        $cateData = $this->processCate($ramGroup, 5);
        $ramGroup->cate()->create($cateData);

        return redirect()->route('admin.ramGroup.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $ramGroup = RamGroup::find($id);
        $isUpdate = true;

        return view('admin.ramGroup.create')->with([
            'ramGroup' => $ramGroup,
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
        $ramGroup = RamGroup::find($request->id);
        $proData = $request->all();

        $proData = $this->processCateName($proData, 'GB');

        // Save RamGroup
        $ramGroup->update($proData);

        // Save Cate
        $cateData = $this->processCate($ramGroup, 5);
        $ramGroup->cate()->update($cateData);

        return redirect()->route('admin.ramGroup.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ramGroup = RamGroup::find($request->id);
        $ramGroup->cate()->delete();
        $ramGroup->delete();
        return ['status' => 'success'];
    }
}
