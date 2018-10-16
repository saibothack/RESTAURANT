<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Menu;
use App\Optional;
use App\Permission;
use App\Restaurant;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         // Ask for confirmation to refresh migration
        if ($this->command->confirm('Do you wish to refresh migration before seeding, Make sure it will clear all old data ?')) {
            $this->command->call('migrate:refresh');
            $this->command->warn("Data deleted, starting from fresh database.");
        }

        Storage::makeDirectory('temp');

        // Seed the default permissions
        $permissions = Permission::defaultPermissions();
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
        $this->command->info('Default Permissions added.');
        // Ask to confirm to assign admin or user role
        if ($this->command->confirm('Create Roles for user, default is admin and user? [y|N]', true)) {
            // Ask for roles from input
            $roles = $this->command->ask('Enter roles in comma separate format.', 'Administrador, Restaurant');
            // Explode roles
            $rolesArray = explode(',', 'Administrador, Restaurant');
            // add roles
            foreach($rolesArray as $role) {
                $role = Role::firstOrCreate(['name' => trim($role)]);
                if( $role->name == 'Administrador' ) {
                    // assign all permissions to admin role
                    $role->permissions()->sync(Permission::all());
                    $this->command->info('Admin will have full rights');
                }
                // create one user for each role
                //$this->createUser($role);
            }
            $this->command->info('Roles ' . $roles . ' added successfully');
        } else {
            Role::firstOrCreate(['name' => 'User']);
            $this->command->info('By default, User role added.');
        }

        $this->createRestaurant();

      	$this->createUser();

      	$dataOptional = array(
            'name' => 'Prueba1',
            'price' => '15',
            'type' => '1'
        );

        $optional = Optional::create($dataOptional);

        DB::table('optionals_has_menu')->insertGetId(
            ['menus_id' => 1, 'optionals_id' => $optional->id]
        );

        $dataOptional = array(
            'name' => 'Prueba2',
            'price' => '20',
            'type' => '1'
        );

        $optional = Optional::create($dataOptional);

        DB::table('optionals_has_menu')->insertGetId(
            ['menus_id' => 2, 'optionals_id' => $optional->id]
        );

        $dataOptional = array(
            'name' => 'Prueba3',
            'price' => '20',
            'type' => '2'
        );

        $optional = Optional::create($dataOptional);

        DB::table('optionals_has_menu')->insertGetId(
            ['menus_id' => 1, 'optionals_id' => $optional->id]
        );

        $dataOptional = array(
            'name' => 'Prueba4',
            'price' => '20',
            'type' => '2'
        );

        $optional = Optional::create($dataOptional);

        DB::table('optionals_has_menu')->insertGetId(
            ['menus_id' => 2, 'optionals_id' => $optional->id]
        );

    }

    private function createRestaurant() {
        $dataRestaurant = array(
            'domain' => 'prueba1.com',
            'name' => 'Prueba1',
            'email' => 'prueba1@prueba1.com',
            'payment_day' => '15',
            'active' => '1',
            'days_grace' => '5',
            'tables' => '14',
            'price' => '14000',
            'images' => '3'
        );

        $restaurant = Restaurant::create($dataRestaurant);
        $this->createUserRestaurantPrueba($restaurant);
        $this->createMenus($restaurant);

        $dataRestaurant = array(
            'domain' => 'prueba2.com',
            'name' => 'Prueba2',
            'email' => 'prueba2@prueba2.com',
            'payment_day' => '15',
            'active' => '1',
            'days_grace' => '5',
            'tables' => '14',
            'price' => '14000',
            'images' => '3'
        );

        $restaurant =  Restaurant::create($dataRestaurant);
        $this->createUserRestaurant($restaurant);
        $this->createMenus($restaurant);
    }

    private function createUserRestaurantPrueba($restaurant) {
        $dateUser = array(
            'name' => 'Prueba restaurant 1',
            'email' => 'restaunrat1@gmail.com',
            'password' => 'Sysware2016',
            'restaurants_id' => $restaurant->id
        );

        $user = User::create($dateUser);
        $user->assignRole('Restaurant');
    }

    private function createMenus($restaurant) {

        $dateMenu = array(
            'restaurants_id' => $restaurant->id,
            'title' => 'Menu1',
            'description' => 'Descripción del menu 1',
            'price' => '150',
            'active' => 1

        );

        Menu::create($dateMenu);

        $dateMenu = array(
            'restaurants_id' => $restaurant->id,
            'title' => 'Menu2',
            'description' => 'Descripción del menu 2',
            'price' => '150',
            'active' => 1

        );

        Menu::create($dateMenu);

        $dateMenu = array(
            'restaurants_id' => $restaurant->id,
            'title' => 'Menu3',
            'description' => 'Descripción del menu 3',
            'price' => '150',
            'active' => 1

        );

        Menu::create($dateMenu);
    }

    private function createUserRestaurant($restaurant) {
        $dateUser = array(
            'name' => 'Prueba restaurant 2',
            'email' => 'restaunrat2@gmail.com',
            'password' => 'Sysware2016',
            'restaurants_id' => $restaurant->id
        );

        $user = User::create($dateUser);
        $user->assignRole('Restaurant');
    }

    /**
     * Create a user with given role
     *
     * @param $role
     */
    private function createUser()
    {
    	$dateUser = array(
            'name' => 'Gad Arenas',
            'email' => 'garenas@sysware.com.mx',
            'password' => 'Sysware2016'
        );

        $user = User::create($dateUser);
        $user->assignRole('Administrador');
        $this->command->info('Admin login details:');
        $this->command->warn('Username : '.$user->email);
        $this->command->warn('Password : "Sysware2016"');
    }
}
