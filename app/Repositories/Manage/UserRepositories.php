<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 15/08/2017
 * Time: 13:28
 */

namespace App\Repositories\Manage;

use App\Libs\LogLib\LogRepository;
use Carbon\Carbon;
use App\Model\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Class Users
 * @package App\Repositories\BaseApp
 */
class UserRepositories
{
    /**
     * Mengambil list user limit
     * @param $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getListPaginate($limit)
    {
        return User::paginate($limit);
    }

    /**
     * Get Count User
     * @return int
     */
    public function getCountUser()
    {
       return User::all()->count();
    }

    /**
     * Get COunt User by Portal
     * @param $portal_id
     * @return mixed
     */
    public function getCountUserByPortal($portal_id)
    {
        $countUser = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->join('portals', 'roles.portal_id', '=', 'portals.id')
            ->where('portals.id', '=', $portal_id)
            ->count();
        return $countUser;
    }

    /**
     * Get Data UserLogin
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getDataLogin()
    {
        return Auth::user();
    }

    /**
     * Inser user baru
     * @param $params
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public function createUser($params)
    {

        $params['password'] = Hash::make($params['password']);
        $params['lock_st'] = 0;
        $params['registerDate'] = Carbon::now();
        LogRepository::addLog('insert', 'Tambah user dengan data',null, $params , ['password', 'password_confirm','images']);
        return User::create($params);
    }

    /**
     * Update user
     * @param $params
     * @param User $user
     * @return bool
     * @internal param $id
     */
    public function updateUser($params, User $user){
        if (isset($params['password'])){
            if(!empty( $params['password']) || !is_null($params['password'])){
                $params['password'] = Hash::make($params['password']);
            }
            if(is_null($params['password'])){
                unset($params['password']);
                unset($params['password_confirm']);
            }
        }
        LogRepository::addLog('update', 'Update user dengan data', $user ,$params, ['password', 'password_confirm','images'] );
        return $user->update($params);
    }

    /**
     * Update data user login
     * @param $params
     * @return mixed
     */
    public function updateUserLogin($params)
    {
        if(!is_null( $params['password'])){
            $params['password'] = Hash::make($params['password']);
        }else{
            $params['password'] = Auth::user()->getAuthPassword();
        }
        LogRepository::addLog('update', 'Update user dengan data', Auth::user(),$params );
        return Auth::user()->update($params);
    }

    /**
     * Hapus user
     * @param User $user
     * @return bool|null
     * @throws \Exception
     * @internal param $id
     */
    public function deleteUser(User $user)
    {
        LogRepository::addLog('delete','Hapus user dengan nama role : '.$user->name);
        return  $userDelete = $user->delete();
    }
}