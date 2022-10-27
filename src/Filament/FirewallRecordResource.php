<?php

namespace Crumbls\Firewall\Filament;

use Crumbls\Firewall\Filament\FirewallRecordResource\Pages;
use Crumbls\Firewall\Filament\FirewallRecordResource\RelationManagers;
use Crumbls\Firewall\Models\FirewallRecord;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\Page;

class FirewallRecordResource extends Resource
{
    protected static ?string $model = null;//\Crumbls\Firewall\Models\FirewallRecord::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
	protected static ?string $navigationGroup = 'Access Control';

	public static function getModelLabel(): string {
		return __('Control');
	}

	public static function getModel() : string {
		if (!filled(static::$model)) {
			static::$model = \Firewall::getModelRecord();
		}
		return static::$model;
	}

	public static function getSlug(): string
	{
		if (filled(static::$slug)) {
			return static::$slug;
		}

		$f = 'firewall\\records';

		return \Str::of($f)
			->afterLast('\\Models\\')
			->plural()
			->explode('\\')
			->map(fn (string $string) => \Str::of($string)->kebab()->slug())
			->implode('/');
	}

    public static function form(Form $form): Form
    {
		/*
		print_r(get_object_vars($form));
		print_r(get_class_methods(get_called_class()));
		dd($form);
		*/
        return $form
	        ->columns(1)
            ->schema([
	            Toggle::make('status')
//		            ->reactive()
			            ->lazy()
			            ->label(function(\Closure $get) {
							return $get('status') ? __('Whitelisted') : __('Blacklisted');
		            })
		            ->onIcon('heroicon-o-check-circle')
		            ->offIcon('heroicon-o-x-circle')
		            ->onColor('success')
		            ->offColor('danger'),
		            TextInput::make('ip')
			            ->required()
			            ->ip()
			            ->unique(ignorable: fn ($record) => $record)
/*
//	->disabled()
	->dehydrated(fn (Page $livewire) => $livewire instanceof EditRecord)
*/
            ]);
    }

	public function mountedTableActionRecord($record): void
	{
		echo __METHOD__;
		exit;
		$this->mountedTableActionRecord = $record;
	}

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
IconColumn::make('status')
	->options([
		'heroicon-o-x-circle' => 0,
		'heroicon-o-check-circle' => 1
	])
	->colors([
		'danger' => 0,
		'success' => 1,
	]),

	            TextColumn::make('ip')
		            ->label('IP'),
	            TextColumn::make('created_at')
		            ->label('Created'),
	            TextColumn::make('updated_at')
		            ->label('Updated'),
                //
            ])
            ->filters([
                //
            ])
            ->actions([
	            Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
	            ])
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
            'index' => Pages\ListFirewallRecords::route('/'),
            'create' => Pages\CreateFirewallRecord::route('/create'),
            'edit' => Pages\EditFirewallRecord::route('/{record}/edit'),
        ];
    }    
}
