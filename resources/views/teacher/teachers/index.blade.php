@extends('layouts.index')

@section('content')
<div class="container">
    <h2 class="mb-4">قائمة المعلمين</h2>

    <a href="{{ route('teachers.create') }}" class="btn btn-success mb-3">
        <i class="fas fa-plus"></i> إضافة معلم
    </a>

    <table class="table table-bordered table-striped text-center">
        <thead class="table-dark">
            <tr>
                <th>الاسم</th>
                <th>رقم الهاتف</th>
                <th>المادة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teachers as $teacher)
                <tr>
                    <td>{{ $teacher->name }}</td>
                    <td>{{ $teacher->phone }}</td>
    <td>{{ $teacher->subject?->name ?? 'غير محدد' }}</td>
                    <td>
                        <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا المعلم؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i> حذف
                            </button>
                        </form>

                        <a href="{{ route('students.create', $teacher->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-user-plus"></i> إضافة طلاب
                        </a>

                        <a href="{{ route('students.index', ['teacher_id' => $teacher->id]) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-users"></i> عرض طلاب
                        </a>
                        <a href="{{ route('teachers.edit', $teacher->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> تعديل
                        </a>

                      <a href="{{ route('teachers.dashboard', $teacher->id) }}" class="btn btn-secondary btn-sm">
    <i class="fas fa-door-open"></i> دخول
</a>

                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
