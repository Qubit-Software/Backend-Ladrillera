<?php


namespace App;
use Illuminate\Support\Facades\Auth;

class AppUtils{

    public static function getAuthUser(){
        // Get the currently authenticated user...
        return Auth::user();
    }

    public static function isAuthenticated(){
        return (Auth::check());         
    }
}
?>