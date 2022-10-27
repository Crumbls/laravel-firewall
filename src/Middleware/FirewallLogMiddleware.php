<?php

namespace Crumbls\Firewall\Middleware;

use Closure;
use Illuminate\Http\Request;

class FirewallLogMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
	 * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
	 */
	public function handle(Request $request, Closure $next)
	{
		$class = \Firewall::getModelLog();
		$entity = $class::create([
			'ip' => $request->ip(),
			'user_id' => \Auth::id(),
			'method' => $request->method(),
			'url' => url()->current()
		]);
echo 'gherew we are!';
exit;
		/**
		 * Blah blah blah.
		 */

		return $next($request);
	}
}