<?php namespace Hardwire\Models;

use Illuminate\Database\Eloquent\Model;

class Teamspeak extends Model {

    protected $table = 'teamspeaks';

    protected $fillable = ['id', 'teamspeak_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo('Hardwire\Models\User');
    }

}
