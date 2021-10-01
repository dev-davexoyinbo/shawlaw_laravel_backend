<?php

namespace App\Console\Commands;

use App\Models\Property;
use Illuminate\Console\Command;

class ModelSearchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'model-search:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $propertyClass = Property::class;
        $this->call("scout:import", [
            "model" => "$propertyClass"
        ]);
        // $this->call("tntsearch:import", [
        //     "model" => $propertyClass
        // ]);
    }
}
