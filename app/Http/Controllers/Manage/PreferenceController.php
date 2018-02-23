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
            $this->setNotification('Berhasil menambah preference.')->success();
        }else{
            // set error nitification
            $this->setNotification('Gagal menambah preference')->danger();
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
        // cek data
        if(! $this->repositories->isExist($preferenceID)){
            // set notification
            $this->setNotification('Preference tidak ditemukan');
            // response
            return response()->route('manage.preference.index');
        }
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
        // cek data
        if(! $this->repositories->isExist($preferenceID)){
            // set notification
            $this->setNotification('Preference tidak ditemukan')->danger();
            // redirect
            return redirect()->route('manage.preference.index');
        }
        // proses update data preference di database
        if($this->repositories->update($request, $preferenceID)){
            // save log
            LogRepository::addLog('update', 'Merubah data preference '.$request->pref_name);
            // set notifikasi success
            $this->setNotification('Berhasil mengubah data preference')->success();
        }else{
            // set notifikasi error
            $this->setNotification("Gagal mengubah data preference")->danger();
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
            // cek data
            if(! $this->repositories->isExist($preferenceID)){
                return response()->json(['message' => 'Preference tidak ditemukan', 'status'=> 'failed']);
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
