<?php

namespace App\Services;

use Illuminate\Validation\ValidationException;

class KarcisSeriesParser
{
    /**
     * Parse comma/newline-separated serial numbers or inclusive numeric ranges.
     *
     * @return array{ranges: array<int, array{0: int, 1: int}>, numbers: array<int, int>}
     */
    public function parse(string $input, int $minimum, int $maximum, string $errorKey = 'karcis_nomor'): array
    {
        $parts = preg_split('/[,\r\n]+/', trim($input), -1, PREG_SPLIT_NO_EMPTY);
        if (!$parts) {
            throw ValidationException::withMessages([
                $errorKey => 'Masukkan nomor atau rentang seri karcis yang digunakan.',
            ]);
        }

        $ranges = [];
        $numbers = [];
        foreach ($parts as $part) {
            if (!preg_match('/^\s*(\d+)\s*(?:-\s*(\d+)\s*)?$/', $part, $matches)) {
                throw ValidationException::withMessages([
                    $errorKey => 'Gunakan nomor atau rentang angka, dipisahkan koma atau baris baru. Contoh: 001-020, 022.',
                ]);
            }

            $start = (int) $matches[1];
            $end = isset($matches[2]) && $matches[2] !== '' ? (int) $matches[2] : $start;
            $lastNumber = $matches[2] ?? $matches[1];
            if ($start > $end || $start < $minimum || $end > $maximum) {
                throw ValidationException::withMessages([
                    $errorKey => "Rentang karcis {$matches[1]}-{$lastNumber} berada di luar seri yang diserahkan.",
                ]);
            }
            if ($end - $start + 1 > 2000 || count($numbers) + ($end - $start + 1) > 2000) {
                throw ValidationException::withMessages([
                    $errorKey => 'Maksimal 2.000 nomor karcis dapat dicatat dalam satu setoran.',
                ]);
            }

            foreach ($ranges as [$existingStart, $existingEnd]) {
                if ($start <= $existingEnd && $end >= $existingStart) {
                    throw ValidationException::withMessages([
                        $errorKey => 'Rentang nomor karcis yang dimasukkan saling tumpang tindih.',
                    ]);
                }
            }

            $ranges[] = [$start, $end];
            for ($number = $start; $number <= $end; $number++) {
                $numbers[] = $number;
            }
        }

        sort($numbers);

        return ['ranges' => $ranges, 'numbers' => $numbers];
    }
}
