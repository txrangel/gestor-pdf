<x-filament::widget>
    <x-filament::card>
        <div class="p-6">
            <h2 class="text-lg font-semibold mb-4">Total de TXTs Importados</h2>
            <p class="text-3xl font-bold text-primary-500">{{ $this->getTotalTxts() }}</p>
        </div>
    </x-filament::card>
</x-filament::widget>