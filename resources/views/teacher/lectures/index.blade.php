@extends('layouts.index')

@section('content')
<div class="container my-4">
    <h2 class="mb-4">📘 جدول محاضرات: {{ $teacher->name }}</h2>

    @forelse ($lectures as $day => $dayLectures)
        <h4 class="mt-4 text-primary">{{ $day }}</h4>
        <table class="table table-bordered text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>العنوان</th>
                    <th>الوصف</th>
                    <th>المادة</th>
                    <th>الوقت</th>
                    <th>المجموعة</th>
                </tr>
            </thead>
            <tbody>
@foreach ($lecturesByDay as $day => $dayLectures)
    <h4 class="mt-4 text-primary">{{ $day }}</h4>
    @if($dayLectures->count())
        <table class="table table-bordered text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>العنوان</th>
                    <th>الوصف</th>
                    <th>المادة</th>
                    <th>الوقت</th>
                    <th>المجموعة</th>
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-secondary text-center">لا توجد محاضرات في هذا اليوم</div>
    @endif
@endforeach

            </tbody>
        </table>
    @empty
        <div class="alert alert-info text-center">لا توجد محاضرات حالياً</div>
    @endforelse
</div>

@endsection
