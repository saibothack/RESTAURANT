<?php

namespace App\Http\Controllers;

use App;
use PDF;
use View;
use QrCode;
use App\User;
use App\Menu;
use App\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $restaurants = Restaurant::search($request->get('search'))->active($request->get('active'))->paginate(10);
        $arrayStatus = array(
            '' => 'Seleccione', 
            '0' => 'Deshabilitado', 
            '1' => 'Activado'
        );
        return view('restaurants.index', compact('arrayStatus', 'restaurants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arrayStatus = array(
            '0' => 'Deshabilitado', 
            '1' => 'Activado'
        );

        return view('restaurants.create', compact('arrayStatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validaRestaurant($request,0);

        $user = Restaurant::create($request->only('domain', 'name', 'email', 'payment_day', 'active', 'days_grace', 'tables', 'price', 'images'));

        return redirect()->route('restaurants.index')
            ->with('flash_message',
             'Restaurante '. $user->name.' agregado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function show(Restaurant $restaurant)
    {
        /*$permission = Permission::findOrFail($id);
        $this->validate($request, [
            'name'=>'required|max:40',
        ]);
        $input = $request->all();
        $permission->fill($input)->save();
        return redirect()->route('permissions.index')
            ->with('flash_message',
             'Permission'. $permission->name.' updated!');*/
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $restaurant = Restaurant::findOrFail($id);
        $arrayStatus = array(
            '0' => 'Deshabilitado', 
            '1' => 'Activado'
        );
        return view('restaurants.edit', compact('restaurant', 'arrayStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validaRestaurant($request,$id);

        $restaurant = Restaurant::findOrFail($id);
        $restaurant->fill($request->only('domain', 'name', 'email', 'payment_day', 'active', 'days_grace', 'tables', 'price', 'images'))->save();

        return redirect()->route('restaurants.index')
            ->with('flash_message',
             'Restaurant '. $restaurant->name.' modificado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Restaurant  $restaurant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $restaurant = Restaurant::findOrFail($id);

            //eliminamos los usuarios del restaurant
            User::where('restaurants_id', $restaurant->id)->delete();

            //eliminamos menus del restauratn
            Menu::where('restaurants_id', $restaurant->id)->delete();

            $restaurant = Restaurant::findOrFail($id);
            $restaurant->delete();

        } catch (Exception $ex) {
            dd($ex->getMessage());
        }

        return redirect()->route('restaurants.index')
            ->with('flash_message',
                'Fue eliminado el menu!');
    }

    public function validaRestaurant($request, $id)
    {
        $this->validate($request, [
            'domain'=>'required|unique:restaurants,domain,'.$id,  
            'name'=>'required|string',
            'email'=>'required|email',
            'payment_day'=>'required|int|min:1|max:28',
            'days_grace'=>'required|int|min:1|max:30',  
            'tables'=>'required|int|min:1',  
            'price'=>'required',
            'active'=>'required|int',
            'images'=>'required|int|min:0|max:10',
            ]
        );
    }

    public function generateToQR($id) {
        $numTables = Restaurant::findOrFail($id)->tables;
        return view('restaurants.qr', compact('numTables', 'id'));
    }

    public function printToQR(Request $request, $id) {
        $restaurant = Restaurant::findOrFail($id);
        $baseUrl = App::make('url')->to('/') . '/restaurant/' . $restaurant->domain;
        $count = count($request['tables']);
        $urlQR = null;

        $urls = array();

        for($i=0;$i<$count; $i++) {
            $date = date('Y-m-d H:i:s');
            $url = $baseUrl . "/" . $request['tables'][$i];
            $nameFile = $restaurant->name . $request['tables'][$i] . $date . ".png";
            $nameFile = str_replace(':', '-', $nameFile);
            $savePath = "../public/images/QR/" . $nameFile;
            QrCode::format('png')->size(200)->generate($url, $savePath);

            $urls[$i] = array(
                'restaurant' => $restaurant->name,
                'table' => $request['tables'][$i],
                'urlQR' => '/images/QR/' . $nameFile,
                'url' => $url
            );
        }

        $html = View::make('restaurants.formatQR', compact('urls'))->render();
        $pdf = PDF::loadHTML($html);

        $urlDownload = $pdf->download('invoice.pdf');

        foreach ($urls as $url) {
            $imgUrl = "../public" . $url['urlQR'];

            if (file_exists($imgUrl)) {
                unlink($imgUrl);
            }
        }

        return $urlDownload;
    }

    public function menu($idRestaurant, $idTable) {

        return view("");
    }
}
