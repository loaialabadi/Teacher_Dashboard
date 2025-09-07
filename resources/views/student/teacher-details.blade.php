@extends('layouts.index')

@section('content')
<div class="container my-4">

    <h2 class="mb-3">👨‍🏫 المدرس: <span class="text-primary">{{ $teacher->name }}</span></h2>
    <h4>👨‍🎓 الطالب: <span class="text-success">{{ $student->name }}</span></h4>

    <hr>

    <h5 class="mb-3">📘 جدول المحاضرات مع هذا المدرس:</h5>

    @forelse($groups as $group)
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h6 class="card-title text-primary">📖 المادة: {{ $group->subject->name ?? '-' }}</h6>
                <p class="card-text">📌 المجموعة: <strong>{{ $group->name }}</strong></p>

                <div class="mt-3">
                    <strong>⏰ المحاضرات:</strong>
                    <ul class="list-group list-group-flush mt-2">
                        @forelse($group->lectures as $lec)
                            @php
                                // جلب الحضور/الغياب للطالب
                                $attendance = $lec->attendances->where('student_id', $student->id)->first();
                                $dayName = \Carbon\Carbon::parse($lec->start_time)->translatedFormat('l');
                                $date = \Carbon\Carbon::parse($lec->start_time)->format('Y-m-d');
                            @endphp

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-calendar-day text-info"></i>
                                    {{ $dayName }} - {{ $date }} <br>
                                    <i class="fas fa-chalkboard-teacher text-secondary"></i>
                                    {{ $lec->title }} —
                                    {{ \Carbon\Carbon::parse($lec->start_time)->format('H:i') }} →
                                    {{ \Carbon\Carbon::parse($lec->end_time)->format('H:i') }}
                                </div>

                                <div>
                                    @if($attendance)
                                        @if($attendance->status === 'present')
                                            <span class="badge bg-success">✅ حاضر</span>
                                        @elseif($attendance->status === 'absent')
                                            <span class="badge bg-danger">❌ غائب</span>
                                        @else
                                            <span class="badge bg-warning">⚠ غير محدد</span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">⏳ لم يتم تسجيل</span>
                                    @endif
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item">لا يوجد محاضرات</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-warning">❌ لا توجد مجموعات لهذا المدرس</div>
    @endforelse

    <a href="{{ route('students.show', $student->id) }}" class="btn btn-secondary mt-3">
        ⬅ رجوع للمدرسين
    </a>
</div>
@endsection
