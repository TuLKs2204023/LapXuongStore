<?php

namespace App\Http\Controllers\Admin\Cates;

use App\Http\Controllers\Controller;
use App\Models\Cates\ScreenGroup;
use Illuminate\Http\Request;
use App\Http\Traits\ProcessModelData;

class ScreenGroupController extends Controller
{
    use ProcessModelData;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $screenGroups = ScreenGroup::all();
        return view('admin.screenGroup.index')->with(['screenGroups' => $screenGroups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $isUpdate = false;
        return view('admin.screenGroup.create')->with(['isUpdate' => $isUpdate]);
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
        $proData = $this->processCateName($proData, '"');

        // Save ScreenGroup
        $screenGroup = ScreenGroup::create($proData);

        // Save Cate
        $cateData = $this->processCate($screenGroup, 6);
        $screenGroup->cate()->create($cateData);

        return redirect()->route('admin.screenGroup.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cates\ScreenGroup  $screenGroup
     * @return \Illuminate\Http\Response
     */
    public function show(ScreenGroup $screenGroup)
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
        $screenGroup = ScreenGroup::find($id);
        $isUpdate = true;

        return view('admin.screenGroup.create')->with([
            'screenGroup' => $screenGroup,
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
        $screenGroup = ScreenGroup::find($request->id);
        $proData = $request->all();

        $proData = $this->processCateName($proData, '"');

        // Save ScreenGroup
        $screenGroup->update($proData);

        // Save Cate
        $cateData = $this->processCate($screenGroup, 6);
        $screenGroup->cate()->update($cateData);

        return redirect()->route('admin.screenGroup.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cates\ScreenGroup  $screenGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $screenGroup = ScreenGroup::find($request->id);
        $screenGroup->cate()->delete();
        $screenGroup->delete();
        return redirect()->route('admin.screenGroup.index');
    }
}
