@extends('layouts.index')

@section('content')
<div class="container">
    <h2>تسجيل حضور الحصة: {{ $class->subject->name }} مع {{ $class->teacher->name }}</h2>
    <p>التاريخ: {{ $class->date }} من {{ $class->start_time }} إلى {{ $class->end_time }}</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('attendance.store', $class->id) }}" method="POST">
        @csrf

        <table class="table table-bordered text-center">
            <thead class="table-dark">
                <tr>
                    <th>اسم الطالب</th>
                    <th>حضور</th>
                    <th>غياب</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    @php
                        $record = $attendanceRecords->get($student->id);
                        $status = $record ? $record->status : 'absent';
                    @endphp
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>
                            <input type="radio" name="attendance[{{ $student->id }}]" value="present" {{ $status == 'present' ? 'checked' : '' }}>
                        </td>
                        <td>
                            <input type="radio" name="attendance[{{ $student->id }}]" value="absent" {{ $status == 'absent' ? 'checked' : '' }}>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">حفظ الحضور</button>
    </form>
</div>
@endsection
