@extends('layouts.index')

@section('content')
<div class="container my-5">
    <h2>تعديل حضور الطالب: {{ $student->name }} في المحاضرة: {{ $lecture->title }}</h2>

    <form action="{{ route('attendances.update', ['lecture' => $lecture->id, 'student' => $student->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="status" class="form-label">حالة الحضور</label>
            <select name="status" id="status" class="form-select" required>
                <option value="present" {{ $attendance->status == 'present' ? 'selected' : '' }}>حاضر</option>
                <option value="absent" {{ $attendance->status == 'absent' ? 'selected' : '' }}>غائب</option>
                <option value="late" {{ $attendance->status == 'late' ? 'selected' : '' }}>متأخر</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">تحديث الحالة</button>
    </form>
</div>
@endsection
