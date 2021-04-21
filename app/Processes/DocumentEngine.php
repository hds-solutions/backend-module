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

    public static function __(string $status, string $type = 'status', $translate = true):string {
        // load constants
        if (self::$constants == []) self::$constants = (new ReflectionClass(self::class))->getConstants();
        // find status
        foreach (self::$constants as $constant => $value)
            // check on STATUS constants
            if (preg_match('/'.strtoupper($type).'_.*/', $constant) && $status == $value)
                // check if returned value must be translated
                return $translate
                    // return constant translation
                    ? __('backend::document.'.$type.'.'.preg_replace('/'.strtoupper($type).'_/', '', $constant) )
                    // return constant name
                    : $constant;
        // return status name
        return __( self::STATUS_Unknown );
    }

    public function processIt(string $action):bool {
        $this->logger('processIt', $this->__($action, 'action', false), false);
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

    // @override
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
            $this->document->isInvalid() ||
            // allow re-execution of prepareIt() when document is approved or rejected
            $this->document->isApproved() || $this->document->isRejected())
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

    protected function prepareIt():?string { $this->logger('prepareIt');
        // validate new status received from document prepareIt process
        if (!in_array(($status = $this->document->prepareIt()), Document::STATUSES))
            // return invalid new status
            return $this->documentError( $this->document->getDocumentError() ?: __('backend::document.invalid-status') );
        // register document status change
        $this->logDocumentStatusChange( $status );
        // prepare document, update and return status
        return $this->document->document_status = $status;
    }

    protected function approveIt():bool { $this->logger('approveIt');
        // approve document
        if ($approved = $this->document->approveIt()) {
            // register document status change
            $this->logDocumentStatusChange( Document::STATUS_Approved );
            // update status
            $this->document->document_status = Document::STATUS_Approved;
            // set approved timestamp
            $this->document->document_approved_at = now();
            // remove rejected timestamp
            $this->document->document_rejected_at = null;
        }
        // return status
        return $approved;
    }

    protected function rejectIt():bool { $this->logger('rejectIt');
        // reject document
        if ($rejected = $this->document->rejectIt()) {
            // register document status change
            $this->logDocumentStatusChange( Document::STATUS_Rejected );
            // update status
            $this->document->document_status = Document::STATUS_Rejected;
            // set rejected timestamp
            $this->document->document_rejected_at = now();
            // remove approved timestamp
            $this->document->document_approved_at = null;
        }
        // return status
        return $rejected;
    }

    protected function completeIt():?string { $this->logger('completeIt');
        // validate new status received from document completeIt process
        if (!in_array(($status = $this->document->completeIt()), Document::STATUSES))
            // return invalid new status
            return $this->documentError( $this->document->getDocumentError() ?: __('backend::document.invalid-status') );
        // register document status change
        $this->logDocumentStatusChange( $status );
        // set completed timestamp
        if ($status == Document::STATUS_Completed) $this->document->document_completed_at = now();
        // complete document, update and return status
        return $this->document->document_status = $status;
    }

    protected function closeIt():?string { $this->logger('closeIt');
        // validate new status received from document closeIt process
        if (in_array(($status = $this->document->closeIt()), Document::STATUSES)) {
            // register document status change
            $this->logDocumentStatusChange( $status );
            // update document status
            $this->document->document_status = $status;
        }
        // set closed timestamp
        if ($status == Document::STATUS_Closed) $this->document->document_closed_at = now();
        // return document status
        return $this->document->document_status;
    }

    protected function reOpenIt():bool { $this->logger('reOpenIt');
        // reOpen document
        if ($opened = $this->document->reOpenIt())
            // register document status change
            $this->logDocumentStatusChange( from_from: Document::STATUS_Closed, to_status: $this->document->document_status );
        // return process status
        return $opened;
    }

    private function logDocumentStatusChange(?string $to_status = null, ?string $from_status = null) {
        // create a new DocumentLog
        $this->document->documentLogs()->create([
            // link document
            'document_loggable_type'    => get_class($this->document),
            'document_loggable_id'      => $this->document->getKey(),
            // set status change
            'from_status'   => $from_status ?? $this->document->document_status,
            'to_status'     => $to_status,
            // register user
            'createdby'     => auth()->user()->id,
            'updatedby'     => auth()->user()->id,
        ]);
    }

    private function logger(string $action, ?string $args = null, bool $document = true) {
        logger(__( class_basename(self::class).':::action(:args) '.($document ? 'on :document#:id' : '[:document#:id]'), [
            'action'    => $action,
            'args'      => $args ?? '',
            'document'  => class_basename( get_class($this->document) ),
            'id'        => $this->document->getKey(),
        ]));
    }

}
