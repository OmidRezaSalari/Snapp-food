<?php

namespace Authenticate\Console\Commands;

use Authenticate\Repositories\User\UserProviderFacade;
use Illuminate\Console\Command;

class CreateUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dummy:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create custom User';

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
            "full-name" => "dummy dummy",
            "username" => "dummy",
            "password" => bcrypt("123456"),
        ]);

        $this->info("Ananymous user created!");

        return 0;
    }
}
