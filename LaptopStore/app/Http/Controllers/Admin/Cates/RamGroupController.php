<?php

namespace App\Http\Controllers\Admin\Cates;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cates\RamGroup;
use Illuminate\Support\Str;
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
        $ramGroup = RamGroup::create($proData);

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
        $ramGroup->delete();
        return redirect()->route('admin.ramGroup.index');
    }
}
