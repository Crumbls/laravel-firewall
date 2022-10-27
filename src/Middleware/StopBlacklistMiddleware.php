<?php

namespace Crumbls\Firewall\Middleware;

use Closure;
use Illuminate\Http\Request;

class StopBlacklistMiddleware
{
	/**
	 * Stop IP addresses that are blacklisted.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
	 * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
	 */
	public function handle(Request $request, Closure $next)
	{
		if (\Firewall::isBlacklisted($request->ip())) {
			/**
			 * TODO: Add event.
			 */
			abort(403, __('Forbidden'));
		}

		return $next($request);
	}
}