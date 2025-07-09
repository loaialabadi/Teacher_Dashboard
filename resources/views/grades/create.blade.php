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

<form action="{{ route('grades.store', $teacher->id) }}" method="POST">
    @csrf

    {{-- Hidden teacher --}}
    <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">

    <div class="mb-3">
        <label for="grade_id" class="form-label">اختر الفصل الدراسي</label>
        <select name="grade_id" id="grade_id" class="form-select" required>
            <option value="">-- اختر الفصل الدراسي --</option>
            @foreach ($grades as $grade)
                <option value="{{ $grade->id }}" {{ old('grade_id') == $grade->id ? 'selected' : '' }}>
                    {{ $grade->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- باقي الحقول مثل الوقت أو المادة... حسب تصميمك --}}

    <button type="submit" class="btn btn-primary">حفظ</button>
</form>

@endsection
