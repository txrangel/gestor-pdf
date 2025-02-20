<x-filament::widget>
    <x-filament::card>
        <div class="p-6">
            <h2 class="text-lg font-semibold mb-4">Uso do Servidor</h2>

            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-600">Total: {{ $this->getStorageUsage()['total'] }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Usado: {{ $this->getStorageUsage()['used'] }} ({{ $this->getStorageUsage()['percentage'] }}%)</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Livre: {{ $this->getStorageUsage()['free'] }}</p>
                </div>
            </div>

            <div class="mt-4">
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-primary-500 h-2.5 rounded-full" style="width: {{ $this->getStorageUsage()['percentage'] }}%"></div>
                </div>
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>