<x-filament::widget>
    <x-filament::card>
        <div class="p-6">
            <h2 class="text-lg font-semibold mb-4">Total de PDFs Importados</h2>
            <p class="text-3xl font-bold text-primary-500">{{ $this->getTotalPdfs() }}</p>
        </div>
    </x-filament::card>
</x-filament::widget>