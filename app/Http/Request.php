<?php

namespace HDSSolutions\Laravel\Http;

class Request extends \Illuminate\Http\Request {

    public function remove($parameter) {
        if (is_array($parameter))
            foreach ($parameter as $key)
                $this->request->remove($key);
        else
            $this->request->remove($parameter);
    }

}
