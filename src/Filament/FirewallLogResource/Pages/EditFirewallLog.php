<?php

namespace Crumbls\Firewall\Filament\FirewallLogResource\Pages;

use Crumbls\Firewall\Filament\FirewallLogResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFirewallLog extends EditRecord
{
    protected static string $resource = FirewallLogResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
