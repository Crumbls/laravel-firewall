<?php

namespace Crumbls\Firewall;

use Crumbls\Firewall\Filament\FirewallLogResource;
use Crumbls\Firewall\Filament\FirewallRecordResource;
use Crumbls\Firewall\Middleware\AllowWhitelistMiddleware;
use Crumbls\Firewall\Middleware\FirewallLogMiddleware;
use Crumbls\Firewall\Middleware\StopBlacklistMiddleware;
use Crumbls\Projects\Livewire\ProjectTable;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\Foundation\Console\AboutCommand;
use Crumbls\Expenses\Commands\Schedule;
use Crumbls\Expenses\Commands\Scoreboard;

class FirewallServiceProvider extends ServiceProvider
{
	/**
	 * Boot our package.
	 */
    public function boot()
    {
	    $this->bootAbout();
		$this->bootFilament();
		$this->bootMiddleware();
	    $this->bootPublishes();
    }

	protected function bootAbout() {
		AboutCommand::add('Crumbls - Laravel Firewall', function() {
			return ['Version' => '1.0.0'];
		});
	}

	/**
	 * Bring our middleware online.
	 */
	protected function bootMiddleware() : void {
		$router = $this->app->make(\Illuminate\Routing\Router::class);
		$router->aliasMiddleware('firewall-log', FirewallLogMiddleware::class);
		$router->aliasMiddleware('firewall-allow-whitelist', AllowWhitelistMiddleware::class);
		$router->aliasMiddleware('firewall-stop-blacklist', StopBlacklistMiddleware::class);
	}

	private function bootCommands() : void {
			$this->commands([
				Schedule::class,
				Scoreboard::class
			]);
	}

	/**
	 * Bring any components online.
	 */
	private function bootComponents() : void {
			\Livewire::component('projects-table', ProjectTable::class);
		return;
		$this->callAfterResolving(\Illuminate\View\Compilers\BladeCompiler::class, function ($blade) {
			$blade->component(\Crumbls\Expenses\Components\Layout::class, 'football-layout', null);
		});
	}

	/**
	 * Bring all routes online
	 */
    protected function bootRoutes() : void {
	    \Route::middleware('web')
		    ->group(function() {
			    require(__DIR__.'/Routes/web.php');
		    });
    }

	public function bootPublishes() : void {
		$this->loadMigrationsFrom(__DIR__.'/Migrations');

		$this->publishes([
			__DIR__.'/Migrations/' => database_path('migrations')
		]);
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() : void {

		$this->mergeConfigFrom(__DIR__.'/Config/config.php', 'firewall');

		/**
		 * Bring our Facade online.
		 */
		$loader = \Illuminate\Foundation\AliasLoader::getInstance();
		$loader->alias('Firewall', \Crumbls\Firewall\Facades\Firewall::class);
		$this->app->bind('firewall', function($app) {
			return new \Crumbls\Firewall\Firewall();
		});
		return;
	}

	/**
	 * Move this to our admin.
	 */
	public function bootFilament() {
		/**
		 * https://github.com/blade-ui-kit/blade-heroicons/tree/main/resources/svg
		 */


		\Livewire::component('crumbls.firewall.filament.firewall-record-resource.pages.create-firewall-record', FirewallRecordResource\Pages\CreateFirewallRecord::class);
		\Livewire::component('crumbls.firewall.filament.firewall-record-resource.pages.edit-firewall-record', FirewallRecordResource\Pages\EditFirewallRecord::class);
		\Livewire::component('crumbls.firewall.filament.firewall-record-resource.pages.list-firewall-record', FirewallRecordResource\Pages\ListFirewallRecord::class);

		$this->app->resolving('filament', function () {
			\Filament\Facades\Filament::registerResources([
				FirewallLogResource::class,
				FirewallRecordResource::class
			]);
		});
		\Filament\Facades\Filament::serving(function () {
		});
	}
}