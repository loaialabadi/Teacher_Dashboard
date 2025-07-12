@extends('layouts.index')

@section('content')
<div class="container">
    <h2>إضافة فصل جديدة</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<form method="POST" action="{{ route('grades.store', ['teacher' => $teacher->id]) }}">
    @csrf
    <select name="grade_id" required>
        @foreach($grades as $grade)
            <option value="{{ $grade->id }}">{{ $grade->name }}</option>
        @endforeach
    </select>
    <button type="submit">إضافة</button>
</form>

@endsection
