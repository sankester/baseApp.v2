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
        // proses tambah user ke database
        if($this->repositories->create($request)){
            $request->session()->flash('notification', ['status' => 'success' , 'message' => 'Berhasil tambah user.']);
        }else{
            $request->session()->flash('notification', ['status' => 'error' , 'message' => 'Gagal tambah user.']);
        }
        // redirect page
        return redirect()->route('manage.user.create');
    }

    // show add form
    public function edit(PortalRepositories $portalRepositories, $userID)
    {
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

    public function update(UserRequest $request, $userID)
    {
        // proses tambah user ke database
        if($this->repositories->update($request, $userID)){
            $request->session()->flash('notification', ['status' => 'success' , 'message' => 'Berhasil ubah user.']);
        }else{
            $request->session()->flash('notification', ['status' => 'error' , 'message' => 'Gagal ubah user.']);
        }
        // redirect page
        return redirect()->route('manage.user.edit', $userID);
    }

    public function show(Request $request, PortalRepositories $portalRepositories, $userID)
    {
        // cek apakah ajax request
        if ($request->ajax()) {
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
            $stringHtml  = '<ul class="nav nav-pills margin-bottom margin-top-10">';
            $stringHtml .= '<li class="nav-item"><a href="#navpills-1" class="nav-link active" data-toggle="tab" aria-expanded="false">User Data</a></li>';
            $stringHtml .= '<li class="nav-item"><a href="#navpills-2" class="nav-link" data-toggle="tab" aria-expanded="false">User Login</a></li>';
            $stringHtml .= '<li class="nav-item"><a href="#navpills-3" class="nav-link" data-toggle="tab" aria-expanded="true">Role</a></li>';
            $stringHtml .= '</ul>';
            $stringHtml .= '<div class="tab-content">';
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
            // proses hapus user dari database
            if($this->repositories->delete($userID)){
                // set response
                return response(['message' => 'Berhasil menghapus user.', 'status' => 'success']);
            }
        }
        // default response
        return response(['message' => 'Gagal menghapus user', 'status' => 'failed']);
    }

}