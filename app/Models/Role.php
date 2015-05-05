<?php namespace Hardwire\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {
    protected $fillable = ['id', 'name', 'description'];

    public function user()
    {
        return $this->belongsTo('Hardwire\Models\User');
    }

}
