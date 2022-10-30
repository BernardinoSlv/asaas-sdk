<?php

declare(strict_types=1);

namespace BernardinoSlv\Asaas\Interfaces;

interface RequestInterface
{
    /**
     * Request with GET method
     *
     * @param string $url
     * @param array $params
     * @return ResponseInterface
     */
    public function get(string $url, array $params = []): ResponseInterface;

    /**
     * Request with POST method
     *
     * @param string $url
     * @param array $data
     * @return ResponseInterface
     */
    public function post(string $url, array $data = []): ResponseInterface;

    /**
     * Request with PUT method
     *
     * @param string $url
     * @param array $data
     * @return ResponseInterface
     */
    public function put(string $url, array $data = []): ResponseInterface;

    /**
     * Request with DELETE method
     *
     * @param string $url
     * @param array $params
     * @return ResponseInterface
     */
    public function delete(string $url, array $params = []): ResponseInterface;
}