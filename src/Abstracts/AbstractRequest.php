<?php

declare(strict_types=1);

namespace BernardinoSlv\Asaas\Abstracts;

use BernardinoSlv\Asaas\Concrets\Response;
use BernardinoSlv\Asaas\Exception\RequestMethodNotAllowed;
use BernardinoSlv\Asaas\Interfaces\RequestInterface;
use BernardinoSlv\Asaas\Interfaces\ResponseInterface;
use CurlHandle;

abstract class AbstractRequest implements RequestInterface
{
    protected $allowedMethods = [
        "GET",
        "POST",
        "PUT",
        "DELETE"
    ];


    protected string $apiToken;

    final public function __construct(string $apiToken)
    {
        // echo json_encode($this->headers);
        // exit;
        $this->apiToken = $apiToken;

    }

    public function get(string $url, array $params = []): ResponseInterface
    {
        $ch = $this->initCurl(
            $this->buildQuery($url, $params),
            "GET",
        );

        // var_dump($ch);
        // exit;
        $text = curl_exec($ch);

        return (new Response($ch, $text));
    }

    public function post(string $url, array $data = []): ResponseInterface
    {
        $ch = $this->initCurl($url, "POST");
        $this->buildBody($ch, $data);
        $text = curl_exec($ch);

        return (new Response($ch, $text));
    }

    public function put(string $url, array $data = []): ResponseInterface
    {
        $ch = $this->initCurl($url, "PUT");
        $this->buildBody($ch, $data);
        $text = curl_exec($ch);

        return (new Response($ch, $text));
    }

    public function delete(string $url, array $params = []): ResponseInterface
    {
        $ch = $this->initCurl(
            $this->buildQuery($url, $params),
            "DELETE",
        );
        $text = curl_exec($ch);

        return (new Response($ch, $text));
    }

    final protected function initCurl(string $url, string $method): CurlHandle 
    {
        $method = strtoupper($method);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "access_token: {$this->apiToken}",
            "Content-Type: application/json"
        ]);

        if (in_array($method, $this->allowedMethods) and $method != "GET") {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        }
        elseif (!in_array($method, $this->allowedMethods)) {
            throw new RequestMethodNotAllowed("{$method} method is not allowed, allowed " . implode(", ", $this->allowedMethods));
        }
        return $ch;
    } 

    final protected function buildQuery(string $url, array $params)
    {
        if (empty($params)) {
            return $url;
        }
        // die( $url . "?" . http_build_query($params));
        return $url . "?" . http_build_query($params);
    }

    final protected function buildBody(CurlHandle &$ch, array $data): void
    {
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
}