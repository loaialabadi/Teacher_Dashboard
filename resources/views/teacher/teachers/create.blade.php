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
            <label>رقم الهاتف</label>
            <input type="text" name="phone" class="form-control">
        </div>

<select name="user_id" required>
    @foreach ($users as $user)
        <option value="{{ $user->id }}">{{ $user->name }}</option>
    @endforeach
</select>


        <button type="submit" class="btn btn-primary">حفظ</button>
    </form>
</div>
@endsection