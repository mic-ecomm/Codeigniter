<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['matricule', 'nom', 'prenoms', 'titre', 'mail', 'code_acces', 'date_embauche', 'date_creation', 'date_modification', 'deleted'];
}