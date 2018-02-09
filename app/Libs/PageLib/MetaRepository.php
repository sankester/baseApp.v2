<?php
/**
 * Created by PhpStorm.
 * User: achva
 * Date: 14/08/2017
 * Time: 08:46
 */

namespace app\Libs\PageLib;
use App\Libs\PageLib\Data\Meta;

class MetaRepository
{
    /**
     * Default Meta to load
     * @var array
     */
    private $defaultMeta = array();
    /**
     * Meta for facebook
     * @var array
     */
    private $metaFacebook = array();

    /**
     * Meta for twitter
     * @var array
     */
    private $metaTwitter = array();
    /**
     * General Meta Google etc.
     * @var array
     */
    private $generalMeta = array();
    /**
     * Meta Object : 'App\Libs\PageLib\Data\Meta'
     * @var
     */
    private $meta;
    /**
     * Data yang akan di inputkan ke meta object default meta
     * @var array
     */
    private $metaData = array();

    /**
     * Data yang akan di inputkan ke object meta facebook
     * @var array
     */
    private $metaDataFacebook = array();

    /**
     * Data yang akan di inputkan ke object meta twiiter
     * @var array
     */
    private $metaDatatwitter = array();

    /**
     * Data yang akan di inputkan ke object meta general
     * @var array
     */
    private $metaDataGeneralMeta = array();

    /**
     * MetaRepository constructor.
     */
    public function __construct()
    {
        $this->initialDefaultMeta();
    }

    /**
     * Menambah value array
     * @param array $data
     * @param default : null $key
     * @param string $value
     */
    private function pustDataArray(array &$data, $key , $value=null)
    {
        empty($value) ? $data[] = $value : $data[$key] = $value;
    }

    /**
     * Inisialisasi  meta default
     */
    public function initialDefaultMeta()
    {
        $this->pustDataArray($this->metaData, 'charset', 'utf-8');
        $this->addDefaultMeta();
        $this->resetMetaData();

        $this->pustDataArray($this->metaData, 'http-equiv', 'X-UA-Compatible');
        $this->pustDataArray($this->metaData, 'content', 'IE=edge');
        $this->addDefaultMeta();
        $this->resetMetaData();

        $this->pustDataArray($this->metaData, 'name', 'viewport');
        $this->pustDataArray($this->metaData, 'content', 'width=device-width, initial-scale=1');
        $this->addDefaultMeta();
        $this->resetMetaData();

        $this->pustDataArray($this->metaData, 'http-equiv', 'Content-Type');
        $this->pustDataArray($this->metaData, 'content', 'text/html; charset=utf-8');
        $this->addDefaultMeta();
        $this->resetMetaData();
        $this->resetMetaData();

        $this->pustDataArray($this->metaData, 'name', 'robots');
        $this->pustDataArray($this->metaData, 'content','index,follow');
        $this->addDefaultMeta();
        $this->resetMetaData();
        $this->resetMetaData();

        $this->meta = new Meta();
    }

    /**
     * Tambah default Meta
     */
    public function addDefaultMeta()
    {
        $this->meta = new Meta($this->metaData);
        $this->defaultMeta[] = $this->meta;
    }

    /**
     * Reset Meta Data
     */
    public function resetMetaData()
    {
        $this->metaData = array();
    }

    /**
     * Ambil data default meta
     * @return array
     */
    public function getDefaultMeta()
    {
        return $this->defaultMeta;
    }

    /**
     * Ambil data meta facebook
     * @return array
     */
    public function getMetaFacebook()
    {
        return $this->metaFacebook;
    }

    /**
     * Ambil data meta twiiter
     * @return array
     */
    public function getMetaTwitter()
    {
        return $this->metaTwitter;
    }

    /**
     * Ambil data meta general
     * @return array
     */
    public function getGeneralMeta()
    {
        return $this->generalMeta;
    }

    /**
     * Set data meta facebook
     * @param string $type
     * @param $site_name
     * @param $title
     * @param null $image
     * @param $description
     * @param null $url
     * @param null $image_type
     * @param null $image_width
     * @param null $image_height
     */
    public function setMetaDataFacebook($type = 'article',
                                        $site_name,
                                        $title,
                                        $image = null,
                                        $description,
                                        $url = null,
                                        $image_type = null,
                                        $image_width = null,
                                        $image_height = null
                                        )
    {
        $this->pustDataArray($this->metaDataFacebook ,'og:type', $type);
        if(!is_null($site_name))  $this->pustDataArray($this->metaDataFacebook ,'og:site_name', $site_name);
        if(!is_null($title))  $this->pustDataArray($this->metaDataFacebook ,'og:title', $title);
        if(!is_null($image))  $this->pustDataArray($this->metaDataFacebook ,'og:image', $image);
        if(!is_null($description))  $this->pustDataArray($this->metaDataFacebook ,'og:description', $description);
        if(!is_null($url))  $this->pustDataArray($this->metaDataFacebook ,'og:url', $url);
        if(!is_null($image_type)) $this-> pustDataArray($this->metaDataFacebook ,'og:image:type', $image_type);
        if(!is_null($image_width))  $this->pustDataArray($this->metaDataFacebook ,'og:image:width', $image_width);
        if(!is_null($image_height))  $this->pustDataArray($this->metaDataFacebook ,'og:image:height', $image_height);
        $this->setMetaFacebook();
    }

    /**
     * add meta to array list meta facebook
     */
    private function setMetaFacebook()
    {
        foreach ($this->metaDataFacebook as $key => $value) {
            $facebookMeta  = array(
                'property' => $key,
                'content' => $value
            );
            if($key == 'og:url') $facebookMeta['itemprop'] = 'author';
            $this->meta = new Meta($facebookMeta);
            $this->metaFacebook[] = $this->meta;
        }
    }

    /**
     * Set data twitter
     * @param $card
     * @param null $site
     * @param $title
     * @param $description
     * @param null $image
     * @param null $image_alt
     */
    public function setMetaDataTwitter($card,
                                       $site = null, // user account twitter
                                       $title,
                                       $description,
                                       $image = null,
                                       $image_alt = null
                                        )
    {
        $this->pustDataArray($this->metaDatatwitter ,'twitter:card', $card);
        if(!is_null($site))  $this->pustDataArray($this->metaDatatwitter ,'twitter:site', $site);
        $this->pustDataArray($this->metaDatatwitter ,'twitter:title', $title);
        $this->pustDataArray($this->metaDataFacebook ,'twitter:description', $description);
        if(!is_null($image))  $this->pustDataArray($this->metaDataFacebook ,'twitter:image:alt', $image);
        if(!is_null($image_alt))  $this->pustDataArray($this->metaDataFacebook ,'twitter:image:alt', $image_alt);
        $this->setMetaTwitter();
    }

    /**
     *  add meta to array list meta twitter
     */
    private function setMetaTwitter()
    {
        foreach ($this->metaDataFacebook as $key => $value) {
            $twitterMeta  = array(
                'name' => $key,
                'content' => $value
            );
            $this->meta = new Meta($twitterMeta);
            $this->metaTwitter[] = $this->meta;
        }
    }

    /**
     *  Set data meta general
     * @param $articel_id
     * @param string $articletype
     * @param $createdate
     * @param null $publishdate
     * @param string $contenttype
     * @param string $platform
     * @param null $author
     * @param $description
     * @param null $keywords
     * @param null $thumbnailUrl
     * @param null $url
     */
    public function setMetaDataGeneralMeta($articel_id,
                                           $articletype = 'singlepage',
                                           $createdate,
                                           $publishdate = null,
                                           $contenttype= 'singlepagenews',
                                           $platform = 'desktop',
                                           $author = null,
                                           $description,
                                           $keywords = null,
                                           $thumbnailUrl = null,
                                           $url = null
    )
    {
        $this->pustDataArray($this->metaDataGeneralMeta ,'articleid', $articel_id);
        if(!is_null($articletype))  $this->pustDataArray($this->metaDataGeneralMeta ,'articletype', $articletype);
        $this->pustDataArray($this->metaDataGeneralMeta ,'createdate', $createdate);
        if(!is_null($publishdate))  $this->pustDataArray($this->metaDataGeneralMeta ,'pubdate', $publishdate);
        if(!is_null($contenttype))  $this->pustDataArray($this->metaDataGeneralMeta ,'contenttype', $contenttype);
        if(!is_null($platform))  $this->pustDataArray($this->metaDataGeneralMeta ,'platform', $platform);
        if(!is_null($author))  $this->pustDataArray($this->metaDataGeneralMeta ,'author', $author);
        if(!is_null($description))  $this->pustDataArray($this->metaDataGeneralMeta ,'description', $description);
        if(!is_null($keywords))  $this->pustDataArray($this->metaDataGeneralMeta ,'keywords', $keywords);
        if(!is_null($thumbnailUrl))  $this->pustDataArray($this->metaDataGeneralMeta ,'thumbnailUrl', $thumbnailUrl);
        if(!is_null($url))  $this->pustDataArray($this->metaDataGeneralMeta ,'url', $url);
        $this->setMetaGeneral();
    }

    /**
     *  add meta to array list meta general
     */
    private function setMetaGeneral()
    {
        foreach ($this->metaDataGeneralMeta as $key => $value) {
            switch($key){
                case 'author' :
                    $this->meta = new Meta(['property' => 'article:author', 'content' => $value, 'itemprop' => $key]);
                    $this->generalMeta[] = $this->meta;
                    break;
                case 'description':
                    $generalMetaData['itemprop'] = 'headline';
                    $this->meta = new Meta(['content' => $value]);
                    $this->generalMeta[] = $this->meta;
                    break;
                case 'pubdate' :
                    $generalMetaData['itemprop'] = 'datePublished';
                    $this->meta = new Meta(['content' => $value, 'itemprop' => 'dateCreated']);
                    $this->generalMeta[] = $this->meta;
                    $this->meta = new Meta(['property' => 'article:publisher', 'content' => $value]);
                    $this->generalMeta[] = $this->meta;
                    break;
                default:

            }
            if($key == 'url' ){
                $generalMetaData  = array(
                    'content' => $value,
                    'itemprop' => $key
                );
            }else{
                $generalMetaData  = array(
                    'name' => $key,
                    'content' => $value
                );
            }

            if($key == 'description' || $key == 'keywords' || $key == 'description' || $key == 'thumbnailUrl'){
                $generalMetaData['itemprop'] = $key;
            }
            $this->meta = new Meta($generalMetaData);
            $this->generalMeta[] = $this->meta;
        }
    }

    /**
     * get list all metadata
     * @return array
     */
    public function getListMeta()
    {
        $listMeta = array_merge($this->defaultMeta, $this->metaFacebook,$this->generalMeta,$this->metaTwitter);
        return $listMeta;
    }



}