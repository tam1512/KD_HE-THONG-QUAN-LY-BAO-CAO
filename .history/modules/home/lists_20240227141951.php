<!DOCTYPE html>
<html lang="vi">

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
   <title>Mô tả hệ thống báo cáo chất lượng</title>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
      integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
      integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />
   <link rel="stylesheet" href="<?php echo _WEB_HOST_TEMPLATE ?>/assets/css/style.css?ver=<?php echo rand() ?>"
      type="text/css">
</head>

<body>
   <div class="box_content container-fluid">
      <div class="row">
         <div class="phu_luc col-lg-3 col-md-4 col-sm-12 col-12">
            <div class="conten-pl sticky-top">
               <nav class='table-of-contents'>
                  <p class='tt_phu_luc'><span>Mục lục:</span></p>
                  <ul>
                     <li class="li_h2">
                        <a class="ul_h2" href='#muc-dich-he-thong'>
                           1. Mục đích của hệ thống
                        </a>
                     </li>
                     <li class="li_h2">
                        <a class="ul_h2" href='#cac-chuc-nang'>
                           2. Các chức năng
                        </a>
                     </li>
                     <li class="li_h3">
                        <a class="ul_h3" href='#chuc-nang-chinh'>
                           2.1. Chức năng chính
                        </a>
                     </li>
                     <li class="li_h4">
                        <a class="ul_h4" href='#bao-cao'>
                           2.1.1. Báo cáo
                        </a>
                     </li>
                     <li class="li_h5">
                        <a class="ul_h5" href='#luong-tao-bao-cao'>
                           a. Luồng tạo báo cáo
                        </a>
                     </li>
                     <li class="li_h5">
                        <a class="ul_h5" href='#luong-ky-bao-cao'>
                           a. Luồng ký báo cáo
                        </a>
                     </li>
                     <li class="li_h4">
                        <a class="ul_h4" href='#thong-ke'>
                           2.1.2. Thống kê
                        </a>
                     </li>
                     <li class="li_h3">
                        <a class="ul_h3" href='#cac-chuc-nang-khac'>
                           2.2. Các chức năng khác
                        </a>
                     </li>
                     <li class="li_h3">
                        <a class="ul_h3" href='#phan-quyen-tai-khoan'>
                           2.3. Phân quyền tài khoản
                        </a>
                     </li>
                     <li class="li_h2">
                        <a class="ul_h2" href='#nhung-luu-y-khi-su-dung-he-thong'>
                           3. Những lưu ý khi sử dụng hệ thống
                        </a>
                     </li>
                     <li class="li_h2">
                        <a class="ul_h2" href='#danh-sach-tai-khoan'>
                           4. Danh sách tài khoản
                        </a>
                     </li>
                     <br>
                     <br>
                     <li class="li_h2">
                        Sử dụng hệ thống <a target="_blank" href="<?php echo _WEB_HOST_ROOT_ADMIN ?>"><b>Tại đây</b></a>
                     </li>
                  </ul>
            </div>
         </div>
         <div class="blog_detail bg-light col-lg-9 col-md-8 col-sm-12 col-12 p-3">
            <h1 class="blog_title">Mô tả hệ thống báo cáo chất lượng</h1>
            <div class="content-detail">
               <h2 class="text" id="muc-dich-he-thong">
                  1. Mục đích hệ thống
               </h2>
               <p class="text">
                  - Mục đích chính của hệ thống là hỗ trợ nhân viên thuận tiện hơn trong việc tạo báo cáo, lấy số lượng
                  thống kê và tiết kiệm chi phí giấy tờ cho công ty.
               </p>
               <p class="text">
                  - Luồng hoạt động cũ tốn nhiều thời gian và chi phí phát sinh. Nhân viên nhận hàng nhập, sau đó phải
                  lập báo cáo cho đợt hàng đó: từ số lượng nhận tuân thủ theo quy chuẩn của AQL 2.5-4.0 Level II tính
                  toán ra số lượng phải kiểm tra, sau đó kiểm tra từng sản phẩm, nếu sản phẩm có lỗi thì ghi lại lỗi và
                  số lượng lỗi, sau khi kiểm tra xong thì mới lên máy tính dùng phần mềm để tạo báo cáo với các thông
                  tin đã lấy ở trên. Tạo báo cáo xong nhân viên ký và đưa cho cơ sở gia công ký xác nhận, sau đó phải
                  tiếp tục đem lên trình sếp để sếp phê duyệt và đưa ra hướng xử lý, lúc này mới hoàn thành. Tuy nhiên
                  phần mềm chỉ hỗ trợ tạo báo cáo còn về mã báo cáo thì không được quản lý nên mã được tạo không theo
                  quy tắc và khó quản lý.
               </p>
               <p class="text">
                  - Ngoài ra việc thống kê lại số lượng cũng rất khó khăn, phải nhập lại toàn bộ số liệu vào excel vì
                  phần mềm chỉ hỗ trợ tạo chứ không lưu trữ dữ liệu.
               </p>
               <p class="text">
                  - Luồng hoạt động mới: Nhân viên kiểm tra sẽ tạo báo cáo trực tiếp trên trang web, sau đó những người
                  có liên quan có thể lên trang web để ký trực tiếp.
               </p>
               <p class="text">
               <h4>Ưu điểm của luồng hoạt động mới:</h4>
               </p>
               <p class="text">
                  - Việc tạo báo cáo trở nên dễ dàng hơn, các thông số được cập nhật tự động.
               </p>
               <p class="text">
                  - Mã báo cáo được tạo tự động, dễ quản lý.
               </p>
               <p class="text">
                  - Nhân viên không cần phải đem báo cáo đi khắp nơi để trình ký, tiết kiệm một phần chi phí giấy tờ cho
                  công ty, tiết kiệm thời gian cho nhân viên.
               </p>
               <p class="text">
                  - Có thống kê để nhân viên có thể xem lại kết quả theo tháng và năm phục vụ cho việc báo cáo thống kê
                  mà không cần phải nhập lại số liệu như luồng hoạt động cũ.
               </p>
               <h2 class="text" id="cac-chuc-nang">
                  2. Các chức năng
               </h2>
               <h3 class="text" id="chuc-nang-chinh">
                  2.1. Chức năng chính
               </h3>
               <p class="text">
                  - Chức năng chính của hệ thống phục vụ cho 2 đối tượng là biên bản báo cáo và thông kê
               </p>
               <h4 class="text" id="bao-cao">
                  2.1.1. Báo cáo
               </h4>
               <p class="text">
                  - Đối tượng báo cáo có 2 luồng hoạt động chính: luồng tạo báo cáo và luồng ký báo cáo
               </p>
               <h5 class="text" id="luong-tao-bao-cao">
                  a. Luồng tạo báo cáo
               </h5>
               <h6 class="text">
                  Các trường thông tin cơ bản của báo cáo
               </h6>
               <image alt="các trường dữ liệu" width="100%"
                  src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/cac-truong-thong-tin.png' ?>" />

               <h6 class="text">
                  Thêm lỗi cho báo cáo
               </h6>
               <image alt="Thêm lỗi và xem trước kết quả" width="100%"
                  src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/ket-qua-xem-truoc.png' ?>" />

               <h6 class="text">
                  Danh sách lỗi của báo cáo
               </h6>
               <image alt="Danh sách lỗi" width="100%"
                  src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/ds-loi.png' ?>" />

               <h6 class="text">
                  Xem và chỉnh sửa ảnh của lỗi
               </h6>
               <image alt="Xem và chỉnh sửa ảnh của lỗi" width="100%"
                  src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/chinh-sua-anh-loi.png' ?>" />

               <h6 class="text">
                  Sau khi thêm báo cáo sẽ được chuyển hướng sang trang danh sách báo cáo
               </h6>
               <image alt="Danh sách báo cáo" width="100%"
                  src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/ds-bao-cao.png' ?>" />
               <h5 class="text" id="luong-ky-bao-cao">
                  b. Luồng ký báo cáo
               </h5>
               <p class="text">
                  - Có 4 đối tượng cần ký để hoàn thành báo cáo: người tạo báo cáo, cơ sở gia công, người xem xét hoặc
                  QĐ/PQĐ và người phê duyệt. Luồng ký tên được thực hiện như sau:
               </p>
               <p class="text li_h3">
                  1. Sau khi tạo báo cáo hệ thống sẽ tự động ký chữ ký của người tạo vào báo cáo. Nếu người tạo báo cáo
                  chọn lưu nháp, người xem xét và QĐ/PQĐ sẽ không nhận được thông báo để vào ký, ngược lại 2 đối tượng
                  trên sẽ nhận được thông báo.
               </p>
               <p class="text li_h3">
                  2. Người tạo đưa báo cáo cho đại diện cơ sở gia công để họ kiểm tra và ký xác nhận.
               </p>
               <p class="text li_h3">
                  3. Khi người xem xét và QĐ/PQĐ nhận được thông báo thì có thể vào báo cáo để ký. Lưu ý người xem xét
                  và QĐ/PQĐ cùng 1 bậc nên chỉ cần 1 trong 2 ký vào báo cáo là được, khi một trong 2 người ký xong thì
                  người phê duyệt sẽ nhận được thông báo.
               </p>
               <p class="text li_h3">
                  4. Người phê duyệt nhận được báo cáo sẽ vào xem, duyệt, thay đổi và đưa ra hướng xử lý, sau đó chọn ký
                  và hoàn thành báo cáo.
               </p>
               <p class="text">
                  - Có thể ký theo 2 cách: một là nhấn vào nút ký ngay ở sau mã báo cáo ở danh sách báo cáo hoặc vào
                  trang nội dung báo cáo để xác nhận ký (có thể vào nhanh bằng cách xem trong phần thông báo của hệ
                  thống).
               </p>
               <p class="text">
                  - Đối với cách ký nhanh của người phê duyệt thì hệ thống sẽ tự đổng chuyển trạng thái của báo cáo từ
                  "Đang xử lý" thành "Chấp nhận".
               </p>
               <h4 class="text" id="thong-ke">
                  2.1.2. Thống kê
               </h4>
               <h6 class="text">
                  Tùy chỉnh tạo biểu đồ thống kê
               </h6>
               <image alt="Tạo biểu đồ thống kê" width="100%"
                  src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/tao-thong-ke.png' ?>" />
               <h6 class="text">
                  Bảng thông tin chi tiết tùy thuộc vào loại biểu đồ
               </h6>
               <image alt="Bảng thông tin chi tiết" width="100%"
                  src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/thong-tin-chi-tiet.png' ?>" />

               <h3 class="text" id="cac-chuc-nang-khac">
                  2.2. Các chức năng khác
               </h3>
               <table class="table table-bordered table-responsive bg-white">
                  <tr class="thead-light">
                     <th>Chức năng</th>
                     <th width="99%">Chi tiết</th>
                  </tr>
                  <tr>
                     <td>Tài khoản</td>
                     <td>
                        <p class="text">- Đăng nhập</p>
                        <p class="text">- Tùy chỉnh thông tin cá nhân</p>
                        <p class="text">- Tùy chỉnh chữ ký cá nhân</p>
                        <p class="text">- Đổi mật khẩu</p>
                        <p class="text">- Đăng xuất</p>
                        <p class="text">- Tự động đăng xuất sau 60 phút</p>
                     </td>
                  </tr>
                  <tr>
                     <td>Tổng quan</td>
                     <td>
                        <p class="text">Xem thống kê sơ lược</p>
                     </td>
                  </tr>
                  <tr>
                     <td>Nhóm người dùng</td>
                     <td>
                        <p class="text">- Tìm kiếm</p>
                        <p class="text">- Thêm</p>
                        <p class="text">- Chỉnh sửa</p>
                        <p class="text">- Xóa</p>
                        <p class="text">- Phân quyền</p>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <p class="text">Quản lý người dùng</p>
                        <p class="text">Danh mục sản phẩm</p>
                        <p class="text">Quản lý sản phẩm</p>
                        <p class="text">Quản lý cơ sở</p>
                        <p class="text">Danh mục lỗi</p>
                        <p class="text">Quản lý lỗi</p>
                        <p class="text">Danh mục báo cáo</p>
                     </td>
                     <td>
                        <p class="text">- Tìm kiếm</p>
                        <p class="text">- Thêm</p>
                        <p class="text">- Chỉnh sửa</p>
                        <p class="text">- Xóa</p>
                     </td>
                  </tr>
               </table>
               <h3 class="text" id="phan-quyen-tai-khoan">
                  <span style="color: black;">
                     2.3. Phân quyền tài khoản
                  </span>
               </h3>
               <h6 class="text">
                  Tài khoản được phân quyền theo nhóm tài khoản
               </h6>
               <image alt="Phân quyền tài khoản" width="100%"
                  src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/phan-quyen-tai-khoan.png' ?>" />
               <h6 class="text">
                  Tài khoản có quyền root có thể phân quyền root cho các nhóm tài khoản (có được tất cả quyền trong hệ
                  thống)
               </h6>
               <image alt="Phân quyền root" width="100%"
                  src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/phan-quyen-root.png' ?>" />
               <h6 class="text">
                  Danh sách các quyền
               </h6>
               <image alt="Phân quyền 1" width="100%"
                  src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/phan-quyen-1.png' ?>" />
               <image alt="Phân quyền 2" width="100%"
                  src="<?php echo _WEB_HOST_TEMPLATE.'/assets/images/phan-quyen-2.png' ?>" />
               <h2 class="text" id="nhung-luu-y-khi-su-dung-he-thong">
                  <span style="color: black;">
                     3. Những lưu ý khi sử dụng hệ thống
                  </span>
               </h2>
               <p class="text">- Nếu sử dụng hệ thông trên thiết bị di động nên sử dụng trình duyệt Google.</p>
               <p class="text">- Hệ thống chỉ có thể truy cập được với giao thức http</p>
               <p class="text">- Truy cập hệ thống ngay với đường link: <a target="_blank"
                     href="http://bccl.wuaze.com/admin">http://bccl.wuaze.com/admin</a></p>
               <p class="text">- Báo cáo sẽ có 5 trạng thái: </p>
               <p class="text li_h3">+ Chưa duyệt: trạng thái này được đặt khi nhân viên bấm nút Lưu nháp (khi bấm nút
                  Lưu nháp thì các nhân viên có liên quan sẽ không nhận được thông báo, người tạo báo cáo có thể tiếp
                  tục sửa).</p>
               <p class="text li_h3">+ Đang xử lý: trạng thái này được đặt khi nhân viên bấm nút Lưu hoặc vào xem báo
                  cáo và bấm nút Xác nhận báo cáo (chỉ áp dụng đối với trường hợp Lưu nháp), lúc này nhân viên được chọn
                  sẽ nhận được thông báo.</p>
               <p class="text li_h3">+ Ba trạng thái: xác nhận, trả sửa, nhận tiền trừ. Ba trạng thái này chỉ được chọn
                  bởi nhóm người phê duyệt, quyết định hướng xử lý báo cáo.</p>
               <p class="text">- Bảng kết quả AQL sẽ tự động cập nhật số lỗi cho phép dựa vào quy chuẩn AQL và số lỗi
                  thực tế dựa vào danh sách lỗi đã thêm, từ đó sẽ tự động tích vào ô phù hợp ở phần kết luận. Điều này
                  giúp cho nhân viên tạo có thể biết trước được kết quả của báo cáo.</p>
               <p class="text">- Khi chỉnh sửa ảnh của lỗi nhớ bấm nút chỉnh sửa trước khi quay lại trang thêm báo cáo.
               </p>
               <p class="text">- Khi bấm nút Lưu hoặc Lưu nháp thì báo cáo bắt buộc phải có đủ các thông tin cơ bản và
                  ít nhất một lỗi trong danh sách lỗi.</p>
               <p class="text">- Ở trang danh sách báo cáo nếu nút bên phải Mã báo cáo là nút Ký ngay, nhân viên có thể
                  nhấn nút này để ký nhanh báo cáo.</p>
               <p class="text">- Đối với những báo cáo có trạng thái Chưa duyệt (Lưu nháp), nhân viên phải vào trang nội
                  dung báo cáo (xem trước) sau đó nhấn nút Xác nhận báo cáo để chuyển trạng thái sang Đang xử lý và cho
                  các nhân viên liên quan nhận được thông báo để vào ký và xem báo cáo.</p>
               <p class="text">- Ở trang nội dung báo cáo (trang xem trước) khi ký chữ ký gia công và thay đổi trạng
                  thái phải bấm nút xác nhận.</p>
               <p class="text">- Khi chọn trạng thái Nhận tiền trừ người phê duyệt phải nhập số tiền hoặc số phần trăm
                  trừ.</p>
               <p class="text">- Có thể ký theo 2 cách: một là nhấn vào nút ký ngay ở sau mã báo cáo ở danh sách báo cáo
                  hoặc vào trang nội dung báo cáo để xác nhận ký (có thể vào nhanh bằng cách xem trong phần thông báo
                  của hệ thống).</p>
               <p class="text">- Đối với cách ký nhanh của người phê duyệt thì hệ thống sẽ tự đổng chuyển trạng thái của
                  báo cáo từ "Đang xử lý" thành "Chấp nhận".</p>
               <h2 class="text" id="danh-sach-tai-khoan">
                  <span style="color: black;">
                     4. Danh sách tài khoản
                  </span>
               </h2>
               <table class="table table-bordered table-responsive bg-white">
                  <tr>
                     <th>Nhóm người dùng</th>
                     <th width="99%">Tài khoản</th>
                  </tr>
                  <tr>
                     <td>Admin</td>
                     <td>
                        <p>admin@gmail.com</p>
                        <p>pass: 123456789</p>
                     </td>
                  </tr>
                  <tr>
                     <td>Người kiểm tra (người tạo báo cáo)</td>
                     <td>
                        <p>KT.nguyen@kimduc.com.vn</p>
                        <p>pass: 123456789</p>
                     </td>
                  </tr>
                  <tr>
                     <td>Người xem xét</td>
                     <td>
                        <p>XX.nguyen@kimduc.com.vn</p>
                        <p>pass: 123456789</p>
                     </td>
                  </tr>
                  <tr>
                     <td>Quản đốc/ Phó quản đốc (QĐ/PQĐ)</td>
                     <td>
                        <p>QĐ.nguyen@kimduc.com.vn</p>
                        <p>pass: 123456789</p>
                        <br>
                        <p>PQĐ.nguyen@kimduc.com.vn</p>
                        <p>pass: 123456789</p>
                     </td>
                  </tr>
                  <tr>
                     <td>Người phê duyệt</td>
                     <td>
                        <p>PD.nguyen@kimduc.com.vn</p>
                        <p>pass: 123456789</p>
                     </td>
                  </tr>
               </table>
            </div>
         </div>
      </div>
   </div>
   <button class="btn scroll-to-top-button" onclick="scrollToTop()"><i class="fa-solid fa-arrow-up"></i><button>
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
            integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous">
         </script>
         <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
         </script>
         <script src="<?php echo _WEB_HOST_TEMPLATE ?>/assets/js/app.js?ver=<?php echo rand() ?>"></script>
</body>

</html>