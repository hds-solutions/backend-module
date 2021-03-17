<?php

namespace HDSSolutions\Finpar\Processes;

use HDSSolutions\Finpar\Interfaces\Document;
use HDSSolutions\Finpar\Traits\HasDocumentActions;
use Illuminate\Support\Collection;
use ReflectionClass;

final class DocumentEngine implements Document {
    use HasDocumentActions;

    private static $constants = [];

    private Document $document;
    private string $document_status;

    public function __construct(Document $document) {
        // save document
        $this->document = $document;
        // save current document status
        $this->document_status = $this->document->document_status;
    }

    public static function __(string $status, string $type = 'status'):string {
        // load constants
        if (self::$constants == []) self::$constants = (new ReflectionClass(self::class))->getConstants();
        // find status
        foreach (self::$constants as $constant => $value)
            // check on STATUS constants
            if (preg_match('/'.strtoupper($type).'_.*/', $constant) && $status == $value)
                // return constant name
                return __('backend::document.'.$type.'.'.preg_replace('/'.strtoupper($type).'_/', '', $constant) );
        // return status name
        return __( self::STATUS_Unknown );
    }

    public function processIt(string $action):bool {
        // validate action
        if (!$this->isValidAction($action)) return $this->documentError( 'Invalid action '.self::__($action, 'action').' for current document status' ) && false;
        // check if action is prepareIt
        if ($action == Document::ACTION_Prepare)
            // execute prepareIt, new status must be InProgress
            return $this->prepareIt() == Document::STATUS_InProgress;
        // check if action is approveIt
        if ($action == Document::ACTION_Approve) {
            // check if document needs to be prepared (current status: Draft or Invalid)
            if ($this->document->isDrafted() || $this->document->isInvalid())
                // prepareIt
                if ($this->prepareIt() !== Document::STATUS_InProgress) return false;
            // execute approveIt
            return $this->approveIt();
        }
        // check if action is rejectIt
        if ($action == Document::ACTION_Reject)
            // execute rejectIt
            return $this->rejectIt();
        // check if action is completeIt
        if ($action == Document::ACTION_Complete) {
            // check if document needs to be prepared (current status: Draft or Invalid)
            if ($this->document->isDrafted() || $this->document->isInvalid())
                // prepareIt
                if ($this->prepareIt() !== Document::STATUS_InProgress) return false;
            // execute completeIt, new status must be InProgress or Completed
            return in_array($this->completeIt(), [ Document::STATUS_InProgress, Document::STATUS_Completed ]);
        }
        // check if action is closeIt
        if ($action == Document::ACTION_Close)
            // execute closeIt
            return $this->closeIt() == Document::STATUS_Closed;
        // check if action is reOpenIt
        if ($action == Document::ACTION_ReOpen)
            // execute reOpenIt
            return $this->reOpenIt();
        // invalid action, return false
        return $this->documentError( 'Unknown action: '.$action ) && false;
    }

    public function documentError(?string $message = null):string {
        // redirect to document
        return $this->document->documentError($message);
    }

    private function isValidAction(string $action):bool {
        // check if action is valid for current document status
        return $this->getAvailableActions()->contains( $action );
    }

    private function getAvailableActions():Collection {
        // available actions
        $actions = collect();
        // valid statuses for prepareIt
        if ($this->document->isDrafted() || $this->document->isInProgress() ||
            $this->document->isInvalid())
            // enable prepareIt action
            $actions->push( Document::ACTION_Prepare );
        // valid statuses for completeIt
        if ($this->document->isDrafted() || $this->document->isInProgress() ||
            $this->document->isApproved())
            // enable completeIt action
            $actions->push( Document::ACTION_Complete );
        // valid statuses for approveIt
        if ($this->document->isDrafted() || $this->document->isInProgress() ||
            $this->document->isRejected() || $this->document->isApproved())
            // enable approveIt action
            $actions->push( Document::ACTION_Approve );
        // valid statuses for rejectIt
        if ($this->document->isInProgress() ||
            $this->document->isApproved() || $this->document->isRejected())
            // enable rejectIt action
            $actions->push( Document::ACTION_Reject );
        // valid statuses for closeIt
        if ($this->document->isCompleted())
            // enable closeIt action
            $actions->push( Document::ACTION_Close );
        // valid statuses for reOpenIt
        if ($this->document->isClosed())
            // enable reOpenIt action
            $actions->push( Document::ACTION_ReOpen );
        // return available actions
        return $actions;
    }

    protected function prepareIt():?string {
        // prepare document, update and return status
        return $this->document->document_status = $this->document->prepareIt();
    }

    protected function approveIt():bool {
        // approve document
        if ($approved = $this->document->approveIt())
            // update status
            $this->document->document_status = Document::STATUS_Approved;
        // return status
        return $approved;
    }

    protected function rejectIt():bool {
        // reject document
        if ($rejected = $this->document->rejectIt())
            // update status
            $this->document->document_status = Document::STATUS_Rejected;
        // return status
        return $rejected;
    }

    protected function completeIt():?string {
        // complete document, update and return status
        return $this->document->document_status = $this->document->completeIt();
    }

    protected function closeIt():?string {
        // close document, update and return status
        return $this->document->document_status = $this->document->closeIt() ?? $this->document->document_status;
    }

    protected function reOpenIt():bool {
        // reOpen document
        return $this->document->reOpenIt();
    }

}
