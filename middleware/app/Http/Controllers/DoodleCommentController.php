<?php

namespace App\Http\Controllers;

use App\Doodle;
use App\DoodleComment;
use Illuminate\Http\Request;

class DoodleCommentController extends Controller
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

        $doodle_comment = DoodleComment::create($request->only(
            'doodle_id',
            'user_id',
            'comment'
        ));

        if ($doodle_comment) {
            $doodle = Doodle::where('id', $doodle_comment->doodle_id)
                ->with('comments.user')
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
        $doodle_comment = DoodleComment::destroy($id);

        if ($doodle_comment) {
            return response()->json([
                'status' => 'success'
            ]);
        }

        return response()->json([
            'status' => 'error'
        ]);
    }
}
