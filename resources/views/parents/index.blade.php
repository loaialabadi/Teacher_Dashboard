@extends('layouts.index')

@section('content')
<div class="container">
    <h2 class="mb-4">قائمة أولياء الأمور</h2>

    <a href="{{ route('parents.create') }}" class="btn btn-success mb-3">
        <i class="fas fa-plus"></i> إضافة ولي أمر
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped text-center">
        <thead class="table-dark">
            <tr>
                <th>الاسم</th>
                <th>البريد الإلكتروني</th>
                <th>رقم الهاتف</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            @foreach($parents as $parent)
                <tr>
                    <td>{{ $parent->name }}</td>
                    <td>{{ $parent->email }}</td>
                    <td>{{ $parent->phone }}</td>
                    <td>
                        <a href="{{ route('parents.edit', $parent->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i> تعديل
                        </a>

                        <form action="{{ route('parents.destroy', $parent->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('هل أنت متأكد من حذف ولي الأمر؟');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i> حذف
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
