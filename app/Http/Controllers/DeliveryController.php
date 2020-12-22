<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\City;
use App\Models\Province;
use App\Models\Wards;
use App\Models\Freeship;
class DeliveryController extends Controller
{
    public function delivery(Request $request){

    	$city = City::orderby('matp','ASC')->get();

    	return view('admin.delivery.add_delivery')->with(compact('city'));
    }
	public function update_delivery(Request $request){
		$data = $request->all();
		$free_ship = Freeship::find($data['freeship_id']);
		$free_value = rtrim($data['free_value'],'.');
		$free_ship->free_freeship = $free_value;
		$free_ship->save();
	}
	public function select_freeship(){
		$freeship = Freeship::orderby('free_id','DESC')->get();
		$output = '';
		$output .= '<div class="table-responsive">  
			<table class="table table-bordered">
				<thread> 
					<tr>
						<th>Tên thành phố</th>
						<th>Tên quận huyện</th> 
						<th>Tên xã phường</th>
						<th>Phí ship</th>
					</tr>  
				</thread>
				<tbody>
				';

				foreach($freeship as $key => $free){

                $output.='
                 <!--city, province, ward: của Freeship tra ve-->                 
					<tr>
						<td>'.$free->city->name_city.'</td>
						<td>'.$free->province->name_quanhuyen.'</td>
						<td>'.$free->wards->name_xaphuong.'</td>
						<td contenteditable data-freeship_id="'.$free->free_id.'" class="free_freeship_edit">'.number_format($free->free_freeship,0,',','.').'</td>
					</tr>
					';
				}

				$output.='		
				</tbody>
				</table></div>
				';

				echo $output;

		
	}
	public function insert_delivery(Request $request){

        $data = $request->all();
		$free_ship = new Freeship();
		$free_ship->free_matp = $data['city'];
		$free_ship->free_maqh = $data['province'];
		$free_ship->free_xaid = $data['wards'];
		$free_ship->free_freeship = $data['free_ship'];
		$free_ship->save();
	}

    public function select_delivery(Request $request){
    	$data = $request->all();
    	if($data['action']){
    		$output = '';
    		if($data['action']=="city"){
    			$select_province = Province::where('matp',$data['ma_id'])->orderby('maqh','ASC')->get();
    				$output.='<option>---Chọn quận huyện---</option>';
    			foreach($select_province as $key => $province){
    				$output.='<option value="'.$province->maqh.'">'.$province->name_quanhuyen.'</option>';
    			}

    		}else{

    			$select_wards = Wards::where('maqh',$data['ma_id'])->orderby('xaid','ASC')->get();
    			$output.='<option>---Chọn xã phường---</option>';
    			foreach($select_wards as $key => $ward){
    				$output.='<option value="'.$ward->xaid.'">'.$ward->name_xaphuong.'</option>';
    			}
    		}
    		echo $output;
    	}
    	
    }
}
