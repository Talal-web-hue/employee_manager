<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Termwind\Components\Raw;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate(
            [
                'first_name'=>'required|string|max:20',
                'last_name'=>'required|string|max:20',
                'email'=>'required|email|string|max:50',
                'password' => 'required|string|min:6|confirmed',
            ]);

        $user = User::create(
            [
             'first_name'=>$request->first_name,
             'last_name'=>$request->last_name,
             'email'=>$request->email,
             'password'=>Hash::make($request->password),
            ]);

        return response()->json(
            [
                'message'=>'تم إنشاء حساب المدير بنجاح' ,
                $user
            ] , 201);
    }



    // تابع تسجيل الدخول داخل الموقع للمدير

    public function login(Request $request)
    {
        $request->validate(
            [
                'email'=>'required|email',
                'password'=>'required|string'
            ]);

            if(!Auth::attempt($request->only('email' , 'password')))
            {
                return response()->json(
                    [
                        'message'=>'البريدالإلكتروني أو كلمة المرور غير صحيحة'
                    ] , 401);
            }

            // جلب إيميل المستخدم
        $user = User::where('email', $request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'تم تسجيل الدخول بنجاح',
            'user'    => $user,
            'token'   => $token,
        ], 200);
    }



    // تابع تسجيل الخروج من الموقع للمدير

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(
            [
                'message'=>'تم تسجيل الخروج بنجاح'
            ], 200);

    }
}