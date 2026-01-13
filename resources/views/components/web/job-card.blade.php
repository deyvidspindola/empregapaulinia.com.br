@props(['job'])
@php
    $key = $job->slug ?? $job->id;
    $locationParam = \Str::slug($job->location);
    $href = route('jobs.show', [$locationParam, $key]);

    $companyName = $job->is_company_visible && $job->company
        ? $job->company->name
        : 'Empresa confidencial';

    $logo = $job->is_company_visible && $job->company && $job->company->logo_path
        ? asset('storage/' . $job->company->logo_path)
        : asset('images/resource/company-logo/5-1.png');

    $salary_display = '';

    $salary = $job->salary;
    $currency = $job->currency;
    if ($salary === null || $salary <= 0) {
        $salary_display = 'A Combinar';
    } else if ($currency === 'BRL') {
        $salary = str_replace('.', '', $salary);
        $salary = str_replace(',', '.', $salary);
        $salary_display = 'R$ ' . number_format((float) $salary, 2, ',', '.');
    }

@endphp
<div class="job-block">
    <div class="inner-box">
        <div class="content">
            <span class="company-logo"><img src="{{ $logo }}" alt=""></span>
            <h4><a href="{{ $href }}">{{ $job->title }}</a></h4>
            <ul class="job-info">
                <li><span class="icon flaticon-briefcase"></span> {{ $companyName }}</li>
                <li><span class="icon flaticon-map-locator"></span> {{ $job->location }}</li>
                <li><span class="icon flaticon-clock-3"></span> {{ $job->postedAt }}</li>
                <li><span class="icon flaticon-money"></span> {{ $salary_display }}</li>
            </ul>
            <p>{{ Str::limit($job->description, 160) }}</p>
        </div>
    </div>
</div>