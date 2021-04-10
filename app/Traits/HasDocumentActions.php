<?php

namespace HDSSolutions\Finpar\Traits;

use HDSSolutions\Finpar\Interfaces\Document;
use HDSSolutions\Finpar\Processes\DocumentEngine;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator as Validator_Factory;

trait HasDocumentActions {

    protected bool $document_enableCloseIt = false;

    private ?string $document_error;

    public static function bootHasDocumentActions() {
        self::deleting(function($model) {
            // check if model is already completed
            if ($model->isCompleted()) {
                // save error message
                $model->documentError('This document can\'t be deleted because is already completed');
                // return false
                return false;
            }
        });
    }

    public abstract function prepareIt():?string;

    public function approveIt():bool { return false; }

    public function rejectIt():bool { return false; }

    public abstract function completeIt():?string;

    public function closeIt():?string { $this->documentError('This document can\'t be closed'); return null; }

    public function reOpenIt():bool { return false; }

    public final function canCloseIt():bool {
        return $this->document_enableCloseIt;
    }

    public final function getDocumentStatusAttribute():string {
        // return current document status
        return in_array($this->attributes['document_status'], Document::STATUSES) ? $this->attributes['document_status'] : Document::STATUS_Unknown;
    }

    public final function setDocumentStatusAttribute(string $status):void {
        // validate status
        if (!in_array($status, Document::STATUSES)) return;
        // set document status
        $this->attributes['document_status'] = $status;
    }

    public function processIt(string $action):bool {
        // check valid action
        if (!in_array($action, Document::ACTIONS)) return false;
        // process document through document engine
        if (!(new DocumentEngine($this))->processIt($action)) return false;
        // save document
        return $this->save();
    }

    public function documentError(?string $message = null):string {
        // save error
        $this->document_error = $message;
        // return invalid document status
        return Document::STATUS_Invalid;
    }

    public function getDocumentError():?string {
        // return saved document error
        return $this->document_error ?? 'Unknown error';
    }

    public final function scopeStatus(Builder $query, string|array $statuses, bool $whereIn = true) {
        // force array
        $statuses = is_array($statuses) ? $statuses : [ $statuses ];
        // filter statuses
        return $query->{$whereIn ? 'whereIn' : 'whereNotIn'}('document_status', $statuses);
    }

    public final function isDrafted():bool {
        // return if document is drafted
        return $this->document_status == Document::STATUS_Draft;
    }

    public final function isInProgress():bool {
        // return if document is in progress
        return $this->document_status == Document::STATUS_InProgress;
    }

    public final function isApproved():bool {
        // return if document is in progress
        return $this->document_status == Document::STATUS_Approved;
    }

    public final function isRejected():bool {
        // return if document is in progress
        return $this->document_status == Document::STATUS_Rejected;
    }

    public final function isInvalid():bool {
        // return if document is invalid
        return $this->document_status == Document::STATUS_Invalid;
    }

    public final function isCompleted():bool {
        // return if document is completed
        return $this->document_status == Document::STATUS_Completed;
    }

    public final function isClosed():bool {
        // return if document is closed
        return $this->document_status == Document::STATUS_Closed;
    }

}
