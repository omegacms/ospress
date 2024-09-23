<?php

use Framework\Support\Facades\Database;

class CreateOrdersTable
{
    public function migrate()
    {
        $table = Database::createTable('orders');
        $table->id('id');
        $table->int('quantity')->default(1);
        $table->float('price')->nullable();
        $table->bool('is_confirmed')->default(false);
        $table->dateTime('ordered_at')->default('CURRENT_TIMESTAMP');
        $table->text('notes');
        $table->execute();
    }
}
