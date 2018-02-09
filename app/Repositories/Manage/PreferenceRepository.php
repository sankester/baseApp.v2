<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 08/09/2017
 * Time: 10:35
 */

namespace App\Repositories\Manage;


use App\Libs\LogLib\LogRepository;
use App\Model\Preference;
use Illuminate\Support\Facades\Auth;

class PreferenceRepository
{
    /**
     * Mngambil data preference limit
     * @param $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getListPaginate($limit)
    {
        return Preference::paginate($limit);
    }

    /**
     * Mengambil semua preference
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return Preference::all();
    }

    public function getByGroupAndName($group,$name)
    {
        return Preference::where('pref_group','=',$group)->where('pref_name','=', $name)->firstOrFail();
    }

    /**
     * @return int
     */
    public function getCountPreference()
    {
        return Preference::all()->count();
    }

    public static function getById($preference_id)
    {
        return Preference::findOrFail($preference_id);
    }

    /**
     * Proses menyimpan data preference ke database
     * @param $params
     * @return mixed
     */
    public function createPreference($params)
    {
        LogRepository::addLog('insert', 'Tambah preference dengan data',null,$params );
        return Auth::user()->preferences()->create($params);
    }

    /**
     * Proses mengupdate data preference di database
     * @param $params
     * @param Preference $preference
     * @return bool
     * @internal param $id
     */
    public function updatePreference($params, Preference $preference){
        LogRepository::addLog('update', 'Update preference dengan data',$preference,$params );
        return $preference->update($params);
    }

    /**
     * Proses menghapus data preference dari database
     * @param Preference $preference
     * @return bool|null
     * @throws \Exception
     * @internal param $id
     */
    public function deletePreference(Preference $preference)
    {
        LogRepository::addLog('delete','Hapus preference dengan nama preference : '.$preference->pref_name);
        return  $preferenceDelete = $preference->delete();
    }
}