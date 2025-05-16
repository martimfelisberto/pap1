<?php
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Categoria;
use App\Models\User;

class CategoriaFactory extends Factory
{
    protected $model = Categoria::class;

    public function definition()
    {
        $titulo = fake()->sentence(3);

        return [
            'titulo' => $titulo,
            'genero' => null, 
            'slug' => Str::slug($titulo),
            'created_by' => User::factory(),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => function (array $attributes) {
                return $this->faker->dateTimeBetween($attributes['created_at'], 'now');
            },
            
        ];
    }
}
