@extends('layouts.teacher')

@section('content')
<div class="container">
    <h2>قائمة تغييرات المحاضرات</h2>
<a href="{{ route('teachers.lectures.lecture_changes.create', $teacher->id) }}" class="btn btn-success mb-3">إضافة تغيير جديد</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered text-center">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>المحاضرة</th>
                <th>المعلم</th>
                <th>الوقت الجديد</th>
                <th>الحالة</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($changes as $change)
                <tr>
                    <td>{{ $change->id }}</td>
                    <td>{{ $change->lecture->title }}</td>
                    <td>{{ $change->lecture->teacher->name }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($change->new_start_time)->format('Y-m-d H:i') }}
                        -
                        {{ \Carbon\Carbon::parse($change->new_end_time)->format('Y-m-d H:i') }}
                    </td>
                    <td>
                        @if($change->status === 'pending')
                            <span class="badge bg-warning">قيد المراجعة</span>
                        @elseif($change->status === 'approved')
                            <span class="badge bg-success">موافق عليه</span>
                        @else
                            <span class="badge bg-danger">مرفوض</span>
                        @endif
                    </td>
                    <td>
<a href="{{ route('teachers.lectures.lecture_changes.show', [$teacher->id, $change->id]) }}" class="btn btn-info btn-sm">عرض</a>

<a href="{{ route('teachers.lectures.lecture_changes.edit', [$teacher->id, $change->id]) }}" class="btn btn-primary btn-sm">تعديل</a>

<form action="{{ route('teachers.lectures.lecture_changes.destroy', [$teacher->id, $change->id]) }}" method="POST" style="display:inline-block">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من الحذف؟')">حذف</button>
</form>

                    </td>
                </tr>
            @empty
                <tr><td colspan="6">لا يوجد تغييرات حالياً</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
