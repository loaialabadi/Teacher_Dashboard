@extends('layouts.teacher')

@section('content')
<div class="container">
    <h2>📚 المجموعات الخاصة بالمدرس: {{ $teacher->name }}</h2>

    @foreach($groups as $group)
        <div class="card my-3">
            <div class="card-header d-flex justify-content-between">
                <span>
                    👥 المجموعة: {{ $group->name }}
                    <span class="badge bg-info">عدد الطلاب: {{ $group->students->count() }}</span>
                </span>
                <a href="{{ route('teachers.groups.quizzes.create', [$teacher->id, $group->id]) }}" class="btn btn-sm btn-primary">
                    ➕ إنشاء كويز
                </a>
            </div>
            <div class="card-body">
                @if($group->quizzes->count())
                    <ul class="list-group">
                        @foreach($group->quizzes as $quiz)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $quiz->title }}</strong> (📅 {{ $quiz->quiz_date }})
                                    <br>
                                    <small class="text-muted">{{ $quiz->description }}</small>
                                </div>
                                <div>
                                    <a href="{{ route('teachers.quizzes.results', [$teacher->id, $quiz->id]) }}" 
                                       class="btn btn-sm btn-success">
                                        📊 إدخال/عرض الدرجات
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-muted">لا يوجد كويزات لهذه المجموعة.</p>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection
