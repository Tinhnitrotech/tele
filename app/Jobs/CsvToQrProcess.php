<?php

namespace App\Jobs;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CsvToQrProcess implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $userId;

    public function __construct($data, $userId)
    {
        $this->data = $data;
        $this->userId = $userId;
    }

    public function handle()
    {
        if ($this->batch()->cancelled()) {
            $this->fail();
            return;
        }
        foreach ($this->data as $row) {
            $dataAtt[] = [
                    '0' => handleFileNamePerson($row[0]),
                    '1' => $row[1],
                    '2' => $row[2],
                    '3' => handleAddressCSV($row[3]),
                    '4' => handleTelQRCode($row[4]),
                    '5' => $row[5],
                    '6' => $row[6]
                ];

            $dataQr = encryptData(json_encode($dataAtt));

            $image = QrCode::format('png')
                ->size(450)->errorCorrection('M')
                ->margin(4)
                ->backgroundColor(255,255,255)
                ->generate($dataQr);

            $output_file = 'images/qrcreate/' . $this->userId . '/' . 'QR_' . handleFileNameQRCode($row[0]) . '_' . handleTelQRCode($row[4]) . '_' . time() . rand(100, 999) . '.png';
            Storage::disk('public')->put($output_file, $image);
            unset($dataAtt);
        }
    }
}
