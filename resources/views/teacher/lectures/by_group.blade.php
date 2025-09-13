@extends('layouts.teacher')
@section('content')
<div class="container my-4">
    <h2>📖 المحاضرات للمجموعة: {{ $group->name }} - الفصل: {{ $grade->name }}</h2>
   

    <a href="{{ route('teachers.lectures.create', [$teacher->id, $grade->id, $group->id]) }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> إنشاء محاضرة جديدة
    </a>
    <ul class="list-group">
        @forelse($lectures as $lecture)
            <li class="list-group-item">
                {{ $lecture->title }} <br>
                <small class="text-muted">{{ $lecture->date }}</small>
            </li>
        @empty
            <li class="list-group-item text-center text-muted">لا توجد محاضرات بعد</li>
        @endforelse
    </ul>
</div>
@endsection
