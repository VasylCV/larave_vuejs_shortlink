<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateShortLinkAPIRequest;
use App\Http\Requests\API\UpdateShortLinkAPIRequest;
use App\Models\ShortLink;
use App\Repositories\ShortLinkRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Response;

/**
 * Class ShortLinkController
 * @package App\Http\Controllers\API
 */

class ShortLinkAPIController extends AppBaseController
{
    /** @var  ShortLinkRepository */
    private $shortLinkRepository;

    public function __construct(ShortLinkRepository $shortLinkRepo)
    {
        $this->shortLinkRepository = $shortLinkRepo;
    }

    /**
     * Get full link
     * GET|HEAD /shortLinks
     *
     * @param Request $request
     * @return Response
     */
    public function getLink(Request $request)
    {
        if (isset($request->param)) {
            $fullPath = $this->shortLinkRepository->getFullByShortPath($request->param);

            if ($fullPath) {
                return $this->sendResponse($fullPath, 'Redirect');
            }
        }

        return $this->sendError('Something went wrong, please try again', 402);
    }

    /**
     * Store a newly created ShortLink in storage.
     * POST /shortLinks
     *
     * @param CreateShortLinkAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateShortLinkAPIRequest $request)
    {
        $input = $request->all();

        $shortLink = $this->shortLinkRepository->store($input);

        if (!$shortLink) {
            return $this->sendError('Something went wrong, please try again', 402);
        }

        return $this->sendResponse($shortLink, 'Short Link saved successfully');
    }
}
