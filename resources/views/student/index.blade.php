@extends('layouts.index')

@section('content')
<div class="container my-4">
    <h2 class="mb-4">📚 قائمة الطلاب</h2>

    {{-- فورم البحث --}}
    <form action="{{ route('students.index') }}" method="GET" class="mb-3 d-flex gap-2">
        <input type="text" name="q" class="form-control" placeholder="ابحث بالاسم أو رقم الهاتف أو ولي الأمر" value="{{ request('q') }}">
        <button type="submit" class="btn btn-primary">🔍 بحث</button>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">إعادة تعيين</a>
    </form>

    @if($students->count() > 0)
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>الاسم</th>
                <th>رقم الهاتف</th>
                <th>ولي الأمر</th>
                <th>الفصل الدراسي</th>
                <th>إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
            <tr>
                <td>{{ $student->name }}</td>
                <td>{{ $student->phone }}</td>
                <td>{{ $student->parent->name ?? '-' }}</td>
                <td>{{ $student->grade->name ?? '-' }}</td>
                <td>
                    <a href="{{ route('students.show', $student->id) }}" class="btn btn-info btn-sm">عرض</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="alert alert-info">لا يوجد طلاب مسجلين حتى الآن.</div>
    @endif
</div>
@endsection
