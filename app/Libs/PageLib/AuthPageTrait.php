<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 18/02/2018
 * Time: 16:02
 */

namespace App\Libs\PageLib;

use Illuminate\Http\Request;

trait AuthPageTrait
{
    protected $request ;

    protected $menuActive;

    protected $isAccess = true;

    protected $roleActive ;

    protected $errorCode = '404';

    protected $errorMenu = '';

    protected $errorUrl  = 'base/forbidden/page/';

    protected $errorMessage = 'Anda tidak mempunyai akses penuh ke halaman ini.';

    protected $rolePermission;

    /*
     * Get role active
     * Keterangan : ambil role aktif yang sudah di set di session
     */
    protected function getRoleActive(){
        $this->roleActive = session()->get('role_active')->load('permission');
    }

    /*
     * Validate page
     * Keterangan : cek apakan menu ini mempunyai permission / tidak
     */
    protected function validatePage($menuID){
        // get role active
        $this->getRoleActive();
        // get role permisison
        $this->rolePermission = $this->roleActive->permission()->whereHas('menu', function ($query) use ($menuID){
            $query->where('menu_id', $menuID);
        })->get();
        // cek role permission
        if($this->rolePermission->isEmpty()){
            return false;
        }
        // default return
        return true;
    }

    /*
     * validate access
     */
    protected function validateAccess($rule){
        // proses validate
        if(! $this->rolePermission->contains('permission_slug', $rule)){
           return false;
        }
        // default
        return true;
    }

    /*
     * Set Error Access
     */
    protected function setErrorAccess($default_error_url , Request $request, $message, $code , $menuID = null){
        if ($request->ajax()) {
            return [
                'access' => 'failed',
                'message' => $message
            ];
        } else {
            $this->setForbiddenAccess($default_error_url, $code, $menuID, $message);
        }
    }

    /*
     * set forbidden data
     */
    public function setForbiddenAccess($url,$code, $menuID, $message)
    {
        $this->isAccess = false;
        $this->errorCode = $code;
        $this->errorUrl = $url;
        $this->errorMenu = $menuID;
        $this->errorMessage = $message;
    }

}