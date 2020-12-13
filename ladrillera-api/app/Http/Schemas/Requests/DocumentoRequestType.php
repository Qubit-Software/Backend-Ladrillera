<?php

namespace App\Http\Schemas\Requests;

abstract class DocumentoRequestType
{
    const DOWNLOAD = 'DOWNLOAD';
    const DISPLAY = 'DISPLAY';
    const INFO = 'INFO';
    const LINK = 'LINK';
}
