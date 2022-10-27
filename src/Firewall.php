<?php

namespace Crumbls\Firewall;

use Crumbls\Firewall\Models\FirewallLog;
use Crumbls\Firewall\Models\FirewallRecord;
use Crumbls\WordPress\Contracts\HasProcess;
use Crumbls\WordPress\Processes\AutomaticProcess;
use Crumbls\WordPress\Processes\DefaultProcess;
use Crumbls\WordPress\Processes\LargeFileProcess;
use Crumbls\WordPress\Processes\SmallFileProcess;

class Firewall {
	/**
	 * A very ugly, memory caching system.
	 * @var array
	 */
	protected array $cache = [];

	public function __construct() {
	}

	public function getModelLog() : string {
		return \Config::get('firewall.model.log.class', FirewallLog::class);
	}

	public function getModelRecord() : string {
		return \Config::get('firewall.model.record.class', FirewallRecord::class);
	}

	public function getStatus(string $ip) : mixed {
		$ip = ip2long($ip);
		if (array_key_exists($ip, $this->cache)) {
			return $this->cache[$ip] == 1;
		}
		$model = $this->getModelRecord();
		$entity = $model::where('ip', $ip)->take(1)->first();

		$this->cache[$ip] = $entity ? $entity->status : null;

		return $this->cache[$ip];
	}

	/**
	 * Determine if this IP address is blacklisted.
	 * @param string $ip
	 * @return bool
	 */
	public function isBlacklisted(string $ip) : bool {
		return $this->getStatus($ip) === 0;
	}

	/**
	 * Determine if this IP address is whitelisted.
	 * @param string $ip
	 * @return bool
	 */
	public function isWhitelisted(string $ip) : bool {
		return $this->getStatus($ip) === 1;
	}

	/**
	 * Blacklist this ip.
	 * @param string $ip
	 * @return bool
	 */
	public function blacklist(string $ip) : void {

//		unset($this->cache[$ip]);
	}

	/**
	 * Whitelist this ip.
	 * @param string $ip
	 * @return bool
	 */
	public function whitelist(string $ip) : void {

	}

	/**
	 * Remove this IP from the blacklist and whitelist.
	 * @param string $ip
	 * @return bool
	 */
	public function nullify(string $ip) : void {

	}
}