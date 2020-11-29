<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
    	'brand_name', 'brand_slug', 'brand_desc','brand_status'
    ];
    //Khóa chính
    protected $primaryKey = 'brand_id';
 	protected $table = 'tbl_brand';
    use HasFactory;
}

