<?php

namespace App\Exceptions;

use Exception;

class ValidationException extends Exception
{
    private $errors;
    
    public function __construct($errors = [], $msg = null){
        $this->errors = $errors;
        parent::__construct($msg);
    }

    /**
     * Report or log an exception.
     *
     * @return void
     */
    public function report()
    {
        \Log::debug('Validation did not pass');
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response()->json($this->errors, 400); 
    }
}
