<?php
namespace Crumbls\Firewall\Filament\FirewallRecordResource\Pages;

use Crumbls\Firewall\Filament\FirewallRecordResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFirewallRecord extends EditRecord
{
    protected static string $resource = FirewallRecordResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
