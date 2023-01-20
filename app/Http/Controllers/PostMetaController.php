<?php

namespace App\Http\Controllers;

use App\Models\PostMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostMetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return DB::select("CALL get_all_post_metas()");
        // return PostMeta::all();
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
            'meta_key' => 'required|string',
            'meta_value' => 'required|string'
        ]);
        
        $implodedData = implode("', '", $validatedData);

        return DB::select("CALL create_post_meta('" . $implodedData . "')");
        // return PostMeta::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return DB::select("CALL get_post_meta_by_id(".$id.")");
        // return PostMeta::find($id);
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
        $data = DB::select("CALL get_post_meta_by_id(".$id.")");
        $data = $data[0];
        $data = reset($data)."', '"; // gets the id of the object

        $validatedData = $request->validate([
            'post_id' => 'required|integer',
            'meta_key' => 'required|string',
            'meta_value' => 'required|string'
        ]);

        $implodedData = implode("', '", $validatedData);
        
        return DB::select("CALL update_post_meta('" . $data . $implodedData . "')");
        // $postMeta = PostMeta::find($id);
        // $postMeta->update($request->all());
        // return $postMeta;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return DB::select("CALL delete_post_meta(".$id.")");
        // return PostMeta::destroy($id);
    }
}
