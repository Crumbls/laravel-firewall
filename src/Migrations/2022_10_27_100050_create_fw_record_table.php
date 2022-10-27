<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	private $model = null;
	public function getModel() {
		if (!filled($this->model)) {
			$class = \Firewall::getModelRecord();
			$this->model = new $class;
		}
		return $this->model;
	}
	public function getConnection() : string {
		return $this->getModel()->getConnection()->getName();
	}
	public function getTable() : string {
		return $this->getModel()->getTable();
	}

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$this->connection = $this->getConnection();
		$table = $this->getTable();
		if (Schema::hasTable($table)) {
			return;
		}
		Schema::create($table, function (Blueprint $table) {
			$table->id();
			$table->boolean('status')->default(0);
			$table->string('ip',64);
			$table->dateTime('created_at')->nullable()->default(null);
			$table->dateTime('updated_at')->nullable()->default(null);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists($this->getTable());
	}
};