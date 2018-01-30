<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\domain\Customer;
use App\domain\Vehicle;
use App\domain\VehicleAccount;
use App\Http\Requests\VehicleRequest;

class CustomerVehiclesController extends Controller
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
        return view('customers.vehicles.index',compact('customer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Customer $customer)
    {
        return view('customers.vehicles.create',compact('customer'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Customer $customer,Request $request)
    {
       $validator = Validator::make($request->all(), [
            'registration' => 'required|unique:vehicles',
            'make' => 'required',
            'model' => 'required',
            'year' => 'required',
            'capacity'=>'required|numeric'
        ]);

        if ($validator->fails()) {
            return back()->withInput()
                        ->withErrors($validator)
                        ->withInput();
        }


       $registration=strToUpper($request['registration']);

       $vehicle=new Vehicle(); 
       $vehicle->registration=$registration;
       $vehicle->year=$request['year'];
       $vehicle->model=$request['model'];
       $vehicle->make=$request['make'];
       $vehicle->capacity=$request['capacity'];
       $vehicle->created_by=auth()->id();


       $customer->vehicles()->save($vehicle);
       $vehicleAccount= new VehicleAccount();
       $vehicleAccount->current_balance=0;
       $vehicle->vehicleAccount()->save($vehicleAccount);


       session()->flash('vehicle-store-message','Vehicle created successfully');
        return view('customers.vehicles.index',compact('customer'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer,Vehicle $vehicle)
    {
      

       return view('customers.vehicles.show',['customer'=>$customer,'vehicle'=>$vehicle]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicle $vehicle)
    {
        return view('customers.vehicles.edit',['customer'=>$vehicle->customer,'vehicle'=>$vehicle]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Vehicle $vehicle,Request $request)
    {
        $this->validate($request,[
            'registration' => 'required',
            'make' => 'required',
            'model' => 'required',
            'year' => 'required',
            'capacity'=>'required|numeric'
            ]);
        $registration=strToUpper($request['registration']);
        $vehicle->registration=$registration;
        $vehicle->make=$request['make'];
        $vehicle->model=$request['model'];
        $vehicle->year=$request['year'];
        $vehicle->capacity=$request['capacity'];
        $vehicle->edited_by=auth()->id();
        $vehicle->save();

        session()->flash('message','Vehicle edit successfully');
        return view('customers.vehicles.index',['customer'=>$vehicle->customer]);

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
