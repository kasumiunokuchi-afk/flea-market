<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'first_login' => true,
        ]);

        event(new Registered($user));

        auth()->login($user);

        return redirect()->route('mypage.profile');
    }
}
