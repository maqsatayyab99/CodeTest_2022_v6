<?php

namespace DTApi\Http\Controllers;

use DTApi\Models\Job;
use DTApi\Models\Distance;
use Illuminate\Http\Request;

/**
 * Class BookingController
 * @package DTApi\Http\Controllers
 */
class BookingController extends BaseController
{

    protected BaseServiceContract $service;

    /**
    *  BookingController constructor.
    *
    * @param BaseServiceContract $service The service contract for handling agencies.
    */
    public function __construct(BaseServiceContract $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(GetJobsRequest $request): JsonResponse
    {
        return $this->tryCatch(function () use ($request) {
            $response = $this->service->getUsersJobs($request->validated());
            return response($response);
        });
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $this->validateId($id, 'App\Models\Jobs');
        return $this->tryCatch(function () use ($id) {
            // Load the necessary relationships
            $relations = $this->loadJobRelationships();
            $job = $this->service->find($id, $relations);
            return response($job);
        });
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        return $this->tryCatch(function () use ($request) {
            // Validate the request data
            $validatedData = $request->validated();
            // Store data in the database
            $response = $this->service->store($validatedData);
            return response($response);
        });
    }

    /**
     * @param $id
     * @param Request $request
     * @return mixed
     */
    public function update($id, Request $request)
    {
        $this->validateId($id, 'App\Models\Jobs');

        return $this->tryCatch(function () use ($request, $id) {
            $response = $this->service->update($id, $request->validated());        
            return response($response);
        });
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function immediateJobEmail(Request $request)
    {
        return $this->tryCatch(function () use ($request) {
            // Validate the request data
            $validatedData = $request->validated();
            // Store data in the database
            $response = $this->service->storeJobEmail($validatedData);
            return response($response);
        });
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getHistory(Request $request)
    {
        return $this->tryCatch(function () use ($request) {
            $response = $this->service->getUsersJobsHistory($request->validated());
            return response($response);
        });
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function acceptJob(Request $request)
    {
        return $this->tryCatch(function () use ($request) {
            $response = $this->service->acceptJob($request->validated());
            return response($response);
        });
    }

    public function acceptJobWithId(Request $request)
    {
        return $this->tryCatch(function () use ($request) {
            $response = $this->service->acceptJobWithId($request->validated());
            return response($response);
        });
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function cancelJob(Request $request)
    {
        return $this->tryCatch(function () use ($request) {
            $response = $this->service->cancelJobAjax($request->validated());
            return response($response);
        });
    
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function endJob(Request $request)
    {
        return $this->tryCatch(function () use ($request) {
            $response = $this->service->endJob($request->validated());
            return response($response);
        });
    }

    public function customerNotCall(Request $request)
    {
        return $this->tryCatch(function () use ($request) {
            $response = $this->service->customerNotCall($request->validated());
            return response($response);
        });
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getPotentialJobs(Request $request)
    {
        return $this->tryCatch(function () use ($request) {
            $response = $this->service->getPotentialJobs($request->validated());
            return response($response);
        });
    }

    public function distanceFeed(Request $request)
    {
        return $this->tryCatch(function () use ($request) {
            $response = $this->service->distanceFeed($request->validated());
            return response($response);
        });
    }

    public function reopen(Request $request)
    {
        return $this->tryCatch(function () use ($request) {
            $response = $this->service->reopen($request->validated());
            return response($response);
        });
    }

    public function resendNotifications(Request $request)
    {

        return $this->tryCatch(function () use ($request) {
            $response = $this->service->resendNotifications($request->validated());
            return response($response);
        });       
    }

    /**
     * Sends SMS to Translator
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function resendSMSNotifications(Request $request)
    {
        return $this->tryCatch(function () use ($request) {
            $response = $this->service->resendSMSNotifications($request->validated());
            return response($response);
        });
    }

    /**
     * Load necessary relationships for a job.
     *
     * @return mixed The job entity with loaded relationships.
     */
    protected function loadJobRelationships()
    {
        return [
            'translatorJobRel.user',
        ];
    }
}
