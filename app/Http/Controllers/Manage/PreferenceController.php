<?php

namespace App\Http\Controllers\Manage;


use App\Http\Controllers\Base\BaseAdminController;
use App\Http\Requests\Manage\PreferenceRequest;
use App\Libs\LogLib\LogRepository;
use App\Repositories\Manage\PortalRepositories;
use App\Repositories\Manage\PreferenceRepositories;
use Illuminate\Http\Request;

class PreferenceController extends BaseAdminController
{
    /**
     * @var PortalRepositories
     */
    private $repositories;

    /**
     * PortalController constructor.
     */
    public function __construct(PreferenceRepositories $repositories,Request $request)
    {
        // load parent construct
        parent::__construct($request);
        // initial preference repositories
        $this->repositories = $repositories;
        $this->request = $request;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // set permission
        $this->setPermission('read-preference');
        // set page template
        $this->setTemplate('manage.preference.index');
        // load js
        $this->loadJs('themes/base/assets/vendor_components/sweetalert/sweetalert.min.js');
        $this->loadJs('js/base/manage/preference/index.js');
        //set page title
        $this->page->setTitle('Manajemen Preference');
        //assign data
        $this->assign('preference', $this->repositories->getListPaginate(10));
        // display page
        return $this->displayPage();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // set permission
        $this->setPermission('create-preference');
        // set page template
        $this->setTemplate('manage.preference.add');
        // load js
        $this->loadJs('themes/base/assets/vendor_components/jquery-validation-1.17.0/dist/jquery.validate.js');
        //set page title
        $this->page->setTitle('Tambah Portal');
        // load view
        return $this->displayPage();
    }


    /**
     * Proses tambah preference ke database
     */
    public function store(PreferenceRequest $request)
    {
        // set permission
        $this->setPermission('create-preference');
        // proses tambah preference ke database
        if($this->repositories->create($request)){
            // save log
            LogRepository::addLog('insert', 'Menambahkan preference dangan nama : '.$request->pref_name);
            // set success notification
            $request->session()->flash('notification', ['status' => 'success' , 'message' => 'Berhasil tambah preference.']);
        }else{
            $request->session()->flash('notification', ['status' => 'error' , 'message' => 'Gagal tambah preference.']);
        }
        // redirect page
        return redirect()->route('manage.preference.create');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($preferenceID)
    {
        // set permission
        $this->setPermission('update-preference');
        // set template
        $this->setTemplate('manage.preference.edit');
        // load js
        $this->loadJs('themes/base/assets/vendor_components/jquery-validation-1.17.0/dist/jquery.validate.js');
        //set page title
        $this->page->setTitle('Edit Preference');
        // assign data
        $this->assign('preference', $this->repositories->getByID($preferenceID));
        // display page
        return  $this->displayPage();
    }

    /**
     * Proses ubah data preference di database
     */
    public function update(PreferenceRequest $request, $preferenceID)
    {
        // set permission
        $this->setPermission('update-preference');
        // proses update data preference di database
        if($this->repositories->update($request, $preferenceID)){
            // save log
            LogRepository::addLog('update', 'Merubah data preference '.$request->pref_name);
            // set notifikasi success
            $request->session()->flash('notification', ['status' => 'success' , 'message' => 'Berhasil ubah preference.']);
        }else{
            // set notifikasi error
            $request->session()->flash('notification', ['status' => 'error' , 'message' => 'Gagal ubah preference.']);
        }
        // redirect page
        return redirect()->route('manage.preference.edit', $preferenceID);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $preferenceID)
    {
        // cek apakah ajax request
        if ($request->ajax()){
            // set permission
            $access =   $this->setPermission('delete-preference');
            if($access['access'] == 'failed'){
                return response(['message' => $access['message'], 'status' => 'failed']);
            }
            // get nama preference
            $prefName = $this->repositories->getByID($preferenceID)->portal_name;
            // proses hapus preference dari database
            if($this->repositories->delete($preferenceID)){
                // save log
                LogRepository::addLog('delete','Menghapus preference'.$prefName);
                // set response
                return response(['message' => 'Berhasil menghapus preference.', 'status' => 'success']);
            }
        }
        // default response
        return response(['message' => 'Gagal menghapus preference', 'status' => 'failed']);
    }
}
