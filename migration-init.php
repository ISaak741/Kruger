<?php

require 'vendor/autoload.php';

use Application\Database\Schema;
use Application\Database\Table;


Schema::create('migrations', function (Table $table) {
    $table->increments('id');
    $table->varchar('migration');
    $table->timestamp('date_created');
});


