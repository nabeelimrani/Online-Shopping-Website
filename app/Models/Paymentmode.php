<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paymentmode extends Model
{
    protected $guarded=[];
    use HasFactory;

     public function payment()
    {
       return $this->hasOne("App\Models\Payment");
    }
}
