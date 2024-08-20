<?php

namespace App\Http\Resources\Carne;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarneIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'total' => $this->valor_total,
            'valor_entrada' => $this->valor_entrada,
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
