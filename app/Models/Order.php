<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Country;
use App\Models\Transportation;

class Order extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function product(){
		return $this->belongsTo(Product::class);
	}
    public function country(){
		return $this->belongsTo(Country::class);
	}
    public function transportation(){
		return $this->belongsTo(Transportation::class);
	}
}
