<?php

namespace App\Filament\Resources\TxtResource\Widgets;

use App\Models\Txt;
use Filament\Widgets\Widget;

class TotalTxtsWidget extends Widget
{
    protected static string $view = 'filament.widgets.total-txts-widget';

    protected int | string | array $columnSpan = 1; // Ocupa 1 coluna na dashboard

    public function getTotalTxts(): int
    {
        return Txt::count(); // Retorna o total de TXTs
    }
}