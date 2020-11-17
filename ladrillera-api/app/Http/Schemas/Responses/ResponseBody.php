<?php

namespace App\Http\Schemas\Responses;

class ResponseBody{

    protected $data;
    protected $msg;
    protected $status_code;
    /**
     * Instantiate a new ResponseBody instance.
     */
    public function __construct($data, $msg, $status_code )
    {
        $this->data = $data;
        $this->msg = $msg;
        $this->status_code = $status_code;

    }

    public function getJsonArray(){
        return [
            "data"=>$this->data,
            "msg"=>$this->msg,
            "status_code"=>$this->status_code,
        ];
    }

    public function get_status_code(){
        return $this->status_code;
    }
    public function get_data(){
        return $this->data;
    }
    public function get_msg(){
        return $this->msg;
    }
}