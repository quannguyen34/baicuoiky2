<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\Category;
use App\Models\Booking;
use App\Models\User;

class AdminController extends Controller
{
    // ==========================================
    // 1. HÀM HIỂN THỊ TRANG DASHBOARD ADMIN (Hàm bị thiếu)
    // ==========================================
    public function index()
    {
        // Lấy thống kê tổng quan
        $stats = [
            'tours' => Tour::count(),
            'bookings' => Booking::count(),
            'revenue' => Booking::where('status', 'confirmed')->sum('total_price'), // Chỉ cộng tiền đơn đã duyệt
            'users' => User::where('role', 0)->count(),
        ];

        // Lấy danh sách dữ liệu để hiển thị ra bảng
        $bookings = Booking::with(['user', 'tour'])->latest()->get();
        $tours = Tour::with('category')->latest()->get();
        $categories = Category::withCount('tours')->latest()->get();
        $users = User::where('role', 0)->latest()->get();

        return view('admin.dashboard', compact('stats', 'bookings', 'tours', 'categories', 'users'));
    }

    // ==========================================
    // 2. HÀM THÊM TOUR MỚI (CÓ XỬ LÝ ẢNH)
    // ==========================================
   public function storeTour(Request $request)
    {
        // Thêm kiểm tra start_date
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'price' => 'required|numeric',
            'duration' => 'required|integer',
            'start_date' => 'required|date', // <-- Thêm dòng này
            'location' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/tours'), $imageName);
            $imagePath = 'uploads/tours/' . $imageName;
        }

        // Đưa start_date vào lệnh tạo Tour
        Tour::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'duration' => $request->duration,
            'start_date' => $request->start_date, // <-- Thêm dòng này
            'location' => $request->location,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Thêm tour mới thành công!');
    }

    // ==========================================
    // 3. HÀM XÓA TOUR
    // ==========================================
    public function destroyTour($id) {
        Tour::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Đã xóa tour!');
    }

    // ==========================================
    // 4. HÀM DUYỆT / HỦY ĐƠN ĐẶT TOUR
    // ==========================================
    public function updateBooking(Request $request, $id) {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn thành công!');
    }

    // ==========================================
    // 5. CÁC HÀM QUẢN LÝ DANH MỤC & KHÁCH HÀNG
    // ==========================================
    public function storeCategory(Request $request) {
        Category::create(['name' => $request->name]);
        return redirect()->back()->with('success', 'Thêm danh mục thành công!');
    }

    public function destroyCategory($id) {
        Category::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Đã xóa danh mục!');
    }

    public function destroyUser($id) {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Đã xóa khách hàng!');
    }
}