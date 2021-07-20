<?php

namespace HDSSolutions\Laravel\Traits;

use HDSSolutions\Laravel\Models\Base\User;
use Illuminate\Support\Facades\DB;

trait HasIdentity {

    private static $identityClazz;

    public static function bootHasIdentity() {
        // load custom identity class or set User as default
        self::$identityClazz = self::$identityClass ?? User::class;
    }

    public final function identity() {
        // link with identity class
        return $this->hasOne(self::$identityClazz, (new self::$identityClazz)->getKeyName());
    }

    public final function getIdentityAttribute() {
        // autoload identity
        if (!$this->relationLoaded('identity'))
            // load empty identity
            $this->setRelation('identity', $this->identity()->first() ?? new self::$identityClazz);
        // return identity
        return $this->relations['identity'];
    }

    public function fill(array $attributes) {
        // check empty values
        if (count($attributes) == 0) return $this;
        // fill identity attributes
        $this->identity->fill( $attributes );
        // fill local attributes
        return parent::fill( $attributes );
    }

    public function save(array $options = []) {
        // create a transaction
        DB::beginTransaction();
        // check if is new model and id is set (called from identity()->make() probably)
        if (!$this->exists && $this->id !== null) {
            // save current identity attributes
            $identityAttrs = $this->identity->attributes;
            // reload identity
            $this->setRelation('identity', $this->identity()->first());
            // fill identity with original attributes
            $this->identity->fill($identityAttrs);
        }
        // save identity
        if (!$this->identity->save($options)) return false;
        // check if is a new object and link with identity
        if (!$this->exists) $this->{$this->getKeyName()} = $this->identity->{$this->identity->getKeyName()};
        // save local
        if (!parent::save($options)) return false;
        // confirm transaction
        DB::commit();
        // return true
        return true;
    }

    public function delete(bool $with_identity = true) {
        // create a transaction
        DB::beginTransaction();
        // delete local
        if (!parent::delete()) return false;
        // delete identity
        if ($with_identity && !$this->identity->delete()) return false;
        // confirm transaction
        DB::commit();
        // success deletion
        return true;
    }
}
