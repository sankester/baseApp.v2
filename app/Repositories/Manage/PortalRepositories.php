<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 20/08/2017
 * Time: 00:38
 */

namespace App\Repositories\Manage;

use App\Model\Manage\Portal;
use App\Repositories\Base\BaseRepositories;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;


class PortalRepositories extends BaseRepositories
{

    // set model
    protected $model = 'Manage\\Portal';

    // get list portal with role
    public function getPortalWithRole()
    {
        return $this->getModel()->with('role')->get();
    }

    // proses insert
    public function create(Request $request)
    {
        // get params
        $params = $request->all();
        // cek logo
        if($request->hasFile('site_logo')){
            /** start upload logo */
            // get image
            $image = $request->file('site_logo');
            // set image name
            $imageName = time().str_replace(' ','-',$request->site_name). '-logo.' . $image->getClientOriginalExtension();
            // set config
            $config = [
                'name'      => $imageName,
                'path'      => 'images/portal',
                'thumbnail' => 'images/portal/thumbnail',
                'resize'    => true
            ];
            if($this->uploadImage($image, $config)){
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
            $imageName = time().str_replace(' ','-',$request->site_name). '-favicon.' . $image->getClientOriginalExtension();
            // set config
            $config = [
                'name'      => $imageName,
                'path'      => 'images/portal',
                'thumbnail' => 'images/portal/thumbnail',
                'width'     => 16,
                'height'     => 16,
                'resize'    => true
            ];
            if($this->uploadImage($image,$config)){
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
                $this->deleteFile($imagePath,   $params['site_logo'] );
                $this->deleteFile($thumbnailPath,   $params['site_logo'] );
            }
            // delete favicon
            if($request->hasFile('site_favicon')){
                $imagePath = 'images/portal/';
                $thumbnailPath = 'images/portal/thumbnail/';
                $this->deleteFile($imagePath,   $params['site_favicon'] );
                $this->deleteFile($thumbnailPath,   $params['site_favicon'] );
            }
            // return
            return false;
        }
    }

    // proses update
    public function update(Request $request, $portalId){
        // get portal
        $portal = $this->getByID($portalId);
        // get params
        $params = $request->all();
        // cek logo
        if($request->hasFile('site_logo')){
            /** start upload logo */
            // get image
            $image = $request->file('site_logo');
            // set image name
            $imageName = time().str_replace(' ','-',$request->site_name). '-logo.' . $image->getClientOriginalExtension();
            // set config
            $config = [
                'name'      => $imageName,
                'path'      => 'images/portal',
                'thumbnail' => 'images/portal/thumbnail',
                'resize'    => true
            ];
            if($this->uploadImage($image, $config)){
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
            // set config
            $config = [
                'name'      => $imageName,
                'path'      => 'images/portal',
                'thumbnail' => 'images/portal/thumbnail',
                'width'     => 16,
                'height'     => 16,
                'resize'    => true
            ];
            if($this->uploadImage($image, $config)){
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
                $this->deleteFile($imagePath, $oldLogo );
                $this->deleteFile($thumbnailPath, $oldLogo );
            }
            // delete favicon
            if($request->hasFile('site_favicon')){
                $imagePath = 'images/portal/';
                $thumbnailPath = 'images/portal/thumbnail/';
                $this->deleteFile($imagePath, $oldFavicon );
                $this->deleteFile($thumbnailPath, $oldFavicon );
            }
            // return
            return true;
        }else{
            // delete logo
            if($request->hasFile('site_logo')){
                $imagePath = 'images/portal/';
                $thumbnailPath = 'images/portal/thumbnail/';
                $this->deleteFile($imagePath,   $params['site_logo'] );
                $this->deleteFile($thumbnailPath,   $params['site_logo'] );
            }
            // deletel favicon
            if($request->hasFile('site_favicon')){
                $imagePath = 'images/portal/';
                $thumbnailPath = 'images/portal/thumbnail/';
                $this->deleteFile($imagePath,   $params['site_favicon'] );
                $this->deleteFile($thumbnailPath,   $params['site_favicon'] );
            }
            // default return
            return false;
        }
    }

    // proses delete
    public function delete($portalId)
    {
        // get portal
        $portal = $this->getByID($portalId);
        // run delete
        if($portal->delete()){
            // set path
            $imagePath = 'images/portal/';
            $thumbnailPath = 'images/portal/thumbnail/';
            // delete logo
            if(! empty($portal->site_logo)){
                $this->deleteFile($imagePath, $portal->site_logo );
                $this->deleteFile($thumbnailPath, $portal->site_logo );
            }
            // delete favicon
            if(! empty($portal->site_favicon)){
                $this->deleteFile($imagePath, $portal->site_favicon );
                $this->deleteFile($thumbnailPath, $portal->site_favicon );
            }
            // return true
            return true;
        }
        // default return
        return false;
    }

}