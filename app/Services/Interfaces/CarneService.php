<?php

namespace App\Services\Interfaces;

interface CarneService
{
        public function createCarne(array $data);
        public function getCarneById($id);
        public function getAllCarnes();
}
