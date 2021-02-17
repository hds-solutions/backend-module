<?php

namespace HDSSolutions\Finpar\Seeders;

use HDSSolutions\Finpar\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // default settings
        $settings = [
            // notifications
            'notifications-email'   => 'no-reply@project.com',

            // contact form
            'contact-email'         => 'no-reply@project.com',
            'contact-phone'         => '+12 345 6789',
            'contact-address'       => '3rd Street 1234',

            // whatsapp action
            'whatsapp-phone'        => '+12 345 6789',
            'whatsapp-text'         => 'Hello!!',

            // SEO
            'gtm'                   => 'GTM-xxxxxxxx',
            'title'                 => config('app.name'),
            'keywords'              => null,
            'description'           => null,

            // eCommerce packages
            'package-basic'         => [ 'type' => 'integer', 'value' => 0 ],
            'package-standard'      => [ 'type' => 'integer', 'value' => 0 ],
            'package-premium'       => [ 'type' => 'integer', 'value' => 0 ],

            // Social
            'facebook'              => null,
            'instagram'             => null,
            'twitter'               => null,
            'medium'                => null,
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
