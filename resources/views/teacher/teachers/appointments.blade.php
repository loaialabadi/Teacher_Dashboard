@extends('layouts.index')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">الحصص الخاصة بالمعلم: <span class="text-primary">{{ $teacher->name }}</span></h2>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th scope="col">تاريخ الحصة</th>
                    <th scope="col">وقت الحصة</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($appointments as $appointment)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_date)->locale('ar')->isoFormat('dddd, YYYY-MM-DD') }}</td>
                    <td>{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="text-center text-muted">لا توجد حصص مسجلة لهذا المعلم.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
