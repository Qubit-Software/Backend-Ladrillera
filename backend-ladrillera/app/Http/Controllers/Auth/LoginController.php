<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:api')->except('logout');
    }



    public function login(Request $request)
    {
        $this->validateLogin($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        $credentials = ['email' => $request->email, 'contraseña' => $request->password];
        $usuario = Usuario::where('email', $credentials['email'])->first();

        if (!is_null($usuario) && Hash::check($credentials['contraseña'], $usuario->contraseña)) {
            $usuario->generateToken();

            return response()->json([
                'data' => $usuario->toArray(),
            ]);
        }

        return $this->sendFailedLoginResponse($request);
    }


    public function logout(Request $request)
    {
        $user = Auth::guard('api')->user();

        if ($user) {
            $user->api_token = null;
            $user->save();
        }

        return response()->json(['data' => 'User logged out.'], 200);
    }
}
