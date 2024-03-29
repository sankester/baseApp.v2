<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 14/02/2018
 * Time: 14:32
 */

namespace App\Http\Controllers\Manage;


use App\Http\Controllers\Base\BaseAdminController;
use App\Http\Requests\Manage\UserRequest;
use App\Libs\LogLib\LogRepository;
use App\Repositories\Manage\PortalRepositories;
use App\Repositories\Manage\RoleRepositories;
use App\Repositories\Manage\UserRepositories;
use Illuminate\Http\Request;

class UserController extends BaseAdminController
{
    // repositories
    protected $repositories;

    // constructor
    public function __construct(UserRepositories $repositories, Request $request)
    {
        // parent construct
        parent::__construct($request);
        // set repositories
        $this->repositories = $repositories;
    }

    // get list user
    public function index(RoleRepositories $roleRepositories)
    {
        // set permission
        $this->setPermission('read-user');
        // set template
        $this->setTemplate('manage.user.index');
        // load js
        $this->loadJs('themes/base/assets/vendor_components/sweetalert/sweetalert.min.js');
        $this->loadJs('themes/base/assets/vendor_components/select2/dist/js/select2.full.min.js');
        $this->loadJs('js/base/manage/user/index.js');
        //set page title
        $this->page->setTitle('Manajemen User');
        // get search data
        $search = $this->request->session()->get('search_base_user');
        $roleID = (isset($search['role_id'])) ? $search['role_id'] : '%';
        $status = (isset($search['status'])) ? $search['status'] : '%';
        $namaLengkap = (isset($search['nama_lengkap'])) ? '%'.$search['nama_lengkap'].'%' : '%';
        // get data
        $listRole = $roleRepositories->getAllSelect();
        $listUser = $this->repositories->getListPaginate(10,$status, $namaLengkap,$roleID);
        // assign data
        $this->assign('listUser', $listUser);
        $this->assign('listRole', [''=>'Pilih Role'] + $listRole);
        $this->assign('search', $search);
        // display
        return $this->displayPage();
    }

    // proses cari
    public function search(Request $request)
    {
        // set permission
        $this->setPermission('read-user');
        // cek input dengan nama search
        if($request->has('search')){
            // validate input
            if($request->get('search') == 'cari'){
                // set data
                $data = [
                    'nama_lengkap' => $request->nama_lengkap,
                    'status' => $request->status,
                    'role_id' => $request->role_id,
                ];
                // set session cari
                $request->session()->put('search_base_user', $data);
            }
        }else{
            // remove session cari
            $request->session()->remove('search_base_user');
        }
        // default redirect
        return redirect()->route('manage.user.index');
    }

    // show add form
    public function create(PortalRepositories $portalRepositories)
    {
        // set permission
        $this->setPermission('create-user');
        // set page template
        $this->setTemplate('manage.user.add');
        // load js
        $this->loadJs('themes/base/assets/vendor_components/jquery-validation-1.17.0/dist/jquery.validate.js');
        $this->loadJs('themes/base/assets/vendor_components/jquery-steps-master/build/jquery.steps.js');
        $this->loadJs('themes/base/assets/vendor_plugins/iCheck/icheck.min.js');
        $this->loadJs('themes/base/assets/vendor_plugins/input-mask/jquery.inputmask.js');
        $this->loadJs('themes/base/assets/vendor_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');
        $this->loadJs('themes/base/assets/vendor_plugins/input-mask/jquery.inputmask.date.extensions.js');
        $this->loadJs('themes/general/jQuery-Autocomplete-master/dist/jquery.autocomplete.min.js');
        $this->loadJs('themes/general/uniform/uniform.min.js');
        $this->loadJs('js/base/manage/user/crud.js');
        //set page title
        $this->page->setTitle('Tambah User');
        // get data
        $listRole = $portalRepositories->getPortalWithRole();
        $listJabatan = $this->repositories->getJabatanExist();
        $jabatanOutput  = '';
        foreach ($listJabatan as $jabatan) {
            $jabatanOutput .= '"'.$jabatan['jabatan'].'",';
        }
        // assign
        $this->assign('listRole', $listRole);
        $this->assign('jabatan', $jabatanOutput);
        // load view
        return $this->displayPage();
    }

    // proses insert
    public function store(UserRequest $request)
    {
        // set permission
        $this->setPermission('create-user');
        // proses tambah user ke database
        if($this->repositories->create($request)){
            // save log
            LogRepository::addLog('insert', 'Menambahakan user ', $request->nama_lengkap);
            // set succes notification
            $this->setNotification('Berhasil menambah user')->success();
        }else{
            // set error message
            $this->setNotification('Gagal menambah user')->danger();
        }
        // redirect page
        return redirect()->route('manage.user.create');
    }

    // show add form
    public function edit(PortalRepositories $portalRepositories, $userID, Request $request)
    {
        // set permission
        $this->setPermission('update-user');
        // cek data
        if(! $this->repositories->isExist($userID)){
            // set notification
            $this->setNotification('Data user tidak ditemukan')->danger();
            // redirect
            return redirect()->route('manage.base.user');
        }
        // cek role prioritas
        if($this->repositories->cekRolePrioritas($userID) == false){
            // set error page
            $this->setErrorAccess('base/forbidden/page/',$this->request, 'maaf, anda tidak mempunyai akses role yang lebih tinggi.','403');
            // load view
            return $this->displayPage();
        }
        // set page template
        $this->setTemplate('manage.user.edit');
        // load js
        $this->loadJs('themes/base/assets/vendor_components/jquery-validation-1.17.0/dist/jquery.validate.js');
        $this->loadJs('themes/base/assets/vendor_components/jquery-steps-master/build/jquery.steps.js');
        $this->loadJs('themes/base/assets/vendor_plugins/iCheck/icheck.min.js');
        $this->loadJs('themes/base/assets/vendor_plugins/input-mask/jquery.inputmask.js');
        $this->loadJs('themes/base/assets/vendor_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');
        $this->loadJs('themes/base/assets/vendor_plugins/input-mask/jquery.inputmask.date.extensions.js');
        $this->loadJs('themes/general/jQuery-Autocomplete-master/dist/jquery.autocomplete.min.js');
        $this->loadJs('themes/general/uniform/uniform.min.js');
        $this->loadJs('js/base/manage/user/crud.js');
        //set page title
        $this->page->setTitle('Edit User');
        // get data
        $user = $this->repositories->getByID($userID);
        $listRole = $portalRepositories->getPortalWithRole();
        $listJabatan = $this->repositories->getJabatanExist();
        $jabatanOutput  = '';
        foreach ($listJabatan as $jabatan) {
            $jabatanOutput .= '"'.$jabatan['jabatan'].'",';
        }
        // assign
        $this->assign('user', $user);
        $this->assign('listRole', $listRole);
        $this->assign('jabatan', $jabatanOutput);
        // load view
        return $this->displayPage();
    }

    // proses update user
    public function update(UserRequest $request, $userID)
    {
        // set permission
        $this->setPermission('update-user');
        // cek data
        if(! $this->repositories->isExist($userID)){
            // set notification
            $this->setNotification('Data user tidak ditemukan')->danger();
            // redirect
            return redirect()->route('manage.user.index');
        }
        // proses tambah user ke database
        if($this->repositories->update($request, $userID)){
            // save log
            LogRepository::addLog('update', 'Merubah data user.'.$request->nama_lengkap);
            // set success notification
            $this->setNotification('Berhasil mengubah data user')->success();
        }else{
            // set error notification
            $this->setNotification('Gagal mengubah data user.')->danger();
        }
        // redirect page
        return redirect()->route('manage.user.edit', $userID);
    }

    // ambil detail user
    public function show(Request $request, PortalRepositories $portalRepositories, $userID)
    {
        // cek apakah ajax request
        if ($request->ajax()) {
            // set permission
            $access =  $this->setPermission('read-user');
            if($access['access'] == 'failed'){
                return response(['message' => $access['message'], 'status' => 'failed']);
            }
            // get data
            $user = $this->repositories->getByID($userID);
            if(! $user){
                // default response
                return response(['message' => 'Gagal mengambil data user', 'status' => 'failed']);
            }
            $listRole = $portalRepositories->getPortalWithRole();
            $foto = (empty($user->userData->foto)) ? asset("themes/base/images/card/img1.jpg") : asset("images/avatar/thumbnail/".$user->userData->foto);
            // set html view
            $title = 'Detail user '.$user->userData->nama_lengkap;
            $stringHtml  = '<ul class="nav nav-tabs customtab" role="tablist">';
            $stringHtml .= '<li class="nav-item"><a href="#navpills-1" class="nav-link active" data-toggle="tab" aria-expanded="false">User Data</a></li>';
            $stringHtml .= '<li class="nav-item"><a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false">User Login</a></li>';
            $stringHtml .= '<li class="nav-item"><a href="#navpills-3" class="nav-link" data-toggle="tab" aria-expanded="true">Role</a></li>';
            $stringHtml .= '</ul>';
            $stringHtml .= '<div class="tab-content mt-10">';
            $stringHtml .= '<div id="navpills-1" class="tab-pane active pl-20" aria-expanded="false"><div class="row" ><div class="col-md-9">';
            $stringHtml .= '<div class="form-group row"><label class="col-md-3 control-label">Nama</label><div class="col-sm-9">';
            $stringHtml .= ': <label class="control-label">'.$user->userData->nama_lengkap.'</label></div></div>';
            $stringHtml .= '<div class="form-group row"><label class="col-md-3 control-label">Tempat Lahir</label><div class="col-sm-9">';
            $stringHtml .= ': <label class="control-label">'.$user->userData->tempat_lahir.'</label></div></div>';
            $stringHtml .= '<div class="form-group row"><label class="col-md-3 control-label">Tanggal Lahir</label><div class="col-sm-9">';
            $stringHtml .= ': <label class="control-label">'.$user->userData->tanggal_lahir.'</label></div></div>';
            $stringHtml .= '<div class="form-group row"> <label class="col-md-3 control-label">No Telp.</label><div class="col-sm-9">';
            $stringHtml .= ': <label class="control-label">'.$user->userData->no_telp.'</label></div></div>';
            $stringHtml .= '<div class="form-group row"><label class="col-md-3 control-label">Jabatan</label><div class="col-sm-9">';
            $stringHtml .= ': <label class="control-label">'.$user->userData->jabatan.'</label></div></div>';
            $stringHtml .= '<div class="form-group row"><label class="col-md-3 control-label">Alamat</label><div class="col-sm-9">';
            $stringHtml .= '<p>: '.$user->userData->alamat.'</p></div></div></div>';
            $stringHtml .= '<div class="col-md-3"> <img src="'. $foto .'" class="avatar avatar-xxl">';
            $stringHtml .= '</div></div></div>';
            $stringHtml .= '<div id="navpills-2" class="tab-pane pl-20" aria-expanded="false"> <div class="row"><div class="col-md-9">';
            $stringHtml .= '<div class="form-group row"><label class="col-md-3 control-label">Username</label><div class="col-sm-9">';
            $stringHtml .= ': <label class="control-label">'. $user->username.'</label></div></div>';
            $stringHtml .= '<div class="form-group row"><label class="col-md-3 control-label">Email</label><div class="col-sm-9">';
            $stringHtml .= ': <label class="control-label">'.$user->email.'</label></div></div>';
            $stringHtml .= '<div class="form-group row"><label class="col-md-3 control-label">Status</label><div class="col-sm-9">';
            $stringHtml .= ': <label class="control-label">'.$user->status.'</label></div></div></div></div></div>';
            $stringHtml .= '<div id="navpills-3" class="tab-pane pl-20" aria-expanded="true"><div class="row">';
            foreach ($listRole as $portal) {
                if(! $portal->role->isEmpty()){
                    $stringHtml .= '<div class="col-lg-4 col-md-4 col-sm-3 col-xs-12"><div class="ribbon-wrapper">';
                    $stringHtml .= '<div class="ribbon ribbon-bookmark bg-success">'.$portal->portal_nm.'</div><div class="ribbon-content"><ul>';
                    foreach ($portal->role as $roleAvailible){
                        foreach ($user->role as $item) {
                            if($roleAvailible->id == $item->id){
                                $stringHtml .= '<li>'.$item->role_nm.'</li>';
                            }
                        }
                    }
                    $stringHtml .= '</ul></div></div></div>';
                }
            }
            $stringHtml .= '</div></div>';
            // set output
            $outputUser = [
                'title' => $title,
                'html'  => $stringHtml
            ];
            // set response
            return response(['data' => $outputUser, 'status' => 'success']);
        }
        // default response
        return response(['message' => 'Gagal mengambil data user', 'status' => 'failed']);
    }

    // proses delete user
    public function destroy(Request $request, $userID)
    {
        // cek apakah ajax request
        if ($request->ajax()){
            // set permission
            $access =    $this->setPermission('delete-user');
            if($access['access'] == 'failed'){
                return response(['message' => $access['message'], 'status' => 'failed']);
            }
            // cek data
            if(! $this->repositories->isExist($userID)){
                // set response
                return response()->json(['message' => 'Data user tidak ditemukan', 'status' => 'failed']);
            }
            // cek role prioritas
            if($this->repositories->cekRolePrioritas($userID) == false){
                // return error
                return response(['message' => 'maaf, anda tidak mempunyai akses role yang lebih tinggi.', 'status' => 'failed']);
            }
            // get user nama
            $user = $this->repositories->getByID($userID)->with('userData');
            // proses hapus user dari database
            if($this->repositories->delete($userID)){
                // save log
                LogRepository::addLog('delete', 'Menghapus user '.$user->userData->nama_lengkap);
                // set response
                return response(['message' => 'Berhasil menghapus user.', 'status' => 'success']);
            }
        }
        // default response
        return response(['message' => 'Gagal menghapus user', 'status' => 'failed']);
    }

}