<?php namespace Hardwire\Steam;

use SteamCondenser\Community\SteamGroup;
use SteamCondenser\Community\WebApi;

class Group {
    const MAX_PLAYER_SUMMARIES = 100;

    public function __construct($steamKey, $steamGroup)
    {
        $this->key = $steamKey;
        $this->group = $steamGroup;
    }

    public function getMembers()
    {
        $memberIds = [];
        $i = 0;
        $page = 0;
        $group = new SteamGroup($this->group);

        foreach($group->getMembers() as $member) {
            if (!isset($memberIds[$page]))
                $memberIds[$page] = [];

            $memberIds[$page][] = $member->getSteamId64();
            $i++;

            if ($i >= self::MAX_PLAYER_SUMMARIES) {
                $i = 0;
                $page++;
            }
        }

        $pageCount = $page + 1;
        $groupMembers = [];

        for ($i = 0; $i < $pageCount; $i++) {
            $result = WebApi::getJSON('ISteamUser', 'GetPlayerSummaries', 2, ['steamids' => implode(',', $memberIds[$i]), 'key' => $this->key]);
            $object = json_decode($result);

            foreach ($object->response->players as $player) {
                $groupMembers[] = $player;
            }
        }

        return $groupMembers;
    }
}