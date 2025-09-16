@extends('layouts.teacher')

@section('content')
<div class="container my-4">
    <h2 class="mb-4">تفاصيل المجموعة: {{ $group->name }}</h2>

    <div class="mb-3">
        <strong>اسم المدرس:</strong> {{ $teacher->name }}
    </div>
    <div class="mb-3">
        <strong>الفصل الدراسي :</strong> {{ $group->grade->name ?? 'غير محدد' }}
    </div>
    <div class="mb-4">
        <strong>المادة:</strong> {{ $group->subject->name ?? 'غير محدد' }}
    </div>
    <div class="mb-3">
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

    <div class="mt-3 d-flex gap-2">
        {{-- زر الرجوع --}}
        <a href="{{ route('teachers.groups.index', $teacher->id) }}" class="btn btn-secondary">
            رجوع إلى المجموعات
        </a>

        {{-- زر نقل الطلاب --}}
<a href="{{ route('teachers.groups.transfer.form', [
    'teacher' => $teacher->id,
    'sourceGroup' => $group->id
]) }}" class="btn btn-warning">
    🔄 نقل الطلاب
</a>

<a href="{{ route('teachers.groups.add-students.form', [$teacher->id, $group->id]) }}" 
   class="btn btn-success">
    ➕ إضافة طلاب جدد
</a>
    </div>
</div>
@endsection
