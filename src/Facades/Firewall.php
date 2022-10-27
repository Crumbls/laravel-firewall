<?php

namespace Crumbls\Firewall\Facades;

use Illuminate\Support\Facades\Facade;

class Firewall extends Facade {
	protected static function getFacadeAccessor()
	{
		return 'firewall';
	}
}