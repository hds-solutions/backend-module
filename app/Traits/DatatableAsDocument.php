<?php

namespace HDSSolutions\Laravel\Traits;

use HDSSolutions\Laravel\Processes\DocumentEngine as Document;
use Illuminate\Database\Eloquent\Builder;

trait DatatableAsDocument {

    protected final function orderDocumentStatus(Builder $query, string $order):Builder {
        // get an array of available Document.statuses
        $statuses = Document::STATUSES;
        // check if order is inverted
        if ($order === 'desc') $statuses = array_reverse($statuses);
        // set custom order for Document.status
        return $query->orderByRaw('FIELD('.$this->getDocumentStatusColumnName().', "'.implode('", "', $statuses).'")');
    }

    protected final function orderDocumentStatusPretty(Builder $query, string $order):Builder {
        // alias to document_status order
        return $this->orderDocumentStatus($query, $order);
    }

    protected final function searchDocumentStatus(Builder $query, string $value):Builder {
        $matches = [];
        // check if value matches some document status string
        foreach (Document::STATUSES as $status)
            // check if status code or status translation matches
            if ( stripos($status, $value) !== false || stripos(Document::__($status), $value) !== false )
                // add status to matches
                $matches[] = $status;

        // filter query with matched statuses
        return count($matches) ? $query->whereIn($this->getDocumentStatusColumnName(), $matches) : $query;
    }

    protected final function searchDocumentStatusPretty(Builder $query, string $value):Builder {
        // alias to document_status search
        return $this->searchDocumentStatus($query, $value);
    }

    protected final function filterDocumentStatus(Builder $query, $status):Builder {
        // filter only with document status
        return $query->where($this->getDocumentStatusColumnName(), $status);
    }

    protected function getDocumentStatusColumnName():string {
        // return default column name
        return ($resource = new $this->resource)->getTable().'.document_status';
    }

}
