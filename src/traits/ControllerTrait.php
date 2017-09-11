<?php

namespace Zein\Zacl\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Cache\TaggableStore;
use URL;

trait ControllerTrait{
    public function sendData($data=[],$message="success"){   
        return response()->json([
            'status' => true,
            'message' => $message,
            'result' => $data,
            ]);
    }
    
    public function sendError($message="error"){   
        return response()->json([
            'status' => false,
            'message' => $message,
            'result' => null,
            ]);
    }
    public function getExpiredCache(){
        $minute = config('zacl.cache_minute');
        return Carbon::now()->addMinutes($minute);
    }
    
    public function clearCache($tagCache){
        if(Cache::getStore() instanceof TaggableStore) {
            Cache::tags($tagCache)->flush();
        }
    }
    
    public static function findFromCache($id,$model){
        $tag = $model->getTable();
        $key = $tag.$id;
        $expired = Carbon::now()->addMinutes(config('zacl.cache_minute'));
        if(Cache::getStore() instanceof TaggableStore) {
            return Cache::tags($tag)->remember($key, $expired, function () use ($model,$id) {
                return $model->find($id);
            });
        }else{
            return $model->find($id);
        }
    }
    
    public static function paginateFromCache($tagCache,$model){
        $minute = config('zacl.cache_minute');
        $expired = Carbon::now()->addMinutes($minute);
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
