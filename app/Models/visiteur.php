<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visiteur extends Model
{
    // On déclare la table visiteur
    protected $table = 'visiteur';

    protected $primaryKey = 'id_visiteur';

    public $timestamps = false;
}
