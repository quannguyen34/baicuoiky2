<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // Hàm xử lý việc đặt tour
    public function store(Request $request, $id)
    {
        $request->validate([
            'guests_count' => 'required|integer|min:1'
        ]);

        // Tìm tour khách đang muốn đặt
        $tour = Tour::findOrFail($id);

        // Tạo đơn đặt tour lưu vào Database
        Booking::create([
            'user_id' => Auth::id(),                     // ID của người đang đăng nhập
            'tour_id' => $tour->id,                      // ID của tour
            'guests_count' => $request->guests_count,    // Số người đi
            'total_price' => $tour->price * $request->guests_count, // Tự động tính tổng tiền
            'status' => 'pending'                        // Trạng thái mặc định: Chờ xác nhận
        ]);

        // Đặt xong thì chuyển hướng về trang Lịch sử (Dashboard) kèm thông báo
        return redirect()->route('dashboard')->with('success', '🎉 Đặt tour thành công! Vui lòng chờ nhân viên liên hệ xác nhận.');
    }
}
