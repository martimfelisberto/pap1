<x-kaira-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
       
            <div class="max-w-7xl mx-auto py-8 px-5 sm:px-7 lg:px-9">
                <div class="flex items-center">
                    
                    <h3 class="text-3xl font-extrabold text-gray-900 dark:text-white">Dashboard Overview</h4>
                </div>
            </div>
      

        <main class="py-8">
            <div class="max-w-7xl mx-auto px-5 sm:px-7 lg:px-9">
                <div class="grid lg:grid-cols-2 gap-8">
                    <!-- Stats Column -->
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Total Users Card -->
                        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl transition-transform hover:scale-[1.02] duration-300">
                            <div class="p-8">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-blue-500 rounded-xl p-4">
                                        
                                    </div>
                                    <div class="ml-6">
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</p>
                                        <h4 class="mt-2 text-4xl font-bold text-gray-900 dark:text-white">{{ $stats['total_users'] }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Produtos Card -->
                        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl transition-transform hover:scale-[1.02] duration-300">
                            <div class="p-8">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-green-500 rounded-xl p-4">
                                        
                                    </div>
                                    <div class="ml-6">
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Produtos</p>
                                        <h4 class="mt-2 text-4xl font-bold text-gray-900 dark:text-white">{{ $stats['total_orders'] }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Revenue Card -->
                        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl transition-transform hover:scale-[1.02] duration-300">
                            <div class="p-8">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 bg-purple-500 rounded-xl p-4">
                                        
                                    </div>
                                    <div class="ml-6">
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Revenue</p>
                                        <h4 class="mt-2 text-4xl font-bold text-gray-900 dark:text-white">€{{ number_format($stats['total_revenue'], 2) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Produtos Column -->
                    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl h-fit">
                        <div class="p-8">
                            <div class="flex items-center justify-between mb-8">
                                <h4 class="text-2xl font-bold text-gray-900 dark:text-white">Recent Produtos</h4>
                                <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                                    View All
                                </button>
                            </div>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-5 py-4 text-left text-sm font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Produto ID</th>
                                            <th class="px-5 py-4 text-left text-sm font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                                            <th class="px-5 py-4 text-left text-sm font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                            <th class="px-5 py-4 text-left text-sm font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Amount</th>
                                            <th class="px-5 py-4 text-left text-sm font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @forelse ($recent_orders as $produto)
                                            <tr>
                                                <td class="px-5 py-4 whitespace-nowrap text-base text-gray-900 dark:text-white">
                                                    #{{ $produto->id }}
                                                </td>
                                                <td class="px-5 py-4 whitespace-nowrap text-base text-gray-900 dark:text-white">
                                                    {{ $produto->user->name }}
                                                </td>
                                                <td class="px-5 py-4 whitespace-nowrap">
                                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-lg
                                                        {{ $produto->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                                           ($produto->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                                        {{ ucfirst($produto->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-5 py-4 whitespace-nowrap text-base text-gray-900 dark:text-white">
                                                    €{{ number_format($produto->total_amount, 2) }}
                                                </td>
                                                <td class="px-5 py-4 whitespace-nowrap text-base text-gray-900 dark:text-white">
                                                    {{ $produto->created_at->format('d/m/Y H:i') }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="px-5 py-4 text-center text-gray-500 dark:text-gray-400 text-lg">
                                                    No produtos found
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-kaira-layout>