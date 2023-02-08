<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::select("CALL get_all_posts()");
        // return Post::all();
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
            'user_id' => 'required|integer',
            'post_parent_id' => 'required|integer',
            'title' => 'required|string',
            'meta_title' => 'required|string',
            'slug' => 'required|string',
            'summary' => 'required|string',
            'content' => 'required|string'
        ]);

        $implodedData = implode("', '", $validatedData);

        return DB::select("CALL create_post('" . $implodedData . "')");
        // return Post::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return DB::select("CALL get_post_by_id(".$id.")");
        // return Post::find($id);
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
        $data = DB::select("CALL get_post_by_id(".$id.")");
        $data = $data[0];
        $data = reset($data)."', '"; // gets the id of the object

        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'post_parent_id' => 'required|integer',
            'title' => 'required|string',
            'meta_title' => 'required|string',
            'slug' => 'required|string',
            'summary' => 'required|string',
            'published' => 'required',
            'content' => 'required|string'
        ]);

        $implodedData = implode("', '", $validatedData);

        return DB::select("CALL update_post('" . $data . $implodedData . "')");
        // $post = Post::find($id);
        // $post->update($request->all());
        // return $post;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return DB::select("CALL delete_post(".$id.")");
        // return Post::destroy($id);
    }

     /**
     * Search for a title of the specified resource from storage.
     *
     * @param  str  $title
     * @return \Illuminate\Http\Response
     */
    public function search(string $title)
    {
        return DB::select("CALL search_by_post_title('" .$title. "')");
        // return Post::where('title', 'like', '%'.$title.'%')->get();
    }
}
