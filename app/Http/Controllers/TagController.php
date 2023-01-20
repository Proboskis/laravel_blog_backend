<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::select("CALL get_all_tags()");
        // return Tag::all();
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
            'title' => 'required|string',
            'meta_title' => 'required|string',
            'slug' => 'required|string',
            'content' => 'required|string'
        ]);

        
        $implodedData = implode("', '", $validatedData);

        return DB::select("CALL create_tag('" . $implodedData . "')");
        // needs timestamps for bellow code to work
        // return Tag::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return DB::select("CALL get_tag_by_id(".$id.")");
        // return Tag::find($id);
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
        $data = DB::select("CALL get_tag_by_id(".$id.")");
        $data = $data[0];
        $data = reset($data)."', '"; // gets the id of the object

        $validatedData = $request->validate([
            'title' => 'required|string',
            'meta_title' => 'required|string',
            'slug' => 'required|string',
            'content' => 'required|string'
        ]);

        $implodedData = implode("', '", $validatedData);
        
        return DB::select("CALL update_tag('" . $data . $implodedData . "')");
        // $tag = Tag::find($id);
        // $tag->update($request->all());
        // return $tag;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return DB::select("CALL delete_tag(".$id.")");
        // return Tag::destroy($id);
    }

    /**
     * Search for a title of the specified resource from storage.
     *
     * @param  str  $title
     * @return \Illuminate\Http\Response
     */
    public function search(string $title)
    {
        return DB::select("CALL search_by_tag_title('" .$title. "')");
        // return Tag::where('tag', 'like', '%'.$title.'%')->get();
    }
}
