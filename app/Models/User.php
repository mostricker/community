<?php namespace Hardwire\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

class User extends Model implements AuthenticatableContract {

	use Authenticatable;
	protected $table = 'users';

	protected $fillable = ['name'];
	protected $hidden = ['remember_token'];

    public function steam()
    {
        return $this->hasOne('Hardwire\Models\Steam');
    }

    public function teamspeak()
    {
        return $this->hasOne('Hardwire\Models\Teamspeak');
    }

}
