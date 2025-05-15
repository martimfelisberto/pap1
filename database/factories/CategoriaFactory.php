<?php
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Categoria;

class CategoriaFactory extends Factory
{
    protected $model = Categoria::class;

    public function definition()
    {
        $titulo = fake()->sentence(3);

        return [
            'titulo' => $titulo,
            'slug' => Str::slug($titulo),
            'genero' => null, // Mantido vazio, será preenchido pelo usuário no formulário
            'created_by' => \App\Models\User::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
