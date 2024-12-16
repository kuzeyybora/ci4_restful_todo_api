<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateTranslationsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'language_code' => [
                'type' => 'VARCHAR',
                'constraint' => '10',
            ],
            'key_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'value' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'status_code' => [
                'type' => 'TEXT',
            ],
            'created_at' => [
                'type'       => 'TIMESTAMP',
                'null'       => true,
                'default'    => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type'       => 'TIMESTAMP',
                'null'       => true,
                'default'    => new RawSql('CURRENT_TIMESTAMP'),
                'on_update'  => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('translations');
    }

    public function down()
    {
        $this->forge->dropTable('translations');
    }
}
