<?php

namespace App\Http\Controllers\Admin\Cates;

use App\Http\Controllers\Controller;
use App\Http\Traits\ProcessModelData;
use App\Models\Cates\Demand;
use Illuminate\Http\Request;

class DemandController extends Controller
{
    use ProcessModelData;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $demands = Demand::all();
        return view('admin.demand.index')->with(['demands' => $demands]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $isUpdate = false;
        return view('admin.demand.create')->with(['isUpdate' => $isUpdate]);
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

        // Save Demand
        $demand = Demand::create($proData);

        // Save Cate
        $cateData = $this->processCate($demand, 10);
        $demand->cate()->create($cateData);

        return redirect()->route('admin.demand.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cates\Demand  $demand
     * @return \Illuminate\Http\Response
     */
    public function show(Demand $demand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cates\Demand  $demand
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $demand = Demand::find($id);
        $isUpdate = true;

        return view('admin.demand.create')->with([
            'demand' => $demand,
            'isUpdate' => $isUpdate
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cates\Demand  $demand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $demand = Demand::find($request->id);
        $proData = $this->processData($request);

        // Save demand
        $demand->update($proData);

        // Save Cate
        $cateData = $this->processCate($demand, 10);
        $demand->cate()->update($cateData);

        return redirect()->route('admin.demand.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cates\Demand  $demand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $demand = Demand::find($request->id);
        $demand->cate()->delete();
        $demand->delete();
        return redirect()->route('admin.demand.index');
    }
}
