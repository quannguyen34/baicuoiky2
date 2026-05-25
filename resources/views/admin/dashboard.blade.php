<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Hệ Thống Tour</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Thêm dòng này -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; font-family: 'Arial', sans-serif; margin: 0; padding: 0; }
        body { display: flex; background: #f4f6f9; color: #333; height: 100vh; }
        
        /* Sidebar */
        .sidebar { width: 250px; background: #2c3e50; color: white; display: flex; flex-direction: column; }
        .sidebar-header { padding: 20px; font-size: 20px; font-weight: bold; background: #1a252f; text-align: center; }
        .tab-btn { padding: 15px 20px; border: none; background: transparent; color: #bdc3c7; text-align: left; font-size: 16px; cursor: pointer; transition: 0.3s; width: 100%; border-left: 4px solid transparent; }
        .tab-btn:hover, .tab-btn.active { background: #34495e; color: white; border-left: 4px solid #3498db; }
        .tab-btn i { width: 25px; }

        /* Main Content */
        .main-content { flex: 1; padding: 30px; overflow-y: auto; }
        .tab-pane { display: none; }
        .tab-pane.active { display: block; animation: fadeIn 0.3s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        /* Cards & Tables */
        .header-top { display: flex; justify-content: space-between; margin-bottom: 30px; }
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-left: 5px solid #3498db; }
        .stat-card h3 { font-size: 28px; margin-top: 10px; color: #2c3e50; }
        .stat-card p { color: #7f8c8d; font-weight: bold; font-size: 14px; text-transform: uppercase; }

        .card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background: #f8f9fa; }
        .btn { padding: 6px 12px; border: none; border-radius: 4px; color: white; cursor: pointer; font-size: 14px; display: inline-block; }
        .btn-green { background: #2ecc71; } .btn-red { background: #e74c3c; } .btn-blue { background: #3498db; }
        .status-badge { padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 12px; }

        /* Forms */
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-control { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        .alert { padding: 15px; background: #2ecc71; color: white; border-radius: 4px; margin-bottom: 20px; }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
<div class="sidebar-header" style="background: white; padding: 25px 20px; border-bottom: 1px solid #eee;">
        <a href="{{ route('admin.dashboard') }}" style="text-decoration: none; font-size: 26px; font-weight: 800; color: #ff4757; font-family: 'Nunito', sans-serif; display: flex; justify-content: center; align-items: center; gap: 10px;">
            <i class="fas fa-paper-plane"></i> TravelGo
        </a>
        <div style="color: #747d8c; font-size: 12px; margin-top: 5px; font-weight: normal; text-transform: uppercase; letter-spacing: 1px;">Admin Workspace</div>
    </div>
        <button class="tab-btn active" onclick="openTab(event, 'dashboard')"><i class="fas fa-chart-line"></i> Thống Kê</button>
        <button class="tab-btn" onclick="openTab(event, 'tours')"><i class="fas fa-map-marked-alt"></i> Quản Lý Tour</button>
        <button class="tab-btn" onclick="openTab(event, 'categories')"><i class="fas fa-list"></i> Danh Mục Tour</button>
        <button class="tab-btn" onclick="openTab(event, 'bookings')"><i class="fas fa-ticket-alt"></i> Đơn Đặt Tour</button>
        <button class="tab-btn" onclick="openTab(event, 'users')"><i class="fas fa-users"></i> Khách Hàng</button>
        
        <a href="{{ route('home') }}" class="tab-btn" style="text-decoration:none; margin-top: auto; background:#c0392b;"><i class="fas fa-home"></i> Về Website</a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        @if(session('success'))
            <div class="alert"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        <!-- TAB: THỐNG KÊ -->
        <div id="dashboard" class="tab-pane active">
            <h2>Tổng Quan Hệ Thống</h2>
            <div class="stats-grid" style="margin-top: 20px;">
                <div class="stat-card" style="border-color: #3498db;">
                    <p>Tổng số Tour</p><h3>{{ $stats['tours'] }}</h3>
                </div>
                <div class="stat-card" style="border-color: #f1c40f;">
                    <p>Đơn đặt (Tất cả)</p><h3>{{ $stats['bookings'] }}</h3>
                </div>
                <div class="stat-card" style="border-color: #2ecc71;">
                    <p>Doanh Thu (Đã duyệt)</p><h3>{{ number_format($stats['revenue']) }} đ</h3>
                </div>
                <div class="stat-card" style="border-color: #9b59b6;">
                    <p>Khách hàng</p><h3>{{ $stats['users'] }}</h3>
                </div>
            </div>
        </div>

        <!-- TAB: QUẢN LÝ ĐƠN ĐẶT -->
        <div id="bookings" class="tab-pane">
            <div class="card">
                <h2>Quản Lý Đơn Đặt Tour</h2>
                <table>
                    <tr><th>Mã Đơn</th><th>Khách Hàng</th><th>Tour</th><th>Số Lượng</th><th>Tổng Tiền</th><th>Trạng Thái</th><th>Hành Động</th></tr>
                    @foreach($bookings as $booking)
                    <tr>
                        <td>#{{ $booking->id }}</td>
                        <td>{{ $booking->user->name }}<br><small>{{ $booking->user->email }}</small></td>
                        <td>{{ $booking->tour->name }}</td>
                        <td>{{ $booking->guests_count }}</td>
                        <td style="color:red; font-weight:bold;">{{ number_format($booking->total_price) }} đ</td>
                        <td>
                            @if($booking->status == 'pending') <span class="status-badge" style="background:#f1c40f;">Chờ duyệt</span>
                            @elseif($booking->status == 'confirmed') <span class="status-badge" style="background:#2ecc71; color:white;">Đã duyệt</span>
                            @else <span class="status-badge" style="background:#e74c3c; color:white;">Đã hủy</span> @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <select name="status" onchange="this.form.submit()" style="padding:5px; border-radius:4px;">
                                    <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                                    <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Xác nhận</option>
                                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Hủy đơn</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <!-- TAB: QUẢN LÝ TOUR -->
        <div id="tours" class="tab-pane">
            <div class="card">
                <h2>Thêm Tour Mới</h2>
                <form action="{{ route('admin.tours.store') }}" method="POST" enctype="multipart/form-data" style="display:flex; flex-wrap:wrap; gap:15px; margin-top:15px;">
                    @csrf
                    <div class="form-group" style="flex: 1 1 48%;"><label>Tên Tour</label><input type="text" name="name" class="form-control" required></div>
                    <div class="form-group" style="flex: 1 1 48%;">
                        <label>Danh mục</label>
                        <select name="category_id" class="form-control" required>
                            @foreach($categories as $cat) <option value="{{ $cat->id }}">{{ $cat->name }}</option> @endforeach
                        </select>
                    </div>
                    <div class="form-group" style="flex: 1 1 30%;"><label>Giá (VNĐ)</label><input type="number" name="price" class="form-control" required></div>
                    <div class="form-group" style="flex: 1 1 30%;"><label>Số ngày</label><input type="number" name="duration" class="form-control" required></div>
                    <div class="form-group" style="flex: 1 1 30%;"><label>Ngày khởi hành</label><input type="date" name="start_date" class="form-control" required></div>
                    <div class="form-group" style="flex: 1 1 48%;"><label>Địa điểm</label><input type="text" name="location" class="form-control" required></div>
                    <div class="form-group" style="flex: 1 1 48%;"><label>Hình ảnh đại diện</label><input type="file" name="image" class="form-control" accept="image/*"></div>
                    <div class="form-group" style="flex: 1 1 100%;"><label>Mô tả / Lịch trình</label><textarea name="description" class="form-control" rows="3" required></textarea></div>
                    <button type="submit" class="btn btn-blue" style="width:100%; padding:15px; font-size:16px;"><i class="fas fa-plus"></i> LƯU TOUR MỚI</button>
                </form>
            </div>

            <div class="card">
                <h2>Danh Sách Tour Đang Có</h2>
                <table>
                    <tr><th>Ảnh</th><th>Tên Tour</th><th>Danh mục</th><th>Giá</th><th>Hành Động</th></tr>
                    @foreach($tours as $tour)
                    <tr>
                        <td><img src="{{ $tour->image ? asset($tour->image) : 'https://via.placeholder.com/50' }}" width="50" height="50" style="object-fit:cover; border-radius:4px;"></td>
                        <td>{{ $tour->name }}</td>
                        <td>{{ $tour->category->name }}</td>
                        <td>{{ number_format($tour->price) }} đ</td>
                        <td>
                            <form action="{{ route('admin.tours.destroy', $tour->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                @csrf @method('DELETE') <button class="btn btn-red"><i class="fas fa-trash"></i> Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <!-- TAB: DANH MỤC & USER -->
        <div id="categories" class="tab-pane">
            <div class="card">
                <h2>Thêm Danh Mục</h2>
                <form action="{{ route('admin.categories.store') }}" method="POST" style="display:flex; gap:10px; margin-top:15px;">
                    @csrf <input type="text" name="name" class="form-control" placeholder="Tên danh mục (VD: Tour Biển)" required>
                    <button class="btn btn-blue">Thêm</button>
                </form>
                <table style="margin-top:20px;">
                    <tr><th>ID</th><th>Tên Danh Mục</th><th>Số Lượng Tour</th><th>Xóa</th></tr>
                    @foreach($categories as $cat)
                    <tr>
                        <td>{{ $cat->id }}</td><td>{{ $cat->name }}</td><td>{{ $cat->tours_count }} tour</td>
                        <td>
                            <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST">
                                @csrf @method('DELETE') <button class="btn btn-red" onclick="return confirm('Xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <div id="users" class="tab-pane">
            <div class="card">
                <h2>Quản Lý Khách Hàng</h2>
                <table>
                    <tr><th>ID</th><th>Tên</th><th>Email</th><th>Ngày đăng ký</th><th>Xóa</th></tr>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td><td>{{ $user->name }}</td><td>{{ $user->email }}</td><td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                @csrf @method('DELETE') <button class="btn btn-red" onclick="return confirm('Xóa?')">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>

    </div>

    <!-- Script chuyển Tab -->
    <script>
        function openTab(evt, tabName) {
            var tabPanes = document.getElementsByClassName("tab-pane");
            for (var i = 0; i < tabPanes.length; i++) tabPanes[i].classList.remove("active");
            var tabBtns = document.getElementsByClassName("tab-btn");
            for (var i = 0; i < tabBtns.length; i++) tabBtns[i].classList.remove("active");
            document.getElementById(tabName).classList.add("active");
            evt.currentTarget.classList.add("active");
        }
    </script>
</body>
</html>