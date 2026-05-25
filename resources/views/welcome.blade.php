<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelGo - Hệ Thống Đặt Tour Trực Tuyến</title>
    <!-- Thư viện Icon & Font -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        /* CSS Cơ bản */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Nunito', sans-serif; }
        body { background-color: #f4f7f6; color: #333; }
        a { text-decoration: none; }

        /* Navbar */
        .navbar { display: flex; justify-content: space-between; align-items: center; padding: 15px 50px; background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 100; }
        .logo { font-size: 24px; font-weight: 800; color: #ff4757; }
        .nav-links a { color: #2f3542; font-weight: 600; margin-left: 20px; transition: color 0.3s; }
        .nav-links a:hover { color: #ff4757; }
        .btn-logout { background: transparent; border: none; color: #ff4757; font-weight: 600; cursor: pointer; font-size: 16px; margin-left: 20px; }

        /* Hero Banner */
        .hero { height: 400px; background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?q=80&w=2021&auto=format&fit=crop') center/cover; display: flex; flex-direction: column; justify-content: center; align-items: center; color: white; text-align: center; padding: 0 20px; }
        .hero h1 { font-size: 48px; font-weight: 800; margin-bottom: 15px; text-shadow: 2px 2px 4px rgba(0,0,0,0.5); }
        .hero p { font-size: 20px; font-weight: 600; }

        /* Thanh Tìm Kiếm */
        .search-box { background: white; padding: 20px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); margin: -40px auto 40px; max-width: 900px; position: relative; z-index: 10; display: flex; gap: 15px; }
        .search-input { flex: 1; padding: 12px 15px; border: 1px solid #dfe4ea; border-radius: 8px; font-size: 16px; outline: none; }
        .btn-search { background: #1e90ff; color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.3s; }
        .btn-search:hover { background: #0073e6; }

        /* Container & Lưới Tour */
        .container { max-width: 1200px; margin: 40px auto; padding: 0 20px; }
        .section-title { font-size: 32px; font-weight: 800; color: #2f3542; margin-bottom: 30px; text-align: center; }
        .tour-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px; }

        /* Thẻ Tour (Card) */
        .tour-card { background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 20px rgba(0,0,0,0.05); transition: transform 0.3s; display: flex; flex-direction: column; }
        .tour-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }
        .tour-img { width: 100%; height: 220px; object-fit: cover; }
        .tour-content { padding: 20px; flex-grow: 1; display: flex; flex-direction: column; }
        
        .alert-success { background-color: #2ed573; color: white; padding: 15px 20px; border-radius: 8px; margin-bottom: 30px; font-weight: 600; text-align: center; }
        footer { background: #2f3542; color: white; text-align: center; padding: 20px; margin-top: 50px; }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <div class="logo"><i class="fas fa-paper-plane"></i> TravelGo</div>
        <div class="nav-links">
            @if (Route::has('login'))
                @auth
                    <span>Xin chào, <b>{{ Auth::user()->name }}</b>!</span>
                    
                    @if(Auth::user()->role == 1)
                        <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> Quản trị Admin</a>
                    @else
                        <a href="{{ route('dashboard') }}"><i class="fas fa-history"></i> Lịch sử đặt tour</a>
                    @endif
                    
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Đăng xuất</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Đăng nhập</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" style="background: #1e90ff; color: white; padding: 8px 20px; border-radius: 20px;">Đăng ký</a>
                    @endif
                @endauth
            @endif
        </div>
    </nav>

    <!-- HERO BANNER -->
    <header class="hero">
        <h1>Khám Phá Thế Giới Cùng TravelGo</h1>
        <p>Đặt tour dễ dàng, xách balo lên và đi thôi!</p>
    </header>

    <!-- THANH TÌM KIẾM -->
    <form action="{{ route('home') }}" method="GET" class="search-box">
        <input type="text" name="location" class="search-input" placeholder="📍 Bạn muốn đi đâu? (VD: Hà Nội)" value="{{ request('location') }}">
        <input type="number" name="max_price" class="search-input" placeholder="💰 Giá tối đa (VNĐ)" value="{{ request('max_price') }}">
        <input type="number" name="duration" class="search-input" placeholder="⏱ Số ngày (VD: 3)" value="{{ request('duration') }}">
        <button type="submit" class="btn-search"><i class="fas fa-search"></i> Tìm kiếm</button>
        <a href="{{ route('home') }}" class="btn-search" style="background:#ff4757; text-align:center;">Xóa lọc</a>
    </form>

    <!-- MAIN CONTENT -->
    <div class="container">
        @if(session('success'))
            <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        <h2 class="section-title">Tour Nổi Bật Nhất</h2>

        @if($tours->isEmpty())
            <p style="text-align: center; color: #747d8c;">Hiện tại chưa có tour nào phù hợp. Hãy thử tìm kiếm khác nhé!</p>
        @else
            <!-- DANH SÁCH TOUR -->
            <div class="tour-grid">
                @foreach($tours as $tour)
                    <div class="tour-card">
                        <!-- Ảnh -->
                        <img src="{{ $tour->image ? asset($tour->image) : 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?q=80&w=800&auto=format&fit=crop' }}" 
                             onerror="this.src='https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1?q=80&w=800&auto=format&fit=crop'" 
                             class="tour-img" alt="Ảnh tour">
                        
                        <!-- Nội dung -->
                        <div class="tour-content">
                            <h3 style="font-size: 18px; font-weight: 700; color: #2f3542; margin-bottom: 10px;">{{ $tour->name }}</h3>
                            <div style="color: #ff4757; font-size: 20px; font-weight: 800; margin-bottom: 15px;">{{ number_format($tour->price, 0, ',', '.') }} đ</div>
                            
                            <div style="color: #747d8c; font-size: 14px; margin-bottom: 8px; display: flex; align-items: center;">
                                <i class="fas fa-map-marker-alt" style="color: #1e90ff; width: 20px;"></i> {{ $tour->location }}
                            </div>
                            <div style="color: #747d8c; font-size: 14px; margin-bottom: 15px; display: flex; align-items: center;">
                                <i class="far fa-clock" style="color: #1e90ff; width: 20px;"></i> {{ $tour->duration }} ngày
                            </div>
                            
                            <!-- Nút Xem chi tiết -->
                            <a href="{{ route('tours.show', $tour->id) }}" style="display: block; width: 100%; text-align: center; background-color: #f1f2f6; padding: 12px; border-radius: 8px; color: #2f3542; font-weight: bold; margin-bottom: 15px; text-decoration: none; font-size: 14px;">
                                Xem chi tiết & Đặt tour
                            </a>
                            
                            <!-- Form Đặt Ngay -->
                            <form action="{{ route('book.tour', $tour->id) }}" method="POST" style="margin-top: auto;">
                                @csrf 
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 15px;">
                                    <i class="fas fa-users" style="color: #57606f;"></i>
                                    <input type="number" name="guests_count" value="1" min="1" required style="width: 70px; padding: 8px 10px; border: 1px solid #ced6e0; border-radius: 6px; text-align: center; font-weight: bold; outline: none;">
                                </div>
                                <button type="submit" style="display: block; width: 100%; background-color: #ff4757; color: white; border: none; padding: 12px; border-radius: 8px; font-weight: bold; cursor: pointer; font-size: 15px;">
                                    Đặt Ngay
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- FOOTER -->
    <footer>
        <p>&copy; 2026 TravelGo. Hệ thống đặt tour Phenikaa.</p>
    </footer>

</body>
</html>