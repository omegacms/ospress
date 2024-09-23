<?php

use Framework\Support\Facades\Database;

class CreateProductsTable
{
    public function migrate()
    {
        $table = Database::createTable('products');
        $table->id('id');
        $table->string('name');
        $table->text('description');
        $table->execute();
    }
}
