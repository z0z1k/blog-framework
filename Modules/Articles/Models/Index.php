<?php

namespace Modules\Articles\Models;

use System\Model;

class Index extends Model
{
    protected static $instance;
    protected string $table = 'oop_articles_index';
    protected string $fk = 'id_article';
}