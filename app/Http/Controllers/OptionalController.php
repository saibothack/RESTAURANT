<?php

namespace App\Http\Controllers;

use Auth;
use App\Role;
use App\Optional;
use App\Restaurant;
use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;

class OptionalController extends Controller
{
    use HasRoles;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $restaurants = Restaurant::active(1)->pluck('name', 'id');

        $restaurants[0] = 'Seleccione';

        $idRestaurant = null;
        if (!Auth::user()->hasRole('Administrador')) {
            $idRestaurant = Auth::user()->restaurants_id;
        } else {
            if (($request->get('restaurants_id') != "") && ($request->get('restaurants_id') != "0")){

                $idRestaurant = $request->get('restaurants_id');
            }
        }

        $optionals = Optional::search($request->get('search'))->type($request->get('type'))->resturant($idRestaurant)->paginate(10);

        $arrayType = array(
            '' => 'Seleccione',
            '1' => 'Extra',
            '2' => 'Opcional'
        );

        return view('optionals.index', compact('optionals', 'arrayType', 'restaurants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $restaurants = Restaurant::active(1)->pluck('name', 'id');

        $restaurants[0] = 'Seleccione';

        $arrayType = array(
            '1' => 'Extra',
            '2' => 'Opcional'
        );

        return view('optionals.create', compact('arrayType', 'restaurants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->hasRole('Administrador')) {
            $this->validaOptionalsAdmin($request);
            Optional::create($request->all());
        } else {
            $this->validaOptionals($request);

            $dataOptional = array(
                'restaurants_id' => Auth::user()->restaurants_id,
                'type' => $request['type'],
                'name' => $request['name'],
                'price' => $request['price']
            );

            Optional::create($dataOptional);
        }

        return redirect()->route('optionals.index')
            ->with('flash_message',
                'El registro fue dado de alta!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Optional  $optional
     * @return \Illuminate\Http\Response
     */
    public function show(Optional $optional)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Optional  $optional
     * @return \Illuminate\Http\Response
     */
    public function edit(Optional $optional)
    {
        $restaurants = Restaurant::active(1)->pluck('name', 'id');

        $restaurants[0] = 'Seleccione';

        $optional = Optional::findOrFail($optional['id']);

        $arrayType = array(
            '1' => 'Extra',
            '2' => 'Opcional'
        );

        return view('optionals.edit', compact('optional', 'arrayType', 'restaurants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Optional  $optional
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Optional $optional)
    {
        $optional = Optional::findOrFail($optional['id']);

        if (Auth::user()->hasRole('Administrador')) {
            $this->validaOptionalsAdmin($request);
            $optional->fill($request->all())->save();
        } else {
            $this->validaOptionals($request);

            $dataOptional = array(
                'restaurants_id' => Auth::user()->restaurants_id,
                'type' => $request['type'],
                'name' => $request['name'],
                'price' => $request['price']
            );

            $optional->fill($dataOptional)->save();
        }

        return redirect()->route('optionals.index')
            ->with('flash_message',
                'Su registro se modifico correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Optional  $optional
     * @return \Illuminate\Http\Response
     */
    public function destroy(Optional $optional)
    {
        $optional = Optional::findOrFail($optional['id']);
        $optional->delete();

        return redirect()->route('optionals.index')
            ->with('flash_message',
                'Su registro fue eliminado!');
    }

    public function validaOptionalsAdmin($request)
    {
        $this->validate($request, [
                'restaurants_id'=>'required|int',
                'type'=>'required|int',
                'name'=>'required|string',
                'price'=>'required'
            ]
        );
    }

    public function validaOptionals($request)
    {
        $this->validate($request, [
                'type'=>'required|int',
                'name'=>'required|string',
                'price'=>'required'
            ]
        );
    }
}
