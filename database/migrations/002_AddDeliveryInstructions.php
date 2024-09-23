<?php

use Framework\Support\Facades\Database;

class AddDeliveryInstructions
{
    public function migrate()
    {
        $table = Database::alterTable('orders');
        $table->text('delivery_instructions');
        $table->execute();
    }
}
