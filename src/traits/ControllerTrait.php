<?php

namespace Zein\Zacl\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Cache\TaggableStore;
use URL;
use Zein\Zacl\Lib;

trait ControllerTrait{
    public function sendData($data=[],$message="success"){   
        return Lib::sendData($data, $message);
    }
    
    public function sendError($message="error"){   
        return Lib::sendError($message);
    }
    public function getExpiredCache(){
        return Lib::getExpiredCache();
    }
    
    public function clearCache($tagCache){
        if(Cache::getStore() instanceof TaggableStore) {
            Cache::tags($tagCache)->flush();
        }
    }
    
    public static function findFromCache($id,$model){
        $tag = $model->getTable();
        $key = $tag.$id;
        $expired = Lib::getExpiredCache();
        if(Cache::getStore() instanceof TaggableStore) {
            return Cache::tags($tag)->remember($key, $expired, function () use ($model,$id) {
                return $model->find($id);
            });
        }else{
            return $model->find($id);
        }
    }
    
    public static function paginateFromCache($tagCache,$model){
        $expired = Lib::getExpiredCache();
        if(Cache::getStore() instanceof TaggableStore) {
            $result = Cache::tags($tagCache)->remember(URL::full(), $expired, function () use ($model) {
                return $model->paginate(config('zacl.paginate'));
            });
        }else{   
            $result = $model->paginate(config('zacl.paginate'));
        }
        return $result;
    }
}
