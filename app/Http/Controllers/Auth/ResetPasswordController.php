<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Manage\MenuRepositories;
use App\Repositories\Manage\PortalRepositories;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    // show form
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.base.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    // set rule
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
            'captcha' => 'required|captcha'
        ];
    }

    // set error message
    protected function validationErrorMessages()
    {
        return [
            'required' => ':attribute tidak bloeh kosong.',
            'string' => ':attribute harus text.',
            'captcha' =>  'captcha tidak dikenali',
        ];
    }

    // reset password
    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        $this->guard()->login($user);

        // get list role user
        $listRole = $user->role()->where('portal_id', $this->getPortal())->get();
        // cek role apakah bisa mengakses portal
        $roleAccess = $this->cek_portal($listRole);
        // cek role akses
        if($roleAccess != false){
            // set session
            session()->put('role_active', $roleAccess);
            // set session role user
            session()->put('role_user', $listRole);
            // set session portal
            $portalRepositories = new PortalRepositories();
            session()->put('portal_active', $portalRepositories->getByID($roleAccess->portal_id));
            // set menu
            $menuRepositories = new MenuRepositories();
            session()->put('list_menu', $menuRepositories->generateMenu(0));
            // jika ada
            $this->redirectTo = $roleAccess->default_page;
        }else{
            // default action
            $this->guard()->logout();
            session()->invalidate();
            $this->redirectTo = '/login';
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

}
