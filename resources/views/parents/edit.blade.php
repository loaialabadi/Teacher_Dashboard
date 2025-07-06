@extends('layouts.index')

@section('content')
<div class="container">
    <h2 class="mb-4">تعديل بيانات ولي الأمر</h2>

    <form action="{{ route('parents.update', $parent->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">الاسم</label>
            <input type="text" name="name" class="form-control" value="{{ $parent->name }}" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">رقم الهاتف</label>
            <input type="text" name="phone" class="form-control" value="{{ $parent->phone }}" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">كلمة المرور (اتركه فارغًا إن لم ترغب بالتعديل)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">تحديث</button>
    </form>
</div>
@endsection
