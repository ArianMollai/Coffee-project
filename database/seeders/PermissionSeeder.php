<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions=[
            ['name' => 'view-users', 'type' => 'users'],
            ['name' => 'create-users', 'type' => 'users'],
            ['name' => 'update-users', 'type' => 'users'],
            ['name' => 'delete-users', 'type' => 'users'],

            //------------------------------------------------

            ['name' => 'view-roles', 'type' => 'roles'],
            ['name' => 'create-roles', 'type' => 'roles'],
            ['name' => 'update-roles', 'type' => 'roles'],
            ['name' => 'delete-roles', 'type' => 'roles'],
            ['name' => 'assign-roles', 'type' => 'roles'],

            //------------------------------------------------

            ['name' => 'view-categories', 'type' => 'categories'],
            ['name' => 'create-categories', 'type' => 'categories'],
            ['name' => 'update-categories', 'type' => 'categories'],
            ['name' => 'delete-categories', 'type' => 'categories'],

            //------------------------------------------------

            ['name' => 'view-tables', 'type' => "tables"],
            ['name' => 'create-tables', 'type' => 'tables'],
            ['name' => 'update-tables', 'type' => 'tables'],
            ['name' => 'delete-tables', 'type' => 'tables'],

            //-----------------------------------------------

            ['name' => 'view-attributes', 'type' => 'attributes'],
            ['name' => 'create-attributes', 'type' => 'attributes'],
            ['name' => 'update-attributes', 'type' => 'attributes'],
            ['name' => 'delete-attributes', 'type' => 'attributes'],

            //-------------------------------------------------

            ['name' => 'view-units', 'type' => 'units'],
            ['name' => 'create-units', 'type' => 'units'],
            ['name' => 'update-units', 'type' => 'units'],
            ['name' => 'delete-units', 'type' => 'units'],

            //------------------------------------------------

            ['name' => 'view-ingridients', 'type' => 'ingridients'],
            ['name' => 'create-ingridients', 'type' => 'ingridients'],
            ['name' => 'update-ingridients', 'type' => 'ingridients'],
            ['name' => 'delete-ingridients', 'type' => 'ingridients'],

            //------------------------------------------------------

            ['name' => 'view-products', 'type' => 'products'],
            ['name' => 'create-products', 'type' => 'products'],
            ['name' => 'update-products', 'type' => 'products'],
            ['name' => 'delete-products', 'type' => 'products']
        ];

        foreach($permissions as $permission){
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                ['type' => $permission['type']]
            );
        }
    }
}
