@extends('layouts.index')

@section('content')
<div class="container my-4">
    <h2 class="mb-4">✏️ تعديل المحاضرة: {{ $lecture->title }}</h2>

    <form action="{{ route('lectures.update', [$teacher->id, $lecture->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label">عنوان المحاضرة</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $lecture->title }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">الوصف</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ $lecture->description }}</textarea>
        </div>

        <div class="mb-3">
            <label for="start_time" class="form-label">وقت البداية</label>
            <input type="datetime-local" name="start_time" id="start_time" class="form-control" value="{{ \Carbon\Carbon::parse($lecture->start_time)->format('Y-m-d\TH:i') }}" required>
        </div>

        <div class="mb-3">
            <label for="end_time" class="form-label">وقت النهاية</label>
            <input type="datetime-local" name="end_time" id="end_time" class="form-control" value="{{ \Carbon\Carbon::parse($lecture->end_time)->format('Y-m-d\TH:i') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">تحديث</button>
        <a href="{{ route('lectures.index', $teacher->id) }}" class="btn btn-secondary">إلغاء</a>
    </form>
</div>
@endsection
