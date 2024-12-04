<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notebook;

class NotebookSeeder extends Seeder
{
    public function run()
    {
        // Добавляем тестовые записи
        Notebook::factory()->count(35)->create();
    }
}
