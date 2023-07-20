<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
                'null' => false
            ],

            'matricule' => [
                'type' => 'VARCHAR',
                'constraint' => '20',
                'null' => false
            ],

            'nom' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false
            ],
            'prenoms' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => true
            ],
            'titre' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => true
            ],
            'mail' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],

            'code_acces' => [
                'type' => 'VARCHAR',
                'constraint' => '8',
                'null' => false,
            ],

            'date_embauche' => [
                'type' => 'DATE',
                'default' => date('Y-m-d'), // Valeur par défaut : date d'aujourd'hui
            ],

            'date_creation' => [
                'type' => 'TIMESTAMP',
                'default' => `CURRENT_TIMESTAMP`
            ],

            'date_modification' => [
                'type' => 'TIMESTAMP',
                'default' => `CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP`
            ],

            'deleted' => [
                'type' => 'BOOLEAN',
                'default' => 0
            ],
        ]);


        $this->forge->addKey('id', true);
        $this->forge->createTable('users');
    }

    public function down()
    {
        //
    }
}