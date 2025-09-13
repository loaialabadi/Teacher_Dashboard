@extends('layouts.index')

@section('content')
<div class="container">
    <h2>تعديل بيانات المعلم: {{ $teacher->name }}</h2>

    {{-- عرض الأخطاء --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('teachers.update', $teacher->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">الاسم</label>
            <input type="text" id="name" name="name" 
                   value="{{ old('name', $teacher->name) }}" 
                   class="form-control">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">البريد الإلكتروني</label>
            <input type="email" id="email" name="email" 
                   value="{{ old('email', $teacher->user->email) }}" 
                   class="form-control">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">رقم الهاتف</label>
            <input type="text" id="phone" name="phone" 
                   value="{{ old('phone', $teacher->phone) }}" 
                   class="form-control">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">كلمة المرور (اتركها فارغة إذا لم ترغب في التغيير)</label>
            <input type="password" id="password" name="password" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
    </form>
</div>
@endsection
