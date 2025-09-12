@extends('layouts.teacher')

@section('content')
<div class="container my-5">
    <h2>تسجيل حضور وغياب لمحاضرة: {{ $lecture->title }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

<form action="{{ route('teachers.lectures.attendance.store', ['teacher' => $teacher->id, 'lecture' => $lecture->id]) }}" method="POST">
        @csrf

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>اسم الطالب</th>
                    <th>الحالة</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>
                        <select name="statuses[{{ $student->id }}]" class="form-select" required>
                            <option value="present" {{ isset($attendances[$student->id]) && $attendances[$student->id]->status === 'present' ? 'selected' : '' }}>حاضر</option>
                            <option value="absent" {{ isset($attendances[$student->id]) && $attendances[$student->id]->status === 'absent' ? 'selected' : '' }}>غائب</option>
                            <option value="late" {{ isset($attendances[$student->id]) && $attendances[$student->id]->status === 'late' ? 'selected' : '' }}>متأخر</option>
                        </select>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">حفظ الحضور</button>
    </form>
</div>
@endsection
