<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use \App\Models\User;


class permissionsWithInitData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //// $adminRole BLOCK BEGIN
        /*
        ACCESS_ROLE_ADMIN = 1  // can do all
        ACCESS_ROLE_MANAGER = 2  // Manager - can  edit hostels
        ACCESS_ROLE_CUSTOMER = 3 // Customer - only personal part
        ACCESS_ROLE_CONTENT_EDITOR = 4  // Content Editor - can  edit news/cms
*/
        $adminRole = Role::create(['name' => ACCESS_ROLE_ADMIN, 'guard_name' => 'web']);
        $appAdminPermission = Permission::create(['name' => PERMISSION_APP_ADMIN, 'guard_name' => 'web']);
        $adminRole->givePermissionTo($appAdminPermission); // means : App admin

/*        $appAdminUser= User::find(1);
        if ( $appAdminUser ) {
            echo '<pre>$::-1</pre>';
//            $appAdminUser->givePermissionTo($appAdminPermission);
        }
        $appAdminUser= User::find(5);
        if ( $appAdminUser ) {
            echo '<pre>$::-15</pre>';
//            $appAdminUser->givePermissionTo($appAdminPermission);
        }*/
        //// $adminRole BLOCK END


        //// HOSTEL ROLE  BLOCK BEGIN
/*        $managersEditorRole = Role::create(['name' => ACCESS_ROLE_MANAGER, 'guard_name' => 'web']);

        $addHostelPermission = Permission::create(['name' => PERMISSION_ADD_HOSTEL, 'guard_name' => 'web']);
        $managersEditorRole->givePermissionTo($addHostelPermission); // means : managerEditor can add hostel

        $editHostelPermission = Permission::create(['name' => PERMISSION_EDIT_HOSTEL, 'guard_name' => 'web']);
        $managersEditorRole->givePermissionTo($editHostelPermission); // means : managerEditor can edit hostel
        $deleteHostelPermission = Permission::create(['name' => PERMISSION_DELETE_HOSTEL, 'guard_name' => 'web']);
        $managersEditorRole->givePermissionTo($deleteHostelPermission); // means : managerEditor can delete hostel*/


/*        $editHostelUser= User::find(1);
        if ( $editHostelUser ) {
            echo '<pre>$::-1</pre>';
//            $editHostelUser->givePermissionTo($editHostelPermission);
//            $editHostelUser->givePermissionTo($deleteHostelPermission);
        }

        $editHostelUser= User::find(3);
        if ( $editHostelUser ) {
            echo '<pre>$::-2</pre>';
//            $editHostelUser->givePermissionTo($editHostelPermission);
//            $editHostelUser->givePermissionTo($deleteHostelPermission);
        }

        $editHostelUser= User::find(4);
        if ( $editHostelUser ) {
            echo '<pre>$::-3</pre>';
//            $editHostelUser->givePermissionTo($editHostelPermission);
//            $editHostelUser->givePermissionTo($deleteHostelPermission);
        }

        $editHostelUser= User::find(5);
        \Log::info(  varDump($editHostelUser, ' -1 $editHostelUser::') );
        if ( $editHostelUser ) {
            echo '<pre>$::-4</pre>';
            \Log::info(  varDump($editHostelUser, ' -11 INSIDE $editHostelUser::') );
//            $editHostelUser->givePermissionTo($editHostelPermission);
//            $editHostelUser->givePermissionTo($deleteHostelPermission);
        }*/
        //// HOSTEL ROLE BLOCK END



        //// CONTENT EDITOR ROLE BLOCK BEGIN
        /// ACCESS_ROLE_MANAGER
        $managerRole = Role::create(['name' => ACCESS_ROLE_MANAGER, 'guard_name' => 'web']);

        $addPagePermission = Permission::create(['name' => PERMISSION_ADD_PAGE, 'guard_name' => 'web']);
        $managerRole->givePermissionTo($addPagePermission); // means : manager can add content

        $editPagePermission = Permission::create(['name' => PERMISSION_EDIT_PAGE, 'guard_name' => 'web']);
        $managerRole->givePermissionTo($editPagePermission); // means : manager can edit content
        $deletePagePermission = Permission::create(['name' => PERMISSION_DELETE_PAGE, 'guard_name' => 'web']);
        $managerRole->givePermissionTo($deletePagePermission); // means : manager can delete content


/*        $editPageUser= User::find(1);
        if ( $editPageUser ) {
            echo '<pre>$::-1</pre>';
//            $editPageUser->givePermissionTo($editPagePermission);
//            $editPageUser->givePermissionTo($deletePagePermission);
        }

        $editPageUser= User::find(3);
        if ( $editPageUser ) {
            echo '<pre>$::-2</pre>';
//            $editPageUser->givePermissionTo($editPagePermission);
//            $editPageUser->givePermissionTo($deletePagePermission);
        }

        $editPageUser= User::find(4);
        if ( $editPageUser ) {
            echo '<pre>$::-3</pre>';
//            $editPageUser->givePermissionTo($editPagePermission);
//            $editPageUser->givePermissionTo($deletePagePermission);
        }

        $editPageUser= User::find(5);
        if ( $editPageUser ) {
            echo '<pre>$::-3</pre>';
//            $editPageUser->givePermissionTo($editPagePermission);
//            $editPageUser->givePermissionTo($deletePagePermission);
        }*/
        //// CONTENT EDITOR ROLE BLOCK END

        $CustomerRole = Role::create(['name' => ACCESS_ROLE_CUSTOMER, 'guard_name' => 'web']);
        $customerPermission = Permission::create(['name' => PERMISSION_CUSTOMER, 'guard_name' => 'web']);
        $CustomerRole->givePermissionTo($customerPermission); // means : customer use services

        // ROLE_CONTENT_EDITOR

//        php artisan passport:install
    }
}
