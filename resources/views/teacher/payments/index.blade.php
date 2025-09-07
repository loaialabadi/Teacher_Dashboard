@extends('layouts.index')

@section('content')

@extends('layouts.index')

@section('content')
<div class="container my-4">
    <h2>💵 إدارة الدفع الشهري للطالب: {{ $student->name }}</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('teachers.payments.store', $student->id) }}" method="POST">
        @csrf
        <input type="hidden" name="year" value="{{ $year }}">

        <table class="table table-bordered text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>الشهر</th>
                    <th>الحالة</th>
                    <th>تم الدفع في</th>
                </tr>
            </thead>
            <tbody>
                @foreach($months as $month)
                    <tr>
                        <td>{{ $month }}</td>
                        <td>
                            <input type="checkbox" name="months[]" value="{{ $month }}"
                                {{ isset($payments[$month]) && $payments[$month] ? 'checked' : '' }}>
                            <span class="{{ isset($payments[$month]) && $payments[$month] ? 'text-success' : 'text-danger' }}">
                                {{ isset($payments[$month]) && $payments[$month] ? '✅ مدفوع' : '❌ غير مدفوع' }}
                            </span>
                        </td>
                        <td>
                            @if(isset($payments[$month]) && $payments[$month])
                                {{ \Carbon\Carbon::now()->format('Y-m-d') }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-success">💾 حفظ التغييرات</button>
    </form>
</div>
@endsection

@endsection