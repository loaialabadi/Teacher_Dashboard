@extends('layouts.teacher')

@section('content')
<div class="container my-4">

    <h2 class="mb-4">📚 المجموعات للمعلم: {{ $teacher->name }}</h2>

    <div class="row">
        @foreach($grades as $grade)
            <div class="col-md-4 mb-3">
                <a href="{{ route('teachers.groups.by-grade', [$teacher->id, $grade->id]) }}" class="text-decoration-none">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title">📖 {{ $grade->name }}</h5>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

</div>
@endsection
