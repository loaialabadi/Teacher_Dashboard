@extends('layouts.teacher')

@section('content')
<div class="container">
    <h2>➕ إضافة مواد للمدرس: {{ $teacher->name }}</h2>

    <form method="POST" action="{{ route('teachers.subjects.store', $teacher->id) }}">
        @csrf

        <div class="form-group mb-3">
            <label for="subjects">اختر المواد:</label>
            <select name="subjects[]" id="subjects" class="form-select" multiple required>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}"
                        {{ in_array($subject->id, old('subjects', $teacher->subjects->pluck('id')->toArray())) ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
            <small class="text-muted">اضغط Ctrl أو Cmd لاختيار أكثر من مادة</small>
        </div>

        <button type="submit" class="btn btn-success mt-3">💾 حفظ</button>
    </form>
</div>
@endsection
