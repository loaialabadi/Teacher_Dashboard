@extends('layouts.teacher')


@section('content')
<div class="container">
    <h2>🛠 تعديل المواد المرتبطة بالمدرس: {{ $teacher->name }}</h2>

    <form method="POST" action="{{ route('subjects.update', $teacher->id) }}">
        @csrf
        @method('PUT')

        @foreach ($allSubjects as $subject)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" 
                       name="subjects[]" value="{{ $subject->id }}"
                       {{ in_array($subject->id, $teacherSubjects) ? 'checked' : '' }}>
                <label class="form-check-label">{{ $subject->name }}</label>
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary mt-3">💾 حفظ</button>
    </form>
</div>
@endsection
