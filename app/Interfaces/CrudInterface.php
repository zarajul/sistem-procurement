<?php

namespace App\Interfaces;

interface CrudInterface
{
    public function getAllData();
    public function getDataById($id);
    public function insertData(array $data);
    public function updateData($id, array $data);
    public function deleteData($id);
    public function searchData($keyword);
}