<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TaskStatus;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //colors of tasks are written like tailwindcss colors
        TaskStatus::create([
            'name' => 'Pendiente',
            'color' => 'gray-400'
        ]);

        TaskStatus::create([
            'name' => 'En progreso',
            'color' => 'yellow-400'
        ]);

        TaskStatus::create([
            'name' => 'Finalizada',
            'color' => 'green-400'
        ]);

        TaskStatus::create([
            'name' => 'Cancelada',
            'color' => 'red-400'
        ]);
    }
}
