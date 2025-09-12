@extends('layouts.teacher')

@section('content')
<div class="container">
    <h2>إضافة حصة جديدة</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('appointments.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="teacher_id">اختر المعلم</label>
            <select name="teacher_id" id="teacher_id" class="form-control" required>
                <option value="">-- اختر المعلم --</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="appointment_date">تاريخ الحصة</label>
            <input type="date" name="appointment_date" id="appointment_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="appointment_time">وقت الحصة</label>
            <input type="time" name="appointment_time" id="appointment_time" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">حفظ الحصة</button>
    </form>
</div>
@endsection
