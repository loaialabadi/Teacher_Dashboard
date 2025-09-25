@extends('layouts.teacher')

@section('content')
<div class="container my-4">

    {{-- عنوان الصفحة --}}
    <h2 class="mb-4 text-center">📅 جدول محاضرات: {{ $teacher->name }}</h2>

    @php
        use Carbon\Carbon;

        // الشهر الحالي
        $currentMonth = Carbon::now()->startOfMonth();
        $startOfMonth = $currentMonth->copy();
        $endOfMonth   = $currentMonth->copy()->endOfMonth();

        // بداية الأسبوع من الأحد (أو الاثنين حسب رغبتك)
        $startOfCalendar = $startOfMonth->copy()->startOfWeek(Carbon::SUNDAY);
        $endOfCalendar   = $endOfMonth->copy()->endOfWeek(Carbon::SATURDAY);

        $period = new DatePeriod($startOfCalendar, new DateInterval('P1D'), $endOfCalendar->copy()->addDay());

        // نجمع المحاضرات حسب اليوم
        $lecturesByDate = $lectures->groupBy(function($lecture) {
            return Carbon::parse($lecture->start_time)->toDateString();
        });
    @endphp

    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>الأحد</th>
                    <th>الاثنين</th>
                    <th>الثلاثاء</th>
                    <th>الأربعاء</th>
                    <th>الخميس</th>
                    <th>الجمعة</th>
                    <th>السبت</th>
                </tr>
            </thead>
            <tbody>
@foreach ($period as $date)
    @php
        $carbonDate = Carbon::instance($date);
        $dayLectures = $lecturesByDate[$carbonDate->toDateString()] ?? collect();
        $week[] = [
            'date' => $carbonDate,
            'lectures' => $dayLectures
        ];
    @endphp

    @if(count($week) == 7)
        <tr>
            @foreach ($week as $day)
                <td style="min-height:120px; vertical-align: top;">
                    <div class="fw-bold mb-1">{{ $day['date']->day }}</div>

@forelse ($day['lectures'] as $lecture)
    <div class="bg-primary text-white rounded p-1 mb-1 small">
        📘 {{ $lecture->title }} <br>
        👥 {{ $lecture->group->name ?? '-' }} <br>
        📖 {{ $lecture->subject->name ?? '-' }} <br>
🏫 {{ $lecture->group->grade->name ?? '-' }} <br>
        🕒 ({{ \Carbon\Carbon::parse($lecture->start_time)->format('H:i') }})
    </div>
@empty
    <div class="text-muted small">-</div>
@endforelse
                </td>
            @endforeach
        </tr>
        @php $week = []; @endphp
    @endif
@endforeach

            </tbody>
        </table>
    </div>

</div>
@endsection
