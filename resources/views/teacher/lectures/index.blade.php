@extends('layouts.teacher')

@section('content')
<div class="container my-4">

    {{-- عنوان الصفحة --}}
    <h2 class="mb-4 text-center">📘 جدول محاضرات: {{ $teacher->name }}</h2>

    @forelse ($lecturesByDay as $day => $dayLectures)
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">{{ $day }}</h4>
            </div>
            <div class="card-body p-0">
                @if($dayLectures->count())
                    <table class="table table-bordered table-hover mb-0 text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>العنوان</th>
                                <th>الوصف</th>
                                <th>المادة</th>
                                <th>الوقت</th>
                                <th>المجموعة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dayLectures as $lecture)
                                <tr>
                                    <td>{{ $lecture->title }}</td>
                                    <td>{{ $lecture->description ?? '-' }}</td>
                                    <td>{{ $lecture->subject->name ?? '-' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($lecture->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($lecture->end_time)->format('H:i') }}</td>
                                    <td>{{ $lecture->group->name ?? '-' }}</td>
                                    <td>
                                        {{-- روابط الحضور --}}
                                        <a href="{{ route('teachers.lectures.attendance.create', ['teacher' => $teacher->id, 'lecture' => $lecture->id]) }}" 
                                           class="btn btn-success btn-sm">
                                           📝 تسجيل حضور
                                        </a>
                                        <a href="{{ route('teachers.lectures.attendance.report', ['teacher' => $teacher->id, 'lecture' => $lecture->id]) }}" 
                                           class="btn btn-info btn-sm">
                                           📊 تقرير
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-secondary text-center m-0 p-2">لا توجد محاضرات في هذا اليوم</div>
                @endif
            </div>
        </div>
    @empty
        <div class="alert alert-info text-center">لا توجد محاضرات حالياً</div>
    @endforelse

</div>
@endsection
