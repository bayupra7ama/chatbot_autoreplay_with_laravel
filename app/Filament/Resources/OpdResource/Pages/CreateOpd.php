<?php

namespace App\Filament\Resources\OpdResource\Pages;

use App\Filament\Resources\OpdResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOpd extends CreateRecord
{
    protected static string $resource = OpdResource::class;

    protected function getRedirectUrl(): string
    {
        // Langsung kembali ke halaman list setelah tambah data
        return $this->getResource()::getUrl('index');
    }
}
