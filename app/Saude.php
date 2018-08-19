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
                            'puls'
						];
	protected $primaryKey = 'id';
	protected $table = 'saude';
}
