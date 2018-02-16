<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

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
    protected $redirectTo = '/base/manage/home';


    /**
     * Set login field
     * @return string
     */
    protected function username(){
        return 'username';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * show form login
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.base.login');
    }


    /**
     * Jika terdaftar
     * @param Request $request
     * @param $user
     * @throws ValidationException
     */
    protected function authenticated(Request $request, $user)
    {
        // get list role user
        $listRole = $user->role()->get();
        // cek role apakah bisa mengakses portal
        $roleAccess = $this->cek_portal($listRole);
        // cek role akses
        if($roleAccess != false){
            // set seesion
            $request->session()->put('role_active', $roleAccess);
            // jika ada
            $this->redirectTo = $roleAccess->default_page;
        }else{
            // default action
            $this->guard()->logout();
            $request->session()->invalidate();
            $this->redirectTo = '/login';
            // set error
            throw ValidationException::withMessages([
                $this->username() => 'User tidak ditemukan',
            ]);
        }
    }

    // cek apakah role mempunyai akses portal
    private function cek_portal($listRole){
        // cek parameter
        if($listRole){
            // loop cek role
            foreach ($listRole as $role){
                // jika ada return true
                if($role->portal_id == $this->getPortal()){
                    return $role;
                    break;
                }
            }
        }
        // default return
        return false;
    }

    // get portal
    protected function getPortal(){
        return env('BASE_PORTAL');
    }

    // logout function
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/');
    }
}
