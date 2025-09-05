@extends('layouts.index')



@section('content')
<div class="container">
    <h2>📚 مواد المدرس: {{ $teacher->name }}</h2>

    <!-- زر إضافة مواد -->
    <a href="{{ route('subjects.create', $teacher->id) }}" class="btn btn-success mb-3">
        ➕ إضافة مواد
    </a>

    <!-- جدول عرض المواد -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>اسم المادة</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($teacher->subjects as $subject)
                <tr>
                    <td>{{ $subject->name }}</td>
                    <td>
                        <!-- زر تعديل: يمكن أن يفتح صفحة تعديل أو نافذة مودال -->
                        <a href="{{ route('subjects.edit', [$teacher->id, $subject->id]) }}" class="btn btn-primary btn-sm">
                            ✏️ تعديل
                        </a>

                        <!-- زر حذف: يمكنك إضافته إذا أردت -->
                        <form action="{{ route('subjects.destroy', [$teacher->id, $subject->id]) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('هل أنت متأكد من حذف المادة؟')">
                                🗑 حذف
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">لا توجد مواد مرتبطة بهذا المدرس.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
