@extends('layouts.index')

@section('content')
<div class="container">
    <h2>
        <i class="fas fa-users"></i> قائمة الطلاب
        @if(isset($teacherName))
            الخاصة بـ <span class="text-primary">{{ $teacherName }}</span>
        @endif
    </h2>

    <a href="{{ route('students.create') }}" class="btn btn-success mb-3">
        <i class="fas fa-user-plus"></i> إضافة طالب
    </a>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th><i class="fas fa-user"></i> الاسم</th>
                <th><i class="fas fa-user"></i> المرحلة التعليميه</th>

                <th><i class="fas fa-chalkboard-teacher"></i> المعلم</th>
                <th><i class="fas fa-book"></i> المادة</th>
                <th><i class="fas fa-user-friends"></i> ولي الأمر</th>
                <th><i class="fas fa-phone"></i> رقم ولي الأمر</th>
                <th><i class="fas fa-trash-alt"></i> حذف الطالب</th>
                <th>ملخص الحضور الشهري</th>
                <th><i class="fas fa-edit"></i> تعديل الطالب</th>
<th>جدول الحصص والمجموعات</th>

            </tr>
        </thead>
<tbody>
    @foreach($students as $student)
        <tr>
            <td>{{ $student->name }}</td>
            <td>{{ $student->academic_stage }}</td>

            <td>{{ $student->teacher ? $student->teacher->name : '-' }}</td>
            <td>{{ $student->class ? $student->class->subject->name : '-' }}</td>
            <td>{{ $student->parent ? $student->parent->name : '-' }}</td>
            <td>{{ $student->parent ? $student->parent->phone : '-' }}</td>
            
            <td>
                <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطالب؟');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">
                        <i class="fas fa-trash"></i> حذف
                    </button>
                </form>
            </td>
            <td>
                <a href="{{ route('attendance.monthly_summary', ['studentId' => $student->id, 'year' => 2025, 'month' => 6]) }}" class="btn btn-info btn-sm">
                    ملخص حضور 6/2025
                </a>
            </td>

            <td>
    <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning btn-sm">
        <i class="fas fa-edit"></i> تعديل
    </a>
    
            </td>
            <td>
               <a href="{{ route('students.schedule-groups', $student->id) }}" class="btn btn-info">
  {{ $student->name }}
</a>
</td>

        </tr>
    @endforeach
</tbody>

    </table>
    {{ $students->links() }}

</div>
@endsection
