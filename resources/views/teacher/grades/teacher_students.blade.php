@extends('layouts.teacher')

@section('content')
<div class="container my-4">
    <h2 class="mb-4">📘 الطلاب في الفصل الدراسي {{ $grade->name }} مع المدرس {{ $teacher->name }}</h2>

    @if($students->isEmpty())
        <div class="alert alert-warning">لا يوجد طلاب مسجلين في هذا الفصل.</div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>رقم الهاتف</th>
                    <th>المجموعة</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->phone }}</td>
                        <td>
                            @foreach ($student->groups as $group)
                                @if($group->teacher_id == $teacher->id && $group->grade_id == $grade->id)
                                    <span class="badge bg-primary">{{ $group->name }}</span>
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
