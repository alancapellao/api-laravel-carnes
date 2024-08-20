<?php

namespace App\Http\Resources\Carne;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarneShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'parcelas' => $this->parcelas->map(function ($parcela) {
                return [
                    'numero' => $parcela->numero,
                    'data_vencimento' => $parcela->data_vencimento,
                    'valor' => $parcela->valor,
                    'entrada' => $parcela->entrada,
                ];
            }),
        ];
    }
}
