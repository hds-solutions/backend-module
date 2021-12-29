<?php

use HDSSolutions\Laravel\Blueprints\BaseBlueprint as Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateUserCompanyTable extends Migration {

    public function up() {
        // get schema builder
        $schema = DB::getSchemaBuilder();

        // replace blueprint
        $schema->blueprintResolver(fn($table, $callback) => new Blueprint($table, $callback));

        // create table
        $schema->create('company_user', function(Blueprint $table) {
            $table->asPivot();
            $table->foreignTo('User');
            $table->foreignTo('Company');
            $table->primary([ 'user_id', 'company_id' ]);
        });
    }

    public function down() {
        Schema::dropIfExists('company_user');
    }
}
