<?php

declare(strict_types=1);

namespace BernardinoSlv\Asaas\Abstracts;

use BernardinoSlv\Asaas\Exception\JsonDecodeException;
use BernardinoSlv\Asaas\Interfaces\ResponseInterface;
use CurlHandle;
use stdClass;

abstract class AbstractResponse implements ResponseInterface
{
    protected CurlHandle $ch;
    
    // protected bool $send = false;

    protected string $text;


    final public function __construct(CurlHandle $ch, string $text)
    {
        $this->ch = $ch;
        $this->text = $text;
    }

    public function toArray(): ?array
    {
        $data = json_decode($this->text, true);
        if (!is_array($data)){
            throw new JsonDecodeException("Could not recognize a valid json");
        }
        return $data;
    }

    public function toObject(): ?stdClass
    {
        return json_decode($this->text);
    }

    public function raw(): ?string
    {
        return $this->text;
    }

    public function length(): int
    {
        return strlen($this->text);
    }

    public function statusCode(): int
    {
        return curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
    }
}