@props(['job'])
@php
    $key = $job->slug ?? $job->id;
    $locationParam = \Str::slug($job->location);
    $href = route('jobs.show', [$locationParam, $key]);

    $companyName = $company->name ?? ($job->company->name ?? 'Empresa');
    $isCompanyVisible = $job->is_company_visible ?? true;
    if (!$isCompanyVisible) {
        $companyName = 'Empresa confidencial';
        $logo = asset('assets/images/novo_logo.png');
    }
@endphp
<div class="job-block">
    <div class="inner-box">
        <div class="content">
            <span class="company-logo"><img src="{{ asset('images/resource/company-logo/4-1.png') }}" alt=""></span>
            <h4><a href="{{ $href }}">{{ $job->title }}</a></h4>
            <ul class="job-info">
                <li><span class="icon flaticon-briefcase"></span> {{ $companyName }}</li>
                <li><span class="icon flaticon-map-locator"></span> {{ $job->location }}</li>
                <li><span class="icon flaticon-map-locator"></span> {{ $job->job_type }}</li>
                <li><span class="icon flaticon-clock-3"></span> {{ $job->postedAt }}</li>
                <li><span class="icon flaticon-money"></span> {{ $job->salary }}</li>
            </ul>
            <p>{{ Str::limit($job->description, 160) }}</p>
            <button class="bookmark-btn"><span class="flaticon-bookmark"></span></button>
        </div>
    </div>
</div>