<?php


$ipv4 = $argv[1] ?? '127.0.0.1';
$port = $argv[2] ?? 80;

` sudo php -S $ipv4:$port -t Public`;
