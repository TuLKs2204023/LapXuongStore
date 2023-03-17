<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ProcessModelData;
use App\Models\HistoryProduct;
use App\Models\Product;
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
            return response()->json(['msg' => 'Stars and review cannot be left blank.']);
        } else {
            $user = User::find(auth()->user()->id);
            $user = $this->processRating($user, $proData);

            //history thầy Dự
            $this->adminRating($user,$proData);
            $this->userRating($user,$proData);
            // Render the view and include it in the JSON response
            $rating = $user->latestRate();
            $view = view('fe.home.rating', ['rating' => $rating])->render();
            return response()->json([
                'success' => true,
                'view' => $view,
            ]);
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
        $rId = $request->rId;
        $pId = $request->pId;
        $rating = Rating::find($rId);
        $rating->delete();
        $product = Product::find($pId);
        return response()->json([
            'message' => 'Rating saved successfully',
            'totalRate' => $product->countRates(),
        ]);
    }
    public function adminDelete(Request $request){
        $ratings = Rating::all()->sortByDesc('id');

        $rId = $request->id;
        // dd($rId);
        $review = Rating::where('product_id',$rId)->get()->first();

        $review->delete();
        return view('admin.rating.index', compact('ratings'));
    }
}
