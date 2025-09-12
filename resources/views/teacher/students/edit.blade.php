@extends('layouts.teacher')

@section('content')
<div class="container my-4">
    <h2><i class="fas fa-edit"></i> تعديل بيانات الطالب</h2>

    <form action="{{ route('teachers.students.update', [$teacher->id, $student->id]) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- اسم الطالب --}}
        <div class="form-group mb-3">
            <label>اسم الطالب:</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $student->name) }}" required>
        </div>

        {{-- رقم الهاتف --}}
        <div class="form-group mb-3">
            <label>رقم الهاتف:</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $student->phone) }}" required>
        </div>

        {{-- المعلم --}}
        <div class="form-group mb-3">
            <label>المعلم:</label>
            <select name="teacher_id" class="form-control" required>
                @foreach($teachers as $t)
                    <option value="{{ $t->id }}" {{ $student->teacher_id == $t->id ? 'selected' : '' }}>
                        {{ $t->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- ولي الأمر --}}
        <div class="form-group mb-3">
            <label>ولي الأمر:</label>
            <select name="parent_id" class="form-control" required>
                @foreach($parents as $p)
                    <option value="{{ $p->id }}" {{ $student->parent_id == $p->id ? 'selected' : '' }}>
                        {{ $p->name }} - {{ $p->phone }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- المادة --}}
        <div class="form-group mb-3">
            <label>المادة:</label>
            <select name="subject_id" class="form-control" required>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ $student->subject_id == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- الفصل الدراسي --}}
        <div class="form-group mb-3">
            <label>الفصل الدراسي:</label>
            <select name="grade_id" class="form-control" required>
                @foreach($grades as $grade)
                    <option value="{{ $grade->id }}" {{ $student->grade_id == $grade->id ? 'selected' : '' }}>
                        {{ $grade->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- المجموعة --}}
        <div class="form-group mb-3">
            <label>المجموعة:</label>
            <select name="group_id" class="form-control">
                <option value="">بدون مجموعة</option>
                @foreach($groups as $group)
                    <option value="{{ $group->id }}" {{ $student->group_id == $group->id ? 'selected' : '' }}>
                        {{ $group->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- الأزرار --}}
        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> حفظ التعديلات</button>
        <a href="{{ route('teachers.students.index', $teacher->id) }}" class="btn btn-secondary">رجوع</a>
    </form>
</div>
@endsection
