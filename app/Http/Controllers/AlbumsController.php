<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Album;

class AlbumsController extends Controller
{
    //
    public function index()
    {
        $albums = Album::with('Photos')->get();
    	return view('albums.index')->with('albums',$albums);
    }
    public function create()
    {
    	return view('albums.create');
    }

    public function store(Request $request)
    {
    	$this->validate($request,[
            'name'=>'required',
            'cover_image'=>'image'
        ]);

        // Get filename with extension
        $filenamewithext = $request->file('cover_image')->getClientOriginalName();
        // return $filenamewithext;

        // Get filename without extension
        $filename = pathinfo($filenamewithext , PATHINFO_FILENAME);
        // return $filename;

        $extension = $request->file('cover_image')->getClientOriginalExtension();
        // return $extension;

        // File name to store
        $fileNameToStore = $filename."_".time().".".$extension;
        // return $fileNameToStore;

        // Upload Image
        $path = $request->file('cover_image')->storeAs('public/album_covers',$fileNameToStore);
        // return $path;

        // create album
        $album = new Album;

        $album->name = $request->input('name');
        $album->description = $request->input('description');
        $album->cover_image = $fileNameToStore;

        $album->save();

        return redirect('/albums')->with('success','Album Created');
    }

    public function show($id)
    {
        $album = Album::with('Photos')->find($id);
        return view('albums.show')->with('album',$album);
    }

    public function destroy($id)
    {
        $album = Album::find($id);
        if(Storage::delete('public/album_covers/'.$album->cover_image)){
        
            $album->delete();
            return redirect('/')->with('success','Album Deleted');
        }
    }
}
