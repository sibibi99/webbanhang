<?php

use Illuminate\Support\Facades\Route;


//FrontEnd
Route::get('/','App\Http\Controllers\HomeController@index');
Route::post('/tim-kiem','App\Http\Controllers\HomeController@search');

//Front End - Danh muc san pham Trang chu
Route::get('/danh-muc-san-pham/{slug_category_product}','App\Http\Controllers\CategoryProduct@show_category_home');
Route::get('/thuong-hieu-san-pham/{brand_slug}','App\Http\Controllers\BrandProduct@show_brand_home');
Route::get('/chi-tiet-san-pham/{product_slug}','App\Http\Controllers\ProductController@details_product');
//Cart
// Route::post('/save-cart','App\Http\Controllers\CartController@save_cart');
// Route::get('/show-cart','App\Http\Controllers\CartController@show_cart');
// Route::get('/delete-to-cart/{rowId}','App\Http\Controllers\CartController@delete_to_cart');
// Route::post('/update-cart-quantity','App\Http\Controllers\CartController@update_cart_quantity');
// Cart AJAX
Route::post('/add-cart-ajax','App\Http\Controllers\CartController@add_cart_ajax');
Route::get('/gio-hang','App\Http\Controllers\CartController@gio_hang');
Route::post('/update-cart','App\Http\Controllers\CartController@update_cart');
Route::get('/del-product/{session_id}','App\Http\Controllers\CartController@delete_product');
Route::get('/del-all-product','App\Http\Controllers\CartController@delete_all_product');
//Coupon
Route::post('/check-coupon','App\Http\Controllers\CartController@check_coupon');
Route::get('/insert-coupon','App\Http\Controllers\CouponController@insert_coupon');
Route::get('/list-coupon','App\Http\Controllers\CouponController@list_coupon');
Route::post('/insert-coupon-code','App\Http\Controllers\CouponController@insert_coupon_code');

Route::get('/delete-coupon/{coupon_id}','App\Http\Controllers\CouponController@delete_coupon');
// Xóa mã khuyến mãi
Route::get('/unset-coupon','App\Http\Controllers\CouponController@unset_coupon');

//Checkout
Route::get('/login-checkout','App\Http\Controllers\CheckoutController@login_checkout');
Route::post('/add-customer','App\Http\Controllers\CheckoutController@add_customer');
Route::get('/checkout','App\Http\Controllers\CheckoutController@checkout');
Route::post('/save-checkout-customer','App\Http\Controllers\CheckoutController@save_checkout_customer');
Route::get('/logout-checkout','App\Http\Controllers\CheckoutController@logout_checkout');
Route::post('/login-customer','App\Http\Controllers\CheckoutController@login_customer');
Route::get('/payment','App\Http\Controllers\CheckoutController@payment');
Route::post('/order-place','App\Http\Controllers\CheckoutController@order_place');
Route::post('/select-delivery-home','App\Http\Controllers\CheckoutController@select_delivery_home');
Route::post('/calculate-free','App\Http\Controllers\CheckoutController@calculate_free');
Route::get('/del-free','App\Http\Controllers\CheckoutController@del_free');

Route::post('/confirm-order','App\Http\Controllers\CheckoutController@confirm_order');

// <<<<<<<-------Backend Admin ----------->>
Route::get('/admin','App\Http\Controllers\AdminController@index');
Route::get('/dashboad','App\Http\Controllers\AdminController@show_dashboad');
Route::get('/logout','App\Http\Controllers\AdminController@logout');
Route::post('/admin-dashboad','App\Http\Controllers\AdminController@dashboad');

//Category Product
Route::get('/add-category-product','App\Http\Controllers\CategoryProduct@add_category_product');
Route::get('/edit-category-product/{category_product_id}','App\Http\Controllers\CategoryProduct@edit_category_product');
Route::get('/delete-category-product/{category_product_id}','App\Http\Controllers\CategoryProduct@delete_category_product');
Route::get('/all-category-product','App\Http\Controllers\CategoryProduct@all_category_product');
    //Lưu Và Cập Nhật
Route::post('/save-category-product','App\Http\Controllers\CategoryProduct@save_category_product');
Route::post('/update-category-product/{category_product_id}','App\Http\Controllers\CategoryProduct@update_category_product');
    //Ẩn Hiện
Route::get('/unactive-category-product/{category_product_id}','App\Http\Controllers\CategoryProduct@unactive_category_product');
Route::get('/active-category-product/{category_product_id}','App\Http\Controllers\CategoryProduct@active_category_product');

//Brand Product
Route::get('/add-brand-product','App\Http\Controllers\BrandProduct@add_brand_product');
Route::get('/edit-brand-product/{brand_product_id}','App\Http\Controllers\BrandProduct@edit_brand_product');
Route::get('/delete-brand-product/{brand_product_id}','App\Http\Controllers\BrandProduct@delete_brand_product');
Route::get('/all-brand-product','App\Http\Controllers\BrandProduct@all_brand_product');

Route::get('/unactive-brand-product/{brand_product_id}','App\Http\Controllers\BrandProduct@unactive_brand_product');
Route::get('/active-brand-product/{brand_product_id}','App\Http\Controllers\BrandProduct@active_brand_product');

Route::post('/save-brand-product','App\Http\Controllers\BrandProduct@save_brand_product');
Route::post('/update-brand-product/{brand_product_id}','App\Http\Controllers\BrandProduct@update_brand_product');

//Product
Route::get('/add-product','App\Http\Controllers\ProductController@add_product');
Route::get('/edit-product/{product_id}','App\Http\Controllers\ProductController@edit_product');
Route::get('/delete-product/{product_id}','App\Http\Controllers\ProductController@delete_product');
Route::get('/all-product','App\Http\Controllers\ProductController@all_product');

Route::get('/unactive-product/{product_id}','App\Http\Controllers\ProductController@unactive_product');
Route::get('/active-product/{product_id}','App\Http\Controllers\ProductController@active_product');

Route::post('/save-product','App\Http\Controllers\ProductController@save_product');
Route::post('/update-product/{product_id}','App\Http\Controllers\ProductController@update_product');

//Order
Route::get('/manage-order','App\Http\Controllers\CheckoutController@manage_order');
Route::get('/view-order/{order_code}','App\Http\Controllers\OrderController@view_order');

Route::get('/print-order/{checkout_code}','App\Http\Controllers\OrderController@print_order');
Route::get('/view-order/{order_code}','App\Http\Controllers\OrderController@view_order');

//Send Mail 
Route::get('/send-mail','App\Http\Controllers\HomeController@send_mail');

//Login facebook
Route::get('/login-facebook','App\Http\Controllers\AdminController@login_facebook');
Route::get('/admin/callback','App\Http\Controllers\AdminController@callback_facebook');

//Login google
Route::get('/login-google','App\Http\Controllers\AdminController@login_google');
Route::get('/google/callback','App\Http\Controllers\AdminController@callback_google');

//Delivery
Route::get('/delivery','App\Http\Controllers\DeliveryController@delivery');
Route::post('/select-delivery','App\Http\Controllers\DeliveryController@select_delivery');
Route::post('/insert-delivery','App\Http\Controllers\DeliveryController@insert_delivery');
// Đưa Phí vận chuyển bằng AJAX ra bảng
Route::post('/select-freeship','App\Http\Controllers\DeliveryController@select_freeship');
Route::post('/update-delivery','App\Http\Controllers\DeliveryController@update_delivery');