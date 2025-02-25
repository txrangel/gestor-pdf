<?php

namespace App\Filament\Resources\PdfResource\Pages;

use App\Filament\Resources\PdfResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePdfs extends ManageRecords
{
    protected static string $resource = PdfResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
