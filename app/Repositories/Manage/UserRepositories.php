<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 15/08/2017
 * Time: 13:28
 */

namespace App\Repositories\Manage;

use App\Model\Manage\UserData;
use App\Repositories\Base\BaseRepositories;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepositories extends BaseRepositories
{
    // set model
    protected $model = 'Manage\\UserLogin';

    // get jabatan exist
    public function getJabatanExist()
    {
        return UserData::select('jabatan')->groupBy('jabatan')->get();
    }

    // get count user
    public function getCountUser()
    {
        return $this->getModel()->whereHas('role', function ($query){
            $query ->where('role_prioritas' ,'>=', session()->get('role_active')->role_prioritas);;
        })->count();
    }

    // cek role prioritas
    public function cekRolePrioritas($userID)
    {
        // get role id
        $role = $this->getByID($userID)->role;
        $roleCek = $role->first()->id;
        // cek session
        if(session()->get('role_active')->role_prioritas < $roleCek || session()->get('role_active')->role_prioritas <= '2'){
            // set return
            return true;
        }
        // default return
        return false;
    }

    // get list
    public function getListPaginate($perPage = 10, ...$params)
    {
        return $this->getModel()->where('id','!=', $this->getAuth()->id)
                ->where('status','like', $params[0])
                ->whereHas('userData', function ($query) use ($params){
                    $query->where('nama_lengkap','like' , $params[1]);
                })
                ->whereHas('role', function ($query) use ($params){
                    if( session()->get('role_active')->role_prioritas != 1){
                        $query->where('id','like' ,$params[2])
                            ->where('role_prioritas' ,'>', session()->get('role_active')->role_prioritas);
                    }else{
                        $query->where('id','like' ,$params[2]);
                    }
                })
                ->with('userData','role')->paginate($perPage);
    }

    // get by id
    public function getByID($id, $column = 'id')
    {
       return $this->getModel()->with('userData','role')->findOrFail($id);
    }

    // create
    public function create(Request $request)
    {
        // set prameter login
        $params  =  $request->only(['username','email']);
        $params['password'] = Hash::make($request->password);
        $params['status'] = 'aktif';
        // create user login
        $user = $this->getModel()->create($params);
        if($user){
            // set params data
            $params     = $request->all();
            $params['tanggal_lahir'] = Carbon::parse($request->tanggal_lahir);
            // cek file
            if($request->hasFile('foto')){
                /** start upload image */
                // get image
                $image = $request->file('foto');
                // set image name
                $imageName = time() . '-'. $image->getClientOriginalName();
                // set config
                $config = [
                    'name'      => $imageName,
                    'path'      => 'images/avatar',
                    'thumbnail' => 'images/avatar/thumbnail',
                    'resize'    => true
                ];
                // Upload image
                if($this->uploadImage($image, $config)){
                    $params['foto'] = $imageName;
                }
                /** end upload image */
            }
            // create user data
            $user->userData()->create($params);
            // syncrone role
            if($request->has('role_id')){
                $user->role()->sync($request->role_id);
            }
            // return
            return true;
        }else{
            return false;
        }
    }

    // update
    public function update(Request $request , $userID)
    {
        // set parameter login
        $params  =  $request->only(['username','email','status']);
        if(!is_null( $request->password)){
            $params['password'] = Hash::make($request->password);
        }else{
            $params['password'] = $this->getAuth()->getAuthPassword();
        }
        // get user
        $user = parent::getByID($userID);
        // proses update
        if($user->update($params)){
            // set params data
            $params     = $request->only(['nama_lengkap','tempat_lahir','tanggal_lahir','no_telp','jabatan','alamat']);
            $params['tanggal_lahir'] = Carbon::parse($request->tanggal_lahir);
            // cek file
            if($request->hasFile('foto')){
                /** start upload image */
                // get image
                $image = $request->file('foto');
                // set image name
                $imageName = time() . '-'. $image->getClientOriginalName();
                // set config
                $config = [
                    'name'      => $imageName,
                    'path'      => 'images/avatar',
                    'thumbnail' => 'images/avatar/thumbnail',
                    'resize'    => true
                ];
                // Upload image
                if($this->uploadImage($image, $config)){
                    $params['foto'] = $imageName;
                    $oldFoto = $user->userData->foto;
                }
                /** end upload image */
            }
            if($user->userData()->update($params)){
                // delete file foto
                if(! empty($oldFoto)){
                    $imagePath = 'images/avatar/';
                    $thumbnailPath = 'images/avatar/thumbnail/';
                    $this->deleteFile($imagePath, $oldFoto );
                    $this->deleteFile($thumbnailPath, $oldFoto );
                }
            }else {
                // delete file foto
                if($request->hasFile('foto')){
                    $imagePath = 'images/avatar/';
                    $thumbnailPath = 'images/avatar/thumbnail/';
                    $this->deleteFile($imagePath,  $params['foto'] );
                    $this->deleteFile($thumbnailPath,  $params['foto'] );
                }
                // return status
                return false;
            }
            // syncrone role
            if($request->has('role_id')){
                $user->role()->sync($request->role_id);
            }
            // return status
            return true;
        }else{
            return false;
        }
    }

    // proses delete
    public function delete($userID)
    {
        // get portal
        $user = parent::getByID($userID);
        // run delete
        if($user->delete()){
            // set path
            $imagePath = 'images/avatar/';
            $thumbnailPath = 'images/avatar/thumbnail/';
            // delete foto
            if(! empty($user->foto)){
                $this->deleteFile($imagePath, $user->foto );
                $this->deleteFile($thumbnailPath, $user->foto );
            }
            // return true
            return true;
        }
        // default return
        return false;
    }
}