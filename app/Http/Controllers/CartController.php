<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Http\Requests;

use Illuminate\Support\Facades\Redirect;
use Cart;
use App\Models\Coupon;
session_start();
class CartController extends Controller
{
   
    public function save_cart(Request $request){
        
        $productId = $request->productid_hidden;
        $quantity = $request->qty;        
        $product_info = DB::table('tbl_product')->where('product_id',$productId)->first(); 

        // Lấy Danh mục và thương hiệu mà có Status = 0 (Hiển thị)
        // $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get(); 
        // $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 
        
        // Dùng thư viện Cart lấy data đưa vào CART
        $data['id'] = $product_info->product_id;
        $data['qty'] = $quantity;
        $data['name'] = $product_info->product_name;
        $data['price'] = $product_info->product_price;
        $data['weight'] = $product_info->product_price;
        $data['options']['image'] = $product_info->product_image;
        Cart::add($data);
// Cart::destroy();
        return Redirect::to('/show-cart');      
    }
    public function show_cart(Request $request){
        //seo 
        $meta_desc = "Giỏ hàng của bạn"; 
        $meta_keywords = "Giỏ hàng";
        $meta_title = "Giỏ hàng của bạn";
        $url_canonical = $request->url();
        //--seo
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get(); 
        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 
        return view('pages.cart.show_cart')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);
        }
    public function delete_to_cart($rowId){
        // Xóa sản phẩm dựa vào RowId của CART
        Cart::update($rowId,0);
        return Redirect::to('/show-cart');
    }
    public function delete_product($session_id){
      // Xóa sản phẩm dựa vào Session
        $cart = Session::get('cart');
        // echo '<pre>';
        // print_r($cart);
        // echo '</pre>';
        if($cart==true){
            foreach($cart as $key => $val){
                if($val['session_id']==$session_id){
                    unset($cart[$key]);
                }
            }
            // Đặt lại giá trị mới cho Cart
            Session::put('cart',$cart);
            return redirect()->back()->with('message','Xóa sản phẩm thành công');

        }else{
            return redirect()->back()->with('message','Xóa sản phẩm thất bại');
        }

    }
    public function delete_all_product(){
        $cart = Session::get('cart');
        if($cart==true){
            // Session::destroy();
            Session::forget('cart');
            // NẾU XÓA HẾT GIỎ HÀNG THÌ XÓA LUÔN MÃ GIẢM GIÁ
            Session::forget('coupon');
            return redirect()->back()->with('message','Xóa hết giỏ thành công');
        }
    }
    // Update số lượng Cart bằng AJAX
    public function update_cart(Request $request){
        $data = $request->all();
        // Để đối xem số lượng đó tương ứng với Cart nào
        $cart = Session::get('cart');
        if($cart==true){
            foreach($data['cart_qty'] as $key => $qty){
                foreach($cart as $session => $val){
                    if($val['session_id']==$key){
                        $cart[$session]['product_qty'] = $qty;
                    }
                }
            }
            Session::put('cart',$cart);
            return redirect()->back()->with('message','Cập nhật số lượng thành công');
        }else{
            return redirect()->back()->with('message','Cập nhật số lượng thất bại');
        }
    }
    public function update_cart_quantity(Request $request){
        $rowId = $request->rowId_cart;
        $qty = $request->cart_quantity;
        // Cập nhật số lượng
        Cart::update($rowId,$qty);
        return Redirect::to('/show-cart');
    }
     public function add_cart_ajax(Request $request){
         $data = $request->all();
        // Inser dữ liệu vào 1 cái Session trong add-to-card | Mỗi sản phẩm thêm vào sẽ tạo ra 1 Sesstion ID, dựa vào đó mà Xóa hoặc Update
        $session_id = substr(md5(microtime()),rand(0,26),5);
        $cart = Session::get('cart');
        if($cart==true){
          // Nếu có sản phẩm rồi thì kiểm tra trùng lặp
          // Phải xóa trống giỏ hàng trước khi test
            $is_avaiable = 0;
            foreach($cart as $key => $val){
                if($val['product_id']==$data['cart_product_id']){
                    $is_avaiable++;
                }
            }
             // Nếu ko có cái nào trùng thì thêm 1 cái Card mới để đặt lại
            if($is_avaiable == 0){
                $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],
                );
                Session::put('cart',$cart);
            }
        }else{
          // Nếu chưa có sản phẩm
            $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],

            );
            // Thêm vào Giỏ hàng
            Session::put('cart',$cart);
          }
          // Lưu giỏ hàng lại       
        Session::save();
    } 
    public function gio_hang(Request $request){
        //seo 
       $meta_desc = "Giỏ hàng của bạn"; 
       $meta_keywords = "Giỏ hàng Ajax";
       $meta_title = "Giỏ hàng Ajax";
       $url_canonical = $request->url();
       //--seo
       $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get(); 
       $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get(); 

       return view('pages.cart.cart_ajax')->with('category',$cate_product)->with('brand',$brand_product)->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);
   }
    public function check_coupon(Request $request){
        $data = $request->all();
        $coupon = Coupon::where('coupon_code',$data['coupon'])->first();
        if($coupon){
            $count_coupon = $coupon->count();
            if($count_coupon>0){
              // Nếu có Coupon sẽ tạo 1 cái Session để lưu Coupon
                $coupon_session = Session::get('coupon');
                if($coupon_session==true){
                    $is_avaiable = 0;
                    if($is_avaiable==0){
                        $cou[] = array(
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_condition' => $coupon->coupon_condition,
                            'coupon_number' => $coupon->coupon_number,

                        );
                        // Tạo ra 1 cái session coupon dưới dạng $cou
                        Session::put('coupon',$cou);
                    }
                }else{
                  // Nếu chưa có  thì tạo 1 cái mới
                    $cou[] = array(
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_condition' => $coupon->coupon_condition,
                            'coupon_number' => $coupon->coupon_number,

                        );
                    Session::put('coupon',$cou);
                }
                Session::save();
                return redirect()->back()->with('message','Thêm mã giảm giá thành công');
            }

        }else{
            return redirect()->back()->with('error','Mã giảm giá không đúng');
        }
    }  
}