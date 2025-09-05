@extends('layouts.index')

@section('content')
<div class="container">
    <h2 class="mb-4">إضافة ولي أمر جديد</h2>

    <form action="{{ route('parents.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">الاسم</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">رقم الهاتف</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">كلمة المرور</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">حفظ</button>
    </form>
</div>
@endsection
