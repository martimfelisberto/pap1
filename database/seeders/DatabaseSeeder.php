<?php

namespace Database\Seeders;

use App\Http\Controllers\ProdutoController;
use Illuminate\Database\Seeder;
use App\Models\Produto;
use App\Models\User;
use App\Models\Categoria;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {// User::factory(10)->create();

        User::factory()->create([
           'name' => 'Admin',
            'email' => 'admin@reshopping.pt',
        ]);

        Produto::factory(2)->create();

        Categoria::factory(5)->create();

    }
}
