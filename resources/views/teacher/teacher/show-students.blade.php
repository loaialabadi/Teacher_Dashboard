@extends('layouts.index')

@section('content')
<div class="container my-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">📚 الطلاب التابعين للمعلم: {{ $teacher->name }}</h3>
<a href="{{ url()->previous() }}" class="btn btn-outline-primary">
    <i class="fas fa-arrow-left"></i> الرجوع
</a>

    </div>

    @if($teacher->students->count())
        <div class="table-responsive">
            <table class="table table-striped table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th>اسم الطالب</th>
                        <th>الصف الدراسي</th>
                        <th> ولي الأمر</th>
                        <th>رقم  التليفون</th>
                        <th>  اسم المجموعة</th>

                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teacher->students as $student)
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->class->name ?? '-' }}</td>
                        <th>{{ $student->parent->name ?? '-' }}</th>
                            <td>{{ $student->phone ?? '-' }}</td>
                        <td>{{ $student->groups->first()->name ?? '-' }}</td>

                            <td>
                                <a href="{{ route('attendance.monthly_summary', $student->id) }}" class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-calendar-alt"></i> مراجعة الحضور
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info text-center">
            لا يوجد طلاب مرتبطين بهذا المعلم حاليًا.
        </div>
    @endif

</div>
@endsection
