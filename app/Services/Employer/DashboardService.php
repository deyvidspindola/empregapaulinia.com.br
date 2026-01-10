<?php

namespace App\Services\Employer;

class DashboardService
{
    
    private $company;
    private $user;
    private $dashboard = [];
    public function __construct()
    {
        $this->company = auth()->user()->company;
        $this->user = auth()->user();
    }

    public function getDashboardData()
    {
        $this->getPublishedJobs();
        $this->getJobViews();
        $this->getApplications();
        $this->getWalletBalance();
        return $this->dashboard;
    }
    private function getPublishedJobs()
    {
        $this->dashboard['published_jobs'] = $this->company->jobs()->active()->count();
    }

    private function getJobViews()
    {
        $this->dashboard['job_views'] = $this->company->jobs()
            ->join('job_posting_views', 'job_postings.id', '=', 'job_posting_views.job_posting_id')
            ->where('job_posting_views.viewed_on', '>=', now()->subDays(30)->toDateString())
            ->count();
    }

    private function getApplications()
    {
        $this->dashboard['applications'] = $this->company->jobs()
            ->join('job_posting_applications', 'job_postings.id', '=', 'job_posting_applications.job_posting_id')
            ->where('job_posting_applications.created_at', '>=', now()->subDays(30)->toDateString())
            ->count();
    }

    private function getWalletBalance()
    {
        $this->dashboard['wallet_balance'] = $this->company->wallet ? $this->company->wallet->balance : 0;
    }

}