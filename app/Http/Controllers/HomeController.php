<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Session;

use Validator;

use App\Product;

use App\Cart;

use App\User;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }




    public function index()
    {
        $product = Product::all()->toArray();

        return view ('home')->with('products',$product );
    }


    public function shop_view($id){
        $prod = Product::find($id);
        return response()->json($prod);
    }


    public function cart(Request $request, $id)
    {

        $prod_id=Product::find($id); 

        $user_id=Auth::user()->id;
        $user=User::find($user_id);
        $user_name = Auth::user()->name;

        $cart = new cart;
        $cart->user_name =$user_name;
        $cart->prod_id = $id;
        $cart->prod_item = $request->pordername;
        $cart->prod_code = $request->pcode;
        $cart->prod_qty = $request->quantity;
        $cart->price = $request->porderprice;
        $cart->amount_due = $request->totalprice;
        $cart->grandTotal = $request->grand_total;

        $cart->save();



        //TO DO: PLS UPDATE THE QUANTITY SHOWING IN WEB
        
    }     
    public function my_cart()
    {
        $cart = Cart::all();

        return view ('shop.cart')->with('carts', $cart);
        
    } 

    public function delete_cart_item($id)
    {
        $cart = Cart::find($id);
        $cart->delete();
        
    }
    public function checkout()
    {
        return view ('shop.checkout');
        
    }













    //ADMIN SIDE
    public function save_product(Request $request)
    {
       
        $this->validate($request,[
            'pname' => 'required',
            'qty' => 'required',
            'price'=> 'required',
            'desc' => 'required',
            'pimage'=> 'required|image|max:2048'
        ]);

        $pro = new Product;
        $pro->name = $request->pname;
        $pro->qty = $request->qty;
        $pro->price = $request->price;
        $pro->description = $request->desc;
        $pro->product_code=0;

        if($files = $request->pimage){
            $destination='images';
            $new_name= rand().'.'.$files->getClientOriginalName();
            $files->move(public_path($destination),$new_name);
            // $path=public_path().'/'.$destination.'/'.$new_name;
            $pro->image=$new_name;
            $pro->save();

            $product = Product::orderBy('created_at', 'desc')->first();
            $id = $product->id;
            // $date = preg_replace("/[\s-:]/", "", $pro->created_at); 
            $pro->product_code = 'SKU:'.$id;
            $pro->save();

            return 'success!';
        }else{
            return 'failed to save the data.';
        }

    }
    //TO FECTH DATA FROM THE DATABASE
    public function show(){
        $product = Product::all()->toArray();

        return view ('admin.index')->with('products',$product );
    }
    //TO VIEW DATA FOR EDIT PURPOSES
    public function view_data($id){
        
        $products = Product::findOrFail($id);

        return view ('admin.view')->with('product',$products);
    }
    //TO UPDATE DATA 
    public function update(Request $request, $id){


    } 




}
