<?php

namespace Database\Seeders;

use App\Models\Helper;
use App\Models\User;
use Illuminate\Database\Seeder;
use Bouncer;

class BouncerSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*******************************************************************************
        *                                Copyright : AGmedia                           *
        *                              email: filip@agmedia.hr                         *
        *******************************************************************************/
        //
        // ROLES
        //
        // ADMIN
        $master = Bouncer::role()->firstOrCreate([
            'name' => 'master',
            'title' => 'Super-admin',
        ]);

        // ZAVOD
        $admin = Bouncer::role()->firstOrCreate([
            'name' => 'admin',
            'title' => 'Administrator',
        ]);

        // INSPEKCIJA
        $editor = Bouncer::role()->firstOrCreate([
            'name' => 'editor',
            'title' => 'Editor',
        ]);

        // ŠEF OVLAŠTENOG TIJELA
        $customer = Bouncer::role()->firstOrCreate([
            'name' => 'customer',
            'title' => 'Javni Profil',
        ]);

        /*******************************************************************************
        *                                Copyright : AGmedia                           *
        *                              email: filip@agmedia.hr                         *
        *******************************************************************************/

        /**
         * ORDERS
         */
        $view_orders = Bouncer::ability()->firstOrCreate([
            'name' => 'view-orders',
            'title' => 'Pregled svih NARUDŽBI'
        ]);
        $create_orders = Bouncer::ability()->firstOrCreate([
            'name' => 'create-orders',
            'title' => 'Kreiranje nove NARUDŽBE'
        ]);
        $edit_orders = Bouncer::ability()->firstOrCreate([
            'name' => 'edit-orders',
            'title' => 'Uređivanje NARUDŽBE'
        ]);
        $delete_orders = Bouncer::ability()->firstOrCreate([
            'name' => 'delete-orders',
            'title' => 'Brisanje NARUDŽBE'
        ]);

        /**
         *
         * PROFIL
         */
        $view_own_profil = Bouncer::ability()->firstOrCreate([
            'name' => 'view-own-profil',
            'title' => 'Pregled svog PROFILA'
        ]);

        $delete_own_profil = Bouncer::ability()->firstOrCreate([
            'name' => 'delete-own-profil',
            'title' => 'Brisanje svog PROFILA'
        ]);

        /**
         *
         * ULOGE
         */
        $view_roles = Bouncer::ability()->firstOrCreate([
            'name' => 'view-roles',
            'title' => 'Pregled svih ULOGA i OVLAŠTENJA'
        ]);

        $edit_roles = Bouncer::ability()->firstOrCreate([
            'name' => 'edit-roles',
            'title' => 'Uređivanje ULOGA svih korisnika'
        ]);

        /*******************************************************************************
         *                                Copyright : AGmedia                           *
         *                              email: filip@agmedia.hr                         *
         *******************************************************************************/
        //
        // PERMISSIONS
        //
        Bouncer::allow($master)->everything();
        /**
         *
         * ADMIN
         */
        Bouncer::allow($admin)->to($view_orders);
        Bouncer::allow($admin)->to($create_orders);
        Bouncer::allow($admin)->to($edit_orders);
        Bouncer::allow($admin)->to($delete_orders);

        Bouncer::allow($admin)->to($view_own_profil);
        Bouncer::allow($admin)->to($delete_own_profil);
        Bouncer::allow($admin)->to($view_roles);
        Bouncer::allow($admin)->to($edit_roles);

        /**
         *
         * EDITOR
         */
        Bouncer::allow($editor)->to($view_orders);
        Bouncer::allow($editor)->to($edit_orders);

        Bouncer::allow($editor)->to($view_own_profil);
        Bouncer::allow($editor)->to($delete_own_profil);

        /**
         *
         * JAVNI PROFIL
         */
        Bouncer::allow($customer)->to($view_own_profil);
        Bouncer::allow($customer)->to($delete_own_profil);

        /**
         *
         */
        foreach ([1, 2] as $id) {
            $user = User::find($id);

            $user->assign('master');
        }


        /*******************************************************************************
        *                                Copyright : AGmedia                           *
        *                              email: filip@agmedia.hr                         *
        *******************************************************************************/



    }
}
