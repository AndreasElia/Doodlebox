<?php

namespace App\Http\Controllers;

use App\Doodle;
use App\DoodleRating;
use Illuminate\Http\Request;

class DoodleRatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
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
        $request['user_id'] = $request->user()->id;

        $doodle_rating = DoodleRating::where('doodle_id', $request->doodle_id)
            ->where('user_id', $request->user_id)
            ->first();

        if ($doodle_rating) {
            $doodle_rating = DoodleRating::destroy($doodle_rating->id);
        }

        $doodle_rating = DoodleRating::create($request->only(
            'doodle_id',
            'user_id',
            'rating'
        ));

        if ($doodle_rating) {
            $doodle = Doodle::where('id', $doodle_rating->doodle_id)
                ->with('comments.user', 'ratings')
                ->first();

            if ($doodle) {
                return response()->json([
                    'status' => 'success',
                    'doodle' => $doodle
                ]);
            }
        }

        return response()->json([
            'status' => 'error'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
