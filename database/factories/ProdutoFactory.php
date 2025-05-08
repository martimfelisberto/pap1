<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produto>
 */
class ProdutoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categorias = ['casacos', 'tshirts', 'camisolas', 'calcas', 'sapatilhas'];
        $generos = ['homem', 'mulher', ''];
        $estados = ['novo', 'usado', 'semi-novo'];
        $marcas = ['Nike', 'Adidas', 'Puma', 'Zara', 'H&M', 'Pull&Bear'];
        
        $categoria = $this->faker->randomElement($categorias);
        
        // Define tamanhos baseados na categoria
        $tamanhos = $categoria === 'sapatilhas' 
            ? range(35, 46) 
            : ['XS', 'S', 'M', 'L', 'XL'];

        return [
            'nome' => $this->faker->words(3, true),
            'descricao' => $this->faker->paragraph(3),
            'preco' => $this->faker->randomFloat(2, 10, 200),
            'imagem' => 'produtos/' . $this->faker->image('public/storage/produtos', 640, 480, null, false),
            'categoria' => $categoria,
            'genero' => $this->faker->randomElement($generos),
            'estado' => $this->faker->randomElement($estados),
            'marca' => $this->faker->randomElement($marcas),
            'tamanho' => $this->faker->randomElement($tamanhos),
            'user_id' => User::factory(),
            'disponivel' => $this->faker->boolean(90), // 90% chance of being available
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => function (array $attributes) {
                return $this->faker->dateTimeBetween($attributes['created_at'], 'now');
            },
        ];
    }

    /**
     * Indicate that the product is new.
     */
    public function novo()
    {
        return $this->state(function (array $attributes) {
            return [
                'estado' => 'novo'
            ];
        });
    }

    /**
     * Indicate that the product is for men.
     */
    public function homem()
    {
        return $this->state(function (array $attributes) {
            return [
                'genero' => 'homem'
            ];
        });
    }

    /**
     * Indicate that the product is for women.
     */
    public function mulher()
    {
        return $this->state(function (array $attributes) {
            return [
                'genero' => 'mulher'
            ];
        });
    }
}
