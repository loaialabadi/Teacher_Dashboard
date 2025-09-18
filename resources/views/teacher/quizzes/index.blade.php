@extends('layouts.teacher')

@section('content')
<div class="container">
    <h2 class="mb-4">📚 مجموعات المعلم: {{ $teacher->name }}</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>اسم المجموعة</th>
                <th>الفصل</th>
                <th>عدد الطلاب</th>
                <th>العمليات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($groups as $group)
                <tr>
                    <td>{{ $group->name }}</td>
                    <td>{{ $group->grade->name ?? '-' }}</td>
                    <td>{{ $group->students->count() }}</td>
                    <td>
                        <a href="{{ route('teachers.groups.show', [$teacher->id, $group->id]) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i> عرض
                        </a>
                        <a href="{{ route('teachers.groups.quizzes.by-group', [$teacher->id, $group->id]) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-clipboard-list"></i> الكويزات
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">لا توجد مجموعات بعد</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
