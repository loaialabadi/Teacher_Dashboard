@extends('layouts.app')

@section('content')
<div class="container">
    <h2>تفاصيل تغيير المحاضرة</h2>

    <p><strong>المحاضرة:</strong> {{ $change->lecture->title }}</p>
    <p><strong>المعلم:</strong> {{ $change->lecture->teacher->name }}</p>
    <p><strong>المجموعة:</strong> {{ $change->lecture->group->name }}</p>
    <p><strong>المادة:</strong> {{ $change->lecture->subject->name }}</p>

    <p><strong>الوقت الأصلي:</strong>
        {{ \Carbon\Carbon::parse($change->lecture->start_time)->format('Y-m-d H:i') }}
        -
        {{ \Carbon\Carbon::parse($change->lecture->end_time)->format('Y-m-d H:i') }}
    </p>

    <p><strong>الوقت الجديد:</strong>
        {{ \Carbon\Carbon::parse($change->new_start_time)->format('Y-m-d H:i') }}
        -
        {{ \Carbon\Carbon::parse($change->new_end_time)->format('Y-m-d H:i') }}
    </p>

    <p><strong>الحالة:</strong> {{ $change->status }}</p>
    <p><strong>ملاحظات:</strong> {{ $change->note ?? '-' }}</p>

    <a href="{{ route('lecture_changes.index') }}" class="btn btn-secondary">رجوع</a>
</div>
@endsection
