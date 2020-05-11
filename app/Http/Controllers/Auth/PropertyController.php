<?php

namespace App\Http\Controllers\Auth;

// use App\Traits\ImageUpload;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use App\Images;
use App\Property;
use App\Location;
use App\User;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;

class PropertyController extends Controller{
    // use ImageUpload;
    public function create(Request $request)
    {   
        $uuid = (string) Str::uuid();

        $validator = Validator::make($request->all(),[
            'image' =>  'required|image|mimes:jpeg,png,jpg,gif|max:8192',   

            'property_name' => 'required|text',
            'transaction_type' => 'required|text',
            'property_type' => 'required|text',
            'property_size' => 'required|text',     
            'price' => 'required|text',
            
            'Region' => 'required|text',
            'district' => 'required|text',
            'address' => 'required|text',
        ]);
        
        $user_id = Auth::id();

        if (!($image_info = getimagesize($request->image))) 
            return response()->json(array('error' => 'not image file'), 415);

        $image_ext = image_type_to_extension($image_info[2]);
        $image_name = $uuid.$image_ext;
        $path = $request->image->storeAs('image', $image_name);
        $external_path = storage_path().'/app/public/image/'.$image_name;


        $image = new Images;
        $image->user_id = $user_id;
        $image->image_name = $image_name;
        $image->save();
        $image->id;


        // $data = new Image;

        // $data->image = $request->image;
        // if($data->image){
        //    try {
        //     $filePath = $this->UserImageUpload($data->image); //Passing $data->image as parameter to our created method
        //     $data->image = $filePath;
        //     $data->save();
        //     return redirect()->back();
        //    }catch (Exception $e) {
        //         return response()->json([
        //             'message' => 'Upload fail'
        //         ], 200);//Write your error message here
        //     }
        //     }

        

        $location = new Location;
        $location->Region = $request->Region;
        $location->district = $request->district;
        $location->address = $request->address;
        $location->save();
        $location->id;

        $property = new Property;
        $property->user_id = $user_id;
        $property->location_id = $location->id;
        $property->image_id = $image->id;
        $property->property_name = $request->property_name;
        $property->transaction_type = $request->transaction_type;
        $property->property_type = $request->property_type;
        $property->property_size = $request->property_size;
        $property->price = $request->price;  
        $property->save();
        
        return response()->json([
            'message' => 'Successfully posted property!'
        ], 201);
    }

}
