<?php

use Framework\Support\Facades\Database;

class CreateUsersTable
{
    public function migrate()
    {
        $table = Database::createTable('users');
        $table->id('id');
        $table->string('name');
        $table->string('email');
        $table->string('password');
        $table->execute();
    }
}
