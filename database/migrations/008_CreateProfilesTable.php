<?php

use Framework\Support\Facades\Database;

class CreateProfilesTable
{
    public function migrate()
    {
        $table = Database::createTable('profiles');
        $table->id('id');
        $table->int('user_id');
        $table->execute();
    }
}
