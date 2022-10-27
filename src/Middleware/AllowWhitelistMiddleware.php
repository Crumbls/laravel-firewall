<?php

namespace Crumbls\Firewall\Middleware;

use Closure;
use Illuminate\Http\Request;

class AllowWhitelistMiddleware
{
	/**
	 * Stop IP addresses that are not whitelisted.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
	 * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
	 */
	public function handle(Request $request, Closure $next)
	{
		if (!\Firewall::isWhitelisted($request->ip())) {
			/**
			 * TODO: Add event.
			 */
			abort(403, __('Forbidden'));
		}

		return $next($request);
	}
}