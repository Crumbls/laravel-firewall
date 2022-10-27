<?php

namespace Crumbls\Firewall\Traits;

trait HasIPAttribute {
	public function setIpAttribute(string $input) : void {
		if (is_numeric($input)) {
			$this->attributes['ip'] = $input;
		} else if (filter_var($input, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
			$this->attributes['ip'] = ip2long($input);
		} else if (filter_var($input, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
			$this->attributes['ip'] = ip2long($input);
		} else {
			throw new \Exception('Invalid IP address.');
		}
	}

	public function getIpAttribute() : string {
		return array_key_exists('ip', $this->attributes) && is_numeric($this->attributes['ip']) ? long2ip($this->attributes['ip']) : '';
	}
}