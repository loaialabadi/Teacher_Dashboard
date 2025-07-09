@extends('layouts.index')

@section('content')
<div class="container mt-4">
    <h2>➕ تسجيل طالب جديد يدويًا للمعلم: {{ $teacher->name }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('teachers.students.store', $teacher->id) }}" method="POST">
        @csrf

        <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">

        <div class="mb-3">
            <label for="student_name" class="form-label">اسم الطالب</label>
            <input type="text" name="name" id="student_name" class="form-control" required value="{{ old('name') }}">
        </div>

        <div class="mb-3">
            <label for="student_phone" class="form-label">رقم تليفون الطالب</label>
            <input type="text" name="phone" id="student_phone" class="form-control" required value="{{ old('phone') }}">
        </div>

        <div class="mb-3">
            <label for="parent_name" class="form-label">اسم ولي الأمر</label>
            <input type="text" name="parent_name" id="parent_name" class="form-control" required value="{{ old('parent_name') }}">
        </div>

        <div class="mb-3">
            <label for="parent_phone" class="form-label">رقم تليفون ولي الأمر</label>
            <input type="text" name="parent_phone" id="parent_phone" class="form-control" required value="{{ old('parent_phone') }}">
        </div>

        <div class="mb-3">
            <label for="subject_id" class="form-label">اختر المادة</label>
            <select name="subject_id" id="subject_id" class="form-select" required>
                <option value="">-- اختر مادة --</option>
                @foreach ($teacher->subjects as $subject)
                    <option value="{{ $subject->id }}" {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="grade_id" class="form-label">اختر الفصل الدراسي</label>
            <select name="grade_id" id="grade_id" class="form-select" required>
                <option value="">-- اختر فصل دراسي --</option>
                @foreach ($teacher->grades as $grade)
                    <option value="{{ $grade->id }}" {{ old('grade_id') == $grade->id ? 'selected' : '' }}>
                        {{ $grade->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="group_id" class="form-label">اختر مجموعة (اختياري)</label>
            <select name="group_id" id="group_id" class="form-select">
                <option value="">-- بدون مجموعة --</option>
                @foreach ($teacher->groups as $group)
                    <option value="{{ $group->id }}" {{ old('group_id') == $group->id ? 'selected' : '' }}>
                        {{ $group->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">💾 حفظ الطالب</button>
    </form>
</div>
@endsection
