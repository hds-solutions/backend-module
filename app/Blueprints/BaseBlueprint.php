<?php

namespace HDSSolutions\Laravel\Blueprints;

use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Schema\Grammars\Grammar;
use Illuminate\Support\Str;

class BaseBlueprint extends Blueprint {
    private bool $softDeletes = true;

    public function asPivot(bool $asPivot = true) {
        $this->softDeletes = $this->softDeletes && !$asPivot;
    }

    public function withSoftDeletes(bool $softDeletes = true) {
        $this->softDeletes = $this->softDeletes && $softDeletes;
    }

    public function withoutSoftDeletes() {
        $this->withSoftDeletes(false);
    }

    public function build(Connection $connection, Grammar $grammar) {
        // check if table is creating
        if ($this->creating()) {
            // add created/updated/deleted
            $this->timestamps();
            // check if softDeletes flag
            if ($this->softDeletes) $this->softDeletes();
        }
        // return parent builder
        return parent::build($connection, $grammar);
    }

    public function coords() {
        return $this->encapsulated(
            $this->decimal('latitude', 10, 8), // ±90
            $this->decimal('longitude', 11, 8), // ±180
        );
    }

    private function encapsulated(...$fields) {
        return new class($fields) {
            private array $fields;
            function __construct(array $fields) { $this->fields = $fields; }
            function __call(string $method, array $arguments) {
                // redirect call to fields
                foreach ($this->fields as $field) call_user_func_array([ $field, $method ], $arguments);
            }
        };
    }

    public function priority() {
        return $this->unsignedInteger('priority');
    }

    public function foreignTo(string $table, string $column = null, string $onDelete = 'restrict') {
        // force table name to plural
        $table = Str::snake( Str::pluralStudly($table) );
        // build column name in singular form
        $column = $column !== null ? $column : Str::singular($table).'_id';
        // add column on table
        $field = $this->unsignedBigInteger($column);
        // add foreign
        $this->foreign($column)->references('id')->on($table)
            // set ON DELETE action
            ->onDelete($onDelete);
        // return created field
        return $field;
    }

    public function dropForeignTo(string $table, string $column) {
        // force table name to plural
        $table = Str::snake( Str::pluralStudly($table) );
        // build column name in singular form
        $column = $column !== null ? $column : Str::singular($table).'_id';
        // remove foreign
        $this->dropForeign($this->table.'_'.$column.'_foreign');
        // remove column
        $this->dropColumn($column);
    }

    public function amount(string $column = null, int $total = 20, int $decimals = 0, bool $signed = false) {
        return $this->{$signed ? 'decimal' : 'unsignedDecimal'}($column ?? 'amount', $total, $decimals);
    }

    public function createdUpdatedBy() {
        $fields = $this->encapsulated(
            $this->unsignedBigInteger('createdby')->comment('Usuario que creo el registro'),
            $this->unsignedBigInteger('updatedby')->comment('Usuario que actualizo el registro'),
        );
        $this->foreign('createdby')->references('id')->on('users');
        $this->foreign('updatedby')->references('id')->on('users');
        return $fields;
    }

    public function asDocument() {
        $this->char('document_status', 2)->default('DR');
        $this->timestamp('document_approved_at')->nullable();
        $this->timestamp('document_rejected_at')->nullable();
        $this->timestamp('document_completed_at')->nullable();
        $this->timestamp('document_closed_at')->nullable();
    }

    public function morphable($name = null) {
        return $this->morphs( Str::singular( $name ?? $this->table ).'able' );
    }

    // @override
    public function morphs($name, $indexName = null) {
        // return lodal overrides to allow encapsulation
        return Builder::$defaultMorphKeyType === 'uuid'
            ? $this->uuidMorphs($name, $indexName)
            : $this->numericMorphs($name, $indexName);
    }

    // @override
    public function uuidMorphs($name, $indexName = null) {
        // create fields with encapsulation
        $fields = $this->encapsulated(
            $this->string("{$name}_type"),
            $this->uuid("{$name}_id"),
        );
        // add index
        $this->index(["{$name}_type", "{$name}_id"], $indexName);
        // return fields
        return $fields;
    }

    // @override
    public function numericMorphs($name, $indexName = null) {
        // create fields with encapsulation
        $fields = $this->encapsulated(
            $this->string("{$name}_type"),
            $this->unsignedBigInteger("{$name}_id"),
        );
        // add index
        $this->index(["{$name}_type", "{$name}_id"], $indexName);
        // return fields
        return $fields;
    }

}
