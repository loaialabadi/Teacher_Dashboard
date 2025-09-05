@extends('layouts.index')

@section('content')
<div class="container my-4">

    <h2 class="mb-3 text-center">👋 مرحب بك في المنظومة يا {{ $student->name }}</h2>
    <p class="text-center">📱 الهاتف: {{ $student->phone }}</p>

    @if($student->parent)
        <p class="text-center">👨‍👩‍👦 ولي الأمر: {{ $student->parent->name }} ({{ $student->parent->phone }})</p>
    @endif

    <hr>

    <h4 class="mb-3">👨‍🏫 اختر المدرس لعرض تفاصيله</h4>

    @php
        $teachers = $student->groups->groupBy('teacher.id');
    @endphp

    @forelse($teachers as $teacherId => $groups)
        @php $teacher = $groups->first()->teacher; @endphp

        <div class="card mb-3 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">👨‍🏫 {{ $teacher->name }}</h5>
                <a href="{{ route('students.teacher.details', [$student->id, $teacher->id]) }}" class="btn btn-primary">
                    عرض التفاصيل ➡
                </a>
            </div>
        </div>
    @empty
        <div class="alert alert-info text-center">❌ لا يوجد مدرسين مرتبطين بك حالياً</div>
    @endforelse

    <a href="{{ route('students.index') }}" class="btn btn-secondary mt-3">⬅ رجوع</a>
</div>
@endsection
