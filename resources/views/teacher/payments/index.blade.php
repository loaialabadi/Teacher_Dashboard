@extends('layouts.teacher')

@section('content')
<div class="container my-4">
    <h2>💰 إدارة الدفع: {{ $student->name }} (معلم: {{ $teacher->name }})</h2>

    <form action="{{ route('teachers.payments.store', [$teacher->id, $student->id]) }}" method="POST">
        @csrf
        <input type="hidden" name="year" value="{{ $year }}">
        <table class="table table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>الشهر</th>
                    <th>تم الدفع؟</th>
                </tr>
            </thead>
            <tbody>
                @foreach($months as $month)
                <tr>
                    <td>{{ $month }}</td>
                    <td>
                        <input type="checkbox" name="months[]" value="{{ $month }}" {{ isset($payments[$month]) && $payments[$month] ? 'checked' : '' }}>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-success">حفظ التعديلات</button>
    </form>
</div>
@endsection
