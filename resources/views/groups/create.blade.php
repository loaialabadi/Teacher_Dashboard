@extends('layouts.index')

@section('content')
<div class="container">
    <h2>إنشاء مجموعة جديدة للمعلم: {{ $teacher->name }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('groups.store', ['teacher' => $teacher->id]) }}">
        @csrf
        <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">

        <div class="mb-3">
            <label for="group_name" class="form-label">اسم المجموعة</label>
            <input type="text" class="form-control" id="group_name" name="group_name" value="{{ old('group_name') }}" required>
        </div>

        <div class="mb-3">
            <label for="subject_id" class="form-label">اختر المادة</label>
            <select class="form-control" id="subject_id" name="subject_id" required>
                <option value="">-- اختر --</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="grade_id" class="form-label">اختر الفصل الدراسي</label>
            <select class="form-control" id="grade_id" name="grade_id" required>
                <option value="">-- اختر --</option>
                @foreach($grades as $grade)
                    <option value="{{ $grade->id }}" {{ old('grade_id') == $grade->id ? 'selected' : '' }}>
                        {{ $grade->name }}
                    </option>
                @endforeach
            </select>
        </div>



        <div class="mb-3">
            <label class="form-label">اختر الطلاب</label>
            <div>
                @foreach ($students as $student)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="student_ids[]" value="{{ $student->id }}" id="student_{{ $student->id }}"
                            {{ (is_array(old('student_ids')) && in_array($student->id, old('student_ids'))) ? 'checked' : '' }}>
                        <label class="form-check-label" for="student_{{ $student->id }}">
                            {{ $student->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">إنشاء المجموعة</button>
    </form>
</div>
@endsection
