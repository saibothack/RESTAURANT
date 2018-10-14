<?php

namespace App\Http\Controllers;

use App;
use Session;
use App\Client;
use App\Restaurant;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        //
    }

    public function getLogin($restaurant, $table)
    {
        if (Session::get('clientId') != null) {
            $url = 'restaurant/' . $restaurant . '/' . $table . '/client/' . Session::get('clientId');
            return redirect($url);
        }


        if (Restaurant::where('domain', '=', $restaurant)->count() == 0) {
            print("El restaurante no esta registrado.");
            exit();
        } else {
            return view('customers.login');
        }
    }

    public function setLogin(Request $request, $nameRestaurant, $table)
    {
        $this->validaClient($request);

        $restaurants = Restaurant::where('domain', '=', $nameRestaurant)->first();

        if (!is_numeric($table)) {
            print("La mesa no es la correcta.");
            exit();
        }

        if(intval($restaurants->tables) <= intval($table)) {
            print("El restaurant no tiene la mesa registrada.");
            exit();
        }

        $client = Client::create($request->only('name', 'email'));
        session(['clientId' => $client->id]);

        $url = 'restaurant/' . $nameRestaurant . '/' . $table . '/client/' . $client->id;
        return redirect($url);
    }

    public function validaClient($request)
    {
        $this->validate($request, [
                'name'=>'required|string',
                'email'=>'required|email'
            ]
        );
    }


}
