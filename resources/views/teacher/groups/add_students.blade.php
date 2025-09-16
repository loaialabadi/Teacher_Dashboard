@extends('layouts.teacher')

@section('content')
<div class="container my-5">
    <h2>➕ إضافة طلاب جدد إلى المجموعة: {{ $group->name }}</h2>

    <form action="{{ route('teachers.groups.add-students', [$teacher->id, $group->id]) }}" method="POST">
        @csrf

        @if($students->isEmpty())
            <p class="text-danger">لا يوجد طلاب متاحين حالياً (كل الطلاب في مجموعات).</p>
        @else
            <div class="list-group mb-3" style="max-height: 400px; overflow-y: auto;">
                @foreach ($students as $student)
                    <label class="list-group-item">
                        <input type="checkbox" name="student_ids[]" value="{{ $student->id }}">
                        {{ $student->name }} - {{ $student->phone }}
                    </label>
                @endforeach
            </div>
            <button type="submit" class="btn btn-success">إضافة الطلاب المحددين</button>
        @endif
    </form>

    <a href="{{ route('teachers.groups.show', [$teacher->id, $group->id]) }}" class="btn btn-secondary mt-3">
        رجوع إلى تفاصيل المجموعة
    </a>
</div>
@endsection
