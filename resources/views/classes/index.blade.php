@extends('layouts.index')

@section('content')
<div class="container">
    <h2>قائمة الحصص</h2>

    <a href="{{ route('classes.create') }}" class="btn btn-success mb-3">إضافة حصة جديدة</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>المعلم</th>
                <th>المادة</th>
                <th>التاريخ</th>
                <th>وقت البداية</th>
                <th>وقت النهاية</th>
                <th>تفاصيل</th>
                <th>تسجيل الحضور</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($classes as $class)
                <tr>
                    <td>{{ $class->teacher->name }}</td>
                    <td>{{ $class->subject->name }}</td>
                    <td>{{ $class->date }}</td>
                    <td>{{ $class->start_time }}</td>
                    <td>{{ $class->end_time }}</td>
                    <td>{{ $class->description }}</td>
                    <td>
                        <a href="{{ route('attendance.show', $class->id) }}" class="btn btn-primary">تسجيل الحضور</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $classes->links() }}
</div>
@endsection
