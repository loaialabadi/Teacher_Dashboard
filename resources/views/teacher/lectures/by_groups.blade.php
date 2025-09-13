@extends('layouts.teacher')
@section('content')
<div class="container my-4">
    <h2>📚 المجموعات الخاصة بفصل: {{ $grade->name }}</h2>
    <div class="row">
        @forelse($groups as $group)
        <div class="col-md-4 mb-3">
            <a href="{{ route('teachers.lectures.bygroup', [$teacher->id, $grade->id, $group->id]) }}" class="text-decoration-none">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">👥 {{ $group->name }}</h5>
                        <small>عدد الطلاب: {{ $group->students->count() }}</small>
                    </div>
                </div>
            </a>
        </div>
        @empty
            <div class="alert alert-info text-center">لا توجد مجموعات لهذا الفصل</div>
        @endforelse
    </div>
</div>
@endsection
