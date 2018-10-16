<?php

namespace App\Http\Controllers;

use App\Optional;
use Illuminate\Http\Request;

class OptionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $optionals = Optional::search($request->get('search'))->type($request->get('type'))->paginate(10);

        $arrayType = array(
            '' => 'Seleccione',
            '1' => 'Extra',
            '2' => 'Opcional'
        );

        return view('optionals.index', compact('optionals', 'arrayType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arrayType = array(
            '1' => 'Extra',
            '2' => 'Opcional'
        );

        return view('optionals.create', compact('arrayType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validaOptionals($request);

        Optional::create($request->all());

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
        $optional = Optional::findOrFail($optional['id']);

        $arrayType = array(
            '1' => 'Extra',
            '2' => 'Opcional'
        );

        return view('optionals.edit', compact('optional', 'arrayType'));
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
        $this->validaOptionals($request);

        $optional = Optional::findOrFail($optional['id']);
        $optional->fill($request->all())->save();

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
