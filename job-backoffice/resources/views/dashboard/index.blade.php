<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900 tracking-tight">Analytics Overview</h2>
                <p class="text-xs text-gray-400 mt-0.5">{{ now()->format('l, d F Y') }}</p>
            </div>
            <span class="inline-flex items-center gap-1.5 text-xs font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 px-3 py-1.5 rounded-full">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse inline-block"></span>
                Live data
            </span>
        </div>
    </x-slot>

    <style>
        .db { font-family: 'Inter', ui-sans-serif, system-ui, sans-serif; }

        .kpi-card {
            background: #fff; border: 1px solid #e8eaed; border-radius: 14px;
            padding: 22px 24px; transition: box-shadow .18s, transform .18s;
        }
        .kpi-card:hover { box-shadow: 0 6px 24px rgba(0,0,0,.07); transform: translateY(-2px); }
        .kpi-icon {
            width: 44px; height: 44px; border-radius: 11px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .kpi-delta { font-size: 11px; font-weight: 600; padding: 3px 9px; border-radius: 99px; }

        .sec-card { background: #fff; border: 1px solid #e8eaed; border-radius: 14px; overflow: hidden; }
        .sec-head {
            padding: 18px 24px; border-bottom: 1px solid #f3f4f6;
            display: flex; align-items: center; justify-content: space-between;
        }
        .sec-title { font-size: 14px; font-weight: 700; color: #111827; }
        .sec-sub   { font-size: 12px; color: #9ca3af; margin-top: 2px; }

        .dtbl { width: 100%; border-collapse: collapse; }
        .dtbl thead th {
            font-size: 10.5px; font-weight: 700; letter-spacing: .06em; text-transform: uppercase;
            color: #9ca3af; padding: 10px 20px; background: #fafafa;
            border-bottom: 1px solid #f3f4f6; white-space: nowrap;
        }
        .dtbl tbody td {
            padding: 13px 20px; font-size: 13px; color: #374151;
            border-bottom: 1px solid #f9fafb; vertical-align: middle;
        }
        .dtbl tbody tr:last-child td { border-bottom: none; }
        .dtbl tbody tr:hover td { background: #fafafa; }

        .rank { width: 26px; height: 26px; border-radius: 7px; display: inline-flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 800; }
        .type-pill { display: inline-block; padding: 3px 10px; border-radius: 99px; font-size: 11px; font-weight: 600; background: #eff6ff; color: #2563eb; }

        .view-btn {
            display: inline-flex; align-items: center; gap: 4px; font-size: 12px; font-weight: 600;
            color: #4f46e5; padding: 5px 12px; border-radius: 8px; border: 1px solid #e0e7ff;
            transition: background .15s, color .15s; text-decoration: none;
        }
        .view-btn:hover { background: #4f46e5; color: #fff; border-color: #4f46e5; }

        .rate-bar-bg  { width: 72px; height: 5px; background: #f3f4f6; border-radius: 99px; overflow: hidden; }
        .rate-bar-fill { height: 100%; border-radius: 99px; }

        .empty-state { padding: 48px 24px; text-align: center; color: #9ca3af; font-size: 13px; }
    </style>

    <div class="db py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- KPI Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

                <div class="kpi-card flex items-start gap-4">
                    <div class="kpi-icon" style="background:#eff6ff;">
                        <svg class="w-5 h-5" style="color:#3b82f6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Active Users</p>
                        <p class="text-2xl font-black text-gray-900 leading-none">{{ number_format($analytics['active_users']) }}</p>
                        <div class="mt-2">
                            <span class="kpi-delta" style="background:#eff6ff;color:#2563eb;">Last 30 days</span>
                        </div>
                    </div>
                </div>

                <div class="kpi-card flex items-start gap-4">
                    <div class="kpi-icon" style="background:#f0fdf4;">
                        <svg class="w-5 h-5" style="color:#16a34a" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Total Jobs</p>
                        <p class="text-2xl font-black text-gray-900 leading-none">{{ number_format($analytics['total_jobs_viewed']) }}</p>
                        <div class="mt-2">
                            <span class="kpi-delta" style="background:#f0fdf4;color:#15803d;">Live vacancies</span>
                        </div>
                    </div>
                </div>

                <div class="kpi-card flex items-start gap-4">
                    <div class="kpi-icon" style="background:#faf5ff;">
                        <svg class="w-5 h-5" style="color:#9333ea" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Applications</p>
                        <p class="text-2xl font-black text-gray-900 leading-none">{{ number_format($analytics['total_applications']) }}</p>
                        <div class="mt-2">
                            <span class="kpi-delta" style="background:#faf5ff;color:#7e22ce;">All submissions</span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Charts Row --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

                {{-- Bar chart --}}
                <div class="sec-card lg:col-span-2">
                    <div class="sec-head">
                        <div>
                            <p class="sec-title">Applications per Job</p>
                            <p class="sec-sub">Top 5 most applied vacancies</p>
                        </div>
                        <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:#6b7280;">
                            <span style="width:10px;height:10px;border-radius:2px;background:#6366f1;display:inline-block;"></span>
                            Applications
                        </div>
                    </div>
                    <div style="padding:20px 24px 16px;">
                        <div style="position:relative;height:240px;">
                            <canvas id="barChart" role="img" aria-label="Bar chart: applications per top 5 jobs">Applications per top 5 jobs.</canvas>
                        </div>
                    </div>
                </div>

                {{-- Doughnut chart --}}
                <div class="sec-card">
                    <div class="sec-head">
                        <div>
                            <p class="sec-title">Conversion Rates</p>
                            <p class="sec-sub">Applications ÷ Views × 100</p>
                        </div>
                    </div>
                    <div style="padding:16px 24px 12px;">
                        <div id="donutLegend" style="display:flex;flex-direction:column;gap:8px;margin-bottom:14px;"></div>
                        <div style="position:relative;height:190px;">
                            <canvas id="donutChart" role="img" aria-label="Doughnut chart: conversion rates top 3 jobs">Conversion rates for top 3 jobs.</canvas>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Most Applied Jobs Table --}}
            <div class="sec-card">
                <div class="sec-head">
                    <div>
                        <p class="sec-title">Most Applied Jobs</p>
                        <p class="sec-sub">Ranked by application volume</p>
                    </div>
                    @if($analytics['most_applied_jobs']->count() > 0)
                        <span style="font-size:12px;font-weight:700;padding:5px 14px;border-radius:99px;background:#fff7ed;color:#c2410c;">
                            {{ number_format($analytics['most_applied_jobs']->sum('job_applications_count')) }} total
                        </span>
                    @endif
                </div>
                <div class="overflow-x-auto">
                    <table class="dtbl">
                        <thead>
                            <tr>
                                <th style="width:52px;">#</th>
                                <th>Job</th>
                                @if (auth()->user()->role=='admin')
                                   <th>Company</th>
                                @endif 
                                <th>Type</th>
                                <th>Salary</th>
                                <th>Applications</th>
                                <th style="width:80px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($analytics['most_applied_jobs'] as $i => $job)
                                @php
                                    $ranks = [
                                        0 => ['bg'=>'#fef3c7','color'=>'#92400e'],
                                        1 => ['bg'=>'#f3f4f6','color'=>'#374151'],
                                        2 => ['bg'=>'#ffedd5','color'=>'#9a3412'],
                                    ];
                                    $r = $ranks[$i] ?? ['bg'=>'#eff6ff','color'=>'#1e40af'];
                                @endphp
                                <tr>
                                    <td>
                                        <span class="rank" style="background:{{ $r['bg'] }};color:{{ $r['color'] }};">{{ $i + 1 }}</span>
                                    </td>
                                    <td>
                                        <p style="font-weight:600;color:#111827;font-size:13px;margin:0;">{{ $job->title }}</p>
                                        <p style="font-size:11px;color:#9ca3af;margin:2px 0 0;">{{ Str::limit($job->description, 48) }}</p>
                                    </td>
                                     @if (auth()->user()->role=='admin')
                                    <td style="color:#4b5563;font-weight:500;">{{ $job->company->name ?? '—' }}</td>
                                    @endif
                                    <td><span class="type-pill">{{ $job->type }}</span></td>
                                    <td style="font-weight:600;color:#111827;">${{ number_format($job->salary) }}</td>
                                    <td>
                                        <span style="font-size:15px;font-weight:800;color:#4f46e5;">{{ number_format($job->job_applications_count) }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('job-vacancies.show', $job->id) }}" class="view-btn">
                                            View
                                            <svg style="width:12px;height:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7"><div class="empty-state">No data available</div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Conversion Rate Table --}}
            <div class="sec-card">
                <div class="sec-head">
                    <div>
                        <p class="sec-title">Conversion Rate Breakdown</p>
                        <p class="sec-sub">Top 3 · Applications ÷ Views × 100</p>
                    </div>
                    <div style="display:flex;gap:10px;font-size:11px;font-weight:600;">
                        <span style="display:flex;align-items:center;gap:4px;color:#15803d;"><span style="width:8px;height:8px;border-radius:50%;background:#22c55e;"></span>High ≥50%</span>
                        <span style="display:flex;align-items:center;gap:4px;color:#a16207;"><span style="width:8px;height:8px;border-radius:50%;background:#eab308;"></span>Mid ≥25%</span>
                        <span style="display:flex;align-items:center;gap:4px;color:#b91c1c;"><span style="width:8px;height:8px;border-radius:50%;background:#ef4444;"></span>Low</span>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="dtbl">
                        <thead>
                            <tr>
                                <th style="width:52px;">#</th>
                                <th>Job</th>
                                 @if (auth()->user()->role=='admin')
                                <th>Company</th>
                                @endif
                                <th>Views</th>
                                <th>Applications</th>
                                <th>Conversion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($analytics['conversion_rate'] as $i => $job)
                                @php
                                    $rate = $job->conversion_rate;
                                    if ($rate >= 50)     { $rc = '#16a34a'; $rb = '#dcfce7'; $rl = 'High'; }
                                    elseif ($rate >= 25) { $rc = '#ca8a04'; $rb = '#fef9c3'; $rl = 'Mid';  }
                                    else                 { $rc = '#dc2626'; $rb = '#fee2e2'; $rl = 'Low';  }
                                    $ranks = [
                                        0 => ['bg'=>'#fef3c7','color'=>'#92400e'],
                                        1 => ['bg'=>'#f3f4f6','color'=>'#374151'],
                                        2 => ['bg'=>'#ffedd5','color'=>'#9a3412'],
                                    ];
                                    $r = $ranks[$i] ?? ['bg'=>'#eff6ff','color'=>'#1e40af'];
                                @endphp
                                <tr>
                                    <td>
                                        <span class="rank" style="background:{{ $r['bg'] }};color:{{ $r['color'] }};">{{ $i + 1 }}</span>
                                    </td>
                                    <td>
                                        <p style="font-weight:600;color:#111827;font-size:13px;margin:0;">{{ $job->title }}</p>
                                        <p style="font-size:11px;color:#9ca3af;margin:2px 0 0;">{{ Str::limit($job->description, 48) }}</p>
                                    </td>
                                     @if (auth()->user()->role=='admin')
                                    <td style="color:#4b5563;font-weight:500;">{{ $job->company->name ?? '—' }}</td>
                                    @endif
                                    <td style="font-weight:600;color:#4b5563;">{{ number_format($job->veiw_count) }}</td>
                                    <td style="font-weight:700;color:#7c3aed;">{{ number_format($job->job_applications_count) }}</td>
                                    <td>
                                        <div style="display:flex;align-items:center;gap:10px;">
                                            <span style="font-size:14px;font-weight:800;color:{{ $rc }};min-width:44px;">{{ number_format($rate, 1) }}%</span>
                                            <div class="rate-bar-bg">
                                                <div class="rate-bar-fill" style="width:{{ min(100,$rate) }}%;background:{{ $rc }};"></div>
                                            </div>
                                            <span style="font-size:10.5px;font-weight:700;padding:2px 8px;border-radius:99px;background:{{ $rb }};color:{{ $rc }};">{{ $rl }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6"><div class="empty-state">No data available</div></td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.js"></script>
    <script>
    (function () {
        const applied  = @json($analytics['most_applied_jobs']);
        const convData = @json($analytics['conversion_rate']);

        // Bar chart
        const barLabels = applied.map(j => j.title.length > 20 ? j.title.slice(0,20)+'…' : j.title);
        const barValues = applied.map(j => j.job_applications_count);

        new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels: barLabels,
                datasets: [{
                    label: 'Applications',
                    data: barValues,
                    backgroundColor: ['rgba(99,102,241,.90)','rgba(99,102,241,.74)','rgba(99,102,241,.58)','rgba(99,102,241,.43)','rgba(99,102,241,.28)'],
                    borderRadius: 8,
                    borderSkipped: false,
                    borderWidth: 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e1b4b', titleColor: '#c7d2fe', bodyColor: '#fff',
                        padding: 10, cornerRadius: 8,
                        callbacks: { label: ctx => '  ' + ctx.parsed.y.toLocaleString() + ' applications' }
                    }
                },
                scales: {
                    x: { grid: { display: false }, border: { display: false }, ticks: { color: '#9ca3af', font: { size: 11 }, autoSkip: false, maxRotation: 15 } },
                    y: { grid: { color: 'rgba(0,0,0,0.04)' }, border: { display: false }, ticks: { color: '#9ca3af', font: { size: 11 }, padding: 8, callback: v => Number.isInteger(v) ? v.toLocaleString() : '' } }
                }
            }
        });

        // Doughnut chart
        const PALETTE = ['#6366f1','#10b981','#f59e0b'];
        const donutLabels = convData.map(j => j.title.length > 20 ? j.title.slice(0,20)+'…' : j.title);
        const donutValues = convData.map(j => Math.round(j.conversion_rate * 10) / 10);

        const legend = document.getElementById('donutLegend');
        donutLabels.forEach((lbl, i) => {
            const el = document.createElement('div');
            el.style.cssText = 'display:flex;align-items:center;justify-content:space-between;';
            el.innerHTML = `<span style="display:flex;align-items:center;gap:6px;"><span style="width:10px;height:10px;border-radius:2px;background:${PALETTE[i]};flex-shrink:0;display:inline-block;"></span><span style="font-size:12px;color:#374151;">${lbl}</span></span><strong style="font-size:12px;color:#111827;">${donutValues[i]}%</strong>`;
            legend.appendChild(el);
        });

        new Chart(document.getElementById('donutChart'), {
            type: 'doughnut',
            data: {
                labels: donutLabels,
                datasets: [{ data: donutValues, backgroundColor: PALETTE, borderWidth: 3, borderColor: '#fff', hoverOffset: 6 }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#111827', titleColor: '#d1d5db', bodyColor: '#fff',
                        padding: 10, cornerRadius: 8,
                        callbacks: { label: ctx => '  ' + ctx.parsed.toFixed(1) + '% conversion' }
                    }
                }
            }
        });
    })();
    </script>

</x-app-layout>