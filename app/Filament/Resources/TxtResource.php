<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TxtResource\Pages;
use App\Filament\Resources\TxtResource\RelationManagers;
use App\Models\Txt;
use Filament\Tables\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class TxtResource extends Resource
{
    protected static ?string $model = Txt::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('pdf_id')
                    ->label('PDF')
                    ->relationship('pdf', 'name')
                    ->unique(table: Txt::class, column: 'pdf_id',ignorable: null,ignoreRecord: true)
                    ->required(),
                // Forms\Components\FileUpload::make('file_path')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('pdf.name')
                    ->label('PDF')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('extension')
                    ->label('Extensão')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('file_path')
                    ->label('Caminho')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Ação para visualizar o conteúdo do TXT
                Action::make('viewTxtContent')
                    ->label('Ver Conteúdo do TXT')
                    ->modalHeading('Conteúdo do TXT')
                    ->modalCancelAction(false)
                    ->modalSubmitAction(false) // Remove o botão de envio (como "Salvar")
                    ->form([
                        RichEditor::make('txt_content')
                            ->label('Conteúdo do TXT')
                            ->disabled(),
                    ])
                    ->mountUsing(function (Txt $record, Forms\ComponentContainer $form) {
                        // Carregar o conteúdo do TXT do arquivo
                        $txtContent = Storage::disk('public')->get($record->file_path);
                        // Substituir quebras de linha por <br>
                        $txtContent = nl2br($txtContent);
                        $form->fill([
                            'txt_content' => $txtContent,
                        ]);
                    })
                    ->hidden(function (Txt $record) {
                        // Exibir a ação apenas se a extensão for .txt
                        return $record->extension !== '.txt';
                    }),
                Action::make('viewZipContents')
                    ->label('Ver Conteúdo do ZIP')
                    ->modalHeading('Arquivos Extraídos do ZIP')
                    ->modalCancelAction(false)
                    ->modalSubmitAction(false)
                    ->form([
                        Repeater::make('files')
                            ->label('Arquivos Extraídos')
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nome do Arquivo')
                                    ->disabled(),
                                TextInput::make('size')
                                    ->label('Tamanho (Bytes)')
                                    ->disabled()
                                    ->formatStateUsing(function ($state) {
                                        return number_format($state / 1024, 2) . ' KB';
                                    }),
                                RichEditor::make('content')
                                    ->label('Conteúdo')
                                    ->disabled()
                                    ->hidden(function ($state) {
                                        return empty($state);
                                    }),
                            ])
                            ->default(function (Txt $record) {
                                // Caminho da pasta extraída
                                $extractPath = storage_path('app/public/txts/' . basename($record->file_path, '.zip'));
                                $files = [];
                
                                if (is_dir($extractPath)) {
                                    // Percorrer os arquivos da pasta
                                    foreach (scandir($extractPath) as $file) {
                                        // Ignorar diretórios "." e ".."
                                        if ($file === '.' || $file === '..') {
                                            continue;
                                        }
                
                                        // Caminho completo do arquivo
                                        $filePath = "$extractPath/$file";
                
                                        // Verificar se é um arquivo TXT
                                        if (is_file($filePath) && pathinfo($filePath, PATHINFO_EXTENSION) === 'txt') {
                                            $files[] = [
                                                'name' => $file,
                                                'size' => filesize($filePath),
                                                'content' => nl2br(file_get_contents($filePath)),
                                            ];
                                        }
                                    }
                                }
                
                                return $files;
                            })
                            ->disableItemDeletion()
                            ->disableItemCreation() // Remove o botão de adicionar arquivo
                            ->collapsible() // Permite recolher os itens
                            ->itemLabel(function (array $state) {
                                return $state['name']; // Define o rótulo de cada item como o nome do arquivo
                            }),
                    ])
                    ->hidden(function (Txt $record) {
                        return $record->extension !== '.zip';
                    }),
                Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (Txt $record) {
                        if ($record->extension != ".txt") {
                            $zipFolderPath = storage_path('app/public/txts/' . basename($record->file_path, '.zip'));
                            $tempZipPath = storage_path('app/public/txts/' . basename($record->file_path, '.zip') . '_download.zip');
                            
                            $zip = new ZipArchive;
                            if ($zip->open($tempZipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                                $files = scandir($zipFolderPath);
                                foreach ($files as $file) {
                                    if ($file !== '.' && $file !== '..') {
                                        $zip->addFile($zipFolderPath . '/' . $file, $file);
                                    }
                                }
                                $zip->close();
                            }
                            
                            return response()->download($tempZipPath)->deleteFileAfterSend(true);
                        }
                        return response()->download(storage_path('app/public/' . $record->file_path));
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageTxts::route('/'),
        ];
    }
}
