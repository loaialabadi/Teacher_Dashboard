@extends('layouts.index')

@section('content')
<div class="container my-4">
    <h2>➕ إضافة طالب جديد</h2>

<form action="{{ route('students.store', ['teacher' => $teacher->id]) }}" method="POST">
        @csrf

        {{-- اسم الطالب --}}
        <div class="mb-3">
            <label>الاسم</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        {{-- الهاتف --}}
        <div class="mb-3">
            <label>رقم الهاتف</label>
            <input type="text" name="phone" class="form-control" required>
        </div>

        {{-- المرحلة الدراسية --}}
        <div class="mb-3">
            <label>المرحلة الدراسية</label>
            <select name="academic_stage" class="form-control" required>
                <option value="">-- اختر المرحلة --</option>
                @foreach ($stages as $stage)
                    <option value="{{ $stage }}">{{ $stage }}</option>
                @endforeach
            </select>
        </div>

        {{-- اختيار المعلم --}}
{{-- عرض اسم المعلم --}}
<h3>إضافة طالب للمدرس: {{ $teacher->name }} - {{ $teacher->subject->name }}</h3>



        {{-- اختيار أو إنشاء ولي أمر --}}
        <div class="mb-3">
            <label>هل تريد إضافة ولي أمر جديد؟</label>
            <select id="createParentToggle" name="createParentToggle" class="form-control">
                <option value="0">اختر من الموجودين</option>
                <option value="1">إنشاء ولي أمر جديد</option>
            </select>
        </div>

        {{-- اختيار ولي أمر موجود --}}
        <div id="existingParentSection" class="mb-3">
            <label>اختر ولي الأمر</label>
            <select name="parent_id" class="form-control">
                @foreach($parents as $parent)
                    <option value="{{ $parent->id }}">{{ $parent->name }} - {{ $parent->phone }}</option>
                @endforeach
            </select>
        </div>

        {{-- إدخال بيانات ولي أمر جديد --}}
        <div id="newParentSection" style="display: none;">
            <h5>بيانات ولي الأمر الجديد</h5>

            <div class="mb-3">
                <label>الاسم</label>
                <input type="text" name="parent_name" class="form-control">
            </div>

            <div class="mb-3">
                <label>رقم الهاتف</label>
                <input type="text" name="parent_phone" class="form-control">
            </div>

            <div class="mb-3">
                <label>كلمة المرور</label>
                <input type="password" name="parent_password" class="form-control">
            </div>
        </div>

        <button type="submit" class="btn btn-success">💾 حفظ الطالب</button>
    </form>
</div>

{{-- JavaScript لتبديل ولي الأمر --}}
<script>
    document.getElementById('createParentToggle').addEventListener('change', function () {
        const showNew = this.value == '1';
        document.getElementById('existingParentSection').style.display = showNew ? 'none' : 'block';
        document.getElementById('newParentSection').style.display = showNew ? 'block' : 'none';
    });
</script>
@endsection
