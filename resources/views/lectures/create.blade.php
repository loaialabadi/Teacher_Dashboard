@extends('layouts.index')

@section('content')
<div class="container my-4">
    <h2>📚 إضافة محاضرات جديدة للمجموعة</h2>

    <form action="{{ route('lectures.storeMultiple', $teacher->id) }}" method="POST">
        @csrf

        <div id="lectures-container">
            <div class="lecture-entry border p-3 mb-3">
                <div class="mb-2">
                    <label>المجموعة</label>
                    <select name="lectures[0][group_id]" class="form-select" required>
                        <option value="">اختر المجموعة</option>
                        @foreach ($teacher->groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>

                <input type="text" name="lectures[0][title]" class="form-control mb-2" placeholder="عنوان المحاضرة" required>
                <textarea name="lectures[0][description]" class="form-control mb-2" placeholder="وصف المحاضرة"></textarea>
                <input type="datetime-local" name="lectures[0][start_time]" class="form-control mb-2" required>
                <input type="datetime-local" name="lectures[0][end_time]" class="form-control mb-2" required>
            </div>
        </div>

        <button type="button" class="btn btn-secondary mb-3" onclick="addLecture()">➕ إضافة محاضرة أخرى</button>
        <br>
        <button type="submit" class="btn btn-success">💾 حفظ المحاضرات</button>
    </form>
</div>

<script>
    let lectureIndex = 1;

    function addLecture() {
        const container = document.getElementById('lectures-container');
        const html = `
            <div class="lecture-entry border p-3 mb-3">
                <div class="mb-2">
                    <label>المجموعة</label>
                    <select name="lectures[${lectureIndex}][group_id]" class="form-select" required>
                        <option value="">اختر المجموعة</option>
                        @foreach ($teacher->groups as $group)
                            <option value="{{ $group->id }}">{{ $group->name }}</option>
                        @endforeach
                    </select>
                </div>
                <input type="text" name="lectures[${lectureIndex}][title]" class="form-control mb-2" placeholder="عنوان المحاضرة" required>
                <textarea name="lectures[${lectureIndex}][description]" class="form-control mb-2" placeholder="وصف المحاضرة"></textarea>
                <input type="datetime-local" name="lectures[${lectureIndex}][start_time]" class="form-control mb-2" required>
                <input type="datetime-local" name="lectures[${lectureIndex}][end_time]" class="form-control mb-2" required>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        lectureIndex++;
    }
</script>
@endsection
