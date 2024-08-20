<?php

namespace App\Repositories\Interfaces;

interface CarneRepository
{
        public function all();
        public function find($id);
        public function create(array $data);
}
