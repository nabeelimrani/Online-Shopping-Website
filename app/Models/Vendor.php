<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    protected $guarded=[];
     public function stocks()
    {
        return $this->hasMany("App\Models\Stock");
    }
       public function payments()
    {
        return $this->hasMany("App\Models\Payment","clientid");
    }
}
