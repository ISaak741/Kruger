<?php

namespace Models;

class Migration extends Model
{
    public static $table = 'migrations';
    public static $cols = ['migration'];
    public static $hidden = ['date_created'];
    public static $ID = 'id';
}
