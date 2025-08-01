<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTables extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'liter' => [
                'type' => 'FLOAT',
            ],
            'km' => [
                'type' => 'INT',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('konsumsi_bbm');

        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'tanggal' => [
                'type' => 'DATE',
            ],
            'km' => [
                'type' => 'INT',
            ],
            'jenis_oli' => [
                'type' => 'VARCHAR',
                'constraint' => '50',
            ],
            'harga_oli' => [
                'type' => 'FLOAT',
            ],
            'jadwal_berikutnya' => [
                'type' => 'INT',
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('konsumsi_oli');
    }

    public function down()
    {
        $this->forge->dropTable('konsumsi_bbm');
        $this->forge->dropTable('konsumsi_oli');
    }
}
