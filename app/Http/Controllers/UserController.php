<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function getReset()
    {
        if(Auth::check()){
            return view('auth.reset');
        }else{
            return redirect('login');
        }
    }

    public function postReset(Request $request)
    {
        $oldpassword = $request->input('oldpassword');
        $password = $request->input('password');
        $data = $request->all();
        $rules = [
            'oldpassword'=>'required|between:6,20',
            'password'=>'required|between:6,20|confirmed',
        ];
        $messages = [
            'required' => '密碼不能為空',
            'between' => '密碼必須是6~20位之間',
            'confirmed' => '新密碼和確認密碼不匹配'
        ];
        $validator = Validator::make($data, $rules, $messages);
        $user = Auth::user();
        $validator->after(function($validator) use ($oldpassword, $user) {
            if (!\Hash::check($oldpassword, $user->password)) {
                $validator->errors()->add('oldpassword', '原密碼錯誤');
            }
        });
        if ($validator->fails()) {
            return back()->withErrors($validator);  //返回一次性錯誤
        }
        $user->password = bcrypt($password);
        $user->save();
        Auth::logout();  //更改完這次密碼後，退出這個用戶
        return redirect('/login');
    }
}
