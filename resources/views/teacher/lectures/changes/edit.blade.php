@extends('layouts.teacher')

@section('content')
<div class="container">
    <h2>تعديل تغيير المحاضرة</h2>
<form action="{{ route('teachers.lectures.lecture_changes.update', [$teacher->id, $lectureChange->id]) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">المحاضرة</label>
        <input type="text" class="form-control" value="{{ $lectureChange->lecture->title }}" disabled>
    </div>

    <div class="mb-3">
        <label class="form-label">الوقت الجديد (من)</label>
        <input type="datetime-local" name="new_start_time" class="form-control" value="{{ $lectureChange->new_start_time }}" required>
    </div>

        <div class="mb-3">
            <label class="form-label">الوقت الجديد (إلى)</label>
            <input type="datetime-local" name="new_end_time" class="form-control" value="{{ $lectureChange->new_end_time }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">الحالة</label>
            <select name="status" class="form-control">
                <option value="pending" @if($lectureChange->status=='pending') selected @endif>قيد المراجعة</option>
                <option value="approved" @if($lectureChange->status=='approved') selected @endif>موافق عليه</option>
                <option value="rejected" @if($lectureChange->status=='rejected') selected @endif>مرفوض</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">ملاحظات</label>
            <textarea name="note" class="form-control">{{ $lectureChange->note }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">تحديث</button>
        <a href="{{ route('teachers.lectures.lecture_changes.index', $teacher->id) }}" class="btn btn-secondary">إلغاء</a>
    </form>
</div>
@endsection
