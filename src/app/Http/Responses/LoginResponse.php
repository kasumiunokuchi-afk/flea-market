<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        if ($user && $user->first_login) {
            $user->update(['first_login' => false]);

            return redirect()->route('mypage.profile');
        }

        return redirect()->intended('/');
    }
}
