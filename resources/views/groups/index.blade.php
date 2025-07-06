@extends('layouts.index')

@section('content')
<div class="container my-4">

    <a href="{{ route('groups.create', $teacher->id) }}" class="btn btn-dark mb-4">
        <i class="fas fa-plus-circle"></i> إنشاء مجموعة جديدة
    </a>

    <h2 class="mb-3">📘 مجموعات المدرس: {{ $teacher->name }}</h2>

    @forelse ($groups as $group)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <strong>اسم المجموعة:</strong> {{ $group->name }}
                    <span class="ms-3 text-muted">عدد الطلاب: {{ $group->students->count() }}</span>
                </div>
                <div>
                    <a href="{{ route('groups.show', ['teacher' => $teacher->id, 'group' => $group->id]) }}" class="btn btn-primary btn-sm">
                        عرض التفاصيل
                    </a>
               <a href="{{ route('groups.transferForm', ['teacher' => $teacher->id, 'sourceGroup' => $group->id]) }}" class="btn btn-warning btn-sm">
    نقل طلاب
</a>

                    <a href="{{ route('groups.addStudentForm', ['teacher' => $teacher->id, 'group' => $group->id]) }}" class="btn btn-success btn-sm">
                        إضافة طالب
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info">
            لا توجد مجموعات حتى الآن لهذا المعلم.
        </div>
    @endforelse
</div>
@endsection
