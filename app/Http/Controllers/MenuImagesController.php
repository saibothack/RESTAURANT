<?php

namespace App\Http\Controllers;

use App\Menu;
use App\MenuImages;
use App\Restaurant;
use Illuminate\Http\Request;

class MenuImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $images = MenuImages::menu($id)->get();

        $menu = Menu::where('id', '=', $id)->first();
        $restaurant = Restaurant::where('id', '=', $menu->restaurants_id)->first();
        $imagesCount = MenuImages::menu($id)->count();
        $showAddFile = ($restaurant->images > $imagesCount);

        return view('images.index', compact('id', 'images', 'showAddFile'));
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
    public function store(Request $request, $id)
    {
        $this->validaImages($request);
        $file = $request->file('image');

        $destinationPath = '../public/images/menu/';
        $date = date('Y-m-d H:i:s');
        $nameFile = $id . $date . "." . $file->getClientOriginalExtension();
        $nameFile = str_replace(':', '-', $nameFile);
        $nameFile = str_replace(' ', '-', $nameFile);
        $file->move($destinationPath, $nameFile);

        $dataImage = array(
            'path' => $nameFile,
            'menus_id' => $id
        );

        MenuImages::create($dataImage);

        return redirect('menus/' . $id . '/images/')
            ->with('flash_message',
                'Se agrego la imagen!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MenuImages  $menuImages
     * @return \Illuminate\Http\Response
     */
    public function show(MenuImages $menuImages)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MenuImages  $menuImages
     * @return \Illuminate\Http\Response
     */
    public function edit(MenuImages $menuImages)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MenuImages  $menuImages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MenuImages $menuImages)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MenuImages  $menuImages
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        dd($request);





        /*$url = '../public/images/menu/'. $menuImages->path;

        dd($url);

        if (file_exists('../public/images/menu/'. $menuImages->path)) {
            unlink('../public/images/menu/'. $menuImages->path);
        }

        $menuImages->delete();


        return redirect('menus/' . $id . '/images/')
            ->with('flash_message',
                'Se elimino la imagen!');*/
    }

    public function validaImages($request)
    {
        $this->validate($request, [
                'image'=>'required|mimes:jpeg,png'
            ]
        );
    }
}
