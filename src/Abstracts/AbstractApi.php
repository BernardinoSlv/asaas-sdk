<?php

declare(strict_types=1);

namespace BernardinoSlv\Asaas\Abstracts;

use BernardinoSlv\Asaas\Concrets\Request;
use BernardinoSlv\Asaas\Exception\EnvNotFoundException;
use BernardinoSlv\Asaas\Interfaces\ApiInterface;
use BernardinoSlv\Asaas\Interfaces\RequestInterface;
use stdClass;

abstract class AbstractApi implements ApiInterface
{
    protected const ENDPOINT_PRODUCTION = "https://www.asaas.com/api/v3";

    protected const ENDPOINT_SANDBOX = "https://sandbox.asaas.com/api/v3";

    public const OUTPUT_STDCLASS = "stdClass";
    
    public const OUTPUT_ARRAY = "array";

    public const OUTPUT_RAW = "raw";

    protected RequestInterface $request;

    protected string $endpoint;
    protected string $action;
    protected string $output = self::OUTPUT_ARRAY;

    final public function __construct(string $env = "sandbox", string $apiToken)
    {
        switch($env) {
            case "sandbox":
                $this->endpoint = self::ENDPOINT_SANDBOX;
                break;
            case "production":
                $this->endpoint = self::ENDPOINT_PRODUCTION;
                break;
            default:
                throw new EnvNotFoundException("{$env} environment nor found, available sandbox and production");
                break;
        }
        $this->request = new Request($apiToken);
    }

    public function create(array $attributes): mixed
    {
        $response = $this->request->post(
            $this->endpoint . "/{$this->action}",
            $attributes
        );

        if ($this->output === self::OUTPUT_ARRAY) {
            return $response->toArray();
        } elseif ($this->output === self::OUTPUT_STDCLASS) {
            return $response->toObject();
        }
        return $response->raw();
    }

    public function find(string $id): mixed
    {
        $response = $this->request->get($this->endpoint . "/{$this->action}/{$id}");

        if ($this->output === self::OUTPUT_ARRAY) {
            return $response->toArray();
        } elseif ($this->output === self::OUTPUT_STDCLASS) {
            return $response->toObject();
        }
        return $response->raw();
    }

    public function list(array $params = []): mixed
    {
        $response = $this->request->get(
            $this->endpoint . "/{$this->action}",
            $params
        );

        if ($this->output === self::OUTPUT_ARRAY) {
            return $response->toArray();
        } elseif ($this->output === self::OUTPUT_STDCLASS) {
            return $response->toObject();
        }
        return $response->raw();
    }

    public function update(string $id, array $attributes): mixed
    {
        $response = $this->request->post(
            $this->endpoint . "/{$this->action}/{$id}",
            $attributes
        );
        
        if ($this->output === self::OUTPUT_ARRAY) {
            return $response->toArray();
        } elseif ($this->output === self::OUTPUT_STDCLASS) {
            return $response->toObject();
        }
        return $response->raw();
    }

    public function remove(string $id): mixed
    {
        $response = $this->request->delete($this->endpoint . "/{$this->action}/{$id}");

        if ($this->output === self::OUTPUT_ARRAY) {
            return $response->toArray();
        } elseif ($this->output === self::OUTPUT_STDCLASS) {
            return $response->toObject();
        }
        return $response->raw();
    }

    public function restore(string $id): mixed
    {
        $response = $this->request->post(
            $this->endpoint . "/{$this->action}/{$id}/restore"
        );

        if ($this->output === self::OUTPUT_ARRAY) {
            return $response->toArray();
        } elseif ($this->output === self::OUTPUT_STDCLASS) {
            return $response->toObject();
        }
        return $response->raw();
    }

    public function setOutput(string $output): ApiInterface
    {
        $this->output = $output;
        return $this;
    }
}