<?php

declare(strict_types=1);

namespace BernardinoSlv\Asaas\Interfaces;

use stdClass;

interface ResponseInterface
{
    /**
     * returns an array with the response data
     *
     * @return array|null
     */
    public function toArray(): ?array;

    /**
     * returns an stdClass with the response data
     *
     * @return stdClass|null
     */
    public function toObject(): ?stdClass;

    /**
     * returns plain text
     *
     * @return string|null
     */
    public function raw(): ?string;
    
    /**
     * returns the plain text size
     *
     * @return integer
     */
    public function length(): int;

    /**
     * Return status code
     *
     * @return integer
     */
    public function statusCode(): int;

}