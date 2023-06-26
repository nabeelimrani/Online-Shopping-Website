<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\Stock;
use App\Models\Payment;
use App\Models\Sale;
class StockController extends Controller
{
Public function salestatus(){

$orders=Sale::where("status","!=",5)->latest()->get();
return view("admin.salestatus",compact("orders"));

}
public function editstock()
{
session()->forget("scart","hcart");
$stock=Stock::find(request()->id);
$stockid=$stock->id;
$hdata=[
"date"=>$stock->created_at,
"vno"=>$stock->vno,
"vendor"=>$stock->vendor->name,
];
if(!empty($hdata))
session()->put("hcart",$hdata);
if($stock)
{
foreach($stock->products as $item)
{
$data=[
"pid"=>$item->id,
"qty"=>$item->pivot->quantity,
"price"=>$item->pivot->price,
];
session()->push("scart",$data);
}
}

$output="<table class='table'><thead><th></th><th>Sno</th><th>Product Name</th><th>Quantity</th><th>Amount</th><thead><tbody>";
foreach(session('scart') as $index=>$stock)
{
$productname=Product::find($stock['pid'])->name;
$cnt=$index+1;
$output.="<tr>
    <td>
        <button type=submit class='cross-btn remove' id='$index'><i class='fas fa-times'></i></button>
    </td>
    <td>$cnt</td>
    <td>$productname</td>
    <td>".$stock['qty']."</td>
    <td>".$stock['price']."</td>
</tr>";
}
$output.="</tbody></table>";

return $this->addstock($output,$hdata,$stockid);
}
public function removestock()
{
$index=request()->index;
$items=session()->get('scart');
unset($items[$index]);
array_values($items);
session()->put('scart',$items);
$output="<table class='table mt-3'><thead><th></th><th>Sno</th><th>Product Name</th><th>Quantity</th><th>Amount</th><thead><tbody>";
foreach(session('scart') as $index=>$stock)
{
$productname=Product::find($stock['pid'])->name;
$cnt=$index+1;
$output.="<tr>
<td>
    <i class='fas fa-times remove' id='$index' ></i>
    <td>$cnt</td>
    <td>$productname</td>
    <td>".$stock['qty']."</td>
    <td>".$stock['price']."</td>
</tr>";
}
$output.="</tbody></table>";
return json_encode(["a"=>$output]);
}
public function delstock($id=0)
{
if($id)
$id=$id;
else
$id=request()->id;
$stock=stock::find($id);
if($stock)
{
foreach($stock->products as $item)
{
$pid=$item->id;
$qty=$item->pivot->quantity;
$inhand=Product::find($pid)->inhand-$qty;
Product::find($pid)->update(["inhand"=>$inhand]);
}
$stock->products()->detach();
if($stock->payment)
$stock->payment->delete();
$stock->delete();
}
return 1;
}
public function storestock()
{
$flag=request()->stockid;
$data=session()->get("hcart",[]);
$vendor=Vendor::where("name",$data['vendor'])->first();
if($vendor)$vid=$vendor->id;else
{
$vendor=Vendor::create(["name"=>$data['vendor']]);
$vid=$vendor->id;
}

$stock=Stock::orderBy("id","DESC")->first();
if($stock) $nid=$stock->id+1; else $nid=1;


if($flag)
{
$nid=$flag;
$this->delstock($nid);
}

$stock1=Stock::Create([
"id"=>$nid,
"vendor_id"=>$vid,
"vno"=>$data['vno'],
"created_at"=>$data['date'],
]);
$stockdata=session()->get("scart");
$sum=0;
foreach($stockdata as $stock)
{
$inhand=Product::find($stock['pid'])->inhand+$stock['qty'];
Product::find($stock['pid'])->update(["inhand"=>$inhand]);
$stock1->products()->attach($stock['pid'],[
"quantity"=>$stock['qty'],
"price"=>$stock['price'],
"created_at"=>$data['date'],
]);
$sum+=$stock['price'];
}
$total=$sum;
$payments=Payment::orderBy("id","DESC")->first();
if($payments) $paymentid=$payments->id+1; else $paymentid=1;
$payment=Payment::create([
"id"=>$paymentid,
"clientid"=>$stock1->vendor_id,
"tmode"=>1,
"description"=>"stock recieved from ".$stock1->vendor->name,
"credit"=>$total,
]);
$stock1->update(["payment_id"=>$payment->id]);
session()->forget("scart","hcart");

return 1;
}

public function enterstock()
{

$hdata=[
"date"=>request()->date,
"vno"=>request()->vno,
"vendor"=>request()->vendor,
];
$data=[
"pid"=>request()->product_id,
"qty"=>request()->quantity,
"price"=>request()->price,
];
if(!empty($data))
session()->push("scart",$data);
if(!empty($hdata))
session()->put("hcart",$hdata);
$output="<table class='table mt-3'><thead><th></th><th>Sno</th><th>Product Name</th><th>Quantity</th><th>Amount</th><thead><tbody>";
foreach(session()->get('scart',[]) as $index=>$stock)
{
$productname=Product::find($stock['pid'])->name;
$cnt=$index+1;
$output.="<tr>
<td>
    <i class='fas fa-times remove' id='$index' ></i>
    <td>$cnt</td>
    <td>$productname</td>
    <td>".$stock['qty']."</td>
    <td>".$stock['price']."</td>
</tr>";
}
$output.="</tbody></table>";
return json_encode(["a"=>$output]);
}
public function addstock($output="",$hdata=[],$stockid=0)
{

$vendors=Vendor::orderBy("name")->get();
$products=Product::orderBy("name")->get();
if(empty($hdata))
$hdata=["date"=>now()->format("Y-m-d"),"vno"=>"","vendor"=>""];
return view("admin.addstock",compact("vendors","products","output","hdata","stockid"));
}
public function stock()
{
$products=Product::all();
$stocks=Stock::latest()->get();
return view("admin.stock",compact("products","stocks"));
}
}