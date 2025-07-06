@extends('layouts.index')

@section('content')
<div class="container">
    <h2>إضافة معلم جديد</h2>

    <form action="{{ route('teachers.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>الاسم</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>رقم الهاتف</label>
            <input type="text" name="phone" class="form-control">
        </div>

        <div class="mb-3">
            <label>المادة</label>
            <select name="subject_id" class="form-control" required>
                <option value="">-- اختر المادة --</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">حفظ</button>
    </form>
</div>
@endsection