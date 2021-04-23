<?php

namespace HDSSolutions\Finpar\Traits;

use HDSSolutions\Finpar\Models\Base\User;
use HDSSolutions\Finpar\Models\Person;
use Illuminate\Support\Facades\DB;

trait ExtendsPerson {
    use HasIdentity;

    protected static $identityClass = Person::class;

    public static function bootExtendsPerson() {
        self::retrieved(fn($model) => $model->appends = $model->appends + [ 'full_name' ]);
    }

    public function getFullNameAttribute():string {
        return $this->business_name ?? ($this->lastname !== null ? $this->lastname.', ' : '').$this->firstname;
    }

    public function getFirstnameAttribute() {
        return $this->identity->firstname;
    }

    public function setFirstnameAttribute($value) {
        $this->identity->firstname = $value;
    }

    public function getLastnameAttribute() {
        return $this->identity->lastname;
    }

    public function setLastnameAttribute($value) {
        $this->identity->lastname = $value;
    }

    public function getDocumentnoAttribute() {
        return $this->identity->documentno;
    }

    public function setDocumentnoAttribute($value) {
        $this->identity->documentno = $value;
    }

    public function getEmailAttribute() {
        return $this->identity->email;
    }

    public function setEmailAttribute($value) {
        $this->identity->email = $value;
    }

    public function getPhoneAttribute() {
        return $this->identity->phone;
    }

    public function setPhoneAttribute($value) {
        $this->identity->phone = $value;
    }

    public function getGenderAttribute() {
        return $this->identity->gender;
    }

    public function setGenderAttribute($value) {
        $this->identity->gender = $value;
    }

}
