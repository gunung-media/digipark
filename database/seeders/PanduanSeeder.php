<?php

namespace Database\Seeders;

use App\Models\Admin\Menu\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PanduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $panduans = [
            'Layanan Konsultasi', 'Pelatihan Dan Pemagangan',
            "Klaim JHT",
            "Pengesahan Peraturan Perusahaan",
            "Laporan PHK", "Pelaporan Lowongan", "Pelaporan Penempatan", "Permintaan Tenaga Kerja", "Info Data Ketenagakerjaan", "Tutorial Pembuatan AK1"
        ];
        $panduanMenu = Menu::where('name', "Panduan")->first();

        if (!empty($panduanMenu)) {
            $panduanMenu->delete();
        }

        $panduanMenu = Menu::create([
            'name' => "Panduan",
            'is_active' => 1
        ]);

        foreach ($panduans as $key => $panduan) {
            $panduanMenu->subMenus()->create([
                'title' =>  $key == count($panduans) - 1 ? $panduan : "Panduan $panduan",
                'body' => $panduan,
            ]);
        }
    }
}
