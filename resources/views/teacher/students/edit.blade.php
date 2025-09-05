@extends('layouts.index')

@section('content')
<div class="container">
    <h2><i class="fas fa-edit"></i> تعديل بيانات الطالب</h2>

    <form action="{{ route('students.update', $student->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>اسم الطالب:</label>
            <input type="text" name="name" class="form-control" value="{{ $student->name }}" required>
        </div>

        <div class="form-group">
            <label>رقم الهاتف:</label>
            <input type="text" name="phone" class="form-control" value="{{ $student->phone }}" required>
        </div>

        <div class="form-group">
            <label>المعلم:</label>
            <select name="teacher_id" class="form-control" required>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" {{ $student->teacher_id == $teacher->id ? 'selected' : '' }}>
                        {{ $teacher->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>ولي الأمر:</label>
            <select name="parent_id" class="form-control" required>
                @foreach($parents as $parent)
                    <option value="{{ $parent->id }}" {{ $student->parent_id == $parent->id ? 'selected' : '' }}>
                        {{ $parent->name }} - {{ $parent->phone }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> حفظ التعديلات</button>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">رجوع</a>
    </form>
</div>
@endsection
