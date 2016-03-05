<?php
use Illuminate\Database\Seeder;
use App\Role;
/**
* Agregamos un usuario nuevo a la base de datos.
*/
class RoleTableSeeder extends Seeder {
    public function run(){

		//DB::table('roles')->delete();
        
        Role::create(array(
			'name'  => 'admin',
            'display_name'     => 'User Administrator',            
            'description' => 'User is allowed to manage and edit other users'
        )
        );
    }
}
