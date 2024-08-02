<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Banners obtenidos correctamente',
                'data' => $banners
            ],
            200
        );
    }

    public function update(Request $request)
    {
        $bannerId = $request['id'];
        $banner = Banner::find($bannerId);

        $banner->name = $request['name'];
        $banner->image = $request['image'];

        $banner->save();

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Banners obtenidos correctamente',
                'data' => $banner
            ],
            200
        );
    }
}
