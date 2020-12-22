<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests;

use App\Models\Slider;
use Session;
use DB;

class SliderController extends Controller
{
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function manage_slider(){
        $all_slider = Slider::orderBy('slider_id','DESC')->get();
        return view('admin.slider.list_slider')->with(compact('all_slider'));
    }
    public function add_slider(){
        return view('admin.slider.add_slider');
    }
    public function insert_slider(Request $request){
        $this->AuthLogin();

        $data = $request->all();
        //Test Du Lieu tra ve
        // dd($data);

        $get_image = $request->file('slider_image');
      
        if($get_image){
            //Lấy tên ảnh gốc
            $get_name_image = $get_image->getClientOriginalName();
            // Chỉ lấy tên bõ phần đuôi
            $name_image = current(explode('.',$get_name_image));
            //Tên ảnh gốc + 0-99 + đuôi ảnh
            $new_image =  $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/slider',$new_image);
            // Có ảnh thì thêm ảnh dùng Model
            $slider = new Slider();

            $slider->slider_name = $data['slider_name'];
            //Lấy tên hình ảnh đã lưu trên serve
            $slider->slider_image = $new_image;
            $slider->slider_desc = $data['slider_desc'];
            $slider->slider_status = $data['slider_status'];
            $slider->save();

            Session::put('message','Thêm Slider thành công');
            return Redirect::to('manage-slider');
        }
        // K có ảnh sẽ Văng messinger bắt buộc thêm
        else{
            Session::put('message','Làm ơn thêm ảnh');
            return Redirect::to('add-slider');
        }       
    }
    public function unactive_slider($slider_id){
        $this->AuthLogin();
        DB::table('tbl_slider')->where('slider_id',$slider_id)->update(['slider_status'=>1]);
        Session::put('message','Ẩn Slider thành công');
        return Redirect::to('manage-slider');

    }
    public function active_slider($slider_id){
        $this->AuthLogin();
        DB::table('tbl_slider')->where('slider_id',$slider_id)->update(['slider_status'=>0]);
        Session::put('message','Kích hoạt Slider thành công');
        return Redirect::to('manage-slider');

    }
}
