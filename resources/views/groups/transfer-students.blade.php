@extends('layouts.index')

@section('content')
<div class="container my-5">

    <h2>نقل طلاب من مجموعة: {{ $sourceGroup->name }}</h2>

    <form action="{{ route('groups.transfer', ['teacher' => $teacher->id, 'sourceGroup' => $sourceGroup->id]) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="target_group_id" class="form-label">اختر المجموعة المستهدفة</label>
            <select name="target_group_id" id="target_group_id" class="form-select" required>
                <option value="">-- اختر المجموعة --</option>
                @foreach ($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                @endforeach
            </select>
        </div>

        <h4>اختر الطلاب للنقل:</h4>
        <div class="list-group mb-3" style="max-height: 400px; overflow-y: auto;">
            @foreach ($students as $student)
                <label class="list-group-item">
                    <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" 
                        @if($student->group_id == $sourceGroup->id) checked @endif>
                    {{ $student->name }} - {{ $student->phone }}
                    @if($student->group)
                        <small class="text-muted">(في مجموعة: {{ $student->group->name }})</small>
                    @endif
                </label>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary">نقل الطلاب</button>
    </form>

</div>
@endsection
