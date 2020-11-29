<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use Session;

use App\Models\Social;
use Socialite;
use App\Models\Login;

use App\Rules\Captcha; 
use Validator;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
session_start();

class AdminController extends Controller
{
    public function login_facebook(){
        return Socialite::driver('facebook')->redirect();
    }

    public function callback_facebook(){
        $provider = Socialite::driver('facebook')->user();
        $account = Social::where('provider','facebook')->where('provider_user_id',$provider->getId())->first();
        if($account){
            //login in vao trang quan tri  
            $account_name = Login::where('admin_id',$account->user)->first();
            Session::put('admin_name',$account_name->admin_name);
            Session::put('admin_id',$account_name->admin_id);
            return redirect('/dashboad')->with('message', 'Đăng nhập Admin thành công');
        }else{
            // Lưu người dùng mới
            $hieu = new Social([
                'provider_user_id' => $provider->getId(),
                'provider' => 'facebook'
            ]);

            $orang = Login::where('admin_email',$provider->getEmail())->first();

            if(!$orang){
                $orang = Login::create([
                    'admin_name' => $provider->getName(),
                    'admin_email' => $provider->getEmail(),
                    'admin_password' => '',
                    'admin_phone' => ''
                    
                ]);
            }

            $hieu->login()->associate($orang);
            $hieu->save();

            $account_name = Login::where('admin_id',$account->user)->first();
            Session::put('admin_name',$account_name->admin_name);
            Session::put('admin_id',$account_name->admin_id);
            return redirect('/dashboad')->with('message', 'Đăng nhập Admin thành công');
        } 
    }
    //login Google
    public function login_google(){
        return Socialite::driver('google')->redirect();
    }
    public function callback_google(){
            $googleUser  = Socialite::driver('google')->stateless()->user(); 

            // // return $googleUser ->id;
            // return $googleUser ->name;
            // return $googleUser ->email;
            $authUser = $this->findOrCreateUser($googleUser ,'google');
            $account_name = Login::where('admin_id',$authUser->user)->first();
            Session::put('admin_name',$account_name->admin_name);
            Session::put('admin_id',$account_name->admin_id);
            return redirect('/dashboad')->with('message', 'Đăng nhập Admin thành công');  
    }
    public function findOrCreateUser($googleUser , $provider){
            $authUser = Social::where('provider_user_id', $googleUser ->id)->first();
            if($authUser){

                return $authUser;
            }
          
            $hieu = new Social([
                'provider_user_id' => $googleUser ->id,
                //Viết HOA tên biến
                'provider' => strtoupper($provider)
            ]);

            $orang = Login::where('admin_email',$googleUser ->email)->first();

                if(!$orang){
                    $orang = Login::create([
                        'admin_name' => $googleUser ->name,
                        'admin_email' => $googleUser ->email,
                        'admin_password' => '',
                        'admin_phone' => '',
                        'admin_status' => 1
                        
                    ]);
                }
                // Nối $hieu và $orang
            $hieu->login()->associate($orang);
                
            $hieu->save();

            $account_name = Login::where('admin_id',$hieu->user)->first();
            Session::put('admin_name',$account_name->admin_name);
            Session::put('admin_id',$account_name->admin_id); 
          
            return redirect('/dashboad')->with('message', 'Đăng nhập Admin thành công');


    }

    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboad');
        }else{
            return Redirect::to('admin')->send();
        }
    }
    public function index(){
        return view('admin_login');
    }
    public function show_dashboad(){
        $this->AuthLogin();
        return view('admin.dashboad');
    }
    //Đăng Nhập
    public function dashboad(Request $request){

      //$data = $request->all();
    //   $data = $request->validate([
    //       //validation laravel 
    //   'admin_email' => 'required',
    //   'admin_password' => 'required',
    //    'g-recaptcha-response' => new Captcha(),    //dòng kiểm tra Captcha
    //             ]);

        $admin_email = $request->admin_email;
        $admin_password = md5($request->admin_password);
        $result = DB::table('tbl_admin')->where('admin_email', $admin_email)->where('admin_password', $admin_password)->first();
        if($result){
            Session::put('admin_name',$result->admin_name);
            Session::put('admin_id',$result->admin_id);
            return Redirect::to('/dashboad');
        }else{
            Session::put('message','Mật khẩu hoặc tài khoản bị sai!');
            return Redirect::to('/admin');
        }
    }
    //Đăng Xuất
    public function logout(){
        $this->AuthLogin();
        Session::put('admin_name',null);
        Session::put('admin_id',null);
        return Redirect::to('/admin');
    }
}
