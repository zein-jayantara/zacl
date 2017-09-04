<?php

namespace Zein\Zacl;

class Lib {
    public static function sendData($data=[],$message="success"){   
        return response()->json([
            'status' => true,
            'message' => $message,
            'result' => $data,
            ]);
    }
    
    public static function sendError($message="error"){   
        return response()->json([
            'status' => false,
            'message' => $message,
            'result' => null,
            ]);
    }
}