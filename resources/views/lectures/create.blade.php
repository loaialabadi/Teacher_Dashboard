@extends('layouts.index')

@section('content')
<div class="container my-4">
    <h2>➕ إضافة محاضرة</h2>

    {{-- نستخدم GET علشان نعيد تحميل الصفحة لما تتغير المجموعة --}}
    <form method="GET" action="{{ route('lectures.create', $teacher->id) }}">
        <div class="mb-3">
            <label for="group_id">اختر المجموعة:</label>
            <select name="group_id" id="group_id" class="form-select" onchange="this.form.submit()" required>
                <option value="">اختر المجموعة</option>
                @foreach($teacher->groups as $group)
                    @if ($group->subject)
                        <option value="{{ $group->id }}" {{ request('group_id') == $group->id ? 'selected' : '' }}>
                            {{ $group->name }} - {{ $group->subject->name }}
                        </option>
                    @endif
                @endforeach
            </select>
        </div>





    </form>

    {{-- فورم حفظ المحاضرة --}}
    @if (request('group_id') && $selectedGroup)
    <form method="POST" action="{{ route('lectures.store', $teacher->id) }}">
        @csrf
        <input type="hidden" name="group_id" value="{{ $selectedGroup->id }}">
        <input type="hidden" name="subject_id" value="{{ $selectedGroup->subject->id }}">

        <div class="mb-3">
            <label>اسم المادة:</label>
            <input type="text" class="form-control" value="{{ $selectedSubjectName }}" readonly>
        </div>

        <div class="mb-3">
            <label>عنوان المحاضرة:</label>
            <input type="text" name="title" class="form-control" required>
        </div>

            <div class="mb-3">
        <label>الفصل الدراسي:</label>
        <input type="text" class="form-control" value="{{ $selectedGroup->grade->name }}" readonly>
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
    @endif
</div>
@endsection
