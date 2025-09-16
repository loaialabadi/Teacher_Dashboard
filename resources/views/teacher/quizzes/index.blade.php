@extends('layouts.teacher')

@section('content')
<div class="container">
    <h2>📑 الكويزات للمجموعة: {{ $group->name }}</h2>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>العنوان</th>
                <th>الوصف</th>
                <th>تاريخ الإضافة</th>
                <th>التحكم</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quizzes as $quiz)
                <tr>
                    <td>{{ $quiz->title }}</td>
                    <td>{{ $quiz->description }}</td>
                    <td>{{ $quiz->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('teachers.groups.quizzes.show', [$teacher, $group, $quiz]) }}" class="btn btn-sm btn-info">عرض</a>
                        <a href="{{ route('teachers.groups.quizzes.edit', [$teacher, $group, $quiz]) }}" class="btn btn-sm btn-warning">تعديل</a>
                        <form action="{{ route('teachers.groups.quizzes.destroy', [$teacher, $group, $quiz]) }}" method="POST" style="display:inline-block">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
