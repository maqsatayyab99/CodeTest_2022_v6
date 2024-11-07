<?php

namespace App\Services;

use App\Services\BaseService;
use DTApi\Repository\BookingRepository;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\BaseServiceContract;
use Illuminate\Database\Eloquent\Model;

class BookingService extends BaseService implements BaseServiceContract
{
    /**
     * BookingService constructor.
     *
     * @param BookingRepository $repository
     */
    public function __construct(BookingRepository $repository)
    {
        parent::__construct($repository);
    }

    /**
     * Get status counts.
     * @param $data
     * @return array
     */
    public function getUsersJobs($data): array
    {
        $user_id = $data->get('user_id');
        if ($user_id) {
            return $this->repository->getUsersJobs($user_id);
        } elseif (
            $data->__authenticatedUser->user_type == config('usertype.admin')
            || $data->__authenticatedUser->user_type == config('usertype.super_admin')
        ) {
            return $this->repository->getAll($data);
        }
    }
    
    /** store job */
    public function  store($data) : array {
        $user = auth()->user();
        return $this->repository->store($user, $data);
    }

    public function updateJob(int $id, $data): array
    {
        $user = $data->__authenticatedUser;
        $data = array_except($data, ['_token', 'submit']);
        return $this->repository->updateJob($id, $data, $user);
    }

    public function storeJobEmail($data):array
    {
        return $this->repository->storeJobEmail($data);
    }

    public function getUsersJobsHistory($data):array
    {
        $response = null;
        $user_id = $data->get('user_id');
        if ($user_id) {
            $response = $this->repository->getUsersJobsHistory($user_id, $data);
        }
        return $response;
    }

    public function acceptJob($data)
    {
        $user = $data->__authenticatedUser;
        return $this->repository->acceptJob($data, $user);
    }

    public function acceptJobWithId($data)
    {
        $user = $data->__authenticatedUser;
        $data = $data->get('job_id');
        return $this->repository->acceptJobWithId($data, $user);
    }

    public function cancelJobAjax($data)
    {
        $user = $data->__authenticatedUser;
        return $this->repository->cancelJobAjax($data, $user);
    }

    public function endJob($data)
    {
        return $this->repository->endJob($data);
    }

    public function customerNotCall($data)
    {
        return $this->repository->customerNotCall($data);
    }

    public function getPotentialJobs($data)
    {
        $user = $data->__authenticatedUser;
        return $this->repository->getPotentialJobs($user);
    }

    public function distanceFeed($data)
    {
        $distance = $data['distance'] ?? "";
        $time = $data['time'] ?? "";
        $jobid = $data['jobid'] ?? null;
        $session = $data['session_time'] ?? "";
        $admincomment = $data['admincomment'] ?? "";

        if ($data['flagged'] === 'true' && empty($admincomment)) {
            return "Please, add comment";
        }

        $flagged = $data['flagged'] === 'true' ? 'yes' : 'no';
        $manually_handled = $data['manually_handled'] === 'true' ? 'yes' : 'no';
        $by_admin = $data['by_admin'] === 'true' ? 'yes' : 'no';

        // Update distance if provided
        if ($time || $distance) {
            $this->repository->updateDistance($jobid, [
                'distance' => $distance,
                'time' => $time,
            ]);
        }

        // Update job details if any relevant data provided
        if ($admincomment || $session || $flagged || $manually_handled || $by_admin) {
            $this->repository->update($jobid, [
                'admin_comments' => $admincomment,
                'flagged' => $flagged,
                'session_time' => $session,
                'manually_handled' => $manually_handled,
                'by_admin' => $by_admin,
            ]);
        }

        return ['Record Updated'];
    }

    public function reopen($data)
    {
        return $this->repository->reopen($data);
    }

    public function resendNotifications($data)
    {
        $job = $this->repository->find($data['jobid']);
        $job_data = $this->repository->jobToData($job);
        $this->repository->sendNotificationTranslator($job, $job_data, '*');
        return ['success' => 'Push sent'];
    }

    public function resendSMSNotifications($data)
    {
        $job = $this->repository->find($data['jobid']);
        $job_data = $this->repository->jobToData($job);
        $this->repository->sendSMSNotificationToTranslator($job, $job_data, '*');
        return ['success' => 'SMS sent'];
    }

}


