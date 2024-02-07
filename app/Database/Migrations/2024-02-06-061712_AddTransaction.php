<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTransaction extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT', 
                'constraint' => 5, 
                'unsigned' => true, 
                'auto_increment' => true
            ],
            'product_id' => [
                'type' => 'INT', 
                'constraint' => 5, 
                'unsigned' => true
            ],
            'trx_date' => ['type' => 'DATE'],
            'price' => ['type' => 'INT'],
            'created_at' => ['type' => 'DATETIME']
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('transactions');
    }

    public function down()
    {
        $this->forge->dropTable('transactions');
    }
}
