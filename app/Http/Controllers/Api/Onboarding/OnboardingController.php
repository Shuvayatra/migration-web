<?php
namespace App\Http\Controllers\Api\Onboarding;

use App\Nrna\Models\Onboarding;
use Chrisbjr\ApiGuard\Http\Controllers\ApiGuardController;
use EllipseSynergie\ApiResponse\Laravel\Response;
use Illuminate\Http\Request;
use Jenssegers\Agent\Facades\Agent;

class OnboardingController extends ApiGuardController
{

    protected $apiMethods = [
        'save' => [
            'keyAuthentication' => false,
        ],
    ];

    public function __construct(Response $response)
    {
        parent::__construct();
    }

    public function save(Request $request)
    {
        $valid = \Validator::make($request->all(), Onboarding::$rules);
        if ($valid->fails()) {
            return $this->response->setStatusCode(422)->withArray(
                [
                    'message' => 'validation_fail',
                    'errors'  => $valid->errors(),
                ]
            );
        }
        $data['metadata'] = $request->all();
        if (Agent::isDesktop()) {
            $data['device_type'] = 'desktop';
        } else {
            $data['device_type'] = 'mobile';
        }

        if (!Onboarding::create($data)) {
            $this->response->errorInternalError('problem adding data.');
        }

        return $this->response->setStatusCode(200)->withArray(['success' => true]);
    }
}