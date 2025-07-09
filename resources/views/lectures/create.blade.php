@extends('layouts.index')

@section('content')
<div class="container my-4">
    <h2 class="mb-4">➕ إضافة محاضرة جديدة للمدرس: {{ $teacher->name }}</h2>

    <form action="{{ route('lectures.store', $teacher->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">عنوان المحاضرة</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">الوصف</label>
            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="start_time" class="form-label">وقت البداية</label>
            <input type="datetime-local" name="start_time" id="start_time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="end_time" class="form-label">وقت النهاية</label>
            <input type="datetime-local" name="end_time" id="end_time" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">حفظ المحاضرة</button>
        <a href="{{ route('lectures.index', $teacher->id) }}" class="btn btn-secondary">رجوع</a>
    </form>
</div>
@endsection
