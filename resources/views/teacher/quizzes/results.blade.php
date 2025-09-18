@extends('layouts.teacher')

@section('content')
<div class="container">
    <h2>📊 درجات الكويز: {{ $quiz->title }}</h2>
    <p>👥 المجموعة: {{ $quiz->group->name }}</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('teachers.quizzes.results.store', [$teacher->id, $quiz->id]) }}" method="POST">
        @csrf
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>الطالب</th>
                    <th>الدرجة</th>
                    <th>ملاحظة</th>
                </tr>
            </thead>
            <tbody>
                @foreach($results as $result)
                    <tr>
                        <td>{{ $result->student->name }}</td>
                        <td>
                            <input type="number" name="scores[{{ $result->student_id }}]" 
                                   value="{{ $result->score }}" 
                                   class="form-control" min="0" max="100">
                        </td>
                        <td>
                            <input type="text" name="notes[{{ $result->student_id }}]" 
                                   value="{{ $result->note }}" 
                                   class="form-control">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button class="btn btn-success">💾 حفظ الدرجات</button>
    </form>
</div>
@endsection
