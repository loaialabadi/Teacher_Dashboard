@extends('layouts.teacher')

@section('content')
<div class="container my-4">
    <h2 class="mb-4">📚 قائمة الفصول الدراسية للمعلم: {{ $teacher->name }}</h2>

    <a href="{{ route('teachers.grades.create', $teacher->id) }}" class="btn btn-success mb-3">
        <i class="fas fa-plus"></i> إضافة فصل دراسي جديد
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($grades->count())
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>اسم الفصل</th>
                    <th>المادة</th>
                    <th>تاريخ الإنشاء</th>
                    <th class="text-center">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grades as $grade)
                    <tr>
                        <td>{{ $grade->name }}</td>
                        <td>{{ $grade->subject->name ?? '-' }}</td>
                        <td>{{ $grade->created_at->format('Y-m-d') }}</td>
                        <td class="text-center">


                            <form action="{{ route('teachers.grades.destroy', [$teacher->id, $grade->id]) }}" 
                                  method="POST" 
                                  style="display:inline-block"
                                  onsubmit="return confirm('هل أنت متأكد من الحذف؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- روابط التصفح --}}
        <div class="mt-3">
            {{ $grades->links() }}
        </div>
    @else
        <p>لا توجد فصول دراسية لهذا المعلم حتى الآن.</p>
    @endif
</div>
@endsection
