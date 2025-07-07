@extends('layouts.index')

@section('content')
<div class="container my-4">
    <h2 class="mb-4">📘 الفصول الدراسية الخاصة بالمدرس: {{ $teacher->name }}</h2>

    <a href="{{ route('groups.create', ['teacher' => $teacher->id]) }}" class="btn btn-success mb-3">
        <i class="fas fa-plus"></i> إضافة مجموعة جديدة
    </a>

    @forelse($SchoolGrades as $class)
        <div class="card mb-4 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ $class->name }}</h5>
                <div>
                    <a href="{{ route('classes.edit', $class->id) }}" class="btn btn-sm btn-primary me-2">
                        <i class="fas fa-edit"></i> تعديل الفصل
                    </a>
                    <form action="{{ route('classes.destroy', $class->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا الفصل؟');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">
                            <i class="fas fa-trash"></i> حذف الفصل
                        </button>
                    </form>
                </div>
            </div>
            <div class="card-body">
                @if($class->groups->count() > 0)
                    @foreach($class->groups as $group)
                        <div class="mb-3 border rounded p-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">المجموعة: {{ $group->name }}</h6>
                                <div>
                                    <a href="{{ route('groups.show', $group->id) }}" class="btn btn-sm btn-info me-1">
                                        <i class="fas fa-users"></i> عرض الطلاب
                                    </a>
                                    <a href="{{ route('groups.edit', $group->id) }}" class="btn btn-sm btn-warning me-1">
                                        <i class="fas fa-edit"></i> تعديل المجموعة
                                    </a>
                                    <form action="{{ route('groups.destroy', $group->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذه المجموعة؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> حذف المجموعة
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @if($group->students->count() > 0)
                                <ul class="list-group">
                                    @foreach($group->students as $student)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            {{ $student->name }}
                                            {{-- يمكن إضافة أزرار للطالب إذا أردت --}}
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">لا يوجد طلاب في هذه المجموعة.</p>
                            @endif
                        </div>
                    @endforeach
                @else
                    <p>لا توجد مجموعات في هذا الفصل.</p>
                @endif
            </div>
        </div>
    @empty
        <div class="alert alert-warning">
            لا توجد فصول دراسية مرتبطة بهذا المدرس.
        </div>
    @endforelse
</div>
@endsection
