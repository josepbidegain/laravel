<?php

namespace App;


class UserRole extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'role_user';

	protected $fillable = [
        'user_id', 'role_id',
    ];

}