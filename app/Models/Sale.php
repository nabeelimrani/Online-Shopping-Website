<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $guarded=[];
    use HasFactory;
     public function products()
    {
       return $this->belongsToMany("App\Models\Product")->withpivot("quantity","pprice","saleprice");
    }
    public function user()
    {
        return $this->belongsTo("App\Models\User");
    }
    public function GetSaledataAttribute()
    {
        $output="";
        foreach($this->products as $product)
        {
            $output.=$product->name ."<br> QTY: ".$product->pivot->quantity ." PRICE: ".$product->pprice*$product->pivot->quantity."<br>";
        }
        return $output;
    } public function GetClientinfoAttribute()
    {
                
        return $this->user->fname." ".$this->user->lname."<br>".$this->user->phone."<br>".$this->user->address1;
    }
    public function GetDateAttribute()
    {
        return $this->created_at->format("d-m-Y");
    }
      public function getTotalAttribute()

    {

        $total=0;

        foreach($this->products as $product)

            $total+=$product->pivot->quantity*$product->pivot->saleprice;


        if($this->discount)
            $total=$total-$total*$this->discount/100;
        return $total;

    }
    public function payment()
    {
       return $this->BelongsTo("App\Models\Payment");
    }
    public function GetinfoAttribute()
    {
           $output="";

        foreach($this->products as $product)

            $output.=$product->name." Quantity: ".$product->pivot->quantity."Price ".$product->pivot->quantity*$product->pivot->saleprice."<br>";



        return $output;
    }


      public function GetDetailsAttribute()
    {
        $status="";
        switch($this->status)

        {

            case 0:

            $status="Pending for Verification";

            break;

            case 1:

            $status="Processing..";

            break;
               case 2:

            $status="dispatched..";

            break;  
              case 3:

            $status="shipped to warehouse..";

            break; 
              break;      case 4:

            $status="On the way..";

            break; 
              break;  
              case 5:

            $status="Dileeverd..";

            break;





        }

        return $status;

    }

    
}
