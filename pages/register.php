<div class="container mt-5" style="max-width: 600px">
  <h2 class="text-center mb-4">📝 Đăng ký tài khoản</h2>
  <form method="POST" action="?page=register_process">
    <div class="mb-3">
      <label for="email" class="form-label">Email:</label>
      <input type="email" class="form-control" name="email" required>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Mật khẩu:</label>
      <input type="password" class="form-control" name="password" required>
    </div>
    <div class="mb-3">
      <label for="name" class="form-label">Họ tên / Tên công ty:</label>
      <input type="text" class="form-control" name="name" required>
    </div>

    <!-- Loại tài khoản -->
    <div class="mb-3">
      <label class="form-label">Loại tài khoản:</label>
      <select class="form-select" name="role" id="role-select">
        <option value="user">Người dùng thường</option>
        <option value="company">Tổ chức / Tuyển dụng</option>
      </select>
    </div>

    <!-- Thông tin công ty (hiện ra khi chọn role=company) -->
    <div id="company-fields" class="border rounded p-3" style="display: none">
      <div class="mb-3">
        <label for="company_size" class="form-label">Quy mô công ty:</label>
        <input type="text" class="form-control" name="company_size">
      </div>
      <div class="mb-3">
        <label for="industry" class="form-label">Ngành nghề hoạt động:</label>
        <input type="text" class="form-control" name="industry">
      </div>
    </div>

    <div class="d-grid">
      <button type="submit" class="btn btn-primary">Đăng ký</button>
    </div>
  </form>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const roleSelect = document.getElementById('role-select');
    const companyFields = document.getElementById('company-fields');

    roleSelect.addEventListener('change', function () {
      if (this.value === 'company') {
        companyFields.style.display = 'block';
      } else {
        companyFields.style.display = 'none';
      }
    });
  });
</script>
