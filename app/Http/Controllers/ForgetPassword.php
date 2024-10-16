<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
class ForgetPassword extends Controller
{
    public function ForgetPassword(){
        return view('front.account.forget-password');
    }
    
    public function forgetPasswordPost(Request $request){
        $request ->validate([
            'email'=>"required|email|exists:users"
        ]);   
        $token = Str::random(64);
        
        DB::table('password_resets')->insert([
            'email'=>$request->email,
            'token'=>$token,
            'created_at'=>Carbon::now(),
        ]);
        Mail::send("email.forget-password",['token'=>$token],function ($message) use ($request){
            $message->to($request->email);
            $message->subject("Reset Password");
        });
        return redirect()->to(route("account.forgetPassword"))->with('success','We have Sent an email to reset your password');

    }
    public function resetPassword($token){
        return view("front.account.new-password",compact('token'));
    }
    public function resetPasswordPost(Request $request){
        $request->validate([
            'email'=> 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'confirm_password'=>'required|same:password',
        ]);
       $updatedPassword= DB::table('passwords_reset')->where([
            'email'=>$request->email,
            'token'=>$request->token
        ])->first();
        if(!$updatedPassword){
            return redirect()->to(route('account.resetPassword'))->with('error','Invalid');
        }
        User::where("email",$request->email)->update(["password"=>Hash::make($request->password)]);
        DB::table('passwords_reset')->where(['email'=>$request->email])->delete();
        return redirect()->to(route('account.login'))->with('success','Password reset success');
    }
}
