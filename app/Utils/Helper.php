<?php

namespace App\Utils;

use Carbon\Carbon;
use Imagick;

class Helper
{
    public static function trimSignature(string $signature): string
    {
        try {
            $imagick = new Imagick();
            $signatureBase64Data = substr($signature, strpos($signature, ',') + 1);
            $signatureImage = base64_decode($signatureBase64Data);
            $imagick->readImageBlob($signatureImage);
            $imagick->trimImage(0); // 0 means trim using the default fuzz value
            $trimmedImageData = $imagick->getImageBlob();
            $trimmedBase64 = "data:image/png;base64," . base64_encode($trimmedImageData);
            $imagick->clear();
            $imagick->destroy();
            return $trimmedBase64;
        } catch (\Throwable $th) {
            return $signature;
        }
    }
    /**
     * @param array<int,mixed> $data
     * @return array<int,mixed>
     */
    public static function manipulateDataHasSignature(array $data): array
    {
        if (isset($data['signature'])) {
            $data['signature'] = self::trimSignature($data['signature']);
        }
        return $data;
    }

    public static function generateDocumentNumber(
        int $id,
        string $departement,
        string|Carbon|null $date = null
    ): string {
        $romanMonths = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII',
        ];

        $parsedDate = $date instanceof Carbon ? $date : Carbon::parse($date ?? now());

        $monthRoman = $romanMonths[$parsedDate->month] ?? 'N/A';
        $year = $parsedDate->year;

        return sprintf("%03d/%s/Naker/%s/%d", $id, $departement, $monthRoman, $year);
    }
}
