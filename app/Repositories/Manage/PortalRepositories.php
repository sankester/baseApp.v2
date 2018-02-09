<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 20/08/2017
 * Time: 00:38
 */

namespace App\Repositories\Manage;


use App\Libs\LogLib\LogRepository;
use App\Model\Portal;
use Illuminate\Support\Facades\Auth;

/**
 * Class Portals
 * @package App\Repositories\BaseApp
 */
class PortalRepositories
{
    /**
     * Mngambil data portal limit
     * @param $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getListPaginate($limit)
    {
        return Portal::paginate($limit);
    }

    /**
     * Mengambil semua portal
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return Portal::all();
    }

    /**
     * @return int
     */
    public function getCountPortal()
    {
        return Portal::all()->count();
    }
    /**
     * Mengambil data portal untuk select
     * @return \Illuminate\Support\Collection
     */
    public function getAllSelect()
    {
        return Portal::pluck('portal_nm','id');
    }

    public static function getById($portal_id)
    {
        return Portal::findOrFail($portal_id);
    }

    /**
     * Proses menyimpan data portal ke database
     * @param $params
     * @return mixed
     */
    public function createPortal($params)
    {
        LogRepository::addLog('insert', 'Tambah portal dengan data',null,$params );
        return Auth::user()->portals()->create($params);
    }

    /**
     * Proses mengupdate data portal di database
     * @param $params
     * @param Portal $portal
     * @return bool
     * @internal param $id
     */
    public function updatePortal($params, Portal $portal){
        LogRepository::addLog('update', 'Update portal dengan data',$portal,$params );
        return $portal->update($params);
    }

    /**
     * Proses menghapus data portal dari database
     * @param Portal $portal
     * @return bool|null
     * @throws \Exception
     * @internal param $id
     */
    public function deletePortal(Portal $portal)
    {
        LogRepository::addLog('delete','Hapus portal dengan nama portal : '.$portal->portal_nm);
        return  $portalDelete = $portal->delete();
    }
}