<?php
namespace Zein\Zacl\Traits;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Zein\Zacl\Lib;

trait RestExceptionHandlerTrait
{

    protected function getJsonResponseForException(Request $request, Exception $e)
    {
        switch(true) {
            case $this->isModelNotFoundException($e):
                $retval = $this->modelNotFound();
                break;
            case $this->isQueryException($e):
                $retval = $this->queryBad($e->getMessage());
                break;
            default:
                $retval = $this->badRequest();
        }

        return $retval;
    }

    protected function badRequest($message='Bad request', $statusCode=400)
    {
        return Lib::sendError($message);
    }

    protected function modelNotFound($message='Record not found', $statusCode=404)
    {
        return Lib::sendError($message);
    }


    protected function isModelNotFoundException(Exception $e)
    {
        return $e instanceof ModelNotFoundException;
    }
    
    protected function isQueryException (Exception $e)
    {
        return $e instanceof QueryException ;
    }
    
    protected function queryBad($message='Record not found', $statusCode=403)
    {
        return Lib::sendError($message);
    }

}