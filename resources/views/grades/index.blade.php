@extends('layouts.index')

@section('content')
<div class="container my-4">
    <h2 class="mb-4">📚 قائمة الفصول الدراسية للمعلم: {{ $teacher->name }}</h2>

    <a href="{{ route('grades.create', ['teacher' => $teacher->id]) }}" class="btn btn-success mb-3">
        <i class="fas fa-plus"></i> إضافة فصل دراسي جديد
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($grades->count())
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>اسم الفصل</th>
                    <th>المادة</th>
                    <th>التاريخ</th>
                    <th>الوصف</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
@foreach($grades as $grade)
    <tr>
        <td>{{ $grade->name ?? '-' }}</td>
        <td>{{ $grade->subject->name ?? '-' }}</td>
        <td>{{ \Carbon\Carbon::parse($grade->date)->format('Y-m-d') }}</td>
        <td>{{ $grade->description ?? '-' }}</td>
        <td>
<a href="{{ route('grades.edit', ['teacher' => $teacher->id, 'grade' => $grade->id]) }}" class="btn btn-sm btn-primary">
    تعديل
</a>
        </td>
    </tr>
@endforeach

            </tbody>
        </table>

        {{ $grades->links() }}

    @else
        <p>لا توجد فصول دراسية لهذا المعلم حتى الآن.</p>
    @endif
</div>
@endsection
