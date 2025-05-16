<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Categoria;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdutoFactory extends Factory
{
    protected $model = Produto::class;

    public function definition(): array
    {
        $estados = ['novo', 'semi-novo', 'usado'];
        $cores = ['preto', 'branco', 'azul', 'vermelho', 'verde', 'amarelo', 'laranja', 'roxo', 'rosa', 'cinza', 'castanho'];
        $categoria = Categoria::inRandomOrder()->first();

       


        return [
            'nome' => $this->faker->word(),
            'descricao' => $this->faker->sentence(10),
            'marca' => $this->faker->word(),
            'tamanho'=> $this->faker->randomElement(['XS', 'S', 'M', 'L', 'XL', '2XL' , '3XL']),
            'tamanhosapatilhas'=> $this->faker->randomElement([]),
            'preco' => $this->faker->randomFloat(2, 10, 1000),
            'quantidade' => $this->faker->numberBetween(1, 100),
            'estado' => $this->faker->randomElement($estados),
            'cores' => json_encode($this->faker->randomElements($cores, 2)),
            'imagem' => 'produtos/default.jpg',
            'medidas' => sprintf(
                "Comprimento: %dcm\nLargura: %dcm\nManga: %dcm",
                $this->faker->numberBetween(60, 80),
                $this->faker->numberBetween(40, 60),
                $this->faker->numberBetween(50, 70)
            ),
            'categoria_id' => $categoria->id,
            'genero' => $categoria->genero,
            'user_id' => User::factory(),
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'updated_at' => function (array $attributes) {
                return $this->faker->dateTimeBetween($attributes['created_at'], 'now');
            },
            
        ];
        
    }

    /**
     * Indicate that the product is new
     */
    public function novo(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'estado' => 'novo'
            ];
        });
    }

    /**
     * Indicate that the product belongs to a specific gender
     */
    public function forGenero(string $genero): Factory
    {
        return $this->state(function (array $attributes) use ($genero) {
            $categoria = Categoria::where('genero', $genero)->inRandomOrder()->first();
            return [
                'genero' => $genero,
                'categoria_id' => $categoria->id
            ];
        });
    }
}
