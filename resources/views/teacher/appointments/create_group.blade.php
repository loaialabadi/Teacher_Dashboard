@extends('layouts.index')

@section('content')
<div class="container">
    <h2>🧑‍🏫 إنشاء مجموعة جديدة للمعلم: {{ $teacher->name }}</h2>

    <form action="{{ route('teachers.store_group') }}" method="POST">
        @csrf
        <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">

        <div class="mb-3">
            <label>اسم المجموعة</label>
            <input type="text" name="group_name" class="form-control" required>
        </div>

        <div id="appointments-section">
            <div class="appointment-row mb-3">
                <label>تاريخ الحصة</label>
                <input type="date" name="dates[]" class="form-control" required>

                <label>الوقت</label>
                <input type="time" name="times[]" class="form-control" required>
            </div>
        </div>

        <button type="button" id="add-more" class="btn btn-sm btn-secondary">+ إضافة موعد آخر</button>

        <br><br>
        <button type="submit" class="btn btn-primary">إنشاء المجموعة والحصص</button>
    </form>
</div>

<script>
document.getElementById('add-more').addEventListener('click', function () {
    const section = document.getElementById('appointments-section');
    const html = `
        <div class="appointment-row mb-3">
            <label>تاريخ الحصة</label>
            <input type="date" name="dates[]" class="form-control" required>
            <label>الوقت</label>
            <input type="time" name="times[]" class="form-control" required>
        </div>`;
    section.insertAdjacentHTML('beforeend', html);
});
</script>
@endsection
