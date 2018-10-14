<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Photo;

class PhotosController extends Controller
{
    public function create($album_id)
    {
        return view('photos.create')->with('album_id',$album_id);
    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required',
            'photo'=>'image'
        ]);

        // Get filename with extension
        $filenamewithext = $request->file('photo')->getClientOriginalName();
        // return $filenamewithext;

        // Get filename without extension
        $filename = pathinfo($filenamewithext , PATHINFO_FILENAME);
        // return $filename;

        $extension = $request->file('photo')->getClientOriginalExtension();
        // return $extension;

        // File name to store
        $fileNameToStore = $filename."_".time().".".$extension;
        // return $fileNameToStore;

        // Upload Image
        $path = $request->file('photo')->storeAs('public/photos/'.$request->input('album_id'),$fileNameToStore);
        // return $path;

        // create photo
        $photo = new Photo;
        $photo->album_id=$request->input('album_id');
        $photo->photo = $fileNameToStore;
        $photo->title = $request->input('title');
        $photo->size= $request->file('photo')->getClientSize();
        $photo->description = $request->input('description');
        
        

        $photo->save();

        return redirect('/albums/'.$request->input('album_id'))->with('success','Photo Uploaded');
    }

    public function show($id)
    {
        $photo = Photo::find($id);
        return view('photos.show')->with('photo',$photo);
    }

    public function destroy($id)
    {
        $photo = Photo::find($id);
        if(Storage::delete('public/photos/'.$photo->album_id.'/'.$photo->photo)){
        
            $photo->delete();
            return redirect('/')->with('success','Photo Deleted');
        }
    }
}
