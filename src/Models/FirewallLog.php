<?php

namespace Crumbls\Firewall\Models;

use Crumbls\Firewall\Traits\HasIPAttribute;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * Spatie\Activitylog\Models\Activity.
 *
 * @property int $id
 * @property string|null $log_name
 * @property string $description
 * @property string|null $subject_type
 * @property int|null $subject_id
 * @property string|null $causer_type
 * @property int|null $causer_id
 * @property \Illuminate\Support\Collection|null $properties
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $causer
 * @property-read \Illuminate\Support\Collection $changes
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $subject
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Crumbls\Firewall\Models\FirewallLog causedBy(\Illuminate\Database\Eloquent\Model $causer)
 * @method static \Illuminate\Database\Eloquent\Builder|\Crumbls\Firewall\Models\FirewallLog forBatch(string $batchUuid)
 * @method static \Illuminate\Database\Eloquent\Builder|\Crumbls\Firewall\Models\FirewallLog forEvent(string $event)
 * @method static \Illuminate\Database\Eloquent\Builder|\Crumbls\Firewall\Models\FirewallLog forSubject(\Illuminate\Database\Eloquent\Model $subject)
 * @method static \Illuminate\Database\Eloquent\Builder|\Crumbls\Firewall\Models\FirewallLog hasBatch()
 * @method static \Illuminate\Database\Eloquent\Builder|\Crumbls\Firewall\Models\FirewallLog inLog($logNames)
 * @method static \Illuminate\Database\Eloquent\Builder|\Crumbls\Firewall\Models\FirewallLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Crumbls\Firewall\Models\FirewallLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Crumbls\Firewall\Models\FirewallLog query()
 */
class FirewallLog extends Model
{
	use HasIPAttribute;

	/**
	 * Disable updated_at
	 */
	const UPDATED_AT = null;

	/**
	 * Fillable.
	 * @var string[]
	 */
    public $fillable = [
	    'ip',
	    'method',
	    'url',
	    'user_id'
    ];

	/**
	 * Prepare our model.
	 * @param array $attributes
	 */
	public function __construct(array $attributes = [])
	{
		if (!isset($this->connection) || !$this->connection) {
			$this->setConnection(\Config::get('firewall.model.log.database_connection', \Config::get('database.default', 'default')));
		}

		if (!isset($this->table) || !$this->table) {
			$this->setTable(\Config::get('firewall.model.log.table_name', 'firewall_logs'));
		}

		parent::__construct($attributes);
	}

	/**
	 * Active User
	 * @return MorphTo
	 */
	public function user(): BelongsTo
	{
		return $this->morphTo(\Config::get('auth.providers.users.model', \App\Models\User::class));
	}

	/**
	 * Active Record
	 * @return MorphTo
	 */
	public function record() : BelongsTo {
		return $this->belongsTo(\Firewall::getModelRecord());
	}

	/**
	 * Restrict our URL attribute.
	 * @param string $input
	 */
	public function setUrlAttribute(string $input) : void {
		$this->attributes['url'] = substr($input, 0, min(strleN($input), 2802));
	}
}