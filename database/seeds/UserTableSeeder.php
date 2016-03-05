<?php
use Illuminate\Database\Seeder;
use App\User;
/**
* Agregamos un usuario nuevo a la base de datos.
*/
class UserTableSeeder extends Seeder {
    public function run(){

		DB::table('users')->delete();
        
        User::create(array(
            'name'  => 'admin',
            'email'     => 'admin@admin.com',            
            'password' => Hash::make('admin') // Hash::make() nos va generar una cadena con nuestra contraseña encriptada
        ));
    }
}