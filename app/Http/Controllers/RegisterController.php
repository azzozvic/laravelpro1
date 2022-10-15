<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Basecontroller as Basecontroller;
use App\Models\User;
use Validator;

class RegisterController extends Basecontroller
{
    public function register(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name'=>'required',
            'email'=>'required | email',
            'password'=>'required',
            'c_password'=>'required | same:password'
        ]);
        if ( $validator->fails()) {
           return $this->sendError('validate youe filde',$validator->errors());
        }
        $input=$request->all();
        $input['password']=Hash::make( $input['password']);
        $user=User::create( $input);
        $success['token']=$user->createToken('azzzozbinmo')->accessToken;
        $success['name']=$user->name;
        return $this->sendResponse($success,'user registred successfully');
    }



    public function login(Request $request)
    {
       if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        $user=Auth::user();
        $success['token']=$user->createToken('azzzozbinmo')->accessToken;
        $success['name']=$user->name;
        return $this->sendResponse($success,'user login successfully');

       }
      else{
        return $this->sendError('user unauthorised',['error','unauthorised']);
      }

    }
}
