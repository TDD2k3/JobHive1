<?php
require_once __DIR__ . '/../controllers/JobController.php';
$controller = new JobController();
$data = $controller->index();
$jobs = $data['jobs'];
$totalPages = $data['totalPages'];
$currentPage = $data['currentPage'];
?>

<section class="section-box animated-characters-section">
  <div class="image-container" id="imageContainer">
  <div class="bg-overlay"></div>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const imageContainer = document.getElementById('imageContainer');

  // 1. Mảng tất cả các ảnh
  const allImages = [
    'image1.png', 'image2.png', 'image3.png', 'image4.png', 'image5.png',
    'image6.png', 'image7.png', 'image8.png', 'image9.png', 'image10.png'
  ];

  // 2. Random 5 ảnh không trùng
  const shuffled = allImages.sort(() => Math.random() - 0.5).slice(0, 5);

  // 3. Vị trí hiển thị cố định
const positions = [
  { top: '5%', left: '15%' },  
  { top: '5%', left: '65%' },  
  { top: '30%', left: '40%' }, 
  { top: '65%', left: '15%' },  
  { top: '65%', left: '65%' }   
];
  // 4. Gán ảnh vào container
  shuffled.forEach((src, index) => {
    const wrapper = document.createElement('div');
    wrapper.className = 'image-item';
    wrapper.style.top = positions[index].top;
    wrapper.style.left = positions[index].left;

    const img = document.createElement('img');
    img.src = `theme/assets/img/${src}`;
    img.alt = `Ảnh ${index + 1}`;

    wrapper.appendChild(img);
    imageContainer.appendChild(wrapper);
  });
});
</script>
</section>
<!--  thống kê hệ động -->
<section class="section-box stats-section text-center">
  <div class="container d-flex justify-content-around">
    <div class="stat-box">
      <div class="stat-number" data-target="100">0</div>
      <p>Công ty</p>
    </div>
    <div class="stat-box">
      <div class="stat-number" data-target="500">0</div>
      <p>Việc làm hấp dẫn</p>
    </div>
    <div class="stat-box">
      <div class="stat-number" data-target="10">0</div>
      <p>Thành phố</p>
    </div>
  </div>

  <!-- logic java  -->
  <script>
  document.addEventListener('DOMContentLoaded', () => {
    const counters = document.querySelectorAll('.stat-number');
    counters.forEach(counter => {
      const updateCount = () => {
        const target = +counter.getAttribute('data-target');
        const current = +counter.innerText;
        const increment = Math.ceil(target / 100);

        if (current < target) {
          counter.innerText = current + increment;
          setTimeout(updateCount, 30);
        } else {
          counter.innerText = target;
        }
      };
      updateCount();
    });
  });
  </script>
</section>

<!-- phần about us -->
<section class="intro-section reveal">
  <div class="intro-container">
    <h2>Chào mừng bạn đến với JobHive</h2>
    <p>
      JobHive là nền tảng tuyển dụng trực tuyến được thiết kế để kết nối nhà tuyển dụng uy tín và các ứng viên tiềm năng. 
      Với giao diện thân thiện, chức năng tìm kiếm thông minh và hệ thống gợi ý phù hợp, chúng tôi giúp bạn rút ngắn con đường đến với công việc mơ ước.
    </p>
    <p>
      Bất kể bạn là sinh viên mới ra trường, người đang tìm kiếm thử thách mới hay doanh nghiệp cần nhân tài, JobHive luôn sẵn sàng hỗ trợ. 
      Chúng tôi cam kết mang lại trải nghiệm nhanh chóng, minh bạch và hiệu quả.
    </p>
    <p>
      Hãy để JobHive đồng hành cùng bạn trên hành trình phát triển sự nghiệp – nơi mà cơ hội và đam mê gặp nhau.
    </p>
    <a href="index.php?page=job_list" class="btn-discover">Khám phá việc làm ngay</a>
  </div>
  <script>
  window.addEventListener("scroll", function () {
    const reveals = document.querySelectorAll(".reveal");
    reveals.forEach(el => {
      const windowHeight = window.innerHeight;
      const revealTop = el.getBoundingClientRect().top;
      const revealPoint = 100;

      if (revealTop < windowHeight - revealPoint) {
        el.classList.add("active");
      }
    });
  });
</script>
</section>
<!-- phần map API -->
<footer class="jobhive-footer">
  <div class="footer-container">
    <div class="footer-info">
      <p>📍 Địa chỉ: 19 Lê Thanh Nghị, Bách Khoa, Hai Bà Trưng, Hà Nội</p>
      <p>📞 Hotline/Zalo: 0123 456 789</p>
      <p>🌐 Website: <a href="#">www.jobhive.vn</a></p>
      <div class="social-icons">
        <a href="#"><img src="theme/assets/img/facebooklogo.png" alt="Facebook" /></a>
        <a href="#"><img src="theme/assets/img/tiktoklogo.png" alt="TikTok" /></a>
        <a href="#"><img src="theme/assets/img/ytblogo.png" alt="YouTube" /></a>
      </div>
    </div>
    <div class="footer-map">
      <iframe 
        src="https://www.google.com/maps?q=19+Lê+Thanh+Nghị,+Bách+Khoa,+Hai+Bà+Trưng,+Hà+Nội&output=embed"
        width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy">
      </iframe>
    </div>
  </div>
</footer>

