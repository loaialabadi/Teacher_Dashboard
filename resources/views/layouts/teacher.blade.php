<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>لوحة المعلم</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <style>
    body {
      display: flex;
      flex-direction: column;
      height: 100vh;
    }
    .topbar {
      background: #fff;
      border-bottom: 1px solid #ddd;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .sidebar {
      width: 250px;
      background: #fff;
      border-left: 1px solid #ddd;
      position: fixed;
      top: 56px; /* ارتفاع التوب بار */
      right: 0;
      bottom: 0;
      overflow-y: auto;
      transition: width 0.3s ease;
      padding: 15px;
    }
    .sidebar.collapsed {
      width: 70px;
    }
    .sidebar a {
      display: block;
      padding: 10px;
      margin-bottom: 5px;
      color: #333;
      text-decoration: none;
      border-radius: 5px;
    }
    .sidebar a.active, .sidebar a:hover {
      background: #0d6efd;
      color: #fff;
    }
    .sidebar i {
      margin-left: 8px;
    }
    .content {
      margin-right: 250px;
      margin-top: 56px;
      padding: 20px;
      flex-grow: 1;
      transition: margin-right 0.3s ease;
    }
    .collapsed + .content {
      margin-right: 70px;
    }
  </style>
</head>
<body>

  <!-- ✅ Topbar -->
  <div class="topbar">
    <div class="logo fw-bold">📘 لوحة المعلم: {{ $teacher->name }}</div>
    <div class="actions d-flex gap-3">
      <i class="fas fa-bell" title="الإشعارات"></i>
      <i class="fas fa-user-circle" title="حسابي"></i>
      <i id="toggleSidebar" class="fas fa-bars" title="تبديل القائمة"></i>
    </div>
  </div>

  <!-- ✅ Sidebar -->
  <div class="sidebar" id="sidebar">

    <h5 class="mb-3">القائمة</h5>

    <a href="{{ route('students.create', $teacher->id) }}" class="{{ request()->routeIs('students.create') ? 'active' : '' }}">
      <i class="fas fa-plus-circle"></i> <span>إضافة طالب جديد</span>
    </a>

    <a href="{{ route('teachers.students.index', $teacher->id) }}" class="{{ request()->routeIs('teachers.students.*') ? 'active' : '' }}">
      <i class="fas fa-user-graduate"></i> <span>عرض الطلاب</span>
    </a>

    <a href="{{ route('teachers.groups.index', $teacher->id) }}" class="{{ request()->routeIs('teachers.groups.*') ? 'active' : '' }}">
      <i class="fas fa-users"></i> <span>عرض المجموعات</span>
    </a>

    <a href="{{ route('teachers.lectures.bygrades', $teacher->id) }}" class="{{ request()->routeIs('teachers.lectures.*') ? 'active' : '' }}">
      <i class="fas fa-chalkboard-teacher"></i> <span>عرض المحاضرات</span>
    </a>

    <a href="{{ route('teachers.teacher.settings', $teacher->id) }}" class="{{ request()->routeIs('teachers.teacher.settings') ? 'active' : '' }}">
      <i class="fas fa-cog"></i> <span>إعدادات المعلم</span>
    </a>

  </div>

  <!-- ✅ Content -->
  <div class="content container">

    <!-- إشعارات -->
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ url()->previous() }}" class="btn btn-outline-primary mb-3">
      <i class="fas fa-arrow-left"></i> الرجوع
    </a>

    {{-- محتوى الصفحة --}}
    @yield('content')

  </div>

  <script>
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');
    const content = document.querySelector('.content');

    toggleBtn.addEventListener('click', () => {
      sidebar.classList.toggle('collapsed');
      if (sidebar.classList.contains('collapsed')) {
        content.style.marginRight = "70px";
      } else {
        content.style.marginRight = "250px";
      }
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
