



<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>لوحة التحكم</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('css/app.css') }}" />
  <!-- أيقونات (فونيكوس مثلا) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body>

    <div class="topbar">
    <div class="logo">لوحة التحكم</div>
    <div class="actions">
      <i class="fas fa-bell" title="الإشعارات"></i>
      <i class="fas fa-user-circle" title="حسابي"></i>
      <i id="toggleSidebar" class="fas fa-bars" title="تبديل القائمة"></i>
    </div>
  </div>

<div class="sidebar" id="sidebar">
  <h4>القائمة</h4>
  
  <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
    <i class="fas fa-home"></i> <span>الرئيسية</span>
  </a>

  <a href="{{ route('teachers.index') }}" class="{{ request()->routeIs('teachers.*') ? 'active' : '' }}">
    <i class="fas fa-chalkboard-teacher"></i> <span>المعلمون</span>
  </a>

  <a href="{{ route('students.index') }}" class="{{ request()->routeIs('students.*') ? 'active' : '' }}">
    <i class="fas fa-user-graduate"></i> <span>الطلاب</span>
  </a>
<a href="{{ route('parents.index') }}" class="{{ request()->routeIs('parents.*') ? 'active' : '' }}">
    <i class="fas fa-users"></i> <span>أولياء الأمور</span>
</a>

  <a href="{{ route('classes.index') }}" class="{{ request()->routeIs('classes.*') ? 'active' : '' }}">
    <i class="fas fa-school"></i> <span>الصفوف</span>
  </a>

  <a href="#" class="{{ request()->routeIs('attendance.*') ? 'active' : '' }}">
    <i class="fas fa-calendar-check"></i> <span>الحضور</span>
  </a>

  <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
    <i class="fas fa-user-cog"></i> <span>حسابي</span>
  </a>

  

  <a href="#" >
    <i class="fas fa-file-alt"></i> <span>التقارير</span>
  </a>

  <a href="#" >
    <i class="fas fa-cogs"></i> <span>الإعدادات</span>
  </a>
</div>


  <div class="content">

    <div class="row mb-4">
  <div class="col-md-4">
    <div class="card text-bg-primary p-3">
      <h5 class="card-title">عدد الطلاب</h5>
      <p class="card-text">{{ $studentCount }}</p>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card text-bg-success p-3">
      <h5 class="card-title">عدد المعلمين</h5>
      <p class="card-text">{{ $teacherCount }}</p>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card text-bg-warning p-3">
      <h5 class="card-title">عدد أولياء الأمور</h5>
      <p class="card-text">{{ $parentCount }}</p>
    </div>
  </div>
</div>

  </div>

  <script>
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const content = document.querySelector('.content');

    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('collapsed');
      if (sidebar.classList.contains('collapsed')) {
        content.style.marginRight = '70px';
      } else {
        content.style.marginRight = '250px';
      }
    });
  </script>
</body>
</html>
