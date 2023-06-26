<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Payment;
use App\Models\Category;
use Carbon\Carbon;
class AdminController extends Controller
{
public function editproduct()
{
$id=request()->id;
$categories=Category::orderBy("name")->get();
$product=Product::find($id);
$output=" <div id='billing-form' class='mb-40'>
    <div class='row'>
        <div class='col-md-12 col-12 mb--10'>
            <label>Product Name*</label>
            
            <input required type='text' name='name' value='".$product->name."' placeholder='Name'>
            <input type='hidden' name='flag' value='".$product->id."'>
        </div>
        <div class='col-md-12 col-12 mb--20'>
            <label>Category</label>
            <select name='category_id' class='nice-select'>
                <option value=''>Select Category</option>";
                foreach($categories as $index=>$cat)
                {
                if($cat->id==$product->category_id)
                {
                $output.="<option selected value='".$cat->id."'>".$cat->name."</option>";
                }
                else
                {
                $output.="<option value='".$cat->id."'>".$cat->name."</option>";
                }
                }
                $output.="
            </select>
        </div>
        
        <div class='col-md-12 col-12 mb--20'>
            <label>Description*</label>
            <textarea name='description' placeholder='Description' class='form-control'>$product->description</textarea>
        </div>
        <div class='col-md-6 col-12 mb--20'>
            <label>Purchase*</label>
            <input required type='text' name='pprice' value='".$product->pprice."' placeholder='Purchase'>
        </div>
        <div class='col-md-6 col-12 mb--20'>
            <label>Sale*</label>
            <input required type='text' name='sprice' value='".$product->sprice."' placeholder='Sale'>
        </div>
        
        
        <div class='col-12 mb--20'>
            <label>image*</label>
            <input  type='file' name='image'>
        </div>
        
    </div>
    <div class='col-md-10 mx-auto'>
        <button type='submit' class='btn btn--primary'>Update</button>
    </div>
</div>";
return json_encode(["a"=>$output]);
}
public function delproduct()
{
$id=request()->id;
$product=Product::find($id);
$image=$product->image;
// unlink($image);
$product->delete();
return 1;
}
public function enterproduct()
{





$request=request()->all();
unset($request["_token"]);
$flag=request()->flag;
unset($request["flag"]);

//add products
if(empty($flag))
{

 $cid=Product::orderBy("id","DESC")->first()->id;
        $cid++;
        $url="products/".$cid.".jpg";

$newname=request()->image->store("products","public");
 rename("storage/".$newname,"storage/products/".$cid.".jpg");
unset($request["image"]);
$inputs=array_merge($request,["id"=>$cid,"image"=>$url]);
Product::create($inputs);
return redirect("/admin/addproducts");





}
/// update products
else
{
      if(!empty(request()->image))
        {
        $currentproduct=$flag;
        $newname="products/".$currentproduct.".jpg";
        $photo=request()->image->store("products","public");
        rename("storage/".$photo,"storage/products/".$currentproduct.".jpg");
        $inputs1=array_merge($request, ["image"=>$newname]);
        }
else
{
unset($request["image"]);
$inputs=$request;
}
Product::find($flag)->update($inputs1);
return redirect("/admin/addproducts");
}
}





public function addproducts()
{
$products=Product::latest()->get();
return view("admin.addproducts",compact("products"));
}
public function changestatus()
{
$status=request()->status;
$id=request()->id;
    if($status==5)
        {   
            $total=0;
            $sale=Sale::find($id);

                if($sale->payment)
            {
                return json_encode(["a"=>$sale]);
            }

            foreach($sale->products as $item)
    {
    $pid=$item->id;
    $qty=$item->pivot->quantity;
    $sprice=$item->pivot->saleprice;
    $inhand=Product::find($pid)->inhand-$qty;
    Product::find($pid)->update(["inhand"=>$inhand]);
    $total+=$sprice*$qty;
    }
$discount=0;
if($sale->discount>0)
$discount=$sale->discount*$total/100;
$gtotal=$total-$discount;

$payment=Payment::create([
    "clientid"=>$sale->user_id,
    "tmode"=>2,
    "description"=>"sale to ".$sale->user->username,
    "debit"=>$gtotal,
    ]);

 Sale::find($id)->update(["payment_id"=>$payment->id]);



}
$sale=Sale::find($id)->update(["status"=>$status]);
return json_encode(["a"=>$sale]);
}
public function updateorderstatus()
{
$id=request()->status;
$order=Sale::find($id);
$ops=[
"0"=>"Pending for verification",
"1"=>"Processing",
"2"=>"Dispached",
"3"=>"Shipped to warehouse",
"4"=>"On th Way",
"5"=>"Delieverd",
];
$output="
<table class='table-bordered table'>
    <thead>
        
        <th>Order #</th>
        <th>Client Info</th>
        <th>Status</th>
        
    </thead>
    <tbody>
        <tr>
            <td valign='middle'>$order->id</td>
            <td valign='middle'>".$order->clientinfo."</td>
            <td valign='middle'> <select  class='form-control' id='status'>";
                
                foreach($ops as $index=>$op)
                {
                if($index==$order->status) $output.="<option selected value='$index'>$op</option>";
                else
                $output.="<option value='$index'>$op</option>";
                }
            $output.="  </select></td>
        </tr>
    </tbody>
</table>";

return json_encode(["a"=>$output]);
}
public function viewoperatorpage()
{
if(auth()->user()->fname=="admin")
$layout="layouts.adminapp";
else
$layout="layouts.workerapp";
return view("worker",compact("layout"));
}
public function deleteoperator()
{
$id=request()->id;
User::find($id)->delete();
return json_encode(["a"=>1]);
}
public function updateoperatordata()
{
request()->validate([
"fname"=>"required|min:3",
"email"=>"required|email",
"phone"=>"required|numeric",
"password"=>"nullable|min:3",
"role"=>"required|numeric",
"user"=>"required|numeric",
]);
$request=request()->all();
$id=$request['user'];
unset($request['user']);
if($request['password'])
{
$password=bcrypt($request['password']);
unset($request['password']);
$request=array_merge($request,["password"=>$password]);
}
else
{
unset($request['password']);
}
$user=User::find($id);
$user->update($request);
return json_encode(["a"=>1]);
}
public function updateoperatormodal()
{
$id=request()->id;
$option=request()->option;
if($id!=Null)
{
$user=User::find($id);
$output="<form method='post' class='checkout-form' id='updateoperatordata'>
    
    <div id='billing-form' class='mb-40 '>
        
        <div class='row'>
            <div class='col-md-12 col-12 mb--20'>
                <label>First Name$id*</label>
                <input type='text' name='fname' placeholder='First Name' value='".$user->fname."'>
                <div id='error-fname'></div>
            </div>
            
            
            <div class='col-md-6 col-12 mb--20'>
                <label>Email Address*</label>
                <input readonly type='email' name='email' placeholder='Email Address' value='".$user->email."'>
                <div id='error-email'></div>
            </div>
            <div class='col-md-6 col-12 mb--20'>
                <label>Phone no*</label>
                <input type='text' name='phone' placeholder='Phone number' value='".$user->phone."'>
                <div id='error-phone'></div>
            </div>
            
            
            <div class='col-md-12 col-12 mb--20'>
                <label>Role*</label>
                <select ' name='role'  class='nice-select'>
                    ";
                    if($user->role==1)
                    {
                    $output.="
                    
                    <option value='2'>Operator</option>
                    <option selected  value='1'>Admin</option>";
                    }
                    else
                    {
                    $output.="
                    
                    <option selected value='2'>Operator</option>
                    <option   value='1'>Admin</option>";
                    }
                    $output.="
                    
                </select>
                <div id='error-role'></div>
            </div>
            <div class='col-md-12 col-12 mb--20'>
                <label>Password*</label>
                <input type='password' name='password' placeholder='Password'>
                <div id='error-password'></div>
            </div>
            <input type='hidden' name='user' value='".$user->id."'>
            <div class='col-md-12 col-12 mb--20'>
                <button type='submit' class='btn btn--primary'>Update Operator</button>
            </div>
            
            
        </div>
    </div>
</form>";
}
else
{
$output="<form method='post' class='checkout-form' id='addoperator'>
    
    
    <div id='billing-form' class='mb-40 '>
        
        <div class='row'>
            <div class='col-md-12 col-12 mb--20'>
                <label>First Name*</label>
                <input type='text' name='fname' placeholder='First Name'>
                <div id='error-fname'></div>
            </div>
            
            
            <div class='col-md-6 col-12 mb--20'>
                <label>Email Address*</label>
                <input type='email' name='email' placeholder='Email Address'>
                <div id='error-email'></div>
            </div>
            <div class='col-md-6 col-12 mb--20'>
                <label>Phone no*</label>
                <input type='text' name='phone' placeholder='Phone number'>
                <div id='error-phone'></div>
            </div>
            
            
            <div class='col-md-12 col-12 mb--20'>
                <label>Role*</label>
                <select name='role' required class='nice-select'>
                    <option value=''>Select Role</option>
                    <option value='2' selected>Operator</option>
                    <option value='1'>Admin</option>
                </select>
                <div id='error-role'></div>
            </div>
            <div class='col-md-12 col-12 mb--20'>
                <label>Password*</label>
                <input type='password' name='password' placeholder='Password'>
                <div id='error-password'></div>
            </div>
            
            <div class='col-md-12 col-12 mb--20'>
                <button type='submit' class='btn btn--primary '>Add Operator</button>
            </div>
            
            
        </div>
    </div>
</form>";
}
return json_encode(["a"=>$output]);
}


public function index()
{


    $date=Carbon::today()->startOfDay();
    $csale=Sale::where("status",5)->whereDate("created_at",$date)->withSum("products","product_sale.saleprice")->get()->sum("products_sum_product_salesaleprice")??0;

     //with FlatMap we can read things in collection of each data
    $msales=Sale::where("status",5)->whereMonth("created_at",Carbon::now()->month)->withSum("products","product_sale.saleprice")->get()->sum("products_sum_product_salesaleprice")??0;  
     $pendingsale=Sale::where("status","<",5)->whereDate("created_at",$date)->withSum("products","product_sale.saleprice")->get()->sum("products_sum_product_salesaleprice")??0;  
     $soldproducts=Sale::where("status",5)->wheredate("created_at",$date)->withSum("products","product_sale.quantity")->get()->sum("products_sum_product_salequantity");

  $top_products=Product::withSum("sales","product_sale.quantity")->orderBy("sales_sum_product_salequantity","DESC")->take(5)->get();   
$labels1="labels: [";
$data1="series: [";
foreach($top_products as $product)
{
$labels1.="'".$product->name."',";
$data1.=$product->sales_sum_product_salequantity.",";
}
$labels1=rtrim($labels1,",")."]";
$data1=rtrim($data1,",")."]";



    // $total2=DB::select("SELECT sum(saleprice)  as total FROM `product_sale` where sale_id IN(Select id from sales where status=0 and created_at='$date' )");
     //->each(function ($sale) use (&$csale) {
            //     $csale += $sale->products->sum('pivot.saleprice');
            // });
    
    // one way
//     $csale = $sales->map(function ($sale) {
//     return $sale->products->sum('pivot.saleprice');
// })->sum();

    //seconds way
    // foreach($sales as $sale)
    // {
    //     $csale+=$sale->products->sum("pivot.saleprice");
    // }
//3rd way
   

 

return view("admin.admin",compact("csale","pendingsale","msales","soldproducts","labels1","data1"));
}




public function userpage()
{
return view("admin.adduser");
}
public function adduser()
{
request()->validate([
"fname"=>"required|min:3",
"email"=>"required|email|unique:users",
"phone"=>"required|numeric",
"password"=>"required",
"role"=>"required|numeric",
]);
$request=request()->all();
$pass=bcrypt($request['password']);
unset($request['_token']);
unset($request['password']);
$inputs=array_merge($request,["password"=>$pass]);
User::Create($inputs);
return json_encode(["a"=>1]);
}
public function operatortable()
{
$output="
<div class='table-responsive mt-5'>
    
    <table class='table table-bordered' >
        <thead class='btn--primary'>
            <th>Sno</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone #</th>
            <th>Role</th>
            <th>Action</th>
        </thead>
        <tbody>
            ";
            $users=User::where("role",">",0)->get();
            foreach($users as $index=>$user)
            {
            $index+=1;
            // $loop->iteration
            $output.="
            <tr>
                <td>".$index."</td>
                <td>".$user->fname."</td>
                <td>".$user->email."</td>
                <td>".$user->phone."</td>
                <td>".$user->rolename."</td>
                <td>
                    ";
                    if($user->id==1)
                    {
                    }
                    else{
                    $output.="
                    
                    <div class='d-flex'>
                        
                        <button class=' wrapper opid' id='".$user->id."'>
                        <li class='icon  update'>
                        </span>
                        <span class='tooltip'>Update</span>
                        <span><i class='fa fa-edit'></i></button>
                            
                            <button class='wrapper delid' id='".$user->id."'>
                            <li class='icon delete'>
                            </span>
                            <span class='tooltip'>delete</span>
                            <span><i class='fa fa-trash'></i></button>
                            </div>
                            ";}
                            $output.="
                        </td>
                    </tr>";
                    }
                    $output.="
                </tbody>
            </table></div>  ";
            return json_encode(["a"=>$output]);
            }
            }