<?php

use Framework\Support\Facades\Database;

class CreateJobsTable
{
    public function migrate()
    {
        $table = Database::createTable('jobs');
        $table->id('id');
        $table->text('closure');
        $table->text('params');
        $table->int('attempts')->default(0);
        $table->bool('is_complete')->default(false);
        $table->execute();
    }
}
