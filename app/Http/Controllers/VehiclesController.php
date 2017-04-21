<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\Customer;
use App\domain\Vehicle;
use App\Http\Requests\VehicleRequest;

class VehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Customer $customer)
    {
        return view('vehicles.index',compact('customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Customer $customer)
    {
        return view('vehicles.create',compact('customer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Customer $customer,VehicleRequest $request)
    {
       $vehicle=new Vehicle(); 
       $vehicle->registration=$request['registration'];
       $vehicle->year=$request['year'];
       $vehicle->model=$request['model'];
       $vehicle->make=$request['make'];
       $vehicle->capacity=$request['capacity'];


       $customer->vehicles()->save($vehicle);

       session()->flash('vehicle-store-message','Vehicle created successfully');
        return view('vehicles.index',compact('customer'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer,Vehicle $vehicle)
    {
       return view('vehicles.show',['customer'=>$customer,'vehicle'=>$vehicle]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
