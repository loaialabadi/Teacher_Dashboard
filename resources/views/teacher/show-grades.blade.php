@extends('layouts.index')

@section('content')
<div class="container my-4">
    <h2 class="mb-4">📚 الفصول الدراسية الخاصة بالمعلم: {{ $teacher->name }}</h2>

    @if($grades->count())
        <ul class="list-group">
            @foreach($grades as $grade)
                <li class="list-group-item">
                    <strong>الفصل:</strong> {{ $grade->name }}<br>
                    <strong>الوصف:</strong> {{ $grade->description ?? '-' }}<br>
                    <strong>المجموعات:</strong>
                    <ul>
                        @foreach($grade->groups as $group)
                            <li>
                                مجموعة رقم {{ $group->id }} ({{ $group->students->count() }} طالب)
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    @else
        <p>لا توجد فصول دراسية لهذا المعلم.</p>
    @endif
</div>
@endsection
