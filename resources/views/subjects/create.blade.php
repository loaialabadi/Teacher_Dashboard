@extends('layouts.index')



@section('content')
<div class="container">
    <h2>➕ إضافة مواد للمدرس: {{ $teacher->name }}</h2>

    <form method="POST" action="{{ route('subjects.store', $teacher->id) }}">
        @csrf

        <div class="form-group">
            <label>اختر المواد:</label>
            @foreach($subjects as $subject)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="subjects[]" value="{{ $subject->id }}">
                    <label class="form-check-label">{{ $subject->name }}</label>
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-success mt-3">💾 حفظ</button>
    </form>
</div>
@endsection
