<?php

namespace App\Http\Controllers;


use DB;
use Auth;
use Session;
use App\Menu;
use App\Optional;
use App\Restaurant;
use App\MenuImages;
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
        $idRestaurant = "";
        if (!Auth::user()->hasRole('Administrador')) {
            $idRestaurant = Auth::user()->restaurants_id;
        } else {
            if (($request->get('restaurants_id') != "") && ($request->get('restaurants_id') != "0")){

                $idRestaurant = $request->get('restaurants_id');
            }
        }

        $menus = Menu::search($request->get('search'))->active($request->get('active'))->restaurant($idRestaurant)->paginate(10);

        foreach ($menus as $menu)
        {
            $menu->join = Restaurant::where('id', '=', $menu->restaurants_id)->get();
        }

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

        $idRestaurant = "";
        if (!Auth::user()->hasRole('Administrador')) {
            $idRestaurant = Auth::user()->restaurants_id;
        }

        $optionals = Optional::type('2')->resturant($idRestaurant)->get();
        $extras = Optional::type('1')->resturant($idRestaurant)->get();

        $arrayStatus = array(
            '' => 'Seleccione',
            '0' => 'Deshabilitado',
            '1' => 'Activado',
            '2' => 'Agotado'
        );

        return view('menus.create', compact('menus', 'arrayStatus', 'restaurants', 'optionals', 'extras'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $menu = null;
        if (Auth::user()->hasRole('Administrador')) {
            $this->validaMenuAdmin($request);
            $menu = Menu::create($request->only('restaurants_id', 'title', 'description', 'price', 'active'));
        } else {
            $this->validaMenu($request);

            $dataOptional = array(
                'restaurants_id' => Auth::user()->restaurants_id,
                'title' => $request['title'],
                'description' => $request['description'],
                'price' => $request['price'],
                'active' => $request['active']
            );

            $menu = Menu::create($dataOptional);
        }

        if (isset($request['optionals'])) {
            foreach ($request['optionals'] as $optional) {
                DB::table('optionals_has_menu')->insertGetId(
                    ['menus_id' => $menu->id, 'optionals_id' => $optional]
                );
            }
        }

        if(isset($request['extras'])) {
            foreach ($request['extras'] as $extra) {
                DB::table('optionals_has_menu')->insertGetId(
                    ['menus_id' => $menu->id, 'optionals_id' => $extra]
                );
            }
        }

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

        $idRestaurant = "";
        if (!Auth::user()->hasRole('Administrador')) {
            $idRestaurant = Auth::user()->restaurants_id;
        }

        $optionals = Optional::type('2')->resturant($idRestaurant)->get();
        $extras = Optional::type('1')->resturant($idRestaurant)->get();

        $selectQuery = DB::table('optionals')->select('optionals.id')
                        ->join('optionals_has_menu', function ($join) use ($id) {
                            $join->on('optionals.id', '=', 'optionals_has_menu.optionals_id')
                                ->where('optionals_has_menu.menus_id', '=', $id);
                        })
                        ->get();

        $optionalsSelect = array();
        $i = 0;

        foreach($selectQuery as $select){
            $optionalsSelect[$i] = $select->id;
            $i++;
        }

        $menu = Menu::findOrFail($id);

        $arrayStatus = array(
            '' => 'Seleccione',
            '0' => 'Deshabilitado',
            '1' => 'Activado'
        );

        return view('menus.edit', compact('menu', 'arrayStatus', 'restaurants', 'optionals', 'extras', 'optionalsSelect'));
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
        $menu = Menu::findOrFail($id);
        if (Auth::user()->hasRole('Administrador')) {
            $this->validaMenuAdmin($request);
            $menu->fill($request->only('restaurants_id', 'title', 'description', 'price', 'active'))->save();
        } else {
            $this->validaMenu($request);

            $dataOptional = array(
                'restaurants_id' => Auth::user()->restaurants_id,
                'title' => $request['title'],
                'description' => $request['description'],
                'price' => $request['price'],
                'active' => $request['active']
            );

            $menu->fill($dataOptional)->save();
        }

        DB::table('optionals_has_menu')->where('menus_id', '=', $menu->id)->delete();

        if (isset($request['optionals'])) {
            foreach ($request['optionals'] as $optional) {
                $id = DB::table('optionals_has_menu')->insertGetId(
                    ['menus_id' => $menu->id, 'optionals_id' => $optional]
                );
            }
        }

        if (isset($request['extras'])) {
            foreach ($request['extras'] as $extra) {
                $id = DB::table('optionals_has_menu')->insertGetId(
                    ['menus_id' => $menu->id, 'optionals_id' => $extra]
                );
            }
        }

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

    public function validaMenuAdmin($request)
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

    public function validaMenu($request)
    {
        $this->validate($request, [
                'title'=>'required|string',
                'description'=>'required|string',
                'price'=>'required',
                'active'=>'required|int'
            ]
        );
    }

    public function getMenuClient($restaurant, $table, $idClient) {

        if (Session::get('clientId') == null) {
            $url = 'restaurant/' . $restaurant . '/' . $table;
            return redirect($url);
        }

        $restaurants = Restaurant::where('domain', '=', $restaurant)->first();

        if (!is_numeric($table)) {
            print("La mesa no es la correcta.");
            exit();
        }

        if(intval($restaurants->tables) <= intval($table)) {
            print("El restaurant no tiene la mesa registrada.");
            exit();
        }

        $menus = Menu::where('restaurants_id', '=', $restaurants->id)->get();

        foreach ($menus as $menu) {
            $menu->join = MenuImages::where('menus_id', '=', $menu->id)->get();
        }

        $total = 0;
        $totalCuenta = 0;

        if (Session::get('dataOrder') != null){
            $totalCuenta = count(Session::get('dataOrder'));

            foreach (Session::get('dataOrder') as $order) {
                $total += (intval(Menu::where('id', '=', $order['idMenu'])->first()->price) * intval($order['request']['number_dish']));

                if (isset($order['request']['optionals'])) {
                    foreach ($order['request']['optionals'] as $optional) {
                        $total += intval(Optional::where('id', '=', $optional)->first()->price);
                    }
                }
            }
        }

        return view('menus.menu', compact('menus', 'restaurant', 'table', 'idClient', 'total', 'totalCuenta'));

    }
}
