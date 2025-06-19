<?php

namespace App\Services;

class InsulinCalculator
{
    /**
     * Calcula a dose de insulina corretiva
     *
     * @param float $currentGlycemia Glicemia atual (mg/dL)
     * @param float $targetGlycemia Glicemia desejada
     * @param float $correctionFactor Quanto 1 unidade de insulina reduz (mg/dL)
     * @return float Dose recomendada
     */
    public function calculateDose(float $currentGlycemia, float $targetGlycemia, float $correctionFactor): float
    {
        $diff = $currentGlycemia - $targetGlycemia;
        if ($diff <= 0) {
            return 0;
        }

        return round($diff / $correctionFactor, 1);
    }
}
