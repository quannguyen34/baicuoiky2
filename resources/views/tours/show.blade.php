<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết Tour - {{ $tour->name }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Nunito', sans-serif; background: #f4f7f6; padding: 40px; color: #333; }
        .container { max-width: 1000px; margin: auto; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); display: flex; flex-wrap: wrap; }
        .tour-img { width: 100%; max-height: 500px; object-fit: cover; }
        .content { padding: 40px; width: 60%; }
        .sidebar { padding: 40px; width: 40%; background: #f8f9fa; border-left: 1px solid #eee; }
        h1 { font-size: 32px; color: #2f3542; margin-bottom: 20px; }
        .info-tag { display: inline-block; background: #dfe4ea; padding: 8px 15px; border-radius: 20px; font-weight: bold; font-size: 14px; margin-right: 10px; margin-bottom: 20px; }
        .price { font-size: 28px; color: #ff4757; font-weight: 800; margin-bottom: 20px; }
        .btn-back { display: inline-block; margin-bottom: 20px; color: #1e90ff; text-decoration: none; font-weight: bold; }
        .book-form { display: flex; flex-direction: column; gap: 15px; }
        input[type="number"] { padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-size: 16px; }
        button { background: #2ed573; color: white; border: none; padding: 15px; border-radius: 8px; font-size: 18px; font-weight: bold; cursor: pointer; transition: 0.3s; }
        button:hover { background: #27ae60; }
        .alert { background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <img src="{{ $tour->image ? asset($tour->image) : 'https://images.unsplash.com/photo-1476514525535-07fb3b4ae5f1' }}" class="tour-img">
        
        <div class="content">
            <a href="{{ route('home') }}" class="btn-back"><i class="fas fa-arrow-left"></i> Quay lại danh sách</a>
            <h1>{{ $tour->name }}</h1>
            
            <span class="info-tag"><i class="fas fa-map-marker-alt" style="color:#ff4757;"></i> {{ $tour->location }}</span>
            <span class="info-tag"><i class="fas fa-clock" style="color:#1e90ff;"></i> {{ $tour->duration }} ngày</span>
            
            <h3 style="margin: 20px 0 10px;">Lịch trình & Mô tả chi tiết:</h3>
            <p style="line-height: 1.8; color: #57606f;">{{ $tour->description }}</p>
        </div>

        <div class="sidebar">
            @if(session('success'))
                <div class="alert"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
            @endif

            <p style="color: #747d8c; font-weight: bold;">Giá trọn gói:</p>
            <div class="price">{{ number_format($tour->price, 0, ',', '.') }} VNĐ / khách</div>

            <form action="{{ route('book.tour', $tour->id) }}" method="POST" class="book-form">
                @csrf
                <label style="font-weight: bold;">Số hành khách tham gia:</label>
                <input type="number" name="guests_count" value="1" min="1" required>
                
                <button type="submit"><i class="fas fa-paper-plane"></i> ĐẶT TOUR NGAY</button>
            </form>
            <p style="font-size: 12px; color: #a4b0be; text-align: center; margin-top: 15px;">*Bạn cần đăng nhập để đặt tour. Nhân viên sẽ gọi điện xác nhận sau khi đặt thành công.</p>
        </div>
    </div>
</body>
</html>