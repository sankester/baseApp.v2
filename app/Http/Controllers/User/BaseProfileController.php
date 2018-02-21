<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 19/02/2018
 * Time: 13:47
 */

namespace App\Http\Controllers\User;


use App\Http\Controllers\Base\BaseAdminController;
use App\Http\Requests\Manage\UserRequest;
use App\Libs\LogLib\LogRepository;
use App\Repositories\Manage\MenuRepositories;
use App\Repositories\Manage\UserRepositories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BaseProfileController extends BaseAdminController
{
    // constructor
    public function __construct(Request $request)
    {
        // parent constructor
        parent::__construct($request);
    }

    // menampilkan profil user
    public function show(UserRepositories $userRepositories)
    {
        // set permission
        $this->setPermission('read-profile');
        // set template
        $this->setTemplate('user/base/profile');
        // load js
        $this->loadJs('themes/base/assets/vendor_components/jquery-validation-1.17.0/dist/jquery.validate.js');
        $this->loadJs('themes/base/assets/vendor_components/sweetalert/sweetalert.min.js');
        $this->loadJs('themes/base/assets/vendor_plugins/input-mask/jquery.inputmask.js');
        $this->loadJs('themes/base/assets/vendor_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js');
        $this->loadJs('themes/base/assets/vendor_plugins/input-mask/jquery.inputmask.date.extensions.js');
        $this->loadJs('themes/general/jQuery-Autocomplete-master/dist/jquery.autocomplete.min.js');
        $this->loadJs('themes/general/uniform/uniform.min.js');
        $this->loadJs('js/base/user/profile.js');
        // get data
        $profile = Auth::user()->load('userData', 'role');
        $listJabatan = $userRepositories->getJabatanExist();
        $jabatanOutput  = '';
        foreach ($listJabatan as $jabatan) {
            $jabatanOutput .= '"'.$jabatan['jabatan'].'",';
        }
        $logPortal  = collect();
        $logUser = collect();
        // cek permission read log
        if($this->validateAccess('read-log')){
            $logPortal  = LogRepository::getLogPortal(1, 10);
            $logUser    =  LogRepository::getLogUser($profile->id, 10);
        }
        // set active
        // assign data
        $this->assign('user', $profile);
        $this->assign('logPortal', $logPortal);
        $this->assign('logUser', $logUser);
        $this->assign('jabatan', $jabatanOutput);
        // display page
        return $this->displayPage();
    }

    // switch role portal
    public function switchRole(Request $request,MenuRepositories $menuRepositories, $roleID)
    {
        // get list role
        $listRole = $request->session()->get('role_user');
        if($listRole->contains('id', $roleID)){
            // get role
            $filtered = $listRole->filter(function ($value, $key) use ($roleID) {
                return $value->id == $roleID;
            })->first();
            // set session role active
            $request->session()->put('role_active', $filtered);
            // set session menu
            $request->session()->put('list_menu', $menuRepositories->generateMenu(0));
        }
        // redirec
        return redirect($filtered->default_page);
    }
    // get log portal ajax
    public function logPortal(Request $request)
    {
        // cek apakah ajax request
        if ($request->ajax()){
            // cek rule
            $access = $this->setPermission('read-log');
            if($access['access'] == 'failed'){
                return response(['message' => $access['message'], 'status' => 'failed']);
            }
            // declare variable
            $htmlData = '';
            // get data
            $data = LogRepository::getLogPortal(1 , 10);
            // set locale
            setlocale(LC_TIME, 'id');
            // set date label
            $dateLabel = $request->default_date;
            // default response
            foreach ($data as $log) {
                // set data
                switch (strtolower(strtok($log->action, " "))){
                    case 'insert' :
                        $label = 'success';
                        $icon  = 'plus';
                        break;
                    case 'update' :
                        $label = 'info';
                        $icon  = 'pencil';
                        break;
                    case 'delete' :
                        $label = 'danger';
                        $icon  = 'trash';
                        break;
                    default :
                        $label = 'primary';
                        $icon  = 'info';
                        break;
                }
                if($dateLabel != $log->created_at->format('d M, Y') ){
                    $dateLabel = $log->created_at->format('d M, Y');
                    $htmlData .= '<li class="time-label"><span class="bg-timeline">'.$log->created_at->format('d M, Y').'</span></li>';
                }
                $htmlData .= '<li class="timeline-portal"><i class="fa fa-'.$icon.' bg-'.$label.' text-white "></i>';
                $htmlData .= '<div class="timeline-item">';
                $htmlData .= '<span class="time"><i class="fa fa-clock-o"></i>'.$log->created_at->format('h:i A').'</span>';
                $htmlData .= '<h3 class="timeline-header"><a href="#">'.$log->user->userData->nama_lengkap.'</a> ('. $log->action .')</h3>';
                $htmlData .= '<div class="timeline-body">'.$log->description.'</div></div></li>';
            }
            if(is_null($data->nextPageUrl())){
                return response(['logs' => $htmlData,'end' => true]);
            }else{
                return response(['logs' => $htmlData,'end' => false]);
            }
        }
        // default response
        return response(['message' => 'Gagal mengambil data', 'status' => 'failed']);
    }

    // get log user ajax
    public function logUser(Request $request)
    {
        // cek apakah ajax request
        if ($request->ajax()){
            // cek rule
            $access = $this->setPermission('read-log');
            if($access['access'] == 'failed'){
                return response(['message' => $access['message'], 'status' => 'failed']);
            }
            // declare variable
            $htmlData = '';
            // get data
            $data = LogRepository::getLogUser(Auth::user()->id , 10);
            // set locale
            setlocale(LC_TIME, 'id');
            // default response
            foreach ($data as $log) {
                $htmlData .= '<div class="post user-activity">';
                $htmlData .= '<div class="user-block">';
                $foto   = (!empty($log->user->userData->foto)) ?  asset('images/avatar/thumbnail/'.$log->user->userData->foto) : asset('themes/base/images/avatar/1.jpg');
                $htmlData .= '<img class="img-bordered-sm rounded-circle" src="'.$foto.'" alt="user image">';
                $htmlData .= '<span class="username"><a href="#">'.$log->user->userData->nama_lengkap.'</a></span><span class="description">'.$log->created_at->diffForHumans().'</span>';
                $htmlData .= '</div><div class="activitytimeline"><p>'.$log->description.'</p></div></div>';
            }
            if(is_null($data->nextPageUrl())){
                return response(['logs' => $htmlData,'end' => true]);
            }else{
                return response(['logs' => $htmlData,'end' => false]);
            }
        }
        // default response
        return response(['message' => 'Gagal mengambil data', 'status' => 'failed']);
    }

    public function updateData(UserRequest $request, UserRepositories $userRepositories)
    {
        // set permission
        $this->setPermission('update-profile');
        // proses tambah user ke database
        if($userRepositories->update($request, Auth::user()->id)){
            // save log
            LogRepository::addLog('update', 'Merubah data user '.$request->nama_lengkap);
            // set success notification
            $request->session()->flash('notification', ['status' => 'success' , 'message' => 'Berhasil ubah user.']);
        }else{
            // set error notification
            $request->session()->flash('notification', ['status' => 'error' , 'message' => 'Gagal ubah user.']);
        }
        // set active
        $active = 'setting';
        // redirect page
        return redirect()->back()->with('active');
    }

}