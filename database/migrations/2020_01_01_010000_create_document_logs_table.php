<?php

use HDSSolutions\Finpar\Blueprints\BaseBlueprint as Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateDocumentLogsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        // get schema builder
        $schema = DB::getSchemaBuilder();

        // replace blueprint
        $schema->blueprintResolver(fn($table, $callback) => new Blueprint($table, $callback));

        // create table
        $schema->create('document_logs', function(Blueprint $table) {
            $table->id();
            $table->morphable('document_logg');
            $table->string('action');
            $table->char('from_status', 2);
            $table->char('to_status', 2);
            $table->text('message')->nullable();
            $table->createdUpdatedBy();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('document_logs');
    }
}
