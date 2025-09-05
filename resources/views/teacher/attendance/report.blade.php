@extends('layouts.index')

@section('content')
<div class="container my-5">
    <h2>تقرير الحضور لمحاضرة: {{ $lecture->title }}</h2>

    <a href="{{ route('attendances.create', $lecture->id) }}" class="btn btn-secondary mb-3">تعديل الحضور</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>اسم الطالب</th>
                <th>الحالة</th>
                <th>تاريخ التسجيل</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->student->name }}</td>
                    <td>{{ ucfirst($attendance->status) }}</td>
                    <td>{{ $attendance->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center">لا توجد بيانات حضور مسجلة.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
