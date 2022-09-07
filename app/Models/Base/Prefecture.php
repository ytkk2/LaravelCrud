<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 13 Feb 2019 12:12:22 +0900.
 */

namespace App\Models\Base;

use Reliese\Database\Eloquent\Model as Eloquent;
use App\Models\Company;

/**
 * Class Prefecture
 * 
 * @property int $id
 * @property string $name
 * @property string $display_name
 * @property int $area_id
 * 
 * @property \App\Models\Area $area
 * @property \Illuminate\Database\Eloquent\Collection $companies
 *
 * @package App\Models\Base
 */
class Prefecture extends Eloquent
{
	public $timestamps = false;

	protected $casts = [
		'area_id' => 'int'
	];

	public function area()
	{
		return $this->belongsTo(\App\Models\Area::class);
	}

	public function companies()
	{
		return $this->hasMany(\App\Models\Company::class);
	}

	public static function selectlist()
{
    $prefs = Prefecture::all();
    $list = array();
    $list += array( "" => "未選択" ); //selectlistの先頭を空に
    foreach ($prefs as $pref) {
       $list += array( $pref->display_name => $pref->display_name );
    }
    return $list;
}
}
