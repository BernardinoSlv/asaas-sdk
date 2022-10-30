<?php

declare(strict_types=1);

namespace BernardinoSlv\Asaas\Interfaces;

use stdClass;

interface ApiInterface
{
    /**
     * Create
     *
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes): mixed;

    /**
     * Find item by id
     *
     * @param integer $id
     * @return mixed
     */
    public function find(string $id): mixed;

    /**
     * List items 
     *
     * @param array $params
     * @return mixed
     */
    public function list(array $params = []): mixed;

    /**
     * Update item by id
     *
     * @param integer $id
     * @param array $attributes
     * @return mixed
     */
    public function update(string $id, array $attributes): mixed;

    /**
     * Remove item by id
     *
     * @param integer $id
     * @return mixed
     */
    public function remove(string $id): mixed;

    /**
     * Restore item by id
     *
     * @param integer $id
     * @return mixed
     */
    public function restore(string $id): mixed;
}