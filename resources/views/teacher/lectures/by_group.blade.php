@extends('layouts.teacher')

@section('content')
<div class="container my-4">
    <h2>📖 المحاضرات للمجموعة: {{ $group->name }} - الفصل: {{ $grade->name }}</h2>
   
    <a href="{{ route('teachers.lectures.create', [$teacher->id, $grade->id, $group->id]) }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> إنشاء محاضرة جديدة
    </a>

    <ul class="list-group">
        @forelse($lectures as $lecture)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $lecture->title }}</strong> <br>
                    <small class="text-muted">{{ $lecture->date }}</small>
                </div>

                <div class="btn-group">
                    {{-- رابط تسجيل الحضور --}}
                    <a href="{{ route('teachers.lectures.attendance.create', [$teacher->id, $lecture->id]) }}" 
                       class="btn btn-sm btn-success">
                        📝 تسجيل الحضور
                    </a>

                    {{-- رابط تقرير الحضور --}}
                    <a href="{{ route('teachers.lectures.attendance.report', [$teacher->id, $lecture->id]) }}" 
                       class="btn btn-sm btn-info">
                        📊 تقرير الحضور
                    </a>

                    {{-- رابط تعديل (لو عايز تعدل بيانات المحاضرة نفسها) --}}
                    <a href="{{ route('teachers.lectures.edit', [$teacher->id, $grade->id, $group->id, $lecture->id]) }}" 
                       class="btn btn-sm btn-warning">
                        ✏️ تعديل
                    </a>
                </div>
            </li>
        @empty
            <li class="list-group-item text-center text-muted">لا توجد محاضرات بعد</li>
        @endforelse
    </ul>
</div>
@endsection
