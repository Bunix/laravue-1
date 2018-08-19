<?php
namespace App;
use Eloquent;

class Saude extends Eloquent {

	protected $fillable = [
							'datum',
							'gewicht',
							'diastole',
                            'systole',
                            'puls'
						];
	protected $primaryKey = 'id';
	protected $table = 'saude';
}
