@extends('layouts.index')

@section('content')
<div class="container my-4">

    <h2 class="mb-4">📘 محاضرات المدرس: {{ $teacher->name }}</h2>

    <!-- زر الإضافة -->
    <a href="{{ route('lectures.create', $teacher->id) }}" class="btn btn-primary mb-3">
        <i class="fas fa-plus"></i> إضافة محاضرة جديدة
    </a>

    @if($lectures->count())
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>العنوان</th>
                    <th>الوصف</th>
                    <th>البداية</th>
                    <th>النهاية</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lectures as $lecture)
                    <tr>
                        <td>{{ $lecture->title }}</td>
                        <td>{{ $lecture->description }}</td>
                        <td>{{ $lecture->start_time }}</td>
                        <td>{{ $lecture->end_time }}</td>
                        <td>
                            <a href="{{ route('lectures.edit', [$teacher->id, $lecture->id]) }}" class="btn btn-sm btn-warning">
                                ✏️ تعديل
                            </a>

                            <form action="{{ route('lectures.destroy', [$teacher->id, $lecture->id]) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">🗑 حذف</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- روابط التصفح -->
        <div class="mt-3">
            {{ $lectures->links() }}
        </div>
    @else
        <div class="alert alert-info">لا توجد محاضرات حالياً.</div>
    @endif
</div>
@endsection
