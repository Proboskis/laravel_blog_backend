<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::select("CALL get_all_comments()");
        // return Comment::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'post_id' => 'required|integer',
            'comment_parent_id' => 'required|integer',
            'title' => 'required|string',
            'published' => 'boolean',
            'content' => 'required|string'
        ]);
        
        $implodedData = implode("', '", $validatedData);

        return DB::select("CALL create_comment('" . $implodedData . "')");
        // return Comment::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return DB::select("CALL get_comment_by_id(".$id.")");
        // return Comment::find($id);
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
        $data = DB::select("CALL get_comment_by_id(".$id.")");
        $data = $data[0];
        $data = reset($data)."', '"; // gets the id of the object

        $validatedData = $request->validate([
            'post_id' => 'required|integer',
            'comment_parent_id' => 'required|integer',
            'title' => 'required|string',
            'published' => 'boolean',
            'content' => 'required|string'
        ]);

        $implodedData = implode("', '", $validatedData);
        
        return DB::select("CALL update_comment('" . $data . $implodedData . "')");
        // $comment = Comment::find($id);
        // $comment->update($request->all());
        // return $comment;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return DB::select("CALL delete_comment(".$id.")");
        // return Comment::destroy($id);
    }
}
