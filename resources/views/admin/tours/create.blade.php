<form action="{{ route('admin.tours.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label>Tên Tour:</label>
    <input type="text" name="name" required>
    
    <label>Danh mục (ID):</label>
    <input type="number" name="category_id" required> <!-- Trong thực tế sẽ dùng Select box dropdown -->
    
    <label>Mô tả:</label>
    <textarea name="description" required></textarea>
    
    <label>Giá:</label>
    <input type="number" name="price" required>
    
    <label>Thời gian (Ngày):</label>
    <input type="number" name="duration" required>
    
    <label>Địa điểm:</label>
    <input type="text" name="location" required>
    
    <label>Ngày khởi hành:</label>
    <input type="date" name="start_date" required>
    
    <label>Hình ảnh:</label>
    <input type="file" name="image">
    
    <button type="submit">Lưu Tour</button>
</form>