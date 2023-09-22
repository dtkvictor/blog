<?php 

namespace App\Http\Helpers;
use App\Models\Log;

class Logs 
{
    private static function body(string $action, string $model, string $message = '') 
    {
        $log = new Log();
        $log->user = auth()->user()->id;
        $log->action = $action;
        $log->model = $model;
        $log->message = $message;
        $log->save();
    }   

    public static function create(string $model, string $message = '')
    {
        self::body('create', $model, $message);
    }
    
    public static function update(string $model, string $message = '')
    {
        self::body('update', $model, $message);
    }

    public static function delete(string $model, string $message = '')
    {
        self::body('update', $model, $message);
    }
}