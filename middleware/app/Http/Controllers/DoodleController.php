<?php

namespace App\Http\Controllers;

use App\Doodle;
use Illuminate\Http\Request;

class DoodleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $doodles = Doodle::all();

        if ($doodles) {
            return response()->json([
                'status' => 'success',
                'doodles' => $doodles
            ]);
        }

        return response()->json([
            'status' => 'error'
        ]);
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
        $request['image'] = json_encode($request->get('image'));

        $doodle = Doodle::create($request->only(
            'user_id',
            'name',
            'image'
        ));

        if ($doodle) {
            return response()->json([
                'status' => 'success',
                'doodle' => $doodle
            ]);
        }

        return response()->json([
            'status' => 'error'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $doodle = Doodle::where('id', $id)
            ->with('comments.user', 'ratings')
            ->first();

        if ($doodle) {
            $doodle->rating = $doodle->ratings()->avg('rating');
            $doodle->user_rating = $doodle->ratings()->where('user_id', $request->user()->id)->first();

            return response()->json([
                'status' => 'success',
                'doodle' => $doodle
            ]);
        }

        return response()->json([
            'status' => 'error'
        ]);
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
        $request['user_id'] = $request->user()->id;
        $request['image'] = json_encode($request->get('image'));

        $doodle = Doodle::where('id', $id);

        if ($doodle->count() > 0) {
            $doodle = $doodle->update($request->only(
                'user_id',
                'name',
                'image'
            ));

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $doodle = Doodle::destroy($id);

        if ($doodle) {
            return response()->json([
                'status' => 'success'
            ]);
        }

        return response()->json([
            'status' => 'error'
        ]);
    }

    /**
     * Get the all of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $page
     * @param  int  $limit
     * @param  string  $search
     * @return \Illuminate\Http\Response
     */
    public function all(Request $request, $page = 1, $limit = 10, $search = null)
    {
        if ($request->has('order')) {
            $doodles = Doodle::orderBy('created_at', $request->get('order'));
        } else {
            $doodles = Doodle::orderBy('created_at', 'desc');
        }

        if ($search != null) {
            $search = urldecode($search);

            $doodles = $doodles->where('name', 'LIKE', '%' . $search . '%');
        }

        $all_doodles = $doodles->take($limit)
            ->skip(($page * $limit) - $limit)
            ->get();

        if ($all_doodles) {
            return response()->json([
                'status' => 'success',
                'doodles' => $all_doodles,
                'count' => $doodles->count()
            ]);
        }

        return response()->json([
            'status' => 'error'
        ]);
    }
}
