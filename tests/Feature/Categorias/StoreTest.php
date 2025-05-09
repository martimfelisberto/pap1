<?php

use App\Models\User;
use App\Models\Categoria;

use function Pest\Laravel\post;
use function Pest\Laravel\actingAs;

it('should have at least 3 characters', function () {
    $user = User::factory()->create();
    actingAs($user);

    $response = post(route('categorias.store'), [
        'nome' => str_repeat('a', 2),
    ]);


    $response
        ->assertSessionHasErrors('nome');
    expect(Categoria::all()->count())->toBe(0);

});
