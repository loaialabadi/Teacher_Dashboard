@extends('layouts.index')

@section('content')

<div class="container my-4">
    <h2>بيانات الطالب: {{ $student->name }}</h2>
    <p>رقم الهاتف: {{ $student->phone }}</p>
    <p>ولي الأمر: {{ $student->parent->name ?? '-' }}</p>
    <p>هاتف ولي الأمر: {{ $student->parent->phone ?? '-' }}</p>
    <p>الفصل الدراسي: {{ $student->grade->name ?? '-' }}</p>
    <p>المادة: {{ $student->subject->name ?? '-' }}</p>
</div>
@endsection