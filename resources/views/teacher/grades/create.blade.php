@extends('layouts.index')

@section('content')
<div class="container my-4">
    <h2 class="mb-4">➕ إضافة فصل دراسي جديد للمدرس: {{ $teacher->name }}</h2>


    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('teachers.grades.store', ['teacher' => $teacher->id]) }}">
                @csrf
                <div class="mb-3">
                    <label for="grade_id" class="form-label">اختر الفصل الدراسي</label>
                    <select name="grade_id" id="grade_id" class="form-select" required>
                        <option value="" disabled selected>-- اختر الفصل --</option>
                        @foreach($grades as $grade)
                            <option value="{{ $grade->id }}">{{ $grade->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-plus-circle"></i> إضافة الفصل
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
