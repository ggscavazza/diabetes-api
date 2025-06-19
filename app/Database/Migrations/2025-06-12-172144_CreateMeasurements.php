<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateMeasurements extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT'],

            'moment' => ['type' => 'ENUM', 'constraint' => ['cafe_da_manha', 'almoco', 'lanche_da_tarde', 'jantar']],

            // Medição antes do momento
            'before_level' => ['type' => 'INT', 'null' => true],
            'before_time' => ['type' => 'DATETIME', 'null' => true],

            // Medição após o momento
            'after_level' => ['type' => 'INT', 'null' => true],
            'after_time' => ['type' => 'DATETIME', 'null' => true],

            // Doses de insulina
            'insulin_regular' => ['type' => 'INT', 'null' => true],
            'insulin_nph' => ['type' => 'INT', 'null' => true],

            // Glicemia ao deitar (independente do momento do dia)
            'bedtime_level' => ['type' => 'INT', 'null' => true],

            // Observações
            'observation' => ['type' => 'TEXT', 'null' => true],

            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('moment');
        $this->forge->addKey('user_id');
        $this->forge->addKey('created_at');
        $this->forge->addKey(['user_id', 'moment']);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('measurements');
    }

    public function down()
    {
        $this->forge->dropTable('measurements');
    }
}
