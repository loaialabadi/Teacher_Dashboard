@extends('layouts.teacher')

@section('content')
<div class="container my-4">
    <h2>➕ إضافة محاضرة</h2>

    {{-- فورم حفظ المحاضرة مباشرة --}}
    @if($selectedGroup)
    <form method="POST" action="{{ route('teachers.lectures.store', $teacher->id) }}">
        @csrf
        {{-- المجموعة والفصل والمادة --}}
        <input type="hidden" name="group_id" value="{{ $selectedGroup->id }}">
        <input type="hidden" name="subject_id" value="{{ $selectedGroup->subject->id }}">

        <div class="mb-3">
            <label>الفصل الدراسي:</label>
            <input type="text" class="form-control" value="{{ $selectedGroup->grade->name }}" readonly>
        </div>

        <div class="mb-3">
            <label>المادة:</label>
            <input type="text" class="form-control" value="{{ $selectedGroup->subject->name }}" readonly>
        </div>

        <div class="mb-3">
            <label>عنوان المحاضرة:</label>
            <input type="text" name="title" class="form-control" placeholder="أدخل عنوان المحاضرة" required>
        </div>

        <div class="mb-3">
            <label>وصف المحاضرة:</label>
            <textarea name="description" class="form-control" placeholder="أدخل وصف المحاضرة"></textarea>
        </div>

        <div class="mb-3">
            <label>تاريخ ووقت البدء:</label>
            <input type="datetime-local" name="start_time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>تاريخ ووقت الانتهاء:</label>
            <input type="datetime-local" name="end_time" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">💾 حفظ المحاضرة</button>
    </form>
    @else
    <div class="alert alert-warning">
        لا توجد مجموعة متاحة لإضافة المحاضرة.
    </div>
    @endif
</div>
@endsection
