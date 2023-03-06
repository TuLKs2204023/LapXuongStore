<?php

namespace App\Http\Controllers\Admin\Cates;

use App\Http\Controllers\Controller;
use App\Models\Cates\ScreenGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
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

        if ($this->isExactVal($proData)) {
            $proData['name'] = $proData['value'] . '"';
        }
        if ($this->isMinVal($proData)) {
            $proData['name'] = 'From ' . $proData['min'] . '"';
        }
        if ($this->isMaxVal($proData)) {
            $proData['name'] = 'To ' . $proData['max'] . ' "';
        }
        if ($this->isRangeVal($proData)) {
            $proData['name'] = 'From ' . $proData['min'] . '"' . ' to ' . $proData['max'] . '"';
        }

        $proData['slug'] = Str::slug($request->name);

        // Save RamGroup
        $ramGroup = ScreenGroup::create($proData);

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
     * @param  \App\Models\Cates\ScreenGroup  $screenGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(ScreenGroup $screenGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cates\ScreenGroup  $screenGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ScreenGroup $screenGroup)
    {
        //
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
        $screenGroup->delete();
        return redirect()->route('admin.screenGroup.index');
    }
}
