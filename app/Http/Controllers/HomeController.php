<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class HomeController extends Controller
{
    public function index(){
        // Gọi Category và Brand trên DB xuống
        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id','desc')->get(); 

        $all_product = DB::table('tbl_product')->where('product_status', '0')->orderby('brand_id','desc')->limit(4)->get(); 

        return view('pages.home')->with('category', $cate_product)->with('brand', $brand_product)->with('all_product', $all_product); 
    }
    public function search(Request $request){

        $keywords = $request->keywords_submit;

        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 
        // LIKE MySQL là thuật toán tìm kiếm LIKE '%or%
        $search_product = DB::table('tbl_product')->where('product_name','like','%'.$keywords.'%')->get(); 


        return view('pages.sanpham.search')->with('category',$cate_product)->with('brand',$brand_product)->with('search_product',$search_product);

    }
}
