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
        //
        self::retrieved(fn($model) => $model->appends = $model->appends + [ 'document_status_pretty' ]);
        //
        self::deleting(function($model) {
            // check if model is already completed
            if ($model->isProcessed()) {
                // save error message
                $model->documentError('This document can\'t be deleted because is already processed');
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

    public final function getDocumentStatusPrettyAttribute():string {
        // return translated status
        return DocumentEngine::__( $this->document_status );
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
        // prevent error message duplication
        if (($this->document_error ?? false) !== $message)
            // register error log, TODO: backtrace to method (?)
            logger(class_basename(static::class).' got document error "'.($message ?? 'null').'"');
        // save error
        $this->document_error = $message;
        // return invalid document status
        return Document::STATUS_Invalid;
    }

    public function getDocumentError():?string {
        // return saved document error
        return $this->document_error ?? null;
    }

    public final function scopeStatus(Builder $query, string|array $statuses, bool $whereIn = true) {
        // force array
        $statuses = is_array($statuses) ? $statuses : [ $statuses ];
        // filter statuses
        return $query->{$whereIn ? 'whereIn' : 'whereNotIn'}($this->getTable().'.document_status', $statuses);
    }

    public final function scopeDrafted(Builder $query, bool $matches = true) {
        // filter documents
        return $this->scopeStatus($query,
            // where status matches
            Document::STATUS_Draft,
            // redirect whereIn flag
            whereIn: $matches);
    }

    public final function isDrafted():bool {
        // return if document is drafted
        return $this->document_status == Document::STATUS_Draft;
    }

    public final function getIsDraftedAttribute():bool {
        // return method result
        return $this->isDrafted();
    }

    public final function scopeInProgress(Builder $query, bool $matches = true) {
        // filter documents
        return $this->scopeStatus($query,
            // where status matches
            Document::STATUS_InProgress,
            // redirect whereIn flag
            whereIn: $matches);
    }

    public final function isInProgress():bool {
        // return if document is in progress
        return $this->document_status == Document::STATUS_InProgress;
    }

    public final function getIsInProgressAttribute():bool {
        // return method result
        return $this->isInProgress();
    }

    public final function scopeApproved(Builder $query, bool $matches = true) {
        // filter documents
        return $this->scopeStatus($query,
            // where status matches
            Document::STATUS_Approved,
            // redirect whereIn flag
            whereIn: $matches);
    }

    public final function isApproved():bool {
        // return if document is in progress
        return $this->document_status == Document::STATUS_Approved;
    }

    public final function getIsApprovedAttribute():bool {
        // return method result
        return $this->isApproved();
    }

    public final function scopeRejected(Builder $query, bool $matches = true) {
        // filter documents
        return $this->scopeStatus($query,
            // where status matches
            Document::STATUS_Rejected,
            // redirect whereIn flag
            whereIn: $matches);
    }

    public final function isRejected():bool {
        // return if document is in progress
        return $this->document_status == Document::STATUS_Rejected;
    }

    public final function getIsRejectedAttribute():bool {
        // return method result
        return $this->isRejected();
    }

    public final function scopeInvalid(Builder $query, bool $matches = true) {
        // filter documents
        return $this->scopeStatus($query,
            // where status matches
            Document::STATUS_Invalid,
            // redirect whereIn flag
            whereIn: $matches);
    }

    public final function isInvalid():bool {
        // return if document is invalid
        return $this->document_status == Document::STATUS_Invalid;
    }

    public final function getIsInvalidAttribute():bool {
        // return method result
        return $this->isInvalid();
    }

    public final function scopeCompleted(Builder $query, bool $matches = true) {
        // filter documents
        return $this->scopeStatus($query,
            // where status matches
            Document::STATUS_Completed,
            // redirect whereIn flag
            whereIn: $matches);
    }

    public final function isCompleted():bool {
        // return if document is completed
        return $this->document_status == Document::STATUS_Completed;
    }

    public final function getIsCompletedAttribute():bool {
        // return method result
        return $this->isCompleted();
    }

    public final function scopeClosed(Builder $query, bool $matches = true) {
        // filter documents
        return $this->scopeStatus($query,
            // where status matches
            Document::STATUS_Closed,
            // redirect whereIn flag
            whereIn: $matches);
    }

    public final function isClosed():bool {
        // return if document is closed
        return $this->document_status == Document::STATUS_Closed;
    }

    public final function getIsClosedAttribute():bool {
        // return method result
        return $this->isClosed();
    }

    public function scopeOpen(Builder $query) {
        // filter documents
        return $this->scopeStatus($query,
            // where status aren't Completed or Closed
            [ Document::STATUS_Rejected, Document::STATUS_Completed, Document::STATUS_Closed ],
            // negation (WHERE NOT IN)
            whereIn: false);
    }

    public final function isOpen():bool {
        // return if document is open
        return $this->isDrafted() || $this->isInProgress() ||
            $this->isApproved() || /*$this->isRejected() ||*/
            $this->isInvalid();
    }

    public final function getIsOpenAttribute():bool {
        // return method result
        return $this->isOpen();
    }

    public function scopeProcessed(Builder $query) {
        // filter documents
        return $this->scopeStatus($query,
            // where status are Completed or Closed
            [ Document::STATUS_Rejected, Document::STATUS_Completed, Document::STATUS_Closed ]);
    }

    public final function isProcessed():bool {
        // return if document is already processed
        return $this->isRejected() || $this->isCompleted() || $this->isClosed();
    }

    public final function getIsProcessedAttribute():bool {
        // return method result
        return $this->isProcessed();
    }

}
