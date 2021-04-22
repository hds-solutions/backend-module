<?php

namespace HDSSolutions\Finpar\Helpers;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Sheet;

class SheetReader implements WithEvents {

    public function __construct(
        private ?Collection $sheets = null,
    ) {
        $this->sheets = collect();
    }

    public function registerEvents():array {
        return [
            // register before sheet event
            BeforeSheet::class => fn(BeforeSheet $event) =>
                // save sheets title
                $this->sheets->put( $event->getSheet()->getTitle(), $event->getSheet() ),
        ];
    }

    public function getSheet(int $idx):?Sheet {
        return $this->sheets->get( $this->sheets->keys()->get($idx) );
    }

    public function getSheetTitle(int $idx):?string {
        return $this->sheets->keys()->get($idx);
    }

}
