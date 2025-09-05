@extends('layouts.index')

@section('content')
<div class="container my-4">

    <h2 class="mb-3">👨‍🏫 تفاصيل المدرس: {{ $teacher->name }}</h2>
    <h4>👨‍🎓 الطالب: {{ $student->name }}</h4>

    <hr>

    <h5>📘 المجموعات الخاصة بك مع هذا المدرس:</h5>

    @forelse($groups as $group)
        <div class="card p-3 mb-2">
            <div>📖 المادة: {{ $group->subject->name ?? '-' }}</div>
            <div>📌 المجموعة: {{ $group->name }}</div>
            <div class="mt-2">
                <strong>⏰ المحاضرات:</strong>
                <ul class="mb-0">
                    @forelse($group->lectures as $lec)
                        <li>
                            {{ $lec->title }} — 
                            {{ \Carbon\Carbon::parse($lec->start_time)->format('H:i') }} →
                            {{ \Carbon\Carbon::parse($lec->end_time)->format('H:i') }}
                        </li>
                    @empty
                        <li>لا يوجد محاضرات</li>
                    @endforelse
                </ul>
            </div>
        </div>
    @empty
        <div class="alert alert-warning">❌ لا توجد مجموعات لهذا المدرس</div>
    @endforelse

    <a href="{{ route('students.show', $student->id) }}" class="btn btn-secondary mt-3">⬅ رجوع للمدرسين</a>
</div>
@endsection
