<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FreeShip extends Model
{
    public $timestamps = false; //set time to false
    protected $fillable = [
    	'free_matp', 'free_maqh','free_xaid','free_freeship'
    ];
    protected $primaryKey = 'free_id';
 	protected $table = 'tbl_free_ship';
    // Mã Thành phố sẽ Thuộc về Phí vận chuyển của Thành phố
    public function city(){
        return $this->belongsTo('App\Models\City', 'free_matp');
    }
 	public function province(){
 		return $this->belongsTo('App\Models\Province', 'free_maqh');
 	}
 	public function wards(){
 		return $this->belongsTo('App\Models\Wards', 'free_xaid');
 	}
    use HasFactory;
}
