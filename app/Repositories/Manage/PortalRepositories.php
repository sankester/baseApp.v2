<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 20/08/2017
 * Time: 00:38
 */

namespace App\Repositories\Manage;

use App\Model\Manage\Portal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

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
     * Mangambil jumlah portal
     * @return int
     */
    public function getCountPortal()
    {
        return Portal::all()->count();
    }

    /**
     * Mengambil data portal berdasarkan id
     * @param $portalId
     * @return mixed
     */
    public function getPortalById($portalId)
    {
        return Portal::findOrFail($portalId);
    }

    /**
     * Mengambil data portal untuk select
     * @return \Illuminate\Support\Collection
     */
    public function getAllSelect()
    {
        return Portal::pluck('portal_nm','id');
    }


    /**
     * Proses menyimpan data portal ke database
     * @param Request $request
     * @return mixed
     * @internal param $params
     */
    public function createPortal(Request $request)
    {
        // get params
        $params = $request->all();
        // cek logo
        if($request->hasFile('site_logo')){
            /** start upload logo */
            // get image
            $image = $request->file('site_logo');
            // set image name
            $imageName = time().$request->site_name. '-logo.' . $image->getClientOriginalExtension();
            if($this->uploadImage($image, $imageName)){
                $params['site_logo'] = $imageName;
            }
            /** end upload logo */
        }
        // cek favicon
        if($request->hasFile('site_favicon')){
            /** start upload favicon */
            // get image
            $image = $request->file('site_favicon');
            // set image name
            $imageName = time().$request->site_name. '-favicon.' . $image->getClientOriginalExtension();
            if($this->uploadImage($image, $imageName, 16, 16)){
                $params['site_favicon'] = $imageName;
            }
            /** end upload favicon */
        }
        $portal  = Portal::create($params);
        if($portal){
            return true;
        }else{
            // delete file logo
            if($request->hasFile('site_logo')){
                $imagePath = 'images/portal/';
                $thumbnailPath = 'images/portal/thumbnail/';
                $this->deleteImage($imagePath,   $params['site_logo'] );
                $this->deleteImage($thumbnailPath,   $params['site_logo'] );
            }
            // delete favicon
            if($request->hasFile('site_favicon')){
                $imagePath = 'images/portal/';
                $thumbnailPath = 'images/portal/thumbnail/';
                $this->deleteImage($imagePath,   $params['site_favicon'] );
                $this->deleteImage($thumbnailPath,   $params['site_favicon'] );
            }
            // return
            return false;
        }
    }

    /**
     * Proses mengupdate data portal di database
     * @param Request $request
     * @param $portalId
     * @return bool
     * @internal param $params
     * @internal param Portal $portal
     * @internal param $id
     */
    public function updatePortal(Request $request, $portalId){
        // get portal
        $portal = $this->getPortalById($portalId);
        // get params
        $params = $request->all();
        // cek logo
        if($request->hasFile('site_logo')){
            /** start upload logo */
            // get image
            $image = $request->file('site_logo');
            // set image name
            $imageName = time().str_replace(' ','-',$request->site_name). '-logo.' . $image->getClientOriginalExtension();
            if($this->uploadImage($image, $imageName)){
                $params['site_logo'] = $imageName;
                $oldLogo = $portal->site_logo;
            }
            /** end upload logo */
        }
        // cek favicon
        if($request->hasFile('site_favicon')){
            /** start upload favicon */
            // get image
            $image = $request->file('site_favicon');
            // set image name
            $imageName = time().str_replace(' ','-',$request->site_name). '-favicon.' . $image->getClientOriginalExtension();
            if($this->uploadImage($image, $imageName, 16, 16)){
                $params['site_favicon'] = $imageName;
                $oldFavicon = $portal->site_favicon;
            }
            /** end upload favicon */
        }
        if($portal->update($params)){
            // delete file logo
            if($request->hasFile('site_logo')){
                $imagePath = 'images/portal/';
                $thumbnailPath = 'images/portal/thumbnail/';
                $this->deleteImage($imagePath, $oldLogo );
                $this->deleteImage($thumbnailPath, $oldLogo );
            }
            // delete favicon
            if($request->hasFile('site_favicon')){
                $imagePath = 'images/portal/';
                $thumbnailPath = 'images/portal/thumbnail/';
                $this->deleteImage($imagePath, $oldFavicon );
                $this->deleteImage($thumbnailPath, $oldFavicon );
            }
            // return
            return true;
        }else{
            // delete logo
            if($request->hasFile('site_logo')){
                $imagePath = 'images/portal/';
                $thumbnailPath = 'images/portal/thumbnail/';
                $this->deleteImage($imagePath,   $params['site_logo'] );
                $this->deleteImage($thumbnailPath,   $params['site_logo'] );
            }
            // deletel favicon
            if($request->hasFile('site_favicon')){
                $imagePath = 'images/portal/';
                $thumbnailPath = 'images/portal/thumbnail/';
                $this->deleteImage($imagePath,   $params['site_favicon'] );
                $this->deleteImage($thumbnailPath,   $params['site_favicon'] );
            }
            // default return
            return false;
        }
    }

    /**
     * Proses menghapus data portal dari database
     * @param $portalId
     * @return bool|null
     * @internal param Portal $portal
     * @internal param $id
     */
    public function deletePortal($portalId)
    {
        // get portal
        $portal = $this->getPortalById($portalId);
        // run delete
        if($portal->delete()){
            // set path
            $imagePath = 'images/portal/';
            $thumbnailPath = 'images/portal/thumbnail/';
            // delete logo
            if(! empty($portal->site_logo)){
                $this->deleteImage($imagePath, $portal->site_logo );
                $this->deleteImage($thumbnailPath, $portal->site_logo );
            }
            // delete favicon
            if(! empty($portal->site_favicon)){
                $this->deleteImage($imagePath, $portal->site_favicon );
                $this->deleteImage($thumbnailPath, $portal->site_favicon );
            }
            // return true
            return true;
        }
        // default return
        return false;
    }

    /**
     * Hapus file image di local server
     * @param $path
     * @param $name
     */
    private function deleteImage($path , $name){
        // delete thumbnail if exist
        if (\File::exists($path . $name)) {
            \File::delete($path . $name);
        }
    }

    /**
     * Upload image ke local server
     * @param $image
     * @param $imageName
     * @param int $newWidth
     * @param int $newHeight
     * @return bool
     */
    private function uploadImage($image, $imageName, $newWidth =  100, $newHeight = 100)
    {
        $imagePath = 'images/portal/';
        $thumbnailPath = 'images/portal/thumbnail/';
        // resize image and save thumnail
        $img = Image::make($image->getRealPath());
        if ($img->resize($newWidth, $newHeight, function ($constraint) {
            $constraint->aspectRatio();
        })->save($thumbnailPath . $imageName)) {
            // upload original image
            if ($image->move($imagePath, $imageName)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}