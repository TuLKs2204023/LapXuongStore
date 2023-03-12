<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Traits\ProcessModelData;
use App\Models\CateGroup;

class CateController extends Controller
{

    use ProcessModelData;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cates = Cate::all();
        $cates->load('cate_group');
        // $cates->loadMorph('cateable', ['manufacture', 'cpu', 'ramGroup']);

        return view('admin.cate.index')->with(['cates' => $cates]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function refresh()
    {
        $cateGrps = CateGroup::all();

        foreach ($cateGrps as $cateGrp) {
            $cateClass = 'App\Models\Cates\\' . $cateGrp->reference_name;
            $cate = $cateClass::all();
            $cate->load('cate');
            $this->proccessRefresh($cate, $cateGrp->id);
        }
        return back()->with('success', 'Data refreshed successfully !');
    }

    private function proccessRefresh($data, $groupId)
    {
        if (count($data) > 0) {
            foreach ($data as $item) {
                $cateItm['name'] = $item->name;
                $cateItm['slug'] = Str::slug($item->name);
                $cateItm['cate_groups_id'] = $groupId;

                $item->cate()->firstOrCreate(
                    ['name' => $item->name, 'cate_groups_id' => $groupId],
                    $cateItm
                );
            }
        } else {
            return false;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $cate = Cate::find($id);
        $isUpdate = true;
        return view('admin.cate.create')->with([
            'cate' => $cate,
            'isUpdate' => $isUpdate,
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
        $cate = Cate::find($request->id);
        $proData = $this->processData($request);

        // Save Cate
        $cate->update($proData);

        return redirect()->route('admin.cate.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $cate = Cate::find($request->id);
        $cate->delete();
        return redirect()->route('admin.cate.index');
    }

    /**
     * Toggle specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toggleDisplay(Request $request)
    {
        $cateId = $request->cateId;
        $cate = Cate::find($cateId);
        $request->isDisplay ? $result = 1 : $result = 0;

        switch ($request->navOrSearch) {
            case 'nav':
                $cate->showOnNav = $result;
                $cate->save();
                break;
            case 'search':
                $cate->showOnSearch = $result;
                $cate->save();
                break;
            default:
                break;
        }
        return $cate;
    }
}
