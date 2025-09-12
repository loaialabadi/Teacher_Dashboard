@extends('layouts.teacher')

@section('content')
<h1>الحصص الخاصة بالمعلم: {{ $teacher->name }}</h1>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>تاريخ الحصة</th>
            <th>وقت الحصة</th>
            <th>الطالب</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($appointments as $appointment)
            <tr>
                <td>{{ $appointment->appointment_date }}</td>
                <td>{{ $appointment->appointment_time }}</td>
                <td>{{ $appointment->student->name ?? 'غير معروف' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3">لا توجد حصص مسجلة لهذا المعلم.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection
