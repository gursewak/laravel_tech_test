<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Neomerx\JsonApi\Encoder\Encoder;

class BaseController extends Controller
{

    public function generateData($model, $schemas = [], $included = [])
    {
        $encoder = Encoder::instance($schemas)
            // ->withUrlPrefix('http://example.com/api/v1')
            ->withEncodeOptions(JSON_PRETTY_PRINT);

        if (!empty($included)) {
            $encoder->withIncludedPaths($included);
        }



        return $encoder->encodeData($model);
    }
}
