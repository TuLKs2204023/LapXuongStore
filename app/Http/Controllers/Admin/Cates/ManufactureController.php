<?php

namespace App\Http\Controllers\Admin\Cates;

use App\Http\Controllers\Controller;
use App\Models\Cates\Manufacture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Http\Traits\ProcessModelData;

class ManufactureController extends Controller
{

    use ProcessModelData;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manufactures = Manufacture::all();
        $manufactures->load('image');
        return view('admin.manufacture.index')->with(['manufactures' => $manufactures]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $isUpdate = false;
        return view('admin.manufacture.create')->with(['isUpdate' => $isUpdate]);
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

        // Save Manufacture
        $manufacture = Manufacture::create($proData);

        // Save Images
        $file = $this->processImage($request);
        if ($file) {
            $manufacture->image()->create($file[0]);
        }

        return redirect()->route('admin.manufacture.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $manufacture = Manufacture::find($id);
        $isUpdate = true;

        return view('admin.manufacture.create')->with([
            'manufacture' => $manufacture,
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
        $manufacture = Manufacture::find($request->id);
        $proData = $this->processData($request);

        // Save Manufacture
        $manufacture->update($proData);

        // Save Image
        $file = $this->processImage($request);

        $image[] = $manufacture->image;

        if ($manufacture->image()->count() > 0) {
            $this->removeItems($image, $proData);
        }

        if ($file) {
            $manufacture->image()->create($file[0]);
        }

        return redirect()->route('admin.manufacture.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $manufacture = Manufacture::find($request->id);
        $image = $manufacture->image;
        File::delete(public_path("images/" . $image->url));
        $image->delete();
        $manufacture->delete();
        return redirect()->route('admin.manufacture.index');
    }
}
