@extends('layouts.index')

@section('content')
<div class="container">
    <h2>تسجيل الحضور للحصة: {{ $appointment->scheduled_at->format('Y-m-d H:i') }}</h2>
    <h4>المعلم: {{ $appointment->teacher->name }}</h4>

    <form method="POST" action="{{ route('attendance.save', $appointment->id) }}">
        @csrf
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>اسم الطالب</th>
                    <th>الحضور</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr>
                    <td>{{ $student->name }}</td>
                    <td>
                        <select name="attendance[{{ $student->id }}]" class="form-select" required>
                            <option value="">اختر الحالة</option>
                            <option value="present" {{ (isset($attendances[$student->id]) && $attendances[$student->id]->status == 'present') ? 'selected' : '' }}>حاضر</option>
                            <option value="absent" {{ (isset($attendances[$student->id]) && $attendances[$student->id]->status == 'absent') ? 'selected' : '' }}>غائب</option>
                        </select>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-success">حفظ الحضور</button>
        <a href="{{ route('appointments.index', $appointment->teacher->id) }}" class="btn btn-secondary">عودة</a>
    </form>
</div>
@endsection
