<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

use App\Models\Permission;
use App\Models\Role;

class PopulateRolesAndPermissionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'roles-permission:populate';

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
        // Path to the permissions file definition
        $pPath = resource_path("json/permissions.json");
        // Path to the roles file definition
        $rPath = resource_path("json/roles.json");

        //Fetch the permissions and roles from the paths above and 
        // create associative arrays from them
        $permissions = json_decode(File::get($pPath), true);
        $roles = json_decode(File::get($rPath), true);

        foreach ($permissions as $permission) {
            Permission::updateOrCreate([
                "id" => $permission["id"]
            ], [
                "name" => $permission["name"]
            ]);
        } //end 

        foreach ($roles as $r) {
            $role = Role::updateOrCreate([
                "id" => $r["id"]
            ], [
                "name" => $r["name"]
            ]);

            $role->permissions()->sync($r["permissions"]);
        } //end foreach
    } //end method handle
}
