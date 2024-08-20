<?php

namespace App\Services;

use App\Repositories\Interfaces\CarneRepository;
use App\Services\Interfaces\CarneService as CarneServiceInterface;
use Carbon\Carbon;

class CarneService implements CarneServiceInterface
{
        protected CarneRepository $carneRepository;

        public function __construct(CarneRepository $carneRepository)
        {
                $this->carneRepository = $carneRepository;
        }

        public function createCarne(array $data)
        {
                if ($data['valor_total'] <= 0) {
                        throw new \Exception('O valor total deve ser maior que zero.');
                }

                if ($data['qtd_parcelas'] <= 0) {
                        throw new \Exception('A quantidade de parcelas deve ser maior que zero.');
                }

                if (isset($data['valor_entrada'])) {
                        if ($data['valor_entrada'] < 0) {
                                throw new \Exception('O valor da entrada não pode ser negativo.');
                        }

                        if ($data['valor_entrada'] > $data['valor_total']) {
                                throw new \Exception('O valor da entrada não pode ser maior que o valor total.');
                        }
                }

                $parcelas = $this->generateParcelas(
                        $data['qtd_parcelas'],
                        $data['valor_total'],
                        $data['valor_entrada'] ?? 0,
                        $data['data_primeiro_vencimento'],
                        $data['periodicidade']
                );

                $data['parcelas'] = $parcelas;

                try {
                        return $this->carneRepository->create($data);
                } catch (\Exception $e) {
                        throw new \Exception('Erro ao criar carnê.');
                }
        }

        public function getCarneById($id)
        {
                try {
                        return $this->carneRepository->find($id);
                } catch (\Exception $e) {
                        throw new \Exception('Erro ao buscar carnê.');
                }
        }

        public function getAllCarnes()
        {
                try {
                        return $this->carneRepository->all();
                } catch (\Exception $e) {
                        throw new \Exception('Erro ao buscar carnês.');
                }
        }

        private function generateParcelas(int $qtdParcelas, float $valorTotal, float $valorEntrada, string $dataPrimeiroVencimento, string $periodicidade): array
        {
                $parcelas = [];
                $valorParcela = ($valorTotal - $valorEntrada) / $qtdParcelas;
                $primeiraParcela = true;
                $numeroParcela = 1;

                for ($i = 0; $i < $qtdParcelas; $i++) {
                        if ($primeiraParcela && $valorEntrada > 0) {
                                $parcelas[] = [
                                        'numero' => $numeroParcela,
                                        'data_vencimento' => $dataPrimeiroVencimento,
                                        'valor' => $valorEntrada,
                                        'entrada' => 1,
                                ];
                                $primeiraParcela = false;
                                $numeroParcela++;
                        }

                        $dataVencimento = Carbon::parse($dataPrimeiroVencimento)
                                ->addUnit($periodicidade === 'mensal' ? 'months' : 'weeks', $i)
                                ->format('Y-m-d');

                        $parcelas[] = [
                                'numero' => $numeroParcela,
                                'data_vencimento' => $dataVencimento,
                                'valor' => $valorParcela,
                                'entrada' => 0,
                        ];

                        $numeroParcela++;
                }

                return $parcelas;
        }
}
