@props(['job'])
@php
$postedAt = optional($job->created_at)->locale('pt_BR')->diffForHumans() ?? '';
$key  = $job->slug ?? $job->id;
$locationParam = \Str::slug($job->location);
$href = route('jobs.show', [$locationParam, $key]);
@endphp
<div class="job-block-five">
    <div class="inner-box">
        <div class="content">
            <span class="company-logo"><img src="images/resource/company-logo/4-1.png" alt=""></span>
            <h4><a href="{{ $href }}">{{ $job->title }}</a></h4>
            <ul class="job-info">
                <li><span class="icon flaticon-briefcase"></span> {{ $job->company->name }}</li>
                <li><span class="icon flaticon-map-locator"></span> {{ $job->location }}</li>
                <li><span class="icon flaticon-map-locator"></span> {{ $job->job_type }}</li>
                <li><span class="icon flaticon-clock-3"></span> {{ $postedAt }}</li>
            </ul>
        </div>
        <a href="{{ $href }}" class="theme-btn btn-style-two">Visualizar Vaga</a>
    </div>
</div>