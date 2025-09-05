@extends('layouts.index')

@section('content')
<div class="container">
    <h2 class="mb-4">تفاصيل ولي الأمر</h2>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $parent->name }}</h5>
            <p class="card-text"><strong>رقم الهاتف:</strong> {{ $parent->phone }}</p>
            <p><strong>الأبناء:</strong></p>
            <ul>
                @foreach($parent->students as $student)
                    <li>{{ $student->name }} - الصف: {{ $student->class->name ?? 'غير محدد' }}</li>
                @endforeach
            </ul>
        </div>
    </div>

    <a href="{{ route('parents.index') }}" class="btn btn-secondary">الرجوع</a>
</div>
@endsection
