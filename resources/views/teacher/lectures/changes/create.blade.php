@extends('layouts.teacher')

@section('content')
<div class="container">
    <h2>إضافة تغيير جديد للمحاضرة</h2>

    <form action="{{ route('teachers.lectures.lecture_changes.store', $teacher->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">اختر المحاضرة</label>
            <select name="lecture_id" class="form-control" required>
                @foreach($lectures as $lecture)
                    <option value="{{ $lecture->id }}">
                        {{ $lecture->title }} - ({{ $lecture->group->name }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">التاريخ الجديد</label>
            <input type="date" name="new_date" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">الوقت الجديد (من)</label>
            <input type="time" name="new_start_time" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">الوقت الجديد (إلى)</label>
            <input type="time" name="new_end_time" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">سبب التغيير</label>
            <textarea name="reason" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-success">حفظ</button>
        <a href="{{ route('teachers.lectures.lecture_changes.index', $teacher->id) }}" class="btn btn-secondary">إلغاء</a>
    </form>
</div>
@endsection
