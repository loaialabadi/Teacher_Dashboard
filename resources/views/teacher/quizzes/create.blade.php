@extends('layouts.teacher')

@section('content')
<div class="container">
    <h2>➕ إنشاء كويز جديد للمجموعة: {{ $group->name }}</h2>

    <form action="{{ route('teachers.groups.quizzes.store', [$teacher->id, $group->id]) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">عنوان الكويز</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">الوصف</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">تاريخ الكويز</label>
            <input type="date" name="quiz_date" class="form-control" required>
        </div>

        <button class="btn btn-success">💾 حفظ الكويز</button>
    </form>
</div>
@endsection
