@extends('layouts.index')

@section('content')

<div class="container">
    <h2>جدول الحصص والمجموعات للطالب: {{ $student->name }}</h2>

    <h3>المجموعات:</h3>
    @if($student->groups->count())
        <ul>
            @foreach($student->groups as $group)
                <li>{{ $group->name }}</li>
            @endforeach
        </ul>
    @else
        <p>لا توجد مجموعات لهذا الطالب.</p>
    @endif

    <h3>جدول الحصص:</h3>
    @if($student->appointments->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>المجموعة</th>
                    <th>تاريخ الحصة</th>
                    <th>وقت الحصة</th>
                    <th>اسم المدرس</th>
                </tr>
            </thead>
            <tbody>
                @foreach($student->appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->group ? $appointment->group->name : 'بدون مجموعة' }}</td>
                        <td>{{ $appointment->appointment_date }}</td>
                        <td>{{ $appointment->appointment_time }}</td>
                        <td>{{ $appointment->teacher ? $appointment->teacher->name : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>لا توجد حصص مجدولة لهذا الطالب.</p>
    @endif
</div>
@endsection
