<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SeedRolesAndPermissionData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //clear cache in app() container
        app()['cache'] -> forget('spatie.permission.cache');

        //create permission
        Permission::create(['name' => 'manage_contents']);
        Permission::create(['name' => 'manage_users']);
        Permission::create(['name' => 'edit_settings']);

        //create founder role which is super administrator
        $founder = Role::create(['name' => 'SuperAdmin']);
        $founder->givePermissionTo('manage_contents');
        $founder->givePermissionTo('manage_users');
        $founder->givePermissionTo('edit_settings');

        //create administrator role
        $maintainer = Role::create(['name' => 'Admin']);
        $maintainer->givePermissionTo('manage_contents');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //clear cache
        app()['cache'] -> forget('spatie.permission.cache');


        $tableNames = config('permission.table_names');

        //here actually we use DB operate database directly, we did not use model here.
        //so Model::unguard and Model::regard means nothing here
        Model::unguard();
        DB::table($tableNames['role_has_permission'])->delete();
        DB::table($tableNames['model_has_roles'])->delete();
        DB::table($tableNames['model_has_permission'])->delete();
        DB::table($tableNames['roles'])->delete();
        DB::table($tableNames['permission'])->delete();
        Model::regard();
    }









}