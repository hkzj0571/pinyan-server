<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class StoreCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store {method}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * allowed methods
     *
     * @var array
     */
    protected $methods = [
        'read-article' => 'readArticle',
    ];

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
        return ($method = $this->methods[$this->argument('method')])
            ? $this->$method()
            : $this->error('this method is not exists!');
    }

    /**
     * Store read article log in cache to database
     */
    public function readArticle()
    {

    }
}
