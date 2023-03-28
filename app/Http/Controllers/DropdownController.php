<?php

namespace App\Http\Controllers;

use App\Models\Address\City;
use App\Models\Address\District;
use App\Models\Address\Ward;
use Illuminate\Http\Request;

class DropdownController extends Controller
{
    public function fetchCity()
    {
        $data['city'] = City::orderBy('name', 'ASC')->get(["name", "id"]);
        return view('dropdown', $data);
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function fetchDistrict(Request $request)
    {
        $data['districts'] = District::orderBy('name', 'ASC')->where("city_id", $request->id)
            ->get(["name", "id"]);
        return response()->json($data);
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function fetchWard(Request $request)
    {
        $data['wards'] = Ward::orderBy('name', 'ASC')->where("district_id", $request->district_id)
            ->get(["name", "id"]);
        return response()->json($data);
    }
}
