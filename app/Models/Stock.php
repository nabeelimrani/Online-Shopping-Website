<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $guarded=[];
    use HasFactory;
    public function payment()
    {
        return $this->belongsTo("App\Models\Payment");
    }
    public function products()
    {
       return $this->belongsToMany("App\Models\Product")->withpivot("quantity","price");
    }
    public function vendor()
    {
        return $this->belongsTo("App\Models\Vendor");
    }
    public function GetDetailAttribute()
    {
        $output="";
        foreach($this->products as $product)
        {
            $output.=$product->name ."<br> QTY: ".$product->pivot->quantity ." PRICE: ".$product->pivot->price."<br>";
        }
        return $output;
    }
       public function getAmountAttribute()
    {
        return $this->products->sum("pivot.price");
    }

}
