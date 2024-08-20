<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CarneRepository;
use App\Models\Carne;
use Illuminate\Support\Facades\DB;

class EloquentCarneRepository implements CarneRepository
{
        public function all()
        {
                return Carne::with('parcelas')->get();
        }

        public function find($id)
        {
                return Carne::with('parcelas')->find($id);
        }

        public function create(array $data)
        {
                DB::beginTransaction();

                try {
                        $carne = Carne::create($data);

                        if (!empty($data['parcelas'])) {
                                $this->createParcelas($carne, $data['parcelas']);
                        }

                        DB::commit();

                        return $carne->load('parcelas');
                } catch (\Exception $e) {
                        DB::rollBack();
                        throw $e;
                }
        }

        private function createParcelas(Carne $carne, array $parcelas)
        {
                $carne->parcelas()->createMany($parcelas);
        }
}
