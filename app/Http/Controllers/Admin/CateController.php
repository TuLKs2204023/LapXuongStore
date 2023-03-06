<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Traits\ProcessModelData;
use App\Models\Cates\Color;
use App\Models\Cates\Cpu;
use App\Models\Cates\Demand;
use App\Models\Cates\Gpu;
use App\Models\Cates\HddGroup;
use App\Models\Cates\Manufacture;
use App\Models\Cates\RamGroup;
use App\Models\Cates\Resolution;
use App\Models\Cates\ScreenGroup;
use App\Models\Cates\Series;
use App\Models\Cates\SsdGroup;

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
        // -----------------------------Manufacture section-----------------------------------
        $manufactures = Manufacture::all();
        $manufactures->load('cate');
        $this->proccessRefresh($manufactures, 1);

        // -----------------------------Series section-----------------------------------
        $series = Series::all();
        $series->load('cate');
        $this->proccessRefresh($series, 2);

        // -----------------------------CPU section-----------------------------------
        $cpus = Cpu::all();
        $cpus->load('cate');
        $this->proccessRefresh($cpus, 3);

        // -----------------------------GPU section-----------------------------------
        $gpus = Gpu::all();
        $gpus->load('cate');
        $this->proccessRefresh($gpus, 4);

        // -----------------------------RAM section-----------------------------------
        $ramGroups = RamGroup::all();
        $ramGroups->load('cate');
        $this->proccessRefresh($ramGroups, 5);

        // -----------------------------Screen section-----------------------------------
        $screenGroups = ScreenGroup::all();
        $screenGroups->load('cate');
        $this->proccessRefresh($screenGroups, 6);

        // -----------------------------HDD section-----------------------------------
        $hddGroups = HddGroup::all();
        $hddGroups->load('cate');
        $this->proccessRefresh($hddGroups, 7);

        // -----------------------------SSD section-----------------------------------
        $ssdGroups = SsdGroup::all();
        $ssdGroups->load('cate');
        $this->proccessRefresh($ssdGroups, 8);

        // -----------------------------Color section-----------------------------------
        $colors = Color::all();
        $colors->load('cate');
        $this->proccessRefresh($colors, 9);

        // -----------------------------Demand section-----------------------------------
        $demands = Demand::all();
        $demands->load('cate');
        $this->proccessRefresh($demands, 10);

        // -----------------------------Resolution section-----------------------------------
        $resolutions = Resolution::all();
        $resolutions->load('cate');
        $this->proccessRefresh($resolutions, 11);


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
