@extends('layouts.index')

@section('content')
<div class="container">
    <h2>نقل طلاب من المجموعة: {{ $sourceGroup->name }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('groups.transferStudents', ['teacher' => $teacher->id, 'sourceGroup' => $sourceGroup->id]) }}">
        @csrf

        <div class="mb-3">
            <label for="target_group_id" class="form-label">اختر المجموعة الهدف</label>
            <select name="target_group_id" id="target_group_id" class="form-select" required>
                <option value="">-- اختر المجموعة --</option>
                @foreach($targetGroups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">اختر الطلاب للنقل</label>
            <div>
                @foreach($students as $student)
                    <div class="form-check">
                        <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" id="student_{{ $student->id }}" class="form-check-input">
                        <label for="student_{{ $student->id }}" class="form-check-label">{{ $student->name }}</label>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">نقل الطلاب</button>
        <a href="{{ route('groups.show', ['teacher' => $teacher->id, 'group' => $sourceGroup->id]) }}" class="btn btn-secondary">عودة</a>
    </form>
</div>
@endsection
