<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Coupan;
use App\Models\User;
use App\Models\City;
use App\Models\Rating;
use App\Models\Sale;
use Session;

class MainController extends Controller
{       

    public function singleproduct($id)
    {
        $product=Product::find($id);
        $relatedpro=Category::find($product->category_id)->products()->get()->take(8);
            return view("singleproduct",compact("product","relatedpro"));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rating' => ['required', 'integer', 'between:1,5'],
            'product_id' => ['required', 'exists:products,id'],
            'comment' => ['required'],
        ]);

        $rating = Rating::updateOrCreate([
            "user_id"=>auth()->id(),],

            [
            "product_id"=>$request->product_id,
            "comment"=>$request->comment,
            "rating"=>$request->rating,

        ]);
       

        return back();
    }
        public function showcategory($slug)
        { 
        $parts=explode("-",$slug);
        $id=$parts[count($parts)-1];
        $category=Category::find($id);
        $products=$category->products()->paginate(8);
            return view("showcategory",compact("products"));
        }

        public function search()
        {
            $find=request()->find;
            $words=explode(" ",$find);
            $ids=[];
            foreach($words as $word)
            {
                $tids=Category::where("name","like","%$word%")->pluck("id")->toArray();
                if(count($tids)) $ids=array_merge($ids,$tids);
            }
            $ids=array_unique($ids);
            if(count($ids))
            $products=Product::whereIn("category_id",$ids)->with("category")->paginate(8);
            else
            $products=Product::where("name","like","%$find%")->with("category")->paginate(8);
            $title="Search result for ".$find;
             return view("welcome",compact("products","title"));
        }
    public function removecompare()
    {
        $id=request()->id;
        $items=session()->get('compare',[]);
        unset($items[$id]);
        $items=array_values($items);
        if(!empty($items))
        session()->put('compare',$items);
        else
        session()->forget('compare');

        return 1;
    }

public function compare()
{
   
  if(request()->pid)
{
    $data = session()->get('compare', []);
        if(!in_array(request()->pid, $data)) // check if pid is not already in compare array
    {
        if(count($data) < 3)
        {
            session()->push('compare', request()->pid);
        }
    }
}
     $ids=session()->get('compare');
     $products=Product::findMany($ids);
    return view("compare",compact("products"));
}

    public function cityinfo()
    {
           $cityname=request()->cityname;
          
        $city=City::where("name",$cityname)->first();
        if($city)
           {
        return  json_encode(["a"=>$city->state,"b"=>$city->postalcode]);
            }
              
    }
 
    
    public function checkinfo()
    {
        
        $output=0;
        $email=request('email');
        $pass=request('pass');
        $user=null;
       $credentials =['email'=>$email,'password'=>$pass];
        if (Auth::attempt($credentials)) {
            $user=auth()->user();
            
        }
        if($user)
        {
              $cities=City::all();
              $output="


                                    <div id='billing-form' class='mb-40'>
                                        <h4 class='checkout-title'>Billing Address</h4>
                                        <div class='row'>
                                            <div class='col-md-6 col-12 mb--20'>
                                                <label>First Name*</label>
                                                <input type='text' name='fname' placeholder='First Name' value='".$user->fname."'>
                                            </div>
                                            <div class='col-md-6 col-12 mb--20'>
                                                <label>Last Name*</label>
                                                <input type='text' value='".$user->lname."' name='lname' placeholder='Last Name'>
                                            </div>
                                            <div class='col-12 mb--20'>
                                                <label>Company Name</label>
                                                <input type='text' value='".$user->cname."' name='cname' placeholder='Company Name'>
                                            </div>
                                            
                                            </div>
                                            <div class='row'>
                                                <div class='col-md-6 col-12 mb--20'>
                                                <label>Email Address*</label>
                                                <input type='email' readonly value='".$user->email."' name='email' placeholder='Email Address'>
                                            </div>
                                            <div class='col-md-6 col-12 mb--20'>
                                                <label>Phone no*</label>
                                                <input type='text' value='".$user->phone."' name='phone' placeholder='Phone number'>
                                            </div>

                                            </div>
                                            
                                            <div class='col-12 mb--20'>
                                                <label>Address*</label>
                                                <input type='text'  value='".$user->address1."'name='address1' placeholder='Address line 1'>
                                                <input type='text' value='".$user->address2."' name='address2' placeholder='Address line 2'>
                                            </div>
                                            <div class='col-12 col-12 mb--20'>
                                                <div class='row'>
                                                    
                                                
                                                <div class='col-md-12 col-12 mb--20'>
                                                <label>City</label>
                                                <select id='cityname' value='".$user->city."' name='city' class='mys'>";
                                              
                                                foreach($cities as $city)
                                                {
                                                $output.="
                                                    <option>
                                                    ".$city->name."</option>
                                                    ";
                                                }
                                                    $output.="
                                                </select>
                                                
                                                </div>
                                            <div  class='col-md-8 col-12 mb--20'>
                                                <label>State*</label>
                                                <input id='state1' type='text' value='".$user->state."' name='state' placeholder='State'>
                                            </div>
                                            </div>
                                            
                                            <div class='row'>
                                            <div class='col-md-6 col-12 mb--20'>
                                                <label>Zip Code*</label>
                                                <input type='text' value='".$user->zipcode."' name='zipcode' id='zipcode' placeholder='Zip Code'>
                                            </div>
                                        </div>
                                        </div>
                                    </div>


             ";
        }
        return json_encode(["output"=>$output]) ;
            
    }
    public function orderbill()
{ 
    $output="";
    if(session('cart')) 
    {

    $output="<div class='checkout-cart-total'>
<h2 class='checkout-title'>YOUR ORDER</h2>
<h4>Product <span>Total</span></h4>
<ul>";

    $items=session()->get('cart',[]);
    $tprice=0;
    foreach($items as $item)
    {
        $pid=$item['id'];
        $qty=$item['qty'];
        $product=Product::find($pid);
        $price=$product->sprice*$qty;
        $tprice+=$price;
$output.="
    <li><span class='left'>".$product->name." X ".$qty."</span> <span
    class='right'>".$price."</span></li>";
    }
        $discount=0;
    if(session('discount'))
    {   
        $discount=session('discount');
        $tprice=$tprice-$tprice*$discount/100;
    }
    $gtotal=$tprice;
    $output.="
   

</ul>
<p>Sub Total <span>".$tprice."</span></p>
<p>Discount <span>".$discount."%</span></p>
<p>Shipping Fee <span>Fixed</span></p>
<h4>Grand Total <span>".$gtotal."</span></h4>
<hr>

<div class='term-block my-2'>
    <input type='checkbox' id='accept_terms2'>
    <label for='accept_terms2'>I’ve read and accept the terms &
conditions</label>
</div>

</div>";
}
    return $output;
}
            public function placeorder(Request $request)
            {

                if(session('cart'))
                {
                     $items=session()->get("cart",[]);

                $ordernote=$request["ordernote"];
                if(auth()->user())
                {
                    $ad1=$request['address1'];
                    $ad2=$request['address2'];
                    if(!empty($ad1 & $ad2))
                    {
                    $address=[
                        "address1"=>$ad1,
                        "address2"=>$ad2];
                        
                        auth()->user()->update($address);
                    }
                    $user=auth()->user();

                  
                    
                }
                else
                {
                  
                $password=bcrypt($request["password"]);
                unset($request['ordernote']);
                unset($request['_token']);
                unset($request['password']);
                $data1=$request->all();
                $data=array_merge($data1,['password'=>$password]);
                $user=User::Create($data);
                }
                             
                $discount=null;
                if(session('discount'))$discount=session('discount');
                $sale=Sale::create(['user_id'=>$user->id,'discount'=>$discount,'ordernote'=>$ordernote]);

                 $items=session()->get("cart",[]);
                 
         foreach($items as $index=>$item)
         {  
            $totalbill=0;
            $pid=$item['id'];
            $qty=$item['qty'];
            $product=Product::find($pid);
            $sale->products()->attach($pid,[
                "quantity"=>$qty,
                "pprice"=>$product->pprice,
                "saleprice"=>$product->sprice,
                "created_at"=>now(),
                "updated_at"=>now(),

            ]);


        }
        ////// order thanks page code 
          $tprice=0;
          $output="";
    foreach($items as $item)
    {
        $pid=$item['id'];
        $qty=$item['qty'];
        $product=Product::find($pid);
        $price=$product->sprice*$qty;
        $tprice+=$price;

    }
        $discount=0;
    if(session('discount'))
    {   
        $discount=session('discount');
        $tprice=$tprice-$tprice*$discount/100;
    }
  
      



        $output.="<div class='col-12'>
                        <div class='order-complete-message text-center'>
                            <h1>Thank you !</h1>
                            <p>Your order has been received.</p>
                        </div>
                        <ul class='order-details-list'>
                            <li>Order Number: <strong>".$sale->id."</strong></li>
                            <li>Date: <strong>".$sale->created_at."</strong></li>
                            <li>Total: <strong>".$tprice."</strong></li>
                            <li>Payment Method: <strong>Cash on Delivery</strong></li>
                        </ul>
                        <p>Pay with cash upon delivery.</p>
                        <h3 class='order-table-title'>Order Details</h3>
                        <div class='table-responsive'>
                            <table class='table order-details-table'>
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>";
                                 foreach($items as $item)
    {
        $pid=$item['id'];
        $qty=$item['qty'];
        $product=Product::find($pid);
        $diss=$sale->discount;
        $price=$product->sprice*$qty;
       

    
                                  
                                   $output.=" <tr>
                                        <td><a href='#'>".$product->name."</a> <strong>×".$qty."</strong></td>
                                        <td><span>".$price."</span></td>
                                    </tr>";
        }
                                $output.="
                                </tbody>
                                <tfoot>
                                 <tr>
                                        <th>discount:</th>
                                        <td><span>".$diss."</span></td>
                                    </tr>
                               
                                    <tr>
                                        <th>Payment Method:- Cash on Delivery</th>
                                        <td>fixed</td>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <td><span>".$tprice."</span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>";
                      session()->forget("cart","discount","compare");
               return view("order",compact("output")); 
                
               }
               return redirect("/checkout"); 
            }

		public function checkout()
		{
			return view("checkout");
		}
	public function addcoupan()
	{
		$code=request('code');
		 $discount=Coupan::where("code",$code)->first();
		 if (!empty($discount)) {
		 	$discount=$discount->discount;
			 }
 
	 session()->put("discount",$discount);
		return "Yo bitch";

	}
   public function loadcartpage()
   {
      $output="";

      	$subtotal=0;
      
         $items=session()->get("cart",[]);
         foreach($items as $index=>$item)
         {
            $pid=$item['id'];
            $qty=$item['qty'];
            $product=Product::find($pid);
            $price=$product->sprice*$qty;

            $subtotal+=$price;
            $output.="<tr>
                                               
                   <td id=".$index." class='removeproduct'><a href='#'><i class='far fa-trash-alt'></i></a>
                                        </td>
                                                <td class='pro-thumbnail'><a href='#'><img
                                                src='".asset('storage/'.$product->image)."' alt='Product'></a></td>
                                                <td class='pro-title'><a href='#'>".$product->name."</a></td>
                                                <td class='pro-price'><span>".$product->sprice."</span></td>
                                                <td class='pro-quantity'>
                                                    <div class='pro-qty'>
                                                        <div class='count-input-block'>
                                                            <input type='number' 
                                                            id='".$pid."' 
                                                            class='form-control cartqty text-center'
                                                                value='".$qty."'>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class='pro-subtotal'><span>".$price."
                                             </span></td>
                                            </tr>
                                        
                                            ";
         }
     
                            		$grandtotal=$subtotal;
                            		$dis=0;
                            if(session('discount'))
                            {
                            	$dis=session("discount");

        						$grandtotal=$subtotal-$subtotal*$dis/100;    
                            }
                            else{
                            	    $output.="<tr>

                                <td colspan='6' class='actions'>

                                

                                    <div class='coupon-block'>

                                        <div class='coupon-text'>

                                            <label for='coupon_code'>Coupon:</label>

                                            <input type='text' name='coupon_code' class='input-text'

                                            id='coupon_code' value='' placeholder='Apply Coupon code'>

                                        </div>
                                        <div>
                                        <button id='apply_coupon_code' class='btn btn--primary'>Apply coupon</button>
                                        </div>


                                    </div>

                                    

                                  

                                </td>

                            </tr>";
                            }
                          
                                            
                        $summary="    <div class='cart-summary'>
                                <div class='cart-summary-wrap'>
                                    <h4><span>Cart Summary</span></h4>
                                    <p>Sub Total <span class='text-primary'>".$subtotal."</span>
                                    </p><p>Discount<span class='text-primary'>".$dis."%</span></p>
                                    <p>Shipping Cost <span class='text-primary'>fixed</span></p>
                                    <h2>Grand Total <span class='text-primary'>".$grandtotal."</span></h2>
                                </div>
                                <div class='cart-summary-button'>
                                    <a href=".url('/checkout')." class='checkout-btn c-btn btn--primary'>Checkout</a>
                                    
                                </div>
                            </div>";
      return json_encode(["output"=>$output,"summary"=>$summary]);
   }
   public function cart()
   {
      return view("cart");
   }
   public function index($title="Products")
   {
   		// session()->flush();
    $products=Product::latest()->paginate(8);
      return view("welcome",compact("products","title"));
   }

   public function getdetail()
   {
      $id=request()->id;
      $product=Product::find($id);
      $pid=$product->id;
      $image='<img src="'.asset('storage/'.$product->image).'">';
      $title=$product->name;
      $price=$product->sprice;
      $dprice=$product->sprice+$product->sprice*50/100;
      $des=$product->description;
      $catname=$product->category->name;
      $qqty=1;
      $items=session()->get('cart',[]);
      foreach($items as $item)
      {
         if($item['id']==$pid)
         {
            $qqty=$item['qty'];
            break;
         }
      }
          return json_encode(["image"=>$image,"title"=>$title,'price'=>$price,'dprice'=>$dprice,'description'=>$des,'catname'=>$catname,"pid"=>$pid,"qqty"=>$qqty]);
   }
   public function additem()
   {
     if(!empty(request()->all()))
     {
      $id=request('id');
      $qty=request('qty');
      $flag=0;  

      $items=session()->get('cart',[]);

      foreach($items as $index=>&$item)
      {

         if($item['id']==$id)
         {
           $item['qty']=$qty;
           $flag=1;
            Session::put('cart', $items);
            break;
         }
      }
     
      if($flag==0)
      {
      $array=["id"=>$id,"qty"=>$qty];
      session()->push('cart',$array);

      }
   return 1;
   }
    }
   public function loadcart()
   {
      $output='';
      $total=0;
      $totalprice=0;
      if (session()->has('cart')) {
           $total=count(session('cart'));
            $items=session()->get('cart',[]);
            foreach($items as $index=>$item)
            {
               $pid=$item['id'];
               $qty=$item['qty'];
               $product=Product::find($pid);
               $totalprice+=$product->sprice*$qty;

         $output.=' <div class="cart-product">
        <a href="#" class="image">
            <img src="'.asset('storage/'.$product->image).'" alt="">
        </a>
        <div class="content">
            <h3 class="title"><a href="#">'.$product->name.'</a>
            </h3>
            <p class="price"><span class="qty">'.$qty.' ×</span>'.$product->sprice.'</p>
            <button id='.$index.' class="cross-btn removeproduct"><i class="fas fa-times"></i></button>
        </div>
    </div>';
         }

      }
      return json_encode(["output"=>$output,"total"=>$total,"tprice"=>$totalprice."-PKR"]);
   }
      public function removeproduct()
      {
         $id=request()->id;
         $items=session()->get('cart',[]);
         unset($items[$id]);
         array_values($items);
         session()->put('cart',$items);
         return 1;
      }








}
