<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCategories extends Migration
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
            'name' => [
                'type' => 'VARCHAR', 
                'constraint' => 50
            ],
            'status' => [
                'type' => 'ENUM', 
                'constraint' => ['active', 'inactive'], 
                'default' => 'active'
            ],
            'created_at' => [
                'type' => 'DATETIME'
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('categories');
    }

    public function down()
    {
        $this->forge->dropTable('categories');
    }
}
