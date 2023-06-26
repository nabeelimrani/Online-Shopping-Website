<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{

    use HasFactory;
    protected $guarded=[];
    public function category()
    {
        return $this->belongsTo("App\Models\Category");
    }
    public function sales()
    {
       return $this->belongsToMany("App\Models\Sale")->withpivot("quantity","pprice","saleprice");
    }
     public function stocks()
    {
       return $this->belongsToMany("App\Models\Stock")->withpivot("quantity","price");
    }
    public function ratings()
    {
        return $this->hasMany("App\Models\Rating");
    }
    public function getRcounttAttribute()
    {
      return  $this->ratings()->count();
    }
    public function getAverageRating()
    {
        $totalRating = $this->ratings()->count();
        dd($totalRating);
        $averageRating = $this->ratings()->avg('rating');
        return $totalRating ;
    }
}
