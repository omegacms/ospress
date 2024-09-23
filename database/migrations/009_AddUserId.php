<?php

use Framework\Support\Facades\Database;

class AddUserId
{
    public function migrate()
    {
        $table = Database::alterTable('orders');
        $table->int('user_id');
        $table->execute();
    }
}
