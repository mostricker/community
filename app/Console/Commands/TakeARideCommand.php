<?php

namespace Hardwire\Console\Commands;

use Illuminate\Console\Command;
use TeamSpeak3;

class TakeARideCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'teamspeak:ride {--t=1}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $teamspeakServer = TeamSpeak3::factory(config('services.teamspeak.connect'));
        $teamspeakServer->selfUpdate(['client_nickname' => '~Hardwire Gaming~']);
        $channels = $teamspeakServer->channelList();
        $clients = $teamspeakServer->clientList();

        foreach ($clients as $client) {
            $this->info($client . ' = ' . $client['client_database_id']);
        }

        $loops = $this->option('t');
        echo "Running $loops number of times!";
        $id = $this->ask('Client DB ID: ');

        for ($i = 0; $i < $loops; $i++) {
            foreach ($clients as $client) {
                $this->info($client);
                if ($client['client_database_id'] == $id) {
                    foreach ($channels as $channel) {
                        $this->info('Moved ' . $client . ' to ' . $channel);
                        $client->move($channel['cid']);
                    }
                }
            }
        }
    }
}
