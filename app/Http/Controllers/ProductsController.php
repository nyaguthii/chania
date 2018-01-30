<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\domain\Product;
use Yajra\DataTables\DataTables;
use DB;

class ProductsController extends Controller
{
    
    public function __construct(){
		$this->middleware('auth');
	}
    public function index(){
        $products=Product::all();
        return view('products.index',['products'=>$products]);
    }

    public function ajax2(){
        $products = DB::table('products')                                                        
        ->select(DB::raw("id,name,FORMAT(unit_cost,0) unit_cost,FORMAT(selling_price,0) selling_price"))
        ->get();
        //$vehicles = Vehicle::select(['id','year','model']);
        
        return Datatables::of($products)
        ->addColumn('action', function ($product) {
            return '
            <div class="pull-right">
            <a href="/receipts/'.$payment->id.'/show" class="btn btn-xs btn-primary pull-left"><i class="fa fa-print" aria-hidden="true"></i>Print</a>
            <a href="/payments/'.$payment->id.'/edit" class="btn btn-xs btn-warning pull-left"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</a>
            <a href="/payments/'.$payment->id.'/delete" class="btn btn-xs btn-danger pull-left"><i class="fa fa-trash-o" aria-hidden="true"></i>Delete</a>
            </div>
            ';
        })->make(true);
    }
    public function ajax(Request $request){
          //dd($request);
            $data = [];
    
        
                $search = $request->q;
                $products = DB::table("products")
                        ->select("id","name","unit_cost","selling_price")
                        ->where('name','LIKE',"%$search%")
                        ->get();
             
            foreach ($products as $product) {
                $data[] = ['id' => $product->id, 'text' => $product->name,'cost'=>$product->unit_cost,'price'=>$product->selling_price];
            }
            return \Response::json($data);
    }
    
    public function store(Request $request){
     $this->validate($request,[
         'name'=>'required|unique:products,name'
     ]);

     $product= new Product();
     $product->name=$request['name'];
     $product->created_by=auth()->id();
     $product->save();

     return redirect()->route('products.index')->with('message','Product created');
     
    }
    public function delete(Product $product){
        return view('products.delete',['product'=>$product]);
    }
    public function create(){

        return view('products.create');

    }
    public function update(Product $product,Request $request){
        $this->validate($request,[
            'name'=>'required',
            'unit_cost'=>'required|integer',
            'selling_price'=>'required|integer'
        ]);
        
        $product->unit_cost=$request['unit_cost'];
        $product->selling_price=$request['selling_price'];
        $product->name=$request['name'];
        $product->updated_by=auth()->id();
        $product->save();
        return redirect()->route('products.index')->with('message','Product edited');
    }

    public function destroy(Product $product){
        $product->delete();
        return redirect()->route('products.index')->with('message','Product Deleted');
    }
    public function edit(Product $product){
        return view('products.edit',['product'=>$product]);
    }
}
