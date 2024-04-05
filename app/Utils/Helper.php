<?php

namespace App\Utils;

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
}
