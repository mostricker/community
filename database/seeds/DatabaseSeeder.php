<?php

use Carbon\Carbon;
use Hardwire\Models\Steam;
use Hardwire\Models\Teamspeak;
use Hardwire\Models\User;
use Hardwire\Steam\Group;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

	public function run()
	{
        $this->call('UserTableSeeder');
        $this->call('TeamspeakTableSeeder');
	}

}

class UserTableSeeder extends Seeder {

    public function run()
    {
        $now = Carbon::now('utc')->toDateTimeString();
        DB::table('steams')->delete();
        DB::table('users')->delete();

        $group = new Group(config('services.steam.api'), config('services.steam.group'));
        $members = $group->getMembers();

        foreach ($members as $member) {
            $user = new User(['name' => null, 'created_at' => $now, 'updated_at' => $now]);
            $user->save();

            $steam = new Steam([
                'name' => $member->personaname,
                'avatar' => $member->avatarfull,
                'steam_id' => $member->steamid,
                'last_logoff' => $member->lastlogoff,
                'created_at' => $now,
                'updated_at' => $now
            ]);

            $steam->user()->associate($user);
            $steam->save();
        }
    }

}

class TeamspeakTableSeeder extends Seeder {

    public function run()
    {
        DB::table('teamspeaks')->delete();

        $json = json_decode(File::get(base_path('database/seeds/teamspeak.json')));
        $members = $json->members;

        foreach ($members as $member) {
            $steam = Steam::where('steam_id', $member->steam)->first();
            if ($steam === null) continue;

            $ts = new Teamspeak(['teamspeak_id' => $member->teamspeak, 'user_id' => $steam->user_id]);
            $ts->save();
        }
    }

}