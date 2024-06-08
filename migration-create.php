<?php

$migration_name = $argv[1] ?? null;

if (is_null($migration_name)) {
    echo 'please provide migration name' . PHP_EOL;
    exit;
}

$content = "<?php

use Application\Database\Schema;
use Application\Database\Table;

class $migration_name {
    public function up() {
        // put your logic here
    }

    public function down(){
        // put your logic here
    }
}
";

$path = __DIR__ . "/Migrations/$migration_name.php";
if (file_put_contents($path, $content))
    echo "migration : $migration_name has been created successfully " . PHP_EOL;
else
    echo 'migration failed to be created';
