<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\Payment;
use App\Models\Sale;
use App\Models\Paymentmode;
use App\Models\User;
use Carbon\Carbon;
class PaymentController extends Controller
{


         public function searchcustomerledger()

    {
               $vid=request()->vid;
        $sdate=request()->sdate;
        $edate=request()->edate;
         $sdate=Carbon::parse($sdate)->startOfDay();
    $edate=Carbon::parse($edate)->endOfDay();
        $payments=Payment::where("clientid",$vid)->
        where("tmode",2)->
        whereBetween("created_at",[$sdate,$edate])->get();
      return $this->customerledger($payments);
    }

    public function customerledger($payments=[])
    {

        $customers=User::has("sales")->where("role",0)->get();
        return view("admin.customerledger",compact("customers","payments"));
    }

    public function searchsaleledger()
    {

        $sdate=request()->sdate;
        $edate=request()->edate;

        $sdate=Carbon::parse($sdate)->startOfDay();
    $edate=Carbon::parse($edate)->endOfDay();
        $sales=Sale::whereBetween("created_at",[$sdate,$edate])
        ->get();
        return $this->saleledger($sales);
    }

    public function saleledger($sales=[])
    {
    
        return view("admin.saleledger",compact("sales"));
    }
    public function searchvendorledger()
    {
               $vid=request()->vid;
        $sdate=request()->sdate;
        $edate=request()->edate;
         $sdate=Carbon::parse($sdate)->startOfDay();
    $edate=Carbon::parse($edate)->endOfDay();
        $payments=Payment::where("clientid",$vid)->
        where("tmode",1)->
        whereBetween("created_at",[$sdate,$edate])->get();
      return $this->vendorledger($payments);
    }
        public function vendorledger($payments=[])
        {
         
        $vendors=Vendor::has("stocks")->get();
        return view("admin.vendorledger",compact("vendors","payments"));
        }
        public function stockledger()
        {
              $products=Product::has("stocks")->get();
        return view("admin.stockledger",compact("products"));
        }


        public function addreciept()
    {
           $vid=request()->vid;
        $pmode=request()->pmode;
        $credit=request()->namount;
        $description=request()->description;
       $payments=Payment::orderBy("id","DESC")->first();
       if($payments) $nid=$payments->id+1; else $nid=1;
        $payment=Payment::create([
            "id"=>$nid,
            "clientid"=>$vid,
            "tmode"=>2,
            "paymentmode_id"=>$pmode,
            "credit"=>$credit,
            "description"=>$description,
        ]);

        return redirect("/reciept");
    }
    public function reciept()
    {
         $customers=User::has("sales")->get();
        $modes=Paymentmode::all();
        $payments=Payment::has("customer")->where("tmode",2)->where("paymentmode_id","!=",Null)->get();
        return view("admin.reciept",compact("customers","modes","payments"));
    }
    public function delpayment()
    {
        $id=request()->id;
        Payment::find($id)->delete();
        return 1;
    }

    public function addpayment()
    {
           $vid=request()->vid;
        $pmode=request()->pmode;
        $debit=request()->namount;
        $description=request()->description;
       $payments=Payment::orderBy("id","DESC")->first();
       if($payments) $nid=$payments->id+1; else $nid=1;
        $payment=Payment::create([
            "id"=>$nid,
            "clientid"=>$vid,
            "tmode"=>1,
            "paymentmode_id"=>$pmode,
            "debit"=>$debit,
            "description"=>$description,
        ]);

        return redirect("/payment");
    }
    public function getbalance()
    {
          $debit=Payment::where("clientid",request()->vid)->where("tmode",1)->sum("debit");
        $credit=Payment::where("clientid",request()->vid)->where("tmode",1)->sum("credit");
        $balance=$debit-$credit;
        return $balance;
    }
    public function payment()
    {
         $vendors=Vendor::has("stocks")->get();
        $modes=Paymentmode::all();
        $payments=Payment::has("vendor")->where("tmode",1)->where("paymentmode_id","!=",Null)->get();
        return view("admin.payment",compact("vendors","modes","payments"));
    }
}
