<?php

namespace Crumbls\Firewall\Filament\FirewallRecordResource\Pages;

use Crumbls\Firewall\Filament\FirewallRecordResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFirewallRecords extends ListRecords
{
    protected static string $resource = FirewallRecordResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
