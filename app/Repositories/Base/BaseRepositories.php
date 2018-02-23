<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 14/02/2018
 * Time: 21:34
 */

namespace App\Repositories\Base;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class BaseRepositories 
{

    // set base path model
    protected  $basePathModel ;

    // set model
    protected $model = '';

    // pivo table
    protected $pivotTable;

    // operator
    protected $operators = [
        '=', '<', '>', '<=', '>=', '<>', '!=', '<=>',
        'like', 'like binary', 'not like', 'ilike',
        '&', '|', '^', '<<', '>>',
        'rlike', 'regexp', 'not regexp',
        '~', '~*', '!~', '!~*', 'similar to',
        'not similar to', 'not ilike', '~~*', '!~~*',
    ];

    // get model
    public function getModel()
    {
        $this->basePathModel = 'App\\Model\\';
        // set model
        $this->basePathModel .= $this->model;
        return new $this->basePathModel();
    }

    //get pivot table
    public function getPivotTable()
    {
        // set pivot table
        $this->basePathModel .= $this->pivotTable;
        return new $this->basePathModel();
    }

    public function getAuth()
    {
        return Auth::user()->load('userData');
    }

    // get all data
    public function getAll()
    {
        return $this->getModel()->all();
    }

    // get list dengan paginate
    public function getListPaginate($perPage = 10, ...$params)
    {
        $resultModel = $this->getModel();
        // foreach condition
        if(count($params) > 0){
            foreach ($params as $key => $statement) {
                $condition = $statement[0];
                $operator = (in_array($statement[1], $this->operators) ? $statement[1] : '=');
                $value = (in_array($statement[1], $this->operators) ? $statement[2] : $statement[1]);
                $clause = isset($statement[3]) ? $statement[3] : 'and';
                $relation = isset($statement[4]) ? $statement[4] : '';
                $id = isset($statement[5]) ? $statement[5] : '';
                $resultModel = $this->getData($resultModel, $condition,$operator,$value,$clause,$relation,$id);
            }
        }
        // return paginate
        return  $resultModel->paginate($perPage);
    }

    // get data
    protected function getData($model, $condition, $operator, $value , $clause = 'and', $relation = '', $id=''){
        //cek clause
        switch ($clause){
            case 'and' :
                return $model->where($condition,$operator,$value);
                break;
            case 'or':
                return $model->orWhere($condition,$operator,$value);
                break;
            case 'column':
                return $model->whereColumn($condition,$operator,$value);
                break;
            case 'date':
                return $model->whereDate($condition,$operator,$value);
                break;
            case 'dat':
                return $model->whereDay($condition,$operator,$value);
                break;
            case 'month':
                return $model->whereMonth($condition,$operator,$value);
                break;
            case 'time':
                return $model->whereTime($condition,$operator,$value);
                break;
            case 'pivot' :
                $model = $this->getByID($id);
                return $model->$relation()->wherePivot($condition,$operator,$value);
                break;
            default :
                return $model->where($condition,$operator,$value);
                break;
        }
    }

    // get where
    public function where($condition, $operator, $value = '')
    {
        if(! in_array($operator, $this->operators)){
            $value = $operator;
            $operator = '=';
        }
        return $this->getModel()->where($condition, $operator, $value)->get();
    }

    // get data berdasarkan id
    public function getByID($id, $column = 'id')
    {
       return $this->getModel()->where($column,$id)->first();
    }

    // ambil data berdasarkan kondisi tertentu
    public function getWhereMultiple(...$params)
    {
        $resultModel = $this->getModel();
        // foreach condition
        if(count($params) > 0){
            foreach ($params as $key => $statement) {
                $condition = $statement[0];
                $operator = (in_array($statement[1], $this->operators) ? $statement[1] : '=');
                $value = (in_array($statement[1], $this->operators) ? (isset($statement[2]) ? $statement[2] : '') : $statement[1]);
                $clause = isset($statement[3]) ? $statement[3] : 'and';
                $relation = isset($statement[4]) ? $statement[4] : '';
                $id = isset($statement[5]) ? $statement[5] : '';
                $resultModel = $this->getData($resultModel, $condition,$operator,$value,$clause,$relation,$id);
            }
        }
        // return paginate
        return  $resultModel->get();
    }

    // proses insert
    public function create(Request $request)
    {
        return $this->getModel()->create($request->all());
    }

    //proses update
    public function update(Request $request, $id)
    {
        // update
        return $this->getByID($id)->update($request->all());
    }

    // proses delete
    public function delete($id)
    {
        // delete
        return $this->getByID($id)->delete();
    }

    // ambil semua jumlah
    public function countAll()
    {
        return $this->model->all()->count();
    }

    // count where
    public function getCountWhere(...$params)
    {
        $resultModel = $this->getModel();
        // foreach condition
        if(count($params) > 0){
            foreach ($params as $key => $statement) {
                $condition = $statement[0];
                $operator = (in_array($statement[1], $this->operators) ? $statement[1] : '=');
                $value = (in_array($statement[1], $this->operators) ? (isset($statement[2]) ? $statement[2] : '') : $statement[1]);
                $clause = isset($statement[3]) ? $statement[3] : 'and';
                $relation = isset($statement[4]) ? $statement[4] : '';
                $id = isset($statement[5]) ? $statement[5] : '';
                $resultModel = $this->getData($resultModel, $condition,$operator,$value,$clause,$relation,$id);
            }
        }
        // return paginate
        return  $resultModel->count();
    }

    // delete file
    protected function deleteFile($path , $name){
        // delete thumbnail if exist
        if (\File::exists($path . $name)) {
            \File::delete($path . $name);
        }
    }

    // cek apakah data tersedia
    public function isExist($id)
    {
        if(is_null($this->getByID($id))){
            return false;
        }
        return true;
    }

    // upload image
    protected function uploadImage($image, $config)
    {
        $imagePath      = $config['path'];
        $thumbnailPath  = isset($config['thumbnail']) ? $config['thumbnail'] : '';
        $width          = isset($config['width']) ? $config['width'] : 100;
        $height         = isset($config['height']) ? $config['height'] : 100;
        $name           = isset($config['name']) ? $config['name'] : $image->getClientOriginalName();
        $isResize       = isset($config['resize']) ? $config['resize'] : false;
        // resize image and save thumnail
        $img = Image::make($image->getRealPath());
        //cek resize
        if($isResize){
            if(!empty($thumbnailPath)){
                // resize
                $img->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($thumbnailPath.'/'.$name);
                if($image->move($imagePath, $name)){
                    return true;
                }
            }else{
                // resize
                $img->resize($width, $height);
                if($image->save($imagePath, $name)){
                    return true;
                }
            }
        }else{
            if($image->move($imagePath, $name)){
                return true;
            }
        }
        return false;
    }

}