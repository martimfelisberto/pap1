<x-kaira-layout>
@extends('Produtos.clothes.camisolas')

@section('page-title')
    Camisolas {{ ucfirst($genero) }}
@endsection

@section('page-description')
    Explore nossa coleção de camisolas para {{ $genero }}
@endsection

@section('additional-filters')
    <div>
        <label class="block text-sm font-medium text-gray-700">Tamanho</label>
        <select name="tamanho" class="mt-1 w-full rounded-md border-gray-300">
            <option value="">Todos os tamanhos</option>
            <option value="XS" {{ request('tamanho') == 'XS' ? 'selected' : '' }}>XS</option>
            <option value="S" {{ request('tamanho') == 'S' ? 'selected' : '' }}>S</option>
            <option value="M" {{ request('tamanho') == 'M' ? 'selected' : '' }}>M</option>
            <option value="L" {{ request('tamanho') == 'L' ? 'selected' : '' }}>L</option>
            <option value="XL" {{ request('tamanho') == 'XL' ? 'selected' : '' }}>XL</option>
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Marca</label>
        <select name="marca" class="mt-1 w-full rounded-md border-gray-300">
            <option value="">Todas as marcas</option>
            @foreach($marcas as $marca)
                <option value="{{ $marca }}" {{ request('marca') == $marca ? 'selected' : '' }}>
                    {{ $marca }}
                </option>
            @endforeach
        </select>
    </div>
@endsection
</x-kaira-layout>