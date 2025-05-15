<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Categoria;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProdutoFactory extends Factory
{
    public function definition(): array
    {
        $estados = ['novo', 'semi-novo', 'usado'];
        $marcas = ['Bershka', 'Pull&Bear', 'Stradivarius', 'Zara', 'H&M', 'Springfield'];
        $cores = ['preto', 'branco', 'azul', 'vermelho', 'verde', 'amarelo', 'laranja', 'roxo', 'rosa', 'cinza', 'castanho'];
        
        // Get a random categoria from the database
        $categoria = Categoria::inRandomOrder()->first();
        
        // Define tamanhos baseados no tipo de produto
        $tamanhos = ['XS', 'S', 'M', 'L', 'XL', 'XXL'];

        return [
            'nome' => $this->faker->words(3, true),
            'descricao' => $this->faker->paragraph(2),
            'marca' => $this->faker->randomElement($marcas),
            'genero' => $categoria->genero,
            'categoria_id' => $categoria->id,
            'tamanho' => $this->faker->randomElement($tamanhos),
            'estado' => $this->faker->randomElement($estados),
            'cores' => json_encode($this->faker->randomElements($cores, 2)),
            'imagem' => 'produtos/default.jpg', // Define uma imagem padrão
            'medidas' => sprintf(
                "Comprimento: %dcm\nLargura: %dcm\nManga: %dcm",
                $this->faker->numberBetween(60, 80),
                $this->faker->numberBetween(40, 60),
                $this->faker->numberBetween(50, 70)
            ),
            'user_id' => User::factory(),
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
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
                'estado' => 'novo',
            ];
        });
    }

    /**
     * Indicate that the product belongs to a specific gender.
     */
    public function forGenero(string $genero)
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
