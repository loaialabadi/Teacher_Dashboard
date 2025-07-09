@extends('layouts.index')

@section('content')
<div class="container my-4">

    <h2 class="mb-4">📚 طلاب المدرس: {{ $teacher->name }}</h2>

<a href="{{ route('teachers.students.create', ['teacher' => $teacher->id]) }}">إضافة طالب</a>
    <i class="fas fa-plus-circle"></i> إضافة طالب جديد
</a>


    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($students->count() > 0)
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>الاسم</th>
                    <th>رقم الهاتف</th>
                    <th>اسم ولي الأمر</th>
                    <th>هاتف ولي الأمر</th>
                    <th>المادة</th>
                    <th>الفصل الدراسي</th>
                    <th>المجموعة</th>
                    <th>إجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->phone }}</td>
                    <td>{{ $student->parent_name }}</td>
                    <td>{{ $student->parent_phone }}</td>
                    <td>{{ $student->subject->name ?? '-' }}</td>
                    <td>{{ $student->grade->name ?? '-' }}</td>
                    <td>{{ $student->group->name ?? '-' }}</td>
                    <td>
                        <a href="{{ route('students.edit', [$teacher->id, $student->id]) }}" class="btn btn-primary btn-sm">تعديل</a>

                        <form action="{{ route('students.destroy', [$teacher->id, $student->id]) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('هل أنت متأكد من حذف الطالب؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">حذف</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $students->links() }} {{-- pagination --}}
    @else
        <div class="alert alert-info">لا يوجد طلاب مسجلين حتى الآن.</div>
    @endif

</div>
@endsection
