<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator; 

class UserController extends Controller
{
    public function index(){
        $users= User::orderBy('role','ASC')->orderBy('created_at','DESC')->paginate(10);
        return view('admin.users.show',[
            'users'=>$users
        ]);
    }
    public function edit($id){
        $user = User::findorfail($id);
        $users = User::all();
        return view('admin.users.edit',[
            'user'=>$user,
            'users'=>$users,
        ]);
    }
    public function update($id, Request $request){
        $validator = Validator::make($request->all(),[
            'designation' => 'required',
            'role' => 'required|in:admin,user', 
        ]);
        if($validator->passes()){
            $user = User::find($id);
            $user->designation = $request->designation;
            $user->role = $request->role;
            $user ->save();
            session()->flash('success','User Information Updated Successfully');
            return response()->json([
                'status'=>true,
            ]);
            return redirect()->to('admin.edit');
        }else{
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors(),
            ]);
        }
    }
    public function destroy(Request $request){
        $id = $request->id;
        $user = User::find($id);

        if($user == null){
            session()->flash('error','User not found');
            return response()->json([
                'status'=>false,
            ]);
        }
        $user->delete();
        session()->flash('success','User deleted sucessfully');
        return response()->json([
            'status'=>true,
            'redirect_url' => route('admin.users'),
        ]);
        return redirect()->to('admin.users');

    }
}
