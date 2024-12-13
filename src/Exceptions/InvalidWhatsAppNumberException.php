<?php

namespace EvoFone\Exceptions;

use Exception;

class InvalidWhatsAppNumberException extends Exception
{
    /**
     * The output returned from the operation.
     *
     * @var array
     */
    public $output;

    /**
     * Create a new exception instance.
     *
     * @return void
     */
    public function __construct(array $output)
    {
        parent::__construct('The given number is not a valid WhatsApp number');

        $this->output = $output;
    }

    /**
     * The output returned from the operation.
     *
     * @return array
     */
    public function output()
    {
        return $this->output;
    }
}
