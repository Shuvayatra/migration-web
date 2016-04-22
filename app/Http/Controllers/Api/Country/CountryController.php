<?php

namespace App\Http\Controllers\Api\Country;

use App\Nrna\Services\CountryService;
use App\Nrna\Transformer\CountryTransformer;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use EllipseSynergie\ApiResponse\Laravel\Response;
use Illuminate\Http\Request;

class CountryController extends ApiGuardController
{
    /**
     * @var CountryService
     */
    private $country;

    protected $apiMethods = [
        'index' => [
            'keyAuthentication' => false,
        ],
    ];

    /**
     * @param CountryService $country
     * @param Response       $response
     */
    public function __construct(CountryService $country, Response $response)
    {
        parent::__construct();
        $this->middleware('storeApiLog');
        $this->country  = $country;
        $this->response = $response;
    }

    /**
     * latest context pull api.
     *
     * @param  Request $request
     * @return json
     */
    public function index(Request $request)
    {
        $countries = $this->country->all();

        return $this->response->withCollection($countries, new CountryTransformer());
    }
}
