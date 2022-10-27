<?php

namespace Crumbls\Firewall\Filament\FirewallLogResource\Pages;

use Crumbls\Firewall\Filament\FirewallLogResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFirewallLogs extends ListRecords
{
    protected static string $resource = FirewallLogResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
