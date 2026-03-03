<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run()
    {
        Setting::create(['key' => 'site_name', 'value' => 'Wiratama Teknik']);
        Setting::create(['key' => 'site_logo', 'value' => null]); // Nanti diupload admin
        
        // Simpan rekening dalam format JSON
        $banks = [
            ['bank' => 'BCA', 'number' => '1234567890', 'name' => 'PT Wiratama'],
            ['bank' => 'Mandiri', 'number' => '0987654321', 'name' => 'PT Wiratama']
        ];
        Setting::create(['key' => 'bank_accounts', 'value' => json_encode($banks)]);
    }
}