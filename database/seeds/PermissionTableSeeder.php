<?php
use Illuminate\Database\Seeder;
use App\Permission;
/**
* Agregamos un usuario nuevo a la base de datos.
*/
class PermissionTableSeeder extends Seeder {
    public function run(){

		//DB::table('permissions')->delete();
        
        Permission::create(array(
            'name'  => 'delete-user',
            'display_name'=> 'Delete Users',            
            'description' => 'Delete existing users'
        ));
    }
}
