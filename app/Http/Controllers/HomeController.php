<?php namespace Hardwire\Http\Controllers;

use Hardwire\Models\Steam;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use LightOpenID;
use TeamSpeak3;

class HomeController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{

	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
        $ts3_VirtualServer = TeamSpeak3::factory(config('services.teamspeak.connect'));
        $arr_ClientList = $ts3_VirtualServer->clientList();

        foreach ($arr_ClientList as $client) {
            if ($client['client_type'] !== 1)
            $teamspeakIds[] = $client['client_database_id'];
        }

        $members = \Hardwire\Models\User::with(['steam', 'teamspeak'])->get();

		return view('master', compact('members', 'teamspeakIds'));
	}

    public function login(Request $request, Redirector $redirect, Guard $auth)
    {
        $openId = new LightOpenID(url(''));

        if ($openId->validate()) {
            $url = $openId->identity;
            $parts = explode('/', $url);
            $id = $parts[count($parts) - 1];

            $steam = Steam::where('steam_id', $id)->with('user')->first();

            if ($steam === null) {
                return 'Sorry, you must be an authorized Hardwire member to login!';
            }

            $user = $steam->user;
            $auth->login($user);

            return $redirect->action('HomeController@index');
        } else {
            $openId->returnUrl = url($request->fullUrl());
            $openId->identity = 'https://steamcommunity.com/openid';

            return $redirect->to($openId->authUrl());
        }
    }

    public function logout(Redirector $redirect, Guard $auth)
    {
        $auth->logout();
        return $redirect->action('HomeController@index');
    }

}
