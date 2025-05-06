<x-kaira-layout>
@extends('Produtos.sapatilhas')

@section('page-title')
    Sapatilhas {{ ucfirst($genero) }}
@endsection

@section('page-description')
    Explore nossa coleção de sapatilhas para {{ $genero }}
@endsection

@section('additional-filters')
    <div>
        <label class="block text-sm font-medium text-gray-700">Tamanho</label>
        <select name="tamanho" class="mt-1 w-full rounded-md border-gray-300">
            <option value="">Todos os tamanhos</option>
            @for($i = 35; $i <= 46; $i++)
                <option value="{{ $i }}" {{ request('tamanho') == $i ? 'selected' : '' }}>
                    {{ $i }}
                </option>
            @endfor
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