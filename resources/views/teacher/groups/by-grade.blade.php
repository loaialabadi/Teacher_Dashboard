@extends('layouts.teacher')

@section('content')
<div class="container my-4">
    <h2 class="mb-4">
        📚 المجموعات للمعلم: <span class="text-primary">{{ $teacher->name }}</span>
        - الفصل: <span class="text-success">{{ $grade->name }}</span>
    </h2>

    انشاء مجموعه
    <a href="{{ route('teachers.groups.create', $teacher->id) }}" class="btn btn-success mb-3">📥 انشاء مجموعة جديدة</a>

    @if($groups->isEmpty())
        <div class="alert alert-warning">🚫 لا توجد مجموعات مسجلة لهذا الفصل.</div>
    @else
        <div class="row">
            @foreach($groups as $group)
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title">👥 {{ $group->name }}</h5>
                            <p class="card-text">📖 المادة: {{ $group->subject->name ?? 'غير محددة' }}</p>
                            <p class="card-text">👨‍🎓 الطلاب: {{ $group->students->count() }}</p>
                        <a href="{{ route('teachers.groups.show', [$teacher->id, $group->id]) }}" class="btn btn-primary btn-sm">
                            عرض التفاصيل
                        </a>
                                                </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
