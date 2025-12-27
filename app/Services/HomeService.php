<?php

namespace App\Services;

use App\Models\JobPosting;

class HomeService
{
    private $data = [];

    public function getHomeData()
    {
        $this->getPublishedJobs();
        return $this->data;
    }

    private function getPublishedJobs()
    {
        $this->data['published_jobs'] = JobPosting::active()->get();
    }


}