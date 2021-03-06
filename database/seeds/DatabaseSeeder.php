<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(LaratrustSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AccountSeeder::class);
        $this->call(TransactionSeeder::class);
        $this->call(UserGroupsSeeder::class);
        Model::reguard();
    }
}
