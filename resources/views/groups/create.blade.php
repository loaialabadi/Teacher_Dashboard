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

            <div class="mb-3">
                <label class="form-label">التواريخ</label>
                <input type="date" name="dates[]" class="form-control mb-2" required>
                <input type="date" name="dates[]" class="form-control mb-2">
                <small class="form-text text-muted">يمكنك إضافة تاريخين كمثال. أضف المزيد في حالة الحاجة.</small>
            </div>

            <div class="mb-3">
                <label class="form-label">الأوقات</label>
                <input type="time" name="times[]" class="form-control mb-2" required>
                <input type="time" name="times[]" class="form-control mb-2">
                <small class="form-text text-muted">تطابق عدد الأوقات مع التواريخ.</small>
            </div>

            <button type="submit" class="btn btn-primary">إنشاء المجموعة</button>
        </form>
    </div>
@endsection
