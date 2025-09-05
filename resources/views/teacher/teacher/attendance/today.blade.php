@extends('layouts.index')

@section('content')
<div class="container my-4">
    <h2>📅 تسجيل الحضور - محاضرات اليوم للمعلم: {{ $teacher->name }}</h2>

    @if($lectures->isEmpty())
        <div class="alert alert-warning">لا توجد محاضرات اليوم.</div>
    @else
        <ul class="list-group">
            @foreach($lectures as $lecture)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                        🕓 {{ $lecture->start_time_formatted }}
                    - {{ $lecture->subject->name ?? 'بدون مادة' }}
                    - ({{ $lecture->group->name ?? 'بدون مجموعة' }})
                    <a href="{{ route('attendances.create', $lecture->id) }}" class="btn btn-success btn-sm">تسجيل الحضور</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
