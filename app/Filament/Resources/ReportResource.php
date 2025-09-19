<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Report;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Modal\Actions\Action;
use Filament\Actions\Action as ActionsAction;
use App\Filament\Resources\ReportResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ReportResource\RelationManagers;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Manajemen Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')->disabled(),
                TextInput::make('opd')->disabled(),
                TextInput::make('masalah')->disabled(),
                TextInput::make('kontak')->disabled(),
                Textarea::make('deskripsi')->disabled()->rows(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->defaultSort('created_at', 'desc')

            ->columns([
                TextColumn::make('nama'),
                TextColumn::make('opd'),
                TextColumn::make('masalah'),
                TextColumn::make('deskripsi'),
                TextColumn::make('kontak'),
                TextColumn::make('created_at')->dateTime(),
            ])

            ->filters([])
            ->actions([
                Tables\Actions\ViewAction::make(), // 👈 Tambahkan ini

                Tables\Actions\Action::make('hubungi')
                    ->label('Hubungi')
                    ->icon('heroicon-o-phone')
                    ->url(fn($record) => 'https://wa.me/' . preg_replace('/^0/', '62', $record->kontak))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
            'view' => Pages\ViewReport::route('/{record}'), // 👈 ini halaman detail

        ];
    }
}
