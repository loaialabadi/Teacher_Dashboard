@extends('layouts.teacher')

@section('content')
<div class="container my-4">
    <h2 class="mb-4">📚 قائمة الفصول الدراسية للمعلم: {{ $teacher->name }}</h2>

    <a href="{{ route('teachers.grades.create', ['teacher' => $teacher->id]) }}" class="btn btn-success mb-3">
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
                    <th>التاريخ</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
@foreach($grades as $grade)
    <tr>
        <td>{{ $grade->name ?? '-' }}</td>
        <td>{{ \Carbon\Carbon::parse($grade->date)->format('Y-m-d') }}</td>
        <td>
            <a href="{{ route('teachers.grades.edit', ['teacher' => $teacher->id, 'grade' => $grade->id]) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i> تعديل
            </a>

            <form action="{{ route('teachers.grades.destroy', ['teacher' => $teacher->id, 'grade' => $grade->id]) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذا الفصل الدراسي؟')">
                    <i class="fas fa-trash"></i> حذف
                </button>
            </form>

            {{-- الطلاب والمدفوعات --}}
            @foreach($grade->students as $student)
                <a href="{{ route('teachers.payments.index', ['teacher' => $teacher->id, 'student_id' => $student->id]) }}" class="btn btn-sm btn-primary">
                    💵 مدفوعات {{ $student->name }}
                </a>
            @endforeach
        </td>
    </tr>
@endforeach
            </tbody>
        </table>

        {{-- روابط التصفح --}}
        <div class="mt-3">
            {{ $grades->links() }}
        </div>
    @else
        <p>لا توجد فصول دراسية لهذا المعلم حتى الآن.</p>
    @endif
</div>
@endsection
