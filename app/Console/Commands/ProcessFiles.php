<?php

namespace App\Console\Commands;

use App\Managers\DatManager;
use Illuminate\Console\Command;

class ProcessFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:dat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process all files in %HOMEPATH%/data/in';

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
			(new DatManager())->processIn();
    }
}
