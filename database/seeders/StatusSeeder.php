<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $statuses = ['Todo', 'In-Progress', 'Done'];
      foreach($statuses as $status) {
        DB::table('statuses')->insert([
          'name' => $status,
          'slug' => Str::slug($status),
      ]);
      }
    }
}
