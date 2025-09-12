@extends('layouts.teacher')

@section('content')
<div class="container my-4">
    <h2 class="mb-4">تفاصيل المجموعة: {{ $group->name }}</h2>

    <div class="mb-3">
        <strong>اسم المدرس:</strong> {{ $teacher->name }}
    </div>
    <div class="mb-3">
<strong>الفصل الدراسي :</strong> {{ $group->grade->name ?? 'غير محدد' }}
    <div class="mb-4">

        <strong>المادة:</strong> {{ $group->subject->name ?? 'غير محدد' }}
    </div>
        <strong>عدد الطلاب:</strong> {{ $group->students->count() }}
    </div>

    <h4>الطلاب في هذه المجموعة:</h4>
    @if($group->students->isEmpty())
        <p>لا يوجد طلاب في هذه المجموعة.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>البريد الإلكتروني</th>
                    <th>رقم الهاتف</th>
                </tr>
            </thead>
            <tbody>
                @foreach($group->students as $student)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>{{ $student->phone }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('teachers.groups.index', $teacher->id) }}" class="btn btn-secondary mt-3">رجوع إلى المجموعات</a>
</div>
@endsection
