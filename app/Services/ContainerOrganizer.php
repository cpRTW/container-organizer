<?php

namespace App\Services;

class ContainerOrganizer
{
    public function canOrganize(array $matrix): array
    {
        $n = count($matrix);

        $rowSums = [];
        $colSums = array_fill(0, $n, 0);

        foreach ($matrix as $i => $row) {
            $rowSums[] = array_sum($row);

            foreach ($row as $j => $val) {
                $colSums[$j] += $val;
            }
        }

        sort($rowSums);
        sort($colSums);

        return [
            'possible' => $rowSums === $colSums,
            'rowSums' => $rowSums,
            'colSums' => $colSums
        ];
    }
}