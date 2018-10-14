<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Restaurant;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paginate = 10;
        if (!isset($request)) {
            $paginate = $request->get('paginate');
        }

        $menus = Menu::search($request->get('search'))->active($request->get('active'))->restaurant($request->get('restaurants_id'))->paginate($paginate);

        $restaurants = Restaurant::active(1)->pluck('name', 'id');

        $restaurants[0] = 'Seleccione';

        $arrayStatus = array(
            '' => 'Seleccione', 
            '0' => 'Deshabilitado', 
            '1' => 'Activado'
        );

        return view('menus.index', compact('menus', 'arrayStatus', 'restaurants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $restaurants = Restaurant::active(1)->pluck('name', 'id');

        $arrayStatus = array(
            '' => 'Seleccione',
            '0' => 'Deshabilitado',
            '1' => 'Activado',
            '2' => 'Agotado'
        );

        return view('menus.create', compact('menus', 'arrayStatus', 'restaurants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validaMenu($request);

        $menu = Menu::create($request->only('restaurants_id', 'title', 'description', 'price', 'active'));

        return redirect()->route('menus.index')
            ->with('flash_message',
                'Se agrego su registro!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $restaurants = Restaurant::active(1)->pluck('name', 'id');

        $menu = Menu::findOrFail($id);

        $arrayStatus = array(
            '' => 'Seleccione',
            '0' => 'Deshabilitado',
            '1' => 'Activado'
        );

        return view('menus.edit', compact('menu', 'arrayStatus', 'restaurants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validaMenu($request);

        $menu = Menu::findOrFail($id);
        $menu->fill($request->only('restaurants_id', 'title', 'description', 'price', 'active'))->save();

        return redirect()->route('menus.index')
            ->with('flash_message',
                'Su registro fue modificado.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('menus.index')
            ->with('flash_message',
                'Fue eliminado el menu!');
    }

    public function validaMenu($request)
    {
        $this->validate($request, [
                'restaurants_id'=>'required|int|min:1',
                'title'=>'required|string',
                'description'=>'required|string',
                'price'=>'required',
                'active'=>'required|int'
            ]
        );
    }
}
