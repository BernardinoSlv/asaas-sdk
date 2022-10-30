<?php

namespace BernardinoSlv\Asaas;

use BernardinoSlv\Asaas\Api\Customers;
use BernardinoSlv\Asaas\Api\Payments;
use BernardinoSlv\Asaas\Exception\InvalidOutput;
use BernardinoSlv\Asaas\Interfaces\ApiInterface;

class Asaas
{
    protected Customers $customers;
    protected Payments $payments;

    public const OUTPUT_STDCLASS = "stdClass";
    
    public const OUTPUT_ARRAY = "array";

    public const OUTPUT_RAW = "raw";

    public function __construct(string $env, string $apiToken)
    {
        $this->customers = new Customers($env, $apiToken);
        $this->paymensts = new Payments($env, $apiToken);
    }

    /**
     * Get customer object
     *
     * @return Customers
     */
    public function customers(): Customers
    {
        return $this->customers;
    }

    public function paymensts(): Payments
    {
        return $this->paymensts;
    }





    /**
     * Set output type of response
     *
     * @param string $output
     * @return Asaas
     */
    public function setOutput(string $output): Asaas
    {
        switch ($output) {
            case self::OUTPUT_ARRAY:
                $this->customers()->setOutput(self::OUTPUT_ARRAY);
                $this->paymensts()->setOutput(self::OUTPUT_ARRAY);
                break; 
            case self::OUTPUT_STDCLASS:
                $this->customers()->setOutput(self::OUTPUT_STDCLASS);
                $this->paymensts()->setOutput(self::OUTPUT_STDCLASS);
                break;
            case self::OUTPUT_RAW:
                $this->customers()->setOutput(self::OUTPUT_RAW);
                $this->paymensts()->setOutput(self::OUTPUT_RAW);
                break;
            default:
                throw new InvalidOutput("{$output} type output is invalid");
                break;
        }

        return $this;
    }
}