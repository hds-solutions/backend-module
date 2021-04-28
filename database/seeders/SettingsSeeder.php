<?php

namespace HDSSolutions\Finpar\Seeders;

use HDSSolutions\Finpar\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder {

    public function run() {
        // default settings
        $settings = [
            // notifications
            'notifications-email'   => 'no-reply@project.com',

            // documents control
            'pending-documents-age' => [ 'type' => 'integer', 'value' => 30 ],
        ];

        // create settings
        $data = [];
        foreach ($settings as $key => $value)
            if (is_array($value))
                $data[] = [ 'name' => $key ] + $value;
            else
                $data[] = [
                    'name'  => $key,
                    'type'  => 'string',
                    'value' => $value,
                ];

        // insert settings
        Setting::insert($data);
    }

}
