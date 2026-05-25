<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch Sử Đặt Tour - TravelGo</title>
    <!-- Thư viện Icon & Font -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Nunito', sans-serif; }
        body { background-color: #f4f7f6; color: #333; }
        a { text-decoration: none; }

        /* NAVBAR ĐỒNG BỘ VỚI TRANG CHỦ */
        .navbar { display: flex; justify-content: space-between; align-items: center; padding: 15px 50px; background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 100; }
        .logo { font-size: 24px; font-weight: 800; color: #ff4757; display: flex; align-items: center; gap: 8px; }
        .nav-links { display: flex; align-items: center; gap: 20px; }
        .nav-links span { color: #2f3542; font-size: 16px; }
        .nav-links a { color: #2f3542; font-weight: 600; transition: color 0.3s; font-size: 16px; }
        .nav-links a:hover { color: #ff4757; }
        .btn-logout { background: transparent; border: none; color: #ff4757; font-weight: 600; cursor: pointer; font-size: 16px; }

        /* KHUNG NỘI DUNG */
        .container { max-width: 1100px; margin: 40px auto; padding: 0 20px; }
        .card { background: white; border-radius: 16px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        
        .page-title { font-size: 28px; font-weight: 800; color: #2f3542; margin-bottom: 25px; display: flex; align-items: center; gap: 12px; border-bottom: 2px solid #f1f2f6; padding-bottom: 15px; }
        .btn-back { display: inline-flex; align-items: center; gap: 8px; color: #1e90ff; font-weight: 700; margin-bottom: 20px; transition: 0.3s; background: #f1f8ff; padding: 10px 15px; border-radius: 8px;}
        .btn-back:hover { background: #e1f0ff; transform: translateX(-5px); }

        .alert-success { background-color: #d4edda; color: #155724; padding: 15px 20px; border-radius: 8px; margin-bottom: 20px; font-weight: 600; border-left: 5px solid #28a745; display: flex; align-items: center; gap: 10px; }

        /* BẢNG LỊCH SỬ */
        table { width: 100%; border-collapse: collapse; }
        th { background: #2f3542; color: white; padding: 16px; text-align: left; font-weight: 700; }
        th:first-child { border-top-left-radius: 10px; }
        th:last-child { border-top-right-radius: 10px; }
        td { padding: 16px; border-bottom: 1px solid #f1f2f6; vertical-align: middle; }
        tr:hover td { background-color: #f8f9fa; }
        
        .tour-name { font-weight: 800; color: #1e90ff; font-size: 16px; }
        .tour-name:hover { text-decoration: underline; color: #0073e6; }
        .price { color: #ff4757; font-weight: 800; font-size: 16px; }
        
        .badge { padding: 8px 14px; border-radius: 30px; font-size: 13px; font-weight: 800; display: inline-flex; align-items: center; gap: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); }
        .badge-pending { background: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
        .badge-confirmed { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .badge-cancelled { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        .empty-state { text-align: center; padding: 60px 20px; color: #747d8c; }
        .empty-state i { font-size: 60px; color: #dfe4ea; margin-bottom: 20px; }
        .empty-state p { font-size: 18px; font-weight: 600; }
    </style>
</head>
<body>

    <!-- NAVBAR ĐÃ CÓ LOGO TRAVELGO ĐỎ -->
    <nav class="navbar">
        <a href="{{ route('home') }}" class="logo"><i class="fas fa-paper-plane"></i> TravelGo</a>
        
        <div class="nav-links">
            <span>Xin chào, <b>{{ Auth::user()->name }}</b>!</span>
            
            @if(Auth::user()->role == 1)
                <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Quản trị Admin</a>
            @endif
            
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</button>
            </form>
        </div>
    </nav>

    <!-- NỘI DUNG -->
    <div class="container">
        <div class="card">
            <a href="{{ route('home') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Về trang chủ tìm tour mới
            </a>
            
            <h2 class="page-title">
                <i class="fas fa-history" style="color: #ff4757;"></i> Lịch sử chuyến đi của bạn
            </h2>

            @if(session('success'))
                <div class="alert-success">
                    <i class="fas fa-check-circle" style="font-size: 20px;"></i> {{ session('success') }}
                </div>
            @endif

            @if($bookings->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-suitcase-rolling"></i>
                    <p>Bạn chưa đặt chuyến đi nào. Hãy xách balo lên và khám phá thế giới nhé!</p>
                </div>
            @else
                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>Khám phá</th>
                                <th>Địa điểm</th>
                                <th style="text-align: center;">Số lượng</th>
                                <th style="text-align: right;">Tổng thanh toán</th>
                                <th>Thời gian đặt</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                                <tr>
                                    <td>
                                        <a href="{{ route('tours.show', $booking->tour_id) }}" class="tour-name">
                                            {{ $booking->tour->name }}
                                        </a>
                                    </td>
                                    <td style="color: #57606f; font-weight: 600;">
                                        <i class="fas fa-map-marker-alt" style="color: #ff4757; margin-right: 5px;"></i> {{ $booking->tour->location }}
                                    </td>
                                    <td style="text-align: center; font-weight: 800; font-size: 16px;">
                                        <i class="fas fa-user-friends" style="color: #1e90ff; margin-right: 5px;"></i> {{ $booking->guests_count }}
                                    </td>
                                    <td style="text-align: right;" class="price">
                                        {{ number_format($booking->total_price, 0, ',', '.') }} đ
                                    </td>
                                    <td style="font-size: 14px; color: #747d8c; font-weight: 600;">
                                        <i class="far fa-clock"></i> {{ $booking->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td>
                                        @if($booking->status == 'pending')
                                            <span class="badge badge-pending"><i class="fas fa-hourglass-half"></i> Chờ duyệt</span>
                                        @elseif($booking->status == 'confirmed')
                                            <span class="badge badge-confirmed"><i class="fas fa-check"></i> Đã xác nhận</span>
                                        @else
                                            <span class="badge badge-cancelled"><i class="fas fa-times"></i> Đã hủy</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

</body>
</html>
