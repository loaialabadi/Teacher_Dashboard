@extends('layouts.teacher')

@section('content')
<div class="container">
    <h2>إضافة طالب للمجموعة: {{ $group->name }}</h2>

    <form action="{{ route('teachers.groups.add-student.form', ['teacher' => $teacher->id, 'group' => $group->id]) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="student_id" class="form-label">اختر الطالب</label>
            <select name="student_id" id="student_id" class="form-select" required>
                <option value="">-- اختر طالب --</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }} ({{ $student->phone }})</option>
                @endforeach
            </select>
        </div>

        {{-- لو حابب تضيف اختيار المادة أو الحصة --}}
        <div class="mb-3">
            <label for="lecture_id" class="form-label">اختر الحصة</label>
            <select name="lecture_id" id="lecture_id" class="form-select" required>
                <option value="">-- اختر الحصة --</option>
                @foreach ($lectures as $lecture)
                    <option value="{{ $lecture->id }}">{{ $lecture->title }} ({{ $lecture->start_time }} - {{ $lecture->end_time }})</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">إضافة الطالب</button>
    </form>
</div>
@endsection
