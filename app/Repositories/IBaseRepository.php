<?php
namespace App\Repositories;

interface IBaseRepository {

    /**
     * Return all records
     *
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*'));

    /**
     * Return the selected record by id
     *
     * @param $id
     * @return mixed
     */
    public function byId($id);
}