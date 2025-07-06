@extends('layouts.index')

@section('content')
<div class="container">
    <h2>إضافة طالب جديد لمجموعة: {{ $group->name }}</h2>

    <form method="POST" action="{{ route('groups.addStudentStore', ['teacher' => $teacher->id, 'group' => $group->id]) }}">
        @csrf
        <div class="mb-3">
            <label for="student_id" class="form-label">اختر طالبًا</label>
            <select name="student_id" id="student_id" class="form-select" required>
                <option value="">-- اختر طالب --</option>
                @foreach ($availableStudents as $student)
                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">إضافة الطالب</button>
    </form>
</div>
@endsection
