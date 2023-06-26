<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function stock()
    {
    return $this->hasOne("App\Models\Stock");
    }
      public function sale()
    {
    return $this->hasOne("App\Models\Sale");
    }
    public function vendor()
    {
      return $this->belongsTo("App\Models\Vendor","clientid");
    }
     public function customer()
    {
    return $this->belongsTo("App\Models\User","clientid");
    }

  public function paymentmode()
    {
         return $this->belongsTo("App\Models\Paymentmode");
    
    }
}
