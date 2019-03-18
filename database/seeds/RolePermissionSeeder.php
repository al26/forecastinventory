<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role; 
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{

    protected $roles = ['administrator', 'production', 'logistic'];
    protected $permissions = [
        "view-sale-history", "input-sale-history", "update-sale-history", "delete-sale-history",
        "view-product", "add-product", "update-product", "delete-product",
        "view-material", "add-material", "update-material", "delete-material", "add-material-stock", "reduce-material-stock", "input-production", "update-production", "delete-production", "view-production",
        "add-production-stock", "reduce-production-stock", "forecast"
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->roles as $r) {
            Role::create(['name' => $r]); 
        }
        
        foreach ($this->permissions as $p) {
            Permission::create(['name' => $p]);
        }

        $administrator = Role::findByName('administrator');
        $administrator->syncPermissions($this->permissions);

        $production = Role::findByName('production'); 
        $production->syncPermissions([
            "input-production", "update-production", "delete-production", "view-production", "add-production-stock", "reduce-production-stock", "reduce-material-stock"
        ]);

        $logistic = Role::findByName('logistic'); 
        $logistic->syncPermissions([ 
            "reduce-production-stock", "add-material-stock" 
        ]);
        
    }
}