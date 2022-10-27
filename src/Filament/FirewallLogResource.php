<?php

namespace Crumbls\Firewall\Filament;

use Crumbls\Firewall\Filament\FirewallLogResource\Pages;
use Crumbls\Firewall\Filament\FirewallLogResource\RelationManagers;
use Crumbls\Firewall\Models\FirewallLog;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class FirewallLogResource extends Resource
{
    protected static ?string $model = null;//\Crumbls\Firewall\Models\FirewallLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

	protected static ?string $navigationGroup = 'Access Control';

	public static function getModelLabel(): string {
		return __('Logs');
	}
	public static function getModel() : string {
		if (!filled(static::$model)) {
			static::$model = \Firewall::getModelLog();
		}
		return static::$model;
	}

	public static function getSlug(): string
	{
		if (filled(static::$slug)) {
			return static::$slug;
		}

		$f = 'firewall\\logs';

		return \Str::of($f)
			->afterLast('\\Models\\')
			->plural()
			->explode('\\')
			->map(fn (string $string) => \Str::of($string)->kebab()->slug())
			->implode('/');
	}

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
	            TextColumn::make('created_at')
		            ->label('Created'),
	            TextColumn::make('ip')
		            ->label('IP'),
	            TextColumn::make('method')
		            ->label('Method'),
	            TextColumn::make('url')
		            ->label('URL'),
	            TextColumn::make('user.email')
		            ->label('User'),
            ])
            ->filters([
                //
            ])
            ->actions([
//                Tables\Actions\EditAction::make(),
	            Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListFirewallLogs::route('/'),
            'create' => Pages\CreateFirewallLog::route('/create'),
//            'edit' => Pages\EditFirewallLog::route('/{record}/edit'),
        ];
    }    
}
