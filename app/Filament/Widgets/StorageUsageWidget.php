<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Storage;

class StorageUsageWidget extends BaseWidget
{
    protected static string $view = 'filament.widgets.storage-usage-widget';

    // protected int | string | array $columnSpan = '1'; // Ocupa toda a largura da dashboard

    public function getStorageUsage(): array
    {
        // Definir o limite máximo de armazenamento como 200 GB
        $maxStorage = 50 * 1024 * 1024 * 1024; // 200 GB em bytes
    
        // Definir o disco usado
        $disk = Storage::disk('public');
    
        // Calcular o espaço utilizado apenas pelos arquivos salvos
        $usedSpace = $this->getFolderSize($disk, 'pdfs') + $this->getFolderSize($disk, 'txts');

        // Calcular espaço livre baseado no limite de 200 GB
        $freeSpace = max($maxStorage - $usedSpace, 0);
    
        return [
            'total' => $this->formatBytes($maxStorage), // Sempre será 200 GB
            'used' => $this->formatBytes($usedSpace),
            'free' => $this->formatBytes($freeSpace),
            'percentage' => round(($usedSpace / $maxStorage) * 100, 2), // Porcentagem de uso
        ];
    }
    
    /**
     * Obtém o tamanho total de uma pasta dentro do disco especificado.
     */
    private function getFolderSize($disk, string $folder): int
    {
        $size = 0;
        
        foreach ($disk->allFiles($folder) as $file) {
            $size += filesize($disk->path($file));
        }
    
        return $size;
    }    

    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
