<x-kaira-layout>
    <div class="container mx-auto px-4 py-8">
        <!-- Header Section -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">
                @yield('page-title')
            </h1>
            <p class="text-gray-600">
                @yield('page-description')
            </p>
        </div>

        <!-- Filters Section -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-8">
            <form method="GET" action="@yield('filter-action')" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Common Filters -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Preço</label>
                    <div class="mt-1 flex gap-2">
                        <input type="number" name="min_price" placeholder="Min" 
                               class="w-full rounded-xl border-gray-300" 
                               value="{{ request('min_price') }}">
                        <input type="number" name="max_price" placeholder="Max" 
                               class="w-full rounded-xl border-gray-300" 
                               value="{{ request('max_price') }}">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Marca</label>
                    <select name="marca" class="mt-1 w-full rounded-xl border-gray-300">
                        <option value="">Todas as marcas</option>
                        @foreach($marcas as $marca)
                            <option value="{{ $marca }}" {{ request('marca') == $marca ? 'selected' : '' }}>
                                {{ $marca }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Type Specific Filters -->
                @yield('additional-filters')

                <div class="md:col-span-3 flex justify-end mt-4">
                    <button type="submit" class="bg-blue-600 text-white px-3 py-1.5 text-sm rounded-xl hover:bg-blue-700 transition-colors duration-200">
                        Aplicar Filtros
                    </button>
                </div>
            </form>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @yield('products-grid')
        </div>
    </div>
</x-kaira-layout>