<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ProcessModelData;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    use ProcessModelData;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ratings = Rating::all()->sortByDesc('id');
        return view('admin.rating.index', compact('ratings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $proData = $this->processDataWithOutSlug($request);
        if ($proData['selected_rating'] == null || $proData['review'] == null) {
            $errors = ['msg' => 'Stars and review cannot be left blank.'];
            return back()->withErrors($errors);
        } else {
            $user = User::find(auth()->user()->id);
            
            $user = $this->processRating($user, $proData);
            $this->adminRating($user,$proData);
            return back()->with('success', 'Review added successfully.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function show(Rating $rating)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function edit(Rating $rating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rating $rating)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rating  $rating
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $rId = $request->id;
        $rating = Rating::find($rId);
        $rating->delete();
        return back();
    }
}
