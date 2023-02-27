<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Traits\ProcessModelData;
use App\Models\Cates\Cpu;
use App\Models\Cates\Manufacture;
use App\Models\Cates\RamGroup;

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
        $cates->loadMorph('cateable', ['manufacture', 'cpu', 'ramGroup']);

        return view('admin.cate.index')->with(['cates' => $cates]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $manufactures = Manufacture::all();
        $manufactures->load('cate');
        $this->proccessRefresh($manufactures, 1);

        $cpus = Cpu::all();
        $cpus->load('cate');
        $this->proccessRefresh($cpus, 3);

        $ramGroups = RamGroup::all();
        $ramGroups->load('cate');
        $this->proccessRefresh($ramGroups, 5);


        return back()->with('success', 'Data refreshed successfully !');
    }

    private function proccessRefresh($data, $groupId)
    {
        if (count($data) > 0) {
            foreach ($data as $item) {
                if (Cate::where([
                    ['name', $item->name],
                    ['cate_groups_id', $groupId],
                ])->count() == 0) {
                    $cateItm['name'] = $item->name;
                    $cateItm['slug'] = Str::slug($item->name);
                    $cateItm['cate_groups_id'] = $groupId;

                    $item->cate()->create($cateItm);
                }
            }
        } else {
            return false;
        }
    }
}
