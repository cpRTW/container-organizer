<?php

namespace App\Services;

class ContainerOrganizer
{
    public function canOrganize(array $matrix): array
    {
        $n = count($matrix);

        if ($n === 0) {
            return ['possible' => false];
        }

        // Check square matrix + non-negative
        foreach ($matrix as $row) {
            if (!is_array($row) || count($row) !== $n) {
                return ['possible' => false];
            }

            foreach ($row as $val) {
                if (!is_numeric($val) || $val < 0) {
                    return ['possible' => false];
                }
            }
        }

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
            'colSums' => $colSums,
            'message' => $rowSums === $colSums 
                ? 'Organization possible' 
                : 'Mismatch between container capacity and ball types'
        ];
    }
    
}