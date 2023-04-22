<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $languages = config('static_data.languages');

        foreach ($languages as $language) {
            Language::firstOrNew(['code' => $language['code'], 'name' => $language['name']])->save();
        }
    }
}
