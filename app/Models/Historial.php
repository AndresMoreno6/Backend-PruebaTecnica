<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Historial
 *
 * @property int $id
 * @property int $pais_id
 * @property int $ciudad_id
 * @property float $presupuesto_cop
 * @property int $presupuesto_local
 * @property float $tasa_cambio
 * @property string $clima
 * @property Carbon $fecha
 *
 * @property Pais $pai
 * @property Ciudad $ciudad
 *
 * @package App\Models
 */
class Historial extends Model
{
	protected $table = 'historial';
	public $timestamps = false;

	protected $casts = [
		'pais_id' => 'int',
		'ciudad_id' => 'int',
		'presupuesto_cop' => 'float',
		'presupuesto_local' => 'string',
		'tasa_cambio' => 'string',
		'fecha' => 'datetime'
	];

	protected $fillable = [
		'pais_id',
		'ciudad_id',
		'presupuesto_cop',
		'presupuesto_local',
		'tasa_cambio',
		'clima',
		'fecha'
	];

	public function pais()
	{
		return $this->belongsTo(Pais::class, 'pais_id');
	}

	public function ciudad()
	{
		return $this->belongsTo(Ciudad::class);
	}
}
