<?php

namespace App\Console\Commands;

use App\Models\Role;
use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminProfileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin-user:setup';

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
        echo "Creating admin user...\n";

        $user = new User();
        $user->email = "admin@shurlaw.com";
        $user->name = "Shurlaw Admin";
        $user->title = "Admin Title";
        $user->phone_number = "+2348094183083";
        $user->address = "234, Pacific Rim, Pacific Ocean";
        $user->city = "Pacific City";
        $user->state = "Pacific State";
        $user->country = "Pacific Country";
        $user->zip_code = "234444";
        $user->about = "Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi quasi tenetur, officiis, accusantium numquam consequuntur fuga laudantium eius veritatis dolorum suscipit aspernatur! Ea, praesentium possimus sit ratione quidem accusantium beatae.";
        $user->profile_photo = "public/default-profile.jpg";
        $user->password = Hash::make("password");

        $user->save();

        $role = Role::where("name", "ADMIN")->first();

        $user->roles()->attach($role->id);

        echo "Admin user created!!!\n\n";

        return 0;
    }
}
