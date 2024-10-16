<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator; 
class AuthController extends Controller
{
    public function Registeration(){
        return view('front.account.register');
    }
    public function RegisterProcess(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4',
            'email' => 'required|email|unique:users,email', 
            'password'=>'required|min:6',
            'confirm_password'=>'required|same:password',
        ]);
        if($validator->passes()){
            $user = new User();
            $user->name=$request->name;
            $user->email=$request->email;
            $user->password=Hash::make($request->password);
            $user->save();
            session()->flash('success','You Have Registerd Successfully');
            return response()->json([
                'status'=>true,
                'errors'=>[]
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()
            ]);
        }
    }
    public function login(){
        return view('front.account.login');
    }
    public function authenticate(Request $request){
        $validator = Validator::make($request->all(), [
            'email'=>'required',
            'password'=>'required',
        ]);
        if($validator->passes()){
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                return redirect()->route('account.profile');
            }else{
                return redirect()->route('account.login')->with('error','Either Email or Password is Invalid');
            }
        }else{
            return redirect()->route('account.login')
            ->withErrors($validator)
            ->withInput($request->only('email'));
        }
    }
    public function profile(){
        $id=Auth::user()->id;
        $user= User::where('id',$id)->first();
        // if there is view() so we use the name of the folder 
        return view('front.account.profile',[
            'user'=>$user,
        ]);
    }
    public function updateProfile(Request $request){
        $id=Auth::user()->id;
        $validator=Validator::make($request->all(),[
            'name'=>'required|min:3|max:20',
            'email'=>'required|email|unique:users,email,'.$id.',id',
        ]);
        if($validator->passes()){
            $user=User::find($id);
            $user->name=$request->name;
            $user->email=$request->email;
            $user->designation=$request->designation;
            $user->mobile=$request->mobile;
            $user->save();
            session()->flash('success','Profile Updated Successfully');
            return response()->json([
                'status'=>true,
                'errors'=>[],
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors(),
            ]);
        }
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('account.login');   
         // if there is route() so we use the name that found in the web.php 
    }

    public function updateProfilePic(Request $request){
        $id=Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'image' => 'required|image',
        ]);
        if($validator->passes()){
            $image=$request->image;
            $ext=$image->getClientOriginalExtension();
            $imageName=$id.'-'.time().'.'.$ext;
            $image->move(public_path('/profile_pic/'),$imageName);
            User::where('id',$id)->update(['image'=>$imageName]);
            session()->flash('success','Profile Picture Updated Successfully');
            return response()->json([
                'status'=>true,
                'errors'=>[]
            ]);
        }else{
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()
            ]);
        }

    }
    public function updatePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => [
            'required',
            'min:6',
            'regex:/[!@#$%^&*(),.?":{}|<>]/', 
    ],       'confirm_password' => 'required|same:new_password',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()
            ]);
        }
        if(Hash::check($request->old_password,Auth::user()->password) == false){
            session()->flash('error','Old Password is incorrect');
            return response()->json([

                'status'=>false,
            ]);
        }
        $user=User::find(Auth::user()->id);
        $user->password= Hash::make($request->new_password);
        $user->save();

        session()->flash('success','Password is Updated Successfully');
        return response()->json([
            'status'=>true,
            'redirect_url' => route('account.profile'),

        ]);

    }
}
