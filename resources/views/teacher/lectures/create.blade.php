@extends('layouts.teacher')

@section('content')
<div class="container my-4">
    <h2>➕ إضافة محاضرة</h2>

    @if($groups->count())
    <form method="POST" action="{{ route('teachers.lectures.store', $teacher->id) }}">
        @csrf

        {{-- اختيار المجموعة --}}
        <div class="mb-3">
            <label for="group_id">اختر المجموعة:</label>
            <select name="group_id" id="group_id" class="form-control" required>
                <option value="">-- اختر مجموعة --</option>
                @foreach($groups as $group)
                    <option value="{{ $group->id }}">
                        {{ $group->name }} - {{ $group->subject->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- باقي الفورم --}}
        <div class="mb-3">
            <label>عنوان المحاضرة:</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>وصف المحاضرة:</label>
            <textarea name="description" class="form-control"></textarea>
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
    <div class="alert alert-warning">لا توجد مجموعة متاحة لإضافة المحاضرة.</div>
    @endif
</div>
@endsection
