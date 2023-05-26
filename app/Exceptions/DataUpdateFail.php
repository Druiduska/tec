<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;
use Throwable;

class DataUpdateFail extends Exception {
    private $id;
    private $text;

    public function __construct (string $message = "", $code = 0, Throwable $previous = null) {
        parent::__construct( $message, $code, $previous );
    }
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report () {
        Log::error($this->message);
    }
    /**
     * Render the exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request
     *
     * @return void
     */
    public function render ($request) {

    }
}
