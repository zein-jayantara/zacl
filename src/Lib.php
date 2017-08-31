<?php

namespace Zein\Zacl;

class Lib {
    public static function sendData($data=[],$message="success"){   
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
            ]);
    }
    
    public static function sendError($message="error"){   
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => null,
            ]);
    }
}