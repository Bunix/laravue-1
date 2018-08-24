<?php
namespace App;
use Eloquent;

class Saude extends Eloquent {

	protected $fillable = [
							'datum',
							'uhrzeit',
							'gewicht',
							'diastole',
                            'systole',
							'puls',
							'description'
						];
	protected $primaryKey = 'id';
	protected $table = 'saude';

	protected $dates = [
        'created_at',
        'updated_at',
        'datum'
    ];
}
