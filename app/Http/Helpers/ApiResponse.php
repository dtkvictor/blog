<?php

namespace App\Http\Helpers;

use Illuminate\Http\Response;

class ApiResponse {

    public static function success(string $message)
    {
        return response()->json([
            "type" => "Success",
            "message" => $message
        ]);
    }

    public static function created(string $message, object|array $data = [])
    {
        return response()->json([   
            "type" => "Success",
            "message" => $message,
            "data" => $data
        ], Response::HTTP_CREATED);
    }    

    public static function noContent(string $message)
    {
        return response()->json([   
            "type" => "Success",
            "message" => $message,            
        ], Response::HTTP_NO_CONTENT);
    }

    public static function notFound($message) 
    {
        return response()->json([
            "type" => "Error",
            "message" => $message ?? "Page not found",            
        ], Response::HTTP_NOT_FOUND);
    }

    public static function unprocessableEntity(array|object $errors, $message = "")
    {   
        return response()->json([
            "type" => "Error",
            "message" => $message ?? "Unprocessable entity",
            "errors" => $errors
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }       

    public static function conflict(string $message)
    {
        return response()->json([
            "type" => "Error",
            "message" => $message,
        ], Response::HTTP_CONFLICT);
    }
}