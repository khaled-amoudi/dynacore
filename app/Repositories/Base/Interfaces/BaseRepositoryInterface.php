<?php

namespace App\Repositories\Base\Interfaces;
/**
 * Interface BaseRepositoryInterface
 * @package App\Repositories\Interfaces
 */
interface BaseRepositoryInterface
{
    /**
     * Get's a Application by it's ID
     *
     * @param int
     */
    public function get($id);

    /**
     * Get's all Applications.
     *
     * @return mixed
     */
    public function all();

    /**
     * @param array $data
     * @return mixed
     */
    public function store(array $data);


    /**
     * @param $id
     * @param array $data
     * @return mixed
     */
    public function update($id, array $data);

        /**
     * Deletes a Application.
     *
     * @param int
     */
    public function delete($id);

}
