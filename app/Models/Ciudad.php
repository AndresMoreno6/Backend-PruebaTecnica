<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Ciudad
 *
 * @property int $id
 * @property string $nombre
 * @property string $moneda
 * @property string $simbolo_moneda
 * @property int $pais_id
 *
 * @property Pais $pai
 * @property Collection|Historial[] $historials
 *
 * @package App\Models
 */
class Ciudad extends Model
{
	protected $table = 'ciudad';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int',
		'pais_id' => 'int'
	];

	protected $fillable = [
		'nombre',
		'moneda',
		'simbolo_moneda',
		'pais_id'
	];

	public function pais()
	{
		return $this->belongsTo(Pais::class, 'pais_id');
	}

	public function historials()
	{
		return $this->hasMany(Historial::class);
	}
}
