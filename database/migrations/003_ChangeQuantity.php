<?php

use Framework\Support\Facades\Database;

class ChangeQuantity
{
    public function migrate()
    {
        $table = Database::alterTable('orders');
        $table->int('quantity')->nullable()->alter();
        $table->execute();
    }
}
