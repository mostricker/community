<?php namespace Hardwire\Models;

use Illuminate\Database\Eloquent\Model;

class Steam extends Model {

    protected $table = 'steams';

    protected $fillable = ['id', 'name', 'avatar', 'steam_id', 'user_id', 'last_logoff'];

    public function user()
    {
        return $this->belongsTo('Hardwire\Models\User');
    }

}
