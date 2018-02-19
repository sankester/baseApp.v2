<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 07/09/2017
 * Time: 15:35
 */

namespace App\Libs\LogLib;

use App\Libs\LogLib\Data\MessageLog;
use App\Libs\LogLib\Model\Log;
use Illuminate\Support\Facades\Auth;

class LogRepository
{
    /**
     * Message objek data
     * @var
     */
    private static $message;

    /**
     * Model Action
     * @var
     */
    private static $model;

    /**
     * Level
     * @var
     */
    private static $level;

    /**
     * Prfix message
     * @var
     */
    private static $prefix;

    /**
     * Data parsing
     * @var
     */
    private static $data;

    /**
     * Exception data
     * @var
     */
    private static $exception;

    /**
     * Tambah data log
     * @param string $action
     * @param $message
     * @param null $model
     * @param null $data
     * @internal param $level
     * @internal param $prefix
     */
    public static function addLog($action = 'umum', $message , $model = null, $data = null, $exception = null)
    {
        // set default exception
        self::$exception = ['_method', '_token'];
        // add exception
        self::addException($exception);
        //set property data
        self::setProperty($action,$message,$model,$data);
        // get message
        $full_message = self::getMessage();
        // insert to database
        if($full_message != false){
            (new self)->insertLog(self::$level , $full_message);
        }
    }

    /**
     * Set Property Class
     * @param $action
     * @param $prefix
     * @param null $model
     * @param null $data
     * @internal param $level
     */
    public static function setProperty($action, $prefix , $model = null, $data = null)
    {
        // get data
        $data = (new self)->filterData($data);
        self::$message = new MessageLog();
        self::$level = $action;
        self::$model = $model;
        self::$prefix = $prefix;
        self::$data = $data;

    }

    /**
     * Tambah exception
     * @param $exception
     */
    public static function addException($exception){
        if(! is_null($exception)){
            // cek if array
            if(is_array($exception)){
                // foreach to add single exception
                foreach ($exception as $item) {
                    self::$exception[] = $item;
                }
            }else{
                // add single exception
                self::$exception[] = $exception;
            }
        }
    }

    /**
     * Ambil message log
     * @return mixed
     */
    public static function getMessage()
    {
        self::$message->setData(self::$level, self::$prefix,self::$data,self::$model);
        $full_message =  self::$message->generateMessage();
        return $full_message;
    }

    /**
     * Insert data ke database
     * @param $action
     * @param $message
     * @return $this|\Illuminate\Database\Eloquent\Model
     */
    public function insertLog($action , $message)
    {
        $params['action'] =  $action ;
        $params['description'] = $message;
        $params['user_id'] = Auth::user()->id;
        $params['portal_id'] = session()->get('role_active')->portal_id;
        return Log::create($params);
    }

    /**
     * Filter data
     * @param $data
     * @return mixed
     */
    public function filterData($data)
    {
        if(! is_null($data)){
            // filter data
            foreach ($data as $key => $item) {
                // cek exist in array
                if(in_array($key , self::$exception )){
                    // unset exception
                    unset($data[$key]);
                }
            }
            // return data
        }
        return $data;
    }

    /**
     * Mengambil list semua log
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getAll()
    {
        return Log::all();
    }

    /**
     * Mengambil list log berdasarkan ID Portal
     * @param $portal_id
     * @return \Illuminate\Support\Collection
     */
    public static function getLogPortal($portal_id, $perPage)
    {
        return Log::where('portal_id', $portal_id)->latest()->paginate($perPage);
    }

    /**
     * Mengambil log berdasarkan ID User
     * @param $user_id
     * @return \Illuminate\Support\Collection
     */
    public static function getLogUser($user_id, $perPage)
    {
        return Log::where('user_id', $user_id)->latest()->paginate($perPage);
    }
}