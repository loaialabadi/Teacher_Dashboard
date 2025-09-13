@extends('layouts.teacher')

@section('content')
<div class="container my-4">
    <h2 class="mb-4">📚 قائمة الفصول الدراسية للمعلم: {{ $teacher->name }}</h2>

    <a href="{{ route('teachers.grades.create', ['teacher' => $teacher->id]) }}" class="btn btn-success mb-3">
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
                    <th>التاريخ</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>


        {{-- روابط التصفح --}}
        <div class="mt-3">
            {{ $grades->links() }}
        </div>
    @else
        <p>لا توجد فصول دراسية لهذا المعلم حتى الآن.</p>
    @endif
</div>
@endsection
