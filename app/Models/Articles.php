<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Articles extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'web_articles';

    public $timestamps = false;
}
