<?php

namespace App\Http\Controllers;
use App\Models\City;
use App\Models\District;
Use App\Models\Ward;

use Illuminate\Http\Request;

class DropdownController extends Controller
{
    public function fetchCity()
    {
        $data['city'] = City::get(["name", "id"]);
        return view('dropdown', $data);
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function fetchDistrict(Request $request)
    {
        $data['districts'] = District::where("city_id", $request->id)
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
        $data['wards'] = Ward::where("district_id", $request->district_id)
                                    ->get(["name", "id"]);

        return response()->json($data);
    }
}
