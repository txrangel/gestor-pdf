<?php

namespace App\Filament\Resources\PdfResource\Widgets;

use App\Models\Pdf;
use Filament\Widgets\Widget;

class TotalPdfsWidget extends Widget
{
    protected static string $view = 'filament.widgets.total-pdfs-widget';

    protected int | string | array $columnSpan = 1; // Ocupa 1 coluna na dashboard

    public function getTotalPdfs(): int
    {
        return Pdf::count(); // Retorna o total de PDFs
    }
}