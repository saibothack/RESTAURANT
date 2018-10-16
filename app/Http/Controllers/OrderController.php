<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Menu;
use App\Order;
use App\Optional;
use App\MenuImages;
use App\Restaurant;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($restaurant, $table, $idClient, $idMenu)
    {
        if (Session::get('clientId') == null) {
            $url = 'restaurant/' . $restaurant . '/' . $table;
            return redirect($url);
        }

        $restaurants = Restaurant::where('domain', '=', $restaurant)->first();

        if(intval($restaurants->tables) <= intval($table)) {
            print("El restaurant no tiene la mesa registrada.");
            exit();
        }

        if (!is_numeric($table)) {
            print("La mesa no es la correcta.");
            exit();
        }

        $menu = Menu::where('id', '=', $idMenu)->first();

        if (!isset($menu)) {
            print("El menu no corresponde.");
            exit();
        }

        $menu->join = MenuImages::where('menus_id', '=', $idMenu)->get();

        $selectExtras = DB::table('optionals')
            ->join('optionals_has_menu', function ($join) use ($idMenu) {
                $join->on('optionals.id', '=', 'optionals_has_menu.optionals_id')
                    ->where('optionals_has_menu.menus_id', '=', $idMenu);
            })
            ->get();



        return view('orders.index', compact('menu', 'restaurant', 'table', 'idClient', 'selectExtras', 'idMenu', 'total'));


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
    public function store(Request $request, $restaurant, $table, $idClient, $idMenu)
    {
        $dataOrder = array(
            'request' => $request->only('number_dish', 'optionals'),
            'restaurant' => $restaurant,
            'table' => $table,
            'idClient' => $idClient,
            'idMenu' => $idMenu
        );

        if (Session::get('dataOrder') != null) {
            $data = Session::get('dataOrder');
            $data[count(Session::get('dataOrder'))] = $dataOrder;
            session(['dataOrder' => $data]);
        } else {
            $data[0] = $dataOrder;
            session(['dataOrder' => $data]);
        }

        return view('orders.action', compact('restaurant', 'table', 'idClient'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($restaurant, $table, $idClient)
    {
        if (Session::get('clientId') == null) {
            $url = 'restaurant/' . $restaurant . '/' . $table;
            return redirect($url);
        }

        $restaurants = Restaurant::where('domain', '=', $restaurant)->first();

        if(intval($restaurants->tables) <= intval($table)) {
            print("El restaurant no tiene la mesa registrada.");
            exit();
        }

        if (!is_numeric($table)) {
            print("La mesa no es la correcta.");
            exit();
        }

        $total = 0;
        $i = 0;

        $data = array();

        if (Session::get('dataOrder') != null){
            foreach (Session::get('dataOrder') as $order) {
                $menu = Menu::where('id', '=', $order['idMenu'])->first();
                $total += (intval($menu->price) * intval($order['request']['number_dish']));

                $x = 0;

                if (isset($order['request']['optionals'])) {
                    foreach ($order['request']['optionals'] as $optional) {
                        $total += intval(Optional::where('id', '=', $optional)->first()->price);
                        $x++;
                    }
                }

                $data[$i] = array(
                    'name' => $menu->title,
                    'price' => $total,
                    'dish' => $order['request']['number_dish'],
                    'extras' => $x
                );

                $total = 0;
                $i++;
            }
        }

        return view('orders.show', compact('data', 'restaurant', 'table', 'idClient'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($restaurant, $table, $idClient, $id)
    {
        $dataOrder = array();
        $i=0;
        if (Session::get('dataOrder') != null){
            $data = Session::get('dataOrder');
            unset($data[$id]);

            foreach ($data as $dat) {
                $dataOrder[$i] = $dat;
                $i++;
            }
        }

        session(['dataOrder' => $dataOrder]);

        return redirect('restaurant/' . $restaurant . '/' . $table . '/client/' . $idClient . '/detail');
    }
}
