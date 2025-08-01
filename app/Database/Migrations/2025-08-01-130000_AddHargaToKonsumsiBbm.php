<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddHargaToKonsumsiBbm extends Migration
{
    public function up()
    {
        $fields = [
            'harga' => ['type' => 'FLOAT', 'null' => true, 'after' => 'liter'],
            'total' => ['type' => 'FLOAT', 'null' => true, 'after' => 'harga'],
        ];
        $this->forge->addColumn('konsumsi_bbm', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('konsumsi_bbm', ['harga', 'total']);
    }
}
