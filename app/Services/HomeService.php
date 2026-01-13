<?php

namespace App\Services;

use App\Services\Web\VagasService;

class HomeService
{

    public function __construct(
        protected VagasService $vagasService
    ) {}


    private $data = [];

    public function getHomeData()
    {
        $this->data['published_jobs'] = $this->vagasService->getPublishedJobsForHome();
        return $this->data;
    }

}