<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public function send_mail(){
        $to_name = "Xuannguyen";
        $to_email = "xuanthuyloi@gmail.com";

        $data = array("name"=>"Mail từ tài khoản khách hàng","body"=>"Mail gửi về vấn đề hóa đơn");

        Mail::send('pages.send_mail',$data,function($message) use ($to_name,$to_email){
            $message->to($to_email)->subject('test thư gửi mail google');
            $message->from($to_email,$to_name);
        });
        // return redirect('/')->with('message','');
    }

    public function quen_mat_khau(Request $request){


        // $meta_desc = "Quên mật khẩu";
        // $meta_keywords = "Quên mật khẩu";
        // $meta_title = "Quên mật khẩu";
        // $url_canonical = $request->url();

        // return view('pages.checkout.forget_pass')->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);
        
        return view('pages.checkout.forget_pass');
    }
}
