<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageSeeder extends Seeder
{
    public function run()
    {
        $pages = [
            ['type' => 'aboutus', 'PageName' => 'About Us', 'detail' => '<p>This is the About Us page.</p>'],
            ['type' => 'faqs', 'PageName' => 'FAQs', 'detail' => '<p>FAQs content goes here.</p>'],
            ['type' => 'privacy', 'PageName' => 'Privacy Policy', 'detail' => '<p>Privacy policy...</p>'],
            ['type' => 'terms', 'PageName' => 'Terms of Use', 'detail' => '<p>Terms of use...</p>'],
        ];
        foreach($pages as $p){
            Page::updateOrCreate(['type' => $p['type']], $p);
        }
    }
}
