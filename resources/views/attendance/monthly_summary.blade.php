@extends('layouts.index')

@section('content')
<div class="container">
    <h2>ملخص حضور الطالب {{ $student->name }} لشهر {{ $month }}/{{ $year }}</h2>

    <form method="GET" action="{{ route('attendance.monthly_summary', $student->id) }}" class="row g-3 mb-4">
        <div class="col-auto">
            <select name="year" class="form-select">
                @for($y = date('Y') - 5; $y <= date('Y'); $y++)
                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
        <div class="col-auto">
            <select name="month" class="form-select">
                @for($m = 1; $m <= 12; $m++)
                    <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>{{ $m }}</option>
                @endfor
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">عرض</button>
        </div>
    </form>

    <div class="mb-3">
        <p>إجمالي الحصص: {{ $totalSessions }}</p>
        <p>عدد الحضور: {{ $presentCount }}</p>
        <p>عدد الغياب: {{ $absentCount }}</p>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>التاريخ</th>
                <th>الحصة</th>
                <th>الحالة</th>
            </tr>
        </thead>
 <tbody>
    @foreach ($attendances as $attendance)
        <tr>
            <td>{{ $attendance->attended_at ? \Carbon\Carbon::parse($attendance->attended_at)->format('Y-m-d') : '-' }}</td>
            <td>{{ $attendance->class->subject->name ?? '-' }} - {{ $attendance->class->teacher->name ?? '-' }}</td>
            <td>
                @if($attendance->status == 'present')
                    <span class="badge bg-success">حاضر</span>
                @else
                    <span class="badge bg-danger">غائب</span>
                @endif
            </td>
        </tr>
    @endforeach
</tbody>

    </table>
</div>
@endsection
