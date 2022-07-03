<?php

namespace Authenticate\Console\Commands;

use Authenticate\Repositories\User\UserProviderFacade;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateParsPackUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parsPack:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create ParsPack custom User';

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
     * @return int
     */
    public function handle()
    {
        UserProviderFacade::create([
            "full-name" => "Pars pack company",
            "username" => "parspack",
            "password" => bcrypt("123456"),
            "api_token" => Str::random(100)
        ]);

        $this->info("ParsPack user created!");

        return 0;
    }
}
