<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pai
 *
 * @property int $id
 * @property string $nombre
 *
 * @property Collection|Ciudad[] $ciudads
 * @property Collection|Historial[] $historials
 *
 * @package App\Models
 */
class Pais extends Model
{
	protected $table = 'pais';
	public $timestamps = false;

	protected $fillable = [
		'nombre'
	];

	public function ciudads()
	{
		return $this->hasMany(Ciudad::class, 'pais_id');
	}

	public function historials()
	{
		return $this->hasMany(Historial::class, 'pais_id');
	}
}
