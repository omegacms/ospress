<?php

use Framework\Support\Facades\Database;

class DropPrice
{
    public function migrate()
    {
        $table = Database::alterTable('orders');
        $table->dropColumn('price');
        $table->execute();
    }
}
