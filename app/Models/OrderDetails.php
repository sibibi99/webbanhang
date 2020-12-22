<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'order_code', 'product_id', 'product_name','product_price','product_sales_quantity','product_coupon','product_freeship'
    ];
    protected $primaryKey = 'order_details_id';
 	protected $table = 'tbl_order_details';

 	public function product(){
         // belongTo: Mỗi sp trong chi tiết thuộc về 1 cái order_code
 		return $this->belongsTo('App\Models\Product','product_id');
 	}
    use HasFactory;
}
