@extends('layouts.index')

@section('content')
    <div class="container">
        <h2>تعديل مجموعة: {{ $group->name }} للمعلم: {{ $teacher->name }}</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('groups.update', ['teacher' => $teacher->id, 'group' => $group->id]) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="group_name" class="form-label">اسم المجموعة</label>
                <input type="text" class="form-control" id="group_name" name="group_name"
                       value="{{ old('group_name', $group->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="subject_id" class="form-label">المادة الدراسية</label>
                <select name="subject_id" id="subject_id" class="form-select" required>
                    <option value="">-- اختر المادة --</option>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}"
                            {{ old('subject_id', $group->subject_id) == $subject->id ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="grade_id" class="form-label">الفصل الدراسي</label>
                <select name="grade_id" id="grade_id" class="form-select" required>
                    <option value="">-- اختر الفصل --</option>
                    @foreach ($grades as $grade)
                        <option value="{{ $grade->id }}"
                            {{ old('grade_id', $group->grade_id) == $grade->id ? 'selected' : '' }}>
                            {{ $grade->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="lecture_id" class="form-label">المحاضرة</label>
                <select name="lecture_id" id="lecture_id" class="form-select" required>
                    <option value="">-- اختر المحاضرة --</option>
                    @foreach ($lectures as $lecture)
                        <option value="{{ $lecture->id }}"
                            {{ old('lecture_id', $group->lecture_id) == $lecture->id ? 'selected' : '' }}>
                            {{ $lecture->title }} ({{ $lecture->start_time }} - {{ $lecture->end_time }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">اختر الطلاب</label>
                <div>
                    @foreach ($students as $student)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="student_ids[]" value="{{ $student->id }}"
                                id="student_{{ $student->id }}"
                                {{ in_array($student->id, old('student_ids', $group->students->pluck('id')->toArray())) ? 'checked' : '' }}>
                            <label class="form-check-label" for="student_{{ $student->id }}">
                                {{ $student->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="btn btn-primary">تحديث المجموعة</button>
        </form>
    </div>
@endsection
