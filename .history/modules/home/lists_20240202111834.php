<!DOCTYPE html>
<html lang="vi">

<head>
   <meta charset="UTF-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
   <title>Mô tả hệ thống báo cáo chất lượng</title>

   <link rel="preload" href="/fonts/roboto-v16-vietnamese_latin-ext-regular.woff2" as="font" type="font/woff2"
      crossorigin="anonymous">
   <link rel="preload" href="/fonts/Roboto-Medium.woff2" as="font" type="font/woff2" crossorigin="anonymous">
   <link rel="preload" as="style" href="/css/blog.css?v=396">
   <link rel="stylesheet" media="all" href="/css/blog.css?v=396" media="all" onload="if (media != 'all')media='all'">
   <link rel="stylesheet" href="/css/new_style.css" type="text/css" media="all">
   <link rel="stylesheet" href="/css/header_chung.css?v=396" type="text/css">
</head>

<body>
   <div class="box_content">
      <h1 class="blog_title">Mô tả hệ thống quản lý bán hàng - nghệ thuật trong quản lý</h1>
      <p class="blog_auth">Tác giả: <a rel="nofollow" href="/blog/tac-gia/nguyen-loan-tg115">Nguyễn Loan</a></p>
      <div class="phu_luc">
         <div class="conten-pl">
            <nav class='table-of-contents'>
               <p class='tt_phu_luc'><span>Mục lục:</span></p>
               <ul>
                  <li class="li_h2">
                     <a class="ul_h2" href='#mo-ta-he-thong-quan-ly-ban-hang'>
                        1. M&ocirc; tả hệ thống quản l&yacute; b&aacute;n h&agrave;ng
                     </a>
                  </li>
                  <li class="li_h3">
                     <a class="ul_h3" href='#he-thong-quan-ly-ban-hang'>
                        1.1. Hệ thống quản l&yacute; b&aacute;n h&agrave;ng
                     </a>
                  </li>
                  <li class="li_h3">
                     <a class="ul_h3" href='#mo-ta-he-thong-quan-ly-ban-hang'>
                        1.2. M&ocirc; tả hệ thống quản l&yacute; b&aacute;n h&agrave;ng
                     </a>
                  </li>
                  <li class="li_h2">
                     <a class="ul_h2" href='#lam-the-nao-de-quan-ly-duoc-he-thong-ban-hang-chuoi'>
                        2. L&agrave;m thế n&agrave;o để quản l&yacute; được hệ thống b&aacute;n h&agrave;ng chuỗi
                     </a>
                  </li>
                  <li class="li_h3">
                     <a class="ul_h3" href='#quan-ly-hang-hoa-nhap-khau-dieu-chuyen'>
                        2.1. Quản l&yacute; h&agrave;ng h&oacute;a nhập khẩu, điều chuyển
                     </a>
                  </li>
                  <li class="li_h3">
                     <a class="ul_h3" href='#so-sanh-hieu-quan-hoat-dong-giua-cac-chi-nhanh-voi-nhau'>
                        2.2. So s&aacute;nh hiệu quản hoạt động giữa c&aacute;c chi nh&aacute;nh với nhau
                     </a>
                  </li>
                  <li class="li_h3">
                     <a class="ul_h3" href='#phan-quyen-cho-nhan-vien-cap-duoi'>
                        2.3. Ph&acirc;n quyền cho nh&acirc;n vi&ecirc;n cấp dưới
                     </a>
                  </li>
                  <li class="li_h2">
                     <a class="ul_h2" href='#cach-xay-dung-he-thong-quan-ly-ban-hang-online'>
                        3. C&aacute;ch x&acirc;y dựng hệ thống quản l&yacute; b&aacute;n h&agrave;ng online
                     </a>
                  </li>
                  <li class="li_h2">
                     <a class="ul_h2" href='#nhung-ky-nang-quan-ly-ban-hang-giup-nguoi-quan-ly-thanh-cong'>
                        4. Những kỹ năng quản l&yacute; b&aacute;n h&agrave;ng gi&uacute;p người quản l&yacute;
                        th&agrave;nh c&ocirc;ng
                     </a>
                  </li>
                  <li class="li_h3">
                     <a class="ul_h3" href='#dao-tao-doi-ngu-nhan-vien'>
                        4.1. Đ&agrave;o tạo đội ngũ nh&acirc;n vi&ecirc;n
                     </a>
                  </li>
                  <li class="li_h3">
                     <a class="ul_h3" href='#su-dung-thanh-thao-phan-mem-quan-ly'>
                        4.2. Sử dụng th&agrave;nh thạo phần mềm quản l&yacute;
                     </a>
                  </li>
                  <li class="li_h3">
                     <a class="ul_h3" href='#phan-quyen-cho-nhan-vien-cap-duoi'>
                        4.3. Ph&acirc;n quyền cho nh&acirc;n vi&ecirc;n cấp dưới
                     </a>
                  </li>
               </ul>
         </div>
         <div class="banner_gif">
            <a target="blank" href="https://timviec365.vn/cv-xin-viec">
               <img style="width: 100%;height: 100%" class="lazyload" src="/images/load.gif"
                  data-src="https://timviec365.vn/images/banner_cv_right.gif?v=1" alt="Tạo CV online">
            </a>
         </div>
      </div>

      <div class="blog_detail news-detail">
         <div class="summary">
            <p style="margin: 12pt 0in; text-align: justify;">
               <span style="">
                  <span>
                     <span style="color: black;">
                        M&ocirc; tả hệ thống quản l&yacute; b&aacute;n h&agrave;ng ch&iacute;nh l&agrave; việc m&agrave;
                        doanh nghiệp thực hiện nhận đơn h&agrave;ng từ ph&iacute;a kh&aacute;ch h&agrave;ng bằng trực
                        tiếp hoặc gi&aacute;n tiếp qua email, fax, điện thoại. C&oacute; thể n&oacute;i đ&acirc;y
                        l&agrave; một hoạt động thường xuy&ecirc;n lặp đi lặp lại của c&aacute;c doanh nghiệp.
                        Ch&iacute;nh v&igrave; thế h&ocirc;m nay ch&uacute;ng ta c&ugrave;ng t&igrave;m hiểu về m&ocirc;
                        tả hệ thống quản l&yacute; b&aacute;n h&agrave;ng để xem doanh nghiệp họ quản l&yacute; như thế
                        n&agrave;o nh&eacute;.
                     </span>
                  </span>
               </span>
            </p>
         </div>
         <div class="content-detail">
            <h2 style="margin: 12pt 0in; " id="mo-ta-he-thong-quan-ly-ban-hang">
               <span style="">
                  <span>
                     <span style="color: black;">
                        1. M&ocirc; tả hệ thống quản l&yacute; b&aacute;n h&agrave;ng
                     </span>
                  </span>
               </span>
               <o:p></o:p>
            </h2>
            <div style="text-align:center">
               <figure style="display:inline-block">
                  <img alt="mô tả hệ thống quản lý bán hàng" height="418" class="lazyload" src="/images/load.gif"
                     data-src="https://storage.timviec365.vn/timviec365/pictures/images/mo-ta-he-thong-quan-ly-ban-hang-1.jpg"
                     width="800" />
                  <figcaption>M&ocirc; tả hệ thống quản l&yacute; b&aacute;n h&agrave;ng</figcaption>
               </figure>
            </div>
            <h3 style="margin: 12pt 0in; " id="he-thong-quan-ly-ban-hang">
               <span style="">
                  <span>
                     <span style="white-space:pre-wrap">
                        <span style="color: black;">1.1. Hệ thống quản l&yacute; b&aacute;n h&agrave;ng</span>
                     </span>
                  </span>
               </span>
               <o:p></o:p>
            </h3>
            <p style="margin: 12pt 0in; ">
               <span style="">
                  <span>
                     <span style="white-space:pre-wrap">
                        <span style="color: black;">
                           - Hiện nay với sự ph&aacute;t triển nhanh ch&oacute;ng của c&ocirc;ng nghệ th&ocirc;ng tin
                           ng&agrave;y c&agrave;ng hiện đại, đ&atilde; dẫn đến việc mua sắm của con người cũng
                           ng&agrave;y c&agrave;ng dễ d&agrave;ng hơn, ch&iacute;nh v&igrave; thế m&agrave; xu hướng
                           quản l&yacute; b&aacute;n h&agrave;ng ng&agrave;y c&agrave;ng phổ biến hơn. Việc quản
                           l&yacute; b&aacute;n h&agrave;ng kh&ocirc;ng hề đơn giản, rất dễ nhầm lẫn cũng ch&iacute;nh
                           v&igrave; thế m&agrave; đ&atilde; ra đời hệ thống quản l&yacute; b&aacute;n h&agrave;ng.
                        </span>
                     </span>
                  </span>
               </span>
               <o:p></o:p>
            </p>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">Hệ thống quản l&yacute; b&aacute;n h&agrave;ng ch&iacute;nh l&agrave;
                           những phần mềm quản l&yacute; b&aacute;n h&agrave;ng, gi&uacute;p cho người d&ugrave;ng đặc
                           biệt l&agrave; c&aacute;c doanh nghiệp kiểm so&aacute;t, quản l&yacute; được h&agrave;ng
                           h&oacute;a một c&aacute;ch chặt chẽ hơn. Việc quản l&yacute; của hệ thống sẽ được kiểm
                           so&aacute;t trong tất cả c&aacute;c kh&acirc;u: Nhập h&agrave;ng, quản l&yacute; đơn
                           h&agrave;ng, quản l&yacute; kho h&agrave;ng, quản l&yacute; nh&acirc;n vi&ecirc;n, <a
                              href="https://timviec365.vn/blog/nhan-vien-cham-soc-khach-hang-la-gi-new3971.html"><strong>nh&acirc;n
                                 vi&ecirc;n chăm s&oacute;c kh&aacute;ch
                                 h&agrave;ng</strong></a>...</span></span></span></span>
               <o:p></o:p>
            </p>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">- Phần mềm quản l&yacute; hệ thống b&aacute;n h&agrave;ng kh&ocirc;ng
                           c&ograve;n xa lạ với những doanh nghiệp, c&ocirc;ng ty hay cả những cửa h&agrave;ng tạp
                           h&oacute;a nữa. V&agrave; đặc biệt trong thời đại c&ocirc;ng nghệ mở như hiện nay sự
                           ph&aacute;t triển của c&ocirc;ng nghệ v&agrave; mạng internet th&igrave; những phần mềm quản
                           l&yacute; gi&uacute;p con người lại c&agrave;ng l&ecirc;n ng&ocirc;i. Ngay sau đ&acirc;y
                           ch&uacute;ng t&ocirc;i sẽ giới thiệu cho bạn một phần mềm quản l&yacute; b&aacute;n
                           h&agrave;ng v&ocirc; c&ugrave;ng hữu &iacute;ch đ&oacute; l&agrave; &ldquo;phần mềm quản
                           l&yacute; b&aacute;n h&agrave;ng của Halozend&rdquo;</span></span></span></span>
               <o:p></o:p>
            </p>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">Đ&acirc;y l&agrave; một phần mềm quản l&yacute; b&aacute;n h&agrave;ng
                           được rất nhiều c&aacute;c doanh nghiệp ứng dụng v&agrave;o trong kh&acirc;u quản l&yacute;
                           của m&igrave;nh, n&oacute; gi&uacute;p cho người quản l&yacute; c&oacute; thể kiểm
                           so&aacute;t được tất cả những hoạt động sản xuất kinh doanh một c&aacute;ch nhanh
                           ch&oacute;ng v&agrave; ch&iacute;nh x&aacute;c nhất. T&iacute;nh năng ưu việt của phần mềm
                           n&agrave;y ch&iacute;nh l&agrave; với thiết kế th&acirc;n thiện ph&ugrave; hợp với nhiều
                           người d&ugrave;ng, ch&iacute;nh v&igrave; thế m&agrave; n&oacute; đ&atilde; được rất nhiều
                           người tin tưởng sử dụng. Kh&ocirc;ng những bạn c&oacute; thể sử dụng trực tiếp tr&ecirc;n
                           m&aacute;y t&iacute;nh m&agrave; c&ograve;n c&oacute; thể sử dụng tr&ecirc;n chiếc điện thoại
                           hoặc những thiết bị th&ocirc;ng minh, ph&ugrave; hợp với sự di chuyển nhiều nơi của người
                           d&ugrave;ng.</span></span></span></span>
               <o:p></o:p>
            </p>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">Vậy đấy, hệ thống quản l&yacute; b&aacute;n h&agrave;ng đối với doanh
                           nghiệp l&agrave; v&ocirc; c&ugrave;ng quan trọng mỗi một doanh nghiệp muốn quản l&yacute; tốt
                           th&igrave; phải c&oacute; hệ thống quản l&yacute; b&aacute;n h&agrave;ng n&agrave;y để
                           c&oacute; thể kiểm so&aacute;t được tốt hơn.</span></span></span></span>
               <o:p></o:p>
            </p>
            <h3 style="margin: 12pt 0in; " id="mo-ta-he-thong-quan-ly-ban-hang"><span style=""><span><span
                        style="white-space:pre-wrap"><span style="color: black;">1.2. M&ocirc; tả hệ thống quản
                           l&yacute; b&aacute;n h&agrave;ng</span></span></span></span>
               <o:p></o:p>
            </h3>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">Hệ thống quản l&yacute; b&aacute;n h&agrave;ng l&agrave; h&agrave;ng
                           loạt những c&ocirc;ng việc được người người phụ tr&aacute;ch mảng n&agrave;y l&agrave;m đi
                           l&agrave;m lại trong suốt khoảng thời gian d&agrave;i. Cũng ch&iacute;nh v&igrave; thế
                           m&agrave; hệ thống quản l&yacute; b&aacute;n h&agrave;ng kh&ocirc;ng thể kh&ocirc;ng xuất
                           hiện trong hoạt động mua b&aacute;n của doanh nghiệp được.</span></span></span></span>
               <o:p></o:p>
            </p>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">Một doanh nghiệp, c&ocirc;ng ty c&oacute; quy tr&igrave;nh gần như
                           giống nhau. Đều bắt đầu bằng việc nhận đơn h&agrave;ng từ ph&iacute;a kh&aacute;ch
                           h&agrave;ng, nhận trực tiếp hoặc gi&aacute;n tiếp qua điện thoại, email, fax...theo đ&oacute;
                           sẽ tiếp nhận th&ocirc;ng tin đơn đặt h&agrave;ng, sản phẩm đặt h&agrave;ng sau đ&oacute; lưu
                           v&agrave;o kho đơn đặt h&agrave;ng của tất cả c&aacute;c kh&aacute;ch h&agrave;ng. Sau
                           đ&oacute; th&igrave; người quản l&yacute; hệ thống sẽ l&ecirc;n lịch hẹn đ&agrave;m
                           ph&aacute;n với kh&aacute;ch h&agrave;ng.</span></span></span></span>
               <o:p></o:p>
            </p>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">Đối với những đơn đặt h&agrave;ng đ&atilde; đến hẹn th&igrave; <a
                              href="https://timviec365.vn/blog/nhan-vien-ban-hang-la-gi-new4029.html"><strong>nh&acirc;n
                                 vi&ecirc;n b&aacute;n h&agrave;ng</strong></a> phải l&agrave; người xử l&yacute; đơn
                           đ&oacute;, nếu kh&ocirc;ng c&oacute; người nhận đơn đ&oacute; th&igrave; đơn đặt h&agrave;ng
                           đ&oacute; sẽ được hủy bỏ tạm thời. Hệ thống quản l&yacute; b&aacute;n h&agrave;ng giống như
                           một phương thức để chủ c&oacute; thể gi&aacute;m s&aacute;t được hoạt động b&aacute;n
                           h&agrave;ng của nh&acirc;n vi&ecirc;n xem nh&acirc;n vi&ecirc;n c&oacute; trung thực hay
                           kh&ocirc;ng.</span></span></span></span>
               <o:p></o:p>
            </p>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">&nbsp;Sau khi l&agrave;m hết những việc li&ecirc;n quan đến đơn
                           h&agrave;ng v&agrave; xử l&yacute; đơn h&agrave;ng th&igrave; người b&aacute;n h&agrave;ng
                           v&agrave; người phụ tr&aacute;ch phải tổng hợp đầy đủ th&ocirc;ng tin rồi gửi l&ecirc;n
                           ph&ograve;ng phụ tr&aacute;ch kinh doanh của doanh nghiệp.</span></span></span></span>
               <o:p></o:p>
            </p>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">Những y&ecirc;u cầu đối với hệ th&ocirc;ng
                           tin:</span></span></span></span>
               <o:p></o:p>
            </p>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">- Tiếp nhận c&aacute;c đơn đặt h&agrave;ng, đặt cọc v&agrave; cho tất
                           cả c&aacute;c đơn đ&oacute; v&agrave; sổ lưu</span></span></span></span>
               <o:p></o:p>
            </p>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">- Tiếp nhận c&aacute;c h&oacute;a đơn b&aacute;n h&agrave;ng v&agrave;
                           lưu lại</span></span></span></span>
               <o:p></o:p>
            </p>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">- L&agrave;m phiếu bảo h&agrave;nh cho tất cả c&aacute;c mặt
                           h&agrave;ng v&agrave; lưu v&agrave;o sổ</span></span></span></span>
               <o:p></o:p>
            </p>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">- T&iacute;nh to&aacute;n tiền b&aacute;n h&agrave;ng, tiền
                           nợ</span></span></span></span>
               <o:p></o:p>
            </p>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">- Theo d&otilde;i t&igrave;nh trạng của h&agrave;ng h&oacute;a trong
                           kho</span></span></span></span>
               <o:p></o:p>
            </p>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">- In b&aacute;o c&aacute;o h&agrave;ng
                           ng&agrave;y</span></span></span></span>
               <o:p></o:p>
            </p>
            <h2 style="margin: 12pt 0in; " id="lam-the-nao-de-quan-ly-duoc-he-thong-ban-hang-chuoi"><span
                  style=""><span><span style="white-space:pre-wrap"><span style="color: black;">2. L&agrave;m thế
                           n&agrave;o để quản l&yacute; được hệ thống b&aacute;n h&agrave;ng
                           chuỗi</span></span></span></span>
               <o:p></o:p>
            </h2>
            <div style="text-align:center">
               <figure style="display:inline-block"><img alt="làm thế nào để quản lý được hệ thống bán hàng chuỗi"
                     height="444" class="lazyload" src="/images/load.gif"
                     data-src="https://storage.timviec365.vn/timviec365/pictures/images/lam-the-nao-de-quan-ly-duoc-he-thong-ban-hang-chuoi-2.jpg"
                     width="800" />
                  <figcaption>Quản l&yacute; hệ thống b&aacute;n h&agrave;ng chuỗi</figcaption>
               </figure>
            </div>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">Với những người kinh doanh bu&ocirc;n b&aacute;n th&igrave; việc quản
                           l&yacute; hệ thống b&aacute;n h&agrave;ng l&agrave; v&ocirc; c&ugrave;ng quan trọng. Với 1-2
                           cửa h&agrave;ng nhỏ th&igrave; quản l&yacute; sẽ rất đơn giải v&agrave; c&oacute; kết quả
                           t&agrave;i ch&iacute;nh tốt, nhưng với chuỗi cửa h&agrave;ng lớn, c&aacute;c doanh nghiệp lớn
                           sẽ phải l&agrave;m sao khi kh&ocirc;ng quản l&yacute; được hệ thống b&aacute;n h&agrave;ng
                           chuỗi. M&agrave; chỉ c&oacute; kinh doanh theo chuỗi th&igrave; mới c&oacute; hiệu quả kinh
                           tế cao, nếu kh&ocirc;ng tin bạn h&atilde;y thử nh&igrave;n v&agrave;o Big C,
                           metro...th&igrave; c&aacute;c bạn sẽ thấy chuỗi cửa h&agrave;ng của họ ph&aacute;t triển như
                           thế n&agrave;o. Với sự ph&aacute;t triển của doanh nghiệp, c&aacute;c chuỗi cửa h&agrave;ng
                           tăng l&ecirc;n rất nhiều vậy đ&acirc;y ch&iacute;nh l&agrave; b&agrave;i to&aacute;n đặt ra
                           cho người quản l&yacute;. L&agrave;m c&aacute;ch n&agrave;o để quản l&yacute; được hệ thống
                           b&aacute;n h&agrave;ng chuỗi thật tốt.</span></span></span></span>
               <o:p></o:p>
            </p>
            <h3 style="margin: 12pt 0in; " id="quan-ly-hang-hoa-nhap-khau-dieu-chuyen"><span style=""><span><span
                        style="white-space:pre-wrap"><span style="color: black;">2.1. Quản l&yacute; h&agrave;ng
                           h&oacute;a nhập khẩu, điều chuyển</span></span></span></span>
               <o:p></o:p>
            </h3>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">Người quản l&yacute; cần đồng bộ tất cả c&aacute;c quy tr&igrave;nh
                           giữa tất cả c&aacute;c chi nhanh. Số lượng nhập, số lượng xuất ra, tồn kho của từng chi
                           nh&aacute;nh phải được cập nhật thường xuy&ecirc;n. Những hoạt động đ&oacute; sẽ gi&uacute;p
                           cho nh&agrave; quản l&yacute; dễ d&agrave;ng hơn trong việc quản l&yacute; c&aacute;c cửa
                           h&agrave;ng.</span></span></span></span>
               <o:p></o:p>
            </p>
            <h3 style="margin: 12pt 0in; " id="so-sanh-hieu-quan-hoat-dong-giua-cac-chi-nhanh-voi-nhau"><span
                  style=""><span><span style="white-space:pre-wrap"><span style="color: black;">2.2. So s&aacute;nh hiệu
                           quản hoạt động giữa c&aacute;c chi nh&aacute;nh với nhau</span></span></span></span>
               <o:p></o:p>
            </h3>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">Người quản l&yacute; cần tổng hợp doanh số b&aacute;n h&agrave;ng cũng
                           như doanh thu của c&aacute;c chuỗi cửa h&agrave;ng. Từ đ&oacute; c&oacute; thể nhận định được
                           doanh thu h&agrave;ng ng&agrave;y v&agrave; xem x&eacute;t xem những nguy&ecirc;n nh&acirc;n
                           n&agrave;o dẫn đến doanh thu của một số cửa h&agrave;ng lại giảm s&uacute;t như vậy để
                           t&igrave;nh c&aacute;ch khắc phục.</span></span></span></span>
               <o:p></o:p>
            </p>
            <h3 style="margin: 12pt 0in; " id="phan-quyen-cho-nhan-vien-cap-duoi"><span style=""><span><span
                        style="white-space:pre-wrap"><span style="color: black;">2.3. Ph&acirc;n quyền cho nh&acirc;n
                           vi&ecirc;n cấp dưới</span></span></span></span>
               <o:p></o:p>
            </h3>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">Đ&acirc;y l&agrave; một loại h&igrave;nh thức quản l&yacute; phần
                           quyền. Dựa v&agrave;o sự ph&acirc;n quyền n&agrave;y th&igrave; những người được ph&acirc;n
                           quyền sẽ phải đảm nhiệm những nhiệm vụ của m&igrave;nh, thực hiện đ&uacute;ng nhiệm vụ. Với
                           h&igrave;nh thức n&agrave;y th&igrave; người cấp tr&ecirc;n c&oacute; thể dễ d&agrave;ng quản
                           l&yacute; hệ thống th&ocirc;ng qua b&aacute;o c&aacute;o của nh&acirc;n vi&ecirc;n cấp
                           dưới.</span></span></span></span>
               <o:p></o:p>
            </p>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">Đ&acirc;y l&agrave; h&igrave;nh thức m&agrave; bạn thường xuy&ecirc;n
                           thấy ở c&aacute;c cửa h&agrave;ng, sẽ c&oacute; <strong><a
                                 href="https://timviec365.vn/blog/cua-hang-truong-la-gi-new9807.html">cửa h&agrave;ng
                                 trưởng</a></strong>, quản l&yacute; v&agrave; <a
                              href="https://timviec365.vn/blog/nhan-vien-sales-la-gi-new3963.html">nh&acirc;n vi&ecirc;n
                              sales</a>. Đ&acirc;y cũng l&agrave; m&ocirc; h&igrave;nh m&agrave; được rất nhiều
                           nh&agrave; l&atilde;nh đạo &aacute;p dụng trong quản l&yacute; hệ thống b&aacute;n
                           h&agrave;ng.</span></span></span></span>
               <o:p></o:p>
            </p>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">Để quản l&yacute; chuỗi hệ thống cửa h&agrave;ng được tốt hơn
                           th&igrave; bạn h&atilde;y linh động trong việc quản l&yacute; v&agrave; kiểm so&aacute;t hệ
                           thống của m&igrave;nh.</span></span></span></span>
               <o:p></o:p>
            </p>
            <h2 style="margin: 12pt 0in; " id="cach-xay-dung-he-thong-quan-ly-ban-hang-online"><span
                  style=""><span><span style="white-space:pre-wrap"><span style="color: black;">3. C&aacute;ch x&acirc;y
                           dựng hệ thống quản l&yacute; b&aacute;n h&agrave;ng online</span></span></span></span>
               <o:p></o:p>
            </h2>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">Hiện nay với sự b&ugrave;ng nổ của mạng internet đ&atilde; gi&uacute;p
                           con người hội nhập rất nhiều, ch&iacute;nh v&igrave; thế m&agrave; ch&uacute;ng ta
                           kh&ocirc;ng thể phủ nhận được vai tr&ograve; của mạng internet. C&ugrave;ng với sự
                           b&ugrave;ng nổ của c&ocirc;ng nghệ th&ocirc;ng tin th&igrave; thị trường mua b&aacute;n
                           online đang dần b&atilde;o h&ograve;a khi con người kh&ocirc;ng chỉ biết đến mua h&agrave;ng
                           trực tiếp tại cửa h&agrave;ng m&agrave; c&ograve;n c&oacute; thể mua h&agrave;ng online. Nhu
                           cầu mua sắm online ph&aacute;t triển hơn, cũng ch&iacute;nh l&agrave; l&uacute;c m&agrave;
                           những người b&aacute;n h&agrave;ng cần đến hệ thống quản l&yacute; <a
                              href="https://timviec365.vn/blog/cach-ban-hang-online-hieu-qua-new3517.html"
                              target="_blank"><strong>b&aacute;n h&agrave;ng online</strong></a>. Vậy l&agrave;m thế
                           n&agrave;o để c&oacute; thể x&acirc;y dựng được hệ thống quản l&yacute; <a
                              href="https://timviec365.vn/blog/cach-ban-hang-online-new3633.html"><strong>c&aacute;ch
                                 b&aacute;n h&agrave;ng online</strong></a>, h&atilde;y c&ugrave;ng ch&uacute;ng
                           t&ocirc;i t&igrave;m hiểu nh&eacute;.</span></span></span></span>
               <o:p></o:p>
            </p>
            <div style="text-align:center">
               <figure style="display:inline-block"><img alt="cách xây dựng hệ thống quản lý bán hàng online"
                     height="500" class="lazyload" src="/images/load.gif"
                     data-src="https://storage.timviec365.vn/timviec365/pictures/images/cach-xay-dung-he-thong-quan-ly-ban-hang-online-3.jpg"
                     width="800" />
                  <figcaption>C&aacute;ch x&acirc;y dựng hệ thống quản l&yacute; b&aacute;n h&agrave;ng online
                  </figcaption>
               </figure>
            </div>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">- Hệ thống quản l&yacute; <a
                              href="https://timviec365.vn/blog/sale-online-la-gi-new3969.html"><strong>sale
                                 online</strong></a> gồm 4 bộ phận đ&oacute; ch&iacute;nh l&agrave; nhập h&agrave;ng,
                           b&aacute;n h&agrave;ng, b&aacute;o c&aacute;o thống k&ecirc;, quản l&yacute; người
                           d&ugrave;ng. 4 bộ phận n&agrave;y tuy c&oacute; những nhiệm vụ v&agrave; chức năng
                           kh&aacute;c nhau nhưng lại kết nối chặt chẽ với nhau để người quản l&yacute; hệ thống
                           b&aacute;n h&agrave;ng nắm bắt được t&igrave;nh h&igrave;nh. Khi x&acirc;y dựng hệ thống quản
                           l&yacute; b&aacute;n h&agrave;ng online th&igrave; kh&ocirc;ng thể để những bộ phận
                           n&agrave;y t&aacute;ch rời nhau ho&agrave;n to&agrave;n.</span></span></span></span>
               <o:p></o:p>
            </p>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">+ X&acirc;y dựng m&ocirc; h&igrave;nh ph&acirc;n cấp chức năng, việc
                           x&acirc;y dựng m&ocirc; h&igrave;nh n&agrave;y gi&uacute;p cho ch&uacute;ng ta x&aacute;c
                           định được phạm vi của hệ thống cần ph&acirc;n cấp. Đồng thời n&oacute; cũng l&agrave; phương
                           tiện để nh&agrave; thiết kế trao đổi với người sử dụng khi ph&aacute;t triển v&agrave;
                           nh&acirc;n rộng hệ thống.</span></span></span></span>
               <o:p></o:p>
            </p>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">+ Để x&acirc;y dựng được hệ thống n&agrave;y bạn cần phải sử dụng
                           phương ph&aacute;p top down để c&oacute; thể t&igrave;m kiếm được những chức năng chi tiết
                           được quy định trong hệ thống.</span></span></span></span>
               <o:p></o:p>
            </p>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">+ Sử dụng phương ph&aacute;p bottom up để gom nh&oacute;m c&aacute;c
                           chức năng</span></span></span></span>
               <o:p></o:p>
            </p>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">+ Thực hiện kết hợp giản lược h&oacute;a từ ngữ đến khi n&agrave;o thu
                           được chức năng của hệ thống quản l&yacute; b&aacute;n
                           h&agrave;ng.</span></span></span></span>
               <o:p></o:p>
            </p>
            <h2 style="margin: 12pt 0in; " id="nhung-ky-nang-quan-ly-ban-hang-giup-nguoi-quan-ly-thanh-cong"><span
                  style=""><span><span style="white-space:pre-wrap"><span style="color: black;">4. Những kỹ năng quản
                           l&yacute; b&aacute;n h&agrave;ng gi&uacute;p người quản l&yacute; th&agrave;nh
                           c&ocirc;ng</span></span></span></span>
               <o:p></o:p>
            </h2>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">Mặc d&ugrave; đ&atilde; c&oacute; hệ thống quản l&yacute; b&aacute;n
                           h&agrave;ng hỗ trợ đắc lực trong việc quản l&yacute;, thế nhưng người quản l&yacute;
                           b&aacute;n h&agrave;ng vẫn c&ograve;n cần phải c&oacute; những b&iacute; quyết trong quản
                           l&yacute; h&agrave;ng h&oacute;a để th&agrave;nh c&ocirc;ng trong c&ocirc;ng
                           việc.</span></span></span></span>
               <o:p></o:p>
            </p>
            <div style="text-align:center">
               <figure style="display:inline-block"><img alt="kỹ năng quản lý bán hàng giúp người quản lý thành công"
                     height="533" class="lazyload" src="/images/load.gif"
                     data-src="https://storage.timviec365.vn/timviec365/pictures/images/nhung-ky-nang-quan-ly-ban-hang-giup-nguoi-quan-ly-thanh-cong-4.jpg"
                     width="800" />
                  <figcaption>Kỹ năng quản l&yacute; b&aacute;n h&agrave;ng gi&uacute;p người quản l&yacute;
                     th&agrave;nh c&ocirc;ng</figcaption>
               </figure>
            </div>
            <h3 style="margin: 12pt 0in; " id="dao-tao-doi-ngu-nhan-vien"><span style=""><span><span
                        style="white-space:pre-wrap"><span style="color: black;">4.1. Đ&agrave;o tạo đội ngũ nh&acirc;n
                           vi&ecirc;n</span></span></span></span>
               <o:p></o:p>
            </h3>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">Việc đ&agrave;o tạo đội ngũ nh&acirc;n vi&ecirc;n am hiểu sản phẩm
                           l&agrave; v&ocirc; c&ugrave;ng quan trọng đối với những người quản l&yacute;. Kh&ocirc;ng
                           phải tất cả mọi người đều c&oacute; những kỹ năng b&aacute;n h&agrave;ng, ch&iacute;nh
                           v&igrave; thế m&agrave; h&atilde;y đ&agrave;o tạo họ th&agrave;nh những bản sao của
                           ch&iacute;nh bạn trong việc b&aacute;n h&agrave;ng. V&igrave; ai cũng biết rằng đ&acirc;y
                           l&agrave; đội ngũ đem lại doanh thu trực tiếp cho c&ocirc;ng ty.</span></span></span></span>
               <o:p></o:p>
            </p>
            <h3 style="margin: 12pt 0in; " id="su-dung-thanh-thao-phan-mem-quan-ly"><span style=""><span><span
                        style="white-space:pre-wrap"><span style="color: black;">4.2. Sử dụng th&agrave;nh thạo phần mềm
                           quản l&yacute;</span></span></span></span>
               <o:p></o:p>
            </h3>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">Người quản l&yacute; phải sử dụng th&agrave;nh thạo những phần mềm quản
                           l&yacute; để hỗ trợ m&igrave;nh trong c&ocirc;ng việc gi&aacute;m s&aacute;t cũng như chỉ đạo
                           <a
                              href="https://timviec365.vn/blog/cong-viec-sale-la-gi-nhung-vi-tri-trong-nganh-sales-new4041.html"><strong>c&ocirc;ng
                                 việc sale</strong></a>. Để c&oacute; thể sử dụng th&agrave;nh thạo th&igrave; y&ecirc;u
                           cầu về kĩ năng tin học l&agrave; rất quan trọng. Với phần mềm quản l&yacute; b&aacute;n
                           h&agrave;ng, th&igrave; n&oacute; sẽ hỗ trợ đắc lực cho họ trong c&ocirc;ng t&aacute;c quản
                           l&yacute;.</span></span></span></span>
               <o:p></o:p>
            </p>
            <h3 style="margin: 12pt 0in; " id="phan-quyen-cho-nhan-vien-cap-duoi"><span style=""><span><span
                        style="white-space:pre-wrap"><span style="color: black;">4.3. Ph&acirc;n quyền cho nh&acirc;n
                           vi&ecirc;n cấp dưới</span></span></span></span>
               <o:p></o:p>
            </h3>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">Đ&acirc;y l&agrave; một m&ocirc; h&igrave;nh quản l&yacute; m&agrave;
                           người l&atilde;nh đạo n&agrave;o cũng sẽ l&agrave;m khi thực hiện hoạt động quản l&yacute;
                           của m&igrave;nh. Việc ph&acirc;n quyền kh&ocirc;ng những để cho nh&acirc;n vi&ecirc;n cảm
                           thấy tầm quan trọng v&agrave; tr&aacute;ch nhiệm trong c&ocirc;ng việc m&agrave; c&ograve;n
                           để quản l&yacute; tốt hơn. V&igrave; thế ph&acirc;n quyền lu&ocirc;n được sử dụng trong
                           m&ocirc; h&igrave;nh quản l&yacute;.</span></span></span></span>
               <o:p></o:p>
            </p>
            <p style="margin: 12pt 0in; "><span style=""><span><span style="white-space:pre-wrap"><span
                           style="color: black;">Qua b&agrave;i viết tr&ecirc;n đ&acirc;y, c&aacute;c bạn đ&atilde; hiểu
                           thế n&agrave;o l&agrave; m&ocirc; tả hệ thống quản l&yacute; b&aacute;n h&agrave;ng chưa?
                           Việc quản l&yacute; b&aacute;n h&agrave;ng rất quan trọng trong c&aacute;c doanh nghiệp
                           ch&iacute;nh v&igrave; thế m&agrave; quản l&yacute; b&aacute;n h&agrave;ng trở th&agrave;nh
                           nghệ thuật trong quản l&yacute;.</span></span></span></span>
               <o:p></o:p>
            </p>
            <div class="banner_gif" style="width: 100%;float: left;margin-top: 20px;float: left;display: block;">
               <a target="blank" href="https://timviec365.vn/">
                  <img style="width: 100%;height: 100%" class=" lazyloaded" src="../images/banner_cv_bv.gif"
                     data-src="../images/banner_cv_bv.gif" alt="Tìm việc làm nhanh">
               </a>
            </div>
            <div class="gachj"></div>
            <div class="box-social_2">
               <div class="chia_se">
                  <p>Chia sẻ:</p>
               </div>
               <div class="box-social" id="box-social"></div>
            </div>
         </div>
         <div class="content_cmt_vote" data-uid="0" data-type="0">
            <link rel="stylesheet" href="/css/style_cm.css?v=396">
            <div id="box_comment_chat" class="btn_login_do">

               <div style="clear: both;"></div>
               <div class="box_link_comment">
                  <div class="box_cm_head">
                     <span class="text_cm_hed">Bình luận</span>
                  </div>
                  <div class="box_cm_body">
                     <div class="cm_like">
                        <div class="frame_cm_like">
                           <div class="box_items_like_ic">
                              <span class="cm_like_ic">
                                 <img class="item_like_ic   ic1" src="/images/img_comment/Ic_1.png" alt="Thích">
                              </span>
                              <span class="cm_like_ic">
                                 <img class="item_like_ic   ic2" src="/images/img_comment/Ic_2.png" alt="Yêu thích">
                              </span>
                              <span class="cm_like_ic">
                                 <img class="item_like_ic   ic3" src="/images/img_comment/Ic_3.png" alt="Wow">
                              </span>
                              <span class="cm_like_ic">
                                 <img class="item_like_ic   ic4" src="/images/img_comment/Ic_4.png" alt="Thương thương">
                              </span>
                              <span class="cm_like_ic">
                                 <img class="item_like_ic   ic5" src="/images/img_comment/Ic_5.png" alt="Phẫn nộ">
                              </span>
                              <span class="cm_like_ic">
                                 <img class="item_like_ic   ic6" src="/images/img_comment/Ic_6.png" alt="Buồn">
                              </span>
                              <span class="cm_like_ic">
                                 <img class="item_like_ic   ic7" src="/images/img_comment/Ic_7.png" alt="Ha ha">
                              </span>
                           </div>
                           <span class="count_ic" data-like="0">
                           </span>
                        </div>
                        <span class="cm_sh_ic"><b>&#149;</b> 0 chia sẻ </span>
                        <span class="cm_cm_ic"><b>&#149;</b> <span>0</span> bình luận </span>
                        <span class="cm_view_ic ">3372 lượt xem</span>

                        <div class="box_sh_ic">
                           <div class="frame">
                              <p class="sh_title">Chia sẻ</p>
                           </div>
                        </div>
                        <div class="box_cm_ic">
                           <div class="frame">
                              <p class="cm_title">Bình luận</p>

                           </div>
                        </div>
                     </div>
                     <div class="cm_event">
                        <div class="cm_ev_div">
                           <span class="like_event " onclick="like_url(0,'like_event','frame_cm_like')"
                              onmousemove="show_ic(this,'cm_ev_div')" ontaphold="show_ic(this,'cm_list_ev')">
                              <img class="like_event_img" src="/images/img_comment/Ic_color_2.png" alt="Icon">
                              <span class="like_event_txt ">Thích</span>
                           </span>
                           <div class="show_ic" onmousemove="show_ic(this,'cm_ev_div')"
                              onmouseleave="hide_ic(this,'cm_ev_div')">
                              <span class="cm_like_ic" data="1" onclick="like_url(1,'like_event','frame_cm_like')">
                                 <img src="/images/img_comment/Ic_1.png" alt="icon1">
                              </span>
                              <span class="cm_like_ic" data="2" onclick="like_url(2,'like_event','frame_cm_like')">
                                 <img src="/images/img_comment/Ic_2.png" alt="icon2">
                              </span>
                              <span class="cm_like_ic" data="3" onclick="like_url(3,'like_event','frame_cm_like')">
                                 <img src="/images/img_comment/Ic_3.png" alt="icon3">
                              </span>
                              <span class="cm_like_ic" data="4" onclick="like_url(4,'like_event','frame_cm_like')">
                                 <img src="/images/img_comment/Ic_4.png" alt="icon4">
                              </span>
                              <span class="cm_like_ic" data="5" onclick="like_url(5,'like_event','frame_cm_like')">
                                 <img src="/images/img_comment/Ic_5.png" alt="icon5">
                              </span>
                              <span class="cm_like_ic" data="6" onclick="like_url(6,'like_event','frame_cm_like')">
                                 <img src="/images/img_comment/Ic_6.png" alt="icon6">
                              </span>
                              <span class="cm_like_ic" data="7" onclick="like_url(7,'like_event','frame_cm_like')">
                                 <img src="/images/img_comment/Ic_7.png" alt="icon7">
                              </span>
                           </div>
                        </div>
                        <div class="cm_ev_div">
                           <span class="comment_event">
                              <svg width="21" height="20" viewBox="0 0 21 20" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                 <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M0.5 9.33214C0.5 4.1332 4.99145 0 10.4314 0C15.8682 0 20.3627 4.13306 20.3627 9.33214C20.3627 14.5311 15.8713 18.6643 10.4314 18.6643C9.55178 18.6643 8.6952 18.5573 7.87958 18.3536L5.09363 19.8999C4.56865 20.1913 3.92375 19.8117 3.92375 19.2112V16.3821C1.83534 14.6788 0.5 12.1588 0.5 9.33214ZM10.4314 1.43206C5.6902 1.43206 1.93206 5.01322 1.93206 9.33214C1.93206 11.7956 3.1452 14.0062 5.07169 15.4631L5.35582 15.678V18.1165L7.69446 16.8185L7.97815 16.8983C8.75226 17.116 9.57712 17.2322 10.4314 17.2322C15.1725 17.2322 18.9307 13.6511 18.9307 9.33214C18.9307 5.01336 15.1698 1.43206 10.4314 1.43206Z"
                                    fill="#474747" />
                              </svg>
                              Bình luận
                           </span>
                        </div>
                        <div class="cm_ev_div">
                           <span class="share_event" onclick="add_show('box_share')">
                              <svg width="19" height="18" viewBox="0 0 19 18" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                 <path
                                    d="M12.9956 12.4056L18.392 7.09795L18.4604 7.01995C18.5617 6.88399 18.6105 6.71606 18.5979 6.54699C18.5854 6.37792 18.5123 6.21906 18.392 6.09955L12.9956 0.794353L12.9212 0.730753C12.4892 0.406753 11.8532 0.718753 11.8532 1.29355V3.84955L11.5832 3.86755C7.30761 4.20595 4.80321 6.91195 4.20561 11.82C4.12881 12.45 4.85121 12.8448 5.31921 12.4272C7.03641 10.8936 8.81121 9.94075 10.6532 9.55915C10.9484 9.49795 11.2448 9.45115 11.5436 9.41875L11.8532 9.39115V11.9064L11.8592 12.0048C11.9312 12.5484 12.59 12.804 12.9956 12.4056ZM11.6708 5.06395L13.0532 4.97155V2.53195L17.1884 6.59755L13.0532 10.6656V8.07715L11.426 8.22355H11.4164C9.37281 8.44315 7.44441 9.26155 5.62401 10.626C5.98161 9.01915 6.59241 7.81075 7.39521 6.94555C8.39121 5.87155 9.78321 5.21395 11.6708 5.06275V5.06395ZM3.59961 1.79995C2.80396 1.79995 2.0409 2.11602 1.47829 2.67863C0.91568 3.24124 0.599609 4.0043 0.599609 4.79995V14.4C0.599609 15.1956 0.91568 15.9587 1.47829 16.5213C2.0409 17.0839 2.80396 17.4 3.59961 17.4H13.1996C13.9953 17.4 14.7583 17.0839 15.3209 16.5213C15.8835 15.9587 16.1996 15.1956 16.1996 14.4V13.2C16.1996 13.0408 16.1364 12.8882 16.0239 12.7757C15.9114 12.6632 15.7587 12.6 15.5996 12.6C15.4405 12.6 15.2879 12.6632 15.1753 12.7757C15.0628 12.8882 14.9996 13.0408 14.9996 13.2V14.4C14.9996 14.8773 14.81 15.3352 14.4724 15.6727C14.1348 16.0103 13.677 16.2 13.1996 16.2H3.59961C3.12222 16.2 2.66438 16.0103 2.32682 15.6727C1.98925 15.3352 1.79961 14.8773 1.79961 14.4V4.79995C1.79961 4.32256 1.98925 3.86473 2.32682 3.52716C2.66438 3.18959 3.12222 2.99995 3.59961 2.99995H7.19961C7.35874 2.99995 7.51135 2.93674 7.62387 2.82422C7.7364 2.71169 7.79961 2.55908 7.79961 2.39995C7.79961 2.24082 7.7364 2.08821 7.62387 1.97569C7.51135 1.86317 7.35874 1.79995 7.19961 1.79995H3.59961Z"
                                    fill="black" />
                              </svg>
                              Chia sẻ
                           </span>
                           <div class="box_share">
                              <div class="box_share_items" style="display: none!important;">
                                 <img src="/images/img_comment/sh_ic1.png" alt="Chia sẻ trang cá nhân của bạn">
                                 Chia sẻ lên trang cá nhân (Của bạn)
                              </div>
                              <div class="box_share_items" style="display: none!important;">
                                 <img src="/images/img_comment/sh_ic2.png" alt="Chia sẻ trang cá nhân bạn bè">
                                 Chia sẻ lên trang cá nhân (Bạn bè)
                              </div>
                              <div class="box_share_items share_items_chat365 ">
                                 <img src="/images/img_comment/sh_ic3.png" alt="Gửi bằng Chat365">
                                 Gửi bằng Chat365
                              </div>
                              <div class="box_share_items share_group_chat365">
                                 <img src="/images/img_comment/sh_ic4.png" alt="Gửi lên nhóm Chat365">
                                 Gửi lên nhóm Chat365
                              </div>
                              <div class="box_share_items share_items_mxh" onclick="add_show('box_share_mxh')">
                                 <img src="/images/img_comment/sh_ic5.png" alt="Khác">
                                 Khác
                              </div>
                           </div>
                           <div class="box_share_mxh">
                              <div class="box_share_items"
                                 onclick="share_fb('https://timviec365.vn/blog/mo-ta-he-thong-quan-ly-ban-hang-new5591.html');return false;">
                                 <img src="/images/img_comment/iic_f.png" alt="Facebook">
                                 Facebook
                              </div>
                              <div class="box_share_items"
                                 onclick="share_tw('https://timviec365.vn/blog/mo-ta-he-thong-quan-ly-ban-hang-new5591.html');return false;">
                                 <img src="/images/img_comment/iic_t.png" alt="Twitter">
                                 Twitter
                              </div>
                              <div class="box_share_items"
                                 onclick="share_vk('https://timviec365.vn/blog/mo-ta-he-thong-quan-ly-ban-hang-new5591.html');return false;">
                                 <img src="/images/img_comment/iic_v.png" alt="Vkontakte">
                                 Vkontakte
                              </div>
                              <div class="box_share_items"
                                 onclick="share_in('https://timviec365.vn/blog/mo-ta-he-thong-quan-ly-ban-hang-new5591.html');return false;">
                                 <img src="/images/img_comment/iic_l.png" alt="Linked In">
                                 Linked In
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="order_cm">
                        <div class="cm_input input_comment">
                           <img class="img_user" src="https://timviec365.vn/images/user_no.png" alt="bình luận">
                           <textarea class="ct_cm" id="ct_cm" oninput="check_data(this)" maxlength="250"
                              placeholder="Viết bình luận" readonly></textarea>
                           <svg class="ic_send_cm" width="32" height="32" viewBox="0 0 32 32" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <rect width="32" height="32" rx="16" fill="#4C5BD4" />
                              <path
                                 d="M24.7922 8.21841C24.6908 8.11767 24.5628 8.04793 24.4231 8.01737C24.2835 7.98681 24.138 7.99672 24.0037 8.04592L7.48458 14.0456C7.34211 14.0996 7.21946 14.1956 7.13291 14.3208C7.04635 14.4461 7 14.5946 7 14.7468C7 14.899 7.04635 15.0476 7.13291 15.1728C7.21946 15.2981 7.34211 15.3941 7.48458 15.448L13.9346 18.0204L18.6951 13.2507L19.7538 14.3081L14.9708 19.0854L17.5538 25.5275C17.6094 25.6671 17.7057 25.7867 17.8302 25.8709C17.9547 25.9552 18.1017 26.0001 18.2521 26C18.4038 25.9969 18.551 25.9479 18.6744 25.8596C18.7977 25.7712 18.8913 25.6476 18.9429 25.505L24.9498 9.00587C25.001 8.87319 25.0133 8.72871 24.9854 8.58929C24.9575 8.44987 24.8905 8.32124 24.7922 8.21841Z"
                                 fill="white" />
                           </svg>
                           <svg class="cm_img_ct" id="cm_img_ct" width="24" height="24" viewBox="0 0 24 24" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <path
                                 d="M6.76017 22H17.2402C20.0002 22 21.1002 20.31 21.2302 18.25L21.7502 9.99C21.8902 7.83 20.1702 6 18.0002 6C17.3902 6 16.8302 5.65 16.5502 5.11L15.8302 3.66C15.3702 2.75 14.1702 2 13.1502 2H10.8602C9.83017 2 8.63017 2.75 8.17017 3.66L7.45017 5.11C7.17017 5.65 6.61017 6 6.00017 6C3.83017 6 2.11017 7.83 2.25017 9.99L2.77017 18.25C2.89017 20.31 4.00017 22 6.76017 22Z"
                                 stroke="#999999" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                              <path d="M10.5 8H13.5" stroke="#999999" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round" />
                              <path
                                 d="M12 18C13.79 18 15.25 16.54 15.25 14.75C15.25 12.96 13.79 11.5 12 11.5C10.21 11.5 8.75 12.96 8.75 14.75C8.75 16.54 10.21 18 12 18Z"
                                 stroke="#999999" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                           </svg>
                           <input style="display: none;" id="secleimg" name="listimg"
                              onchange="preview_image(event, this);" class="fileupload" type="file">
                           <div id="tag_friend"></div>
                        </div>
                     </div>
                     <div class="cm_list" data="2" data-count="0">
                        <div class="box_cm_list">
                        </div>
                     </div>
                  </div>
               </div>

               <div class="popup_comment" id="popup_items_sh">
                  <div class="popup_items_sh">
                     <div class="box_header">
                        <div class="title">Những người đã chia sẻ tin này</div>
                        <img src="/images/img_comment/close.png" alt="close" class="close_cm">
                     </div>
                     <div class="frame_items">
                     </div>
                  </div>
               </div>

               <div class="popup_comment" id="popup_items_icon">
                  <div class="popup_items_icon">
                     <div class="box_header">
                        <div class="title">
                           <span class="items_ic all active" onclick="show_icon(this,0)">Tất cả</span>
                           <span class="items_ic icon ic1" onclick="show_icon(this,1)"><img
                                 src="/images/img_comment/Ic_1.png" alt="Icon">0</span>
                           <span class="items_ic icon ic2" onclick="show_icon(this,2)"><img
                                 src="/images/img_comment/Ic_2.png" alt="Icon">0</span>
                           <span class="items_ic icon ic3" onclick="show_icon(this,3)"><img
                                 src="/images/img_comment/Ic_3.png" alt="Icon">0</span>
                           <span class="items_ic icon ic4" onclick="show_icon(this,4)"><img
                                 src="/images/img_comment/Ic_4.png" alt="Icon">0</span>
                           <span class="items_ic icon ic5" onclick="show_icon(this,5)"><img
                                 src="/images/img_comment/Ic_5.png" alt="Icon">0</span>
                           <span class="more" onclick="add_show('more_icon')">Xem thêm <img
                                 src="/images/img_comment/ic_down.png" alt="Xem thêm"></span>
                           <div class="more_icon">
                              <div class="title">Xem thêm</div>
                              <div class="items_ic icon ic4" onclick="show_icon(this,4)"><img
                                    src="/images/img_comment/Ic_4.png" alt="Icon">0</div>
                              <div class="items_ic icon ic5" onclick="show_icon(this,5)"><img
                                    src="/images/img_comment/Ic_5.png" alt="Icon">0</div>
                              <div class="items_ic icon ic6" onclick="show_icon(this,6)"><img
                                    src="/images/img_comment/Ic_6.png" alt="Icon">0</div>
                              <div class="items_ic icon ic7" onclick="show_icon(this,7)"><img
                                    src="/images/img_comment/Ic_7.png" alt="Icon">0</div>
                           </div>
                        </div>
                     </div>
                     <div class="box_icon icon_show_0 show">
                        <div class="frame_items">
                        </div>
                     </div>
                     <div class="box_icon icon_show_1 ">
                        <div class="frame_items">
                        </div>
                     </div>
                     <div class="box_icon icon_show_2 ">
                        <div class="frame_items">
                        </div>
                     </div>
                     <div class="box_icon icon_show_3 ">
                        <div class="frame_items">
                        </div>
                     </div>
                     <div class="box_icon icon_show_4 ">
                        <div class="frame_items">
                        </div>
                     </div>
                     <div class="box_icon icon_show_5 ">
                        <div class="frame_items">
                        </div>
                     </div>
                     <div class="box_icon icon_show_6 ">
                        <div class="frame_items">
                        </div>
                     </div>
                     <div class="box_icon icon_show_7 ">
                        <div class="frame_items">
                        </div>
                     </div>

                  </div>
               </div>

               <div class="popup_comment" id="popup_share_chat365">
                  <div class="popup_share_chat365">
                     <div class="box_header">
                        <div class="title">Gửi bằng chat365</div>
                        <img src="/images/img_comment/close.png" alt="close" class="close_cm">
                     </div>
                     <div class="box_header cm_input">
                        <img class="img_user" src="https://timviec365.vn/images/user_no.png" alt="Logo">
                        <textarea class="ct_cm" maxlength="100" id="nd_share"
                           placeholder="Hãy nói gì đó về nội dung này"></textarea>
                     </div>
                     <div class="frame_items" id="list_friend_chat">
                        <div class="items">
                           <p>Bạn chưa có bạn bè để chia sẻ</p>
                        </div>
                     </div>
                  </div>
               </div>


               <div class="popup_comment" id="popup_share_gr">
                  <div class="popup_share_chat365">
                     <div class="box_header">
                        <div class="title">Gửi cho nhóm tại chat365</div>
                        <img src="/images/img_comment/close.png" alt="close" class="close_cm">
                     </div>
                     <div class="box_header cm_input">
                        <img class="img_user" src="https://timviec365.vn/images/user_no.png" alt="Logo">
                        <textarea class="ct_cm" maxlength="100" id="nd_gr_share"
                           placeholder="Hãy nói gì đó về nội dung này"></textarea>
                     </div>
                     <div class="frame_items">
                        <div class="items">
                           <p>Bạn chưa có nhóm để chia sẻ</p>
                        </div>
                     </div>
                  </div>
               </div>
            </div>


            <script type="text/javascript">
            const url_cm = 'https://timviec365.vn/blog/mo-ta-he-thong-quan-ly-ban-hang-new5591.html';
            // id người xem
            const uid_view = '0';
            // avatar người xem
            const uid_ava = '';
            // tên người xem
            const uid_name = '';

            // id người tạo
            const uid_author = 56387;
            // const uid_author = 20;

            var hastag_cm = [];

            if (uid_ava != '' && uid_view > 0) {
               $('.img_user').attr('src', uid_ava);
               $(".img_user").on('error', function() {
                  $(this).attr('src', 'https://timviec365.vn/images/user_no.png');
               })
            }
            </script>
            <script src="/js/socket_cm.js?v=396"></script>

            <script>
            $('.btn_login_do').click(function() {
               if (document.cookie.indexOf('id_chat365=') == -1) {
                  $('.ct_cm').blur();
                  window.open('/dang-nhap.html', '_blank').focus();
               } else {
                  window.location.reload();
               }
            })
            </script>
         </div>
         <div class="content-detail" style="margin-top: 30px;float: left;width: 100%;">
            <div class="box_xt">
               <p class="bvlq">Bài viết liên quan</p>
               <div class="box_xt_item see_more_blog">
                  <div class="bvxt">
                     <a href="/blog/thang-du-von-la-gi-new16477.html" class="img-warpper cover">
                        <img class="lazyload" src="/images/load.gif"
                           data-src="https://storage.timviec365.vn/timviec365/pictures/news/2022/08/22/tou1661140039.jpeg"
                           alt="Thặng dư vốn là gì? Cách tính thặng dư cho doanh nghiệp">
                     </a>
                     <h3 class="title"><a href="/blog/thang-du-von-la-gi-new16477.html">Thặng dư vốn là gì? Cách tính
                           thặng dư cho doanh nghiệp</a></h3>
                  </div>
                  <div class="bvxt">
                     <a href="/blog/sai-lam-khi-kinh-doanh-tren-facebook-new14723.html" class="img-warpper cover">
                        <img class="lazyload" src="/images/load.gif"
                           data-src="https://storage.timviec365.vn/timviec365/pictures/news/2021/06/26/kvj1624711245.jpg"
                           alt="Những sai lầm khi kinh doanh trên Facebook cần tránh, bạn đã biết?">
                     </a>
                     <h3 class="title"><a href="/blog/sai-lam-khi-kinh-doanh-tren-facebook-new14723.html">Những sai lầm
                           khi kinh doanh trên Facebook cần tránh, bạn đã biết?</a></h3>
                  </div>
                  <div class="bvxt">
                     <a href="/blog/sale-off-la-gi-new14704.html" class="img-warpper cover">
                        <img class="lazyload" src="/images/load.gif"
                           data-src="https://storage.timviec365.vn/timviec365/pictures/news/2021/06/25/gvr1624595276.jpg"
                           alt="Sale off là gì? Phân biệt giữa khái niệm sale off và sale up to">
                     </a>
                     <h3 class="title"><a href="/blog/sale-off-la-gi-new14704.html">Sale off là gì? Phân biệt giữa khái
                           niệm sale off và sale up to</a></h3>
                  </div>
                  <div class="bvxt">
                     <a href="/blog/chien-luoc-ban-hang-la-gi-new14585.html" class="img-warpper cover">
                        <img class="lazyload" src="/images/load.gif"
                           data-src="https://storage.timviec365.vn/timviec365/pictures/news/2021/06/08/nxh1623120267.jpg"
                           alt="Bật mí xây dựng chiến lược bán hàng hiệu quả cho người kinh doanh">
                     </a>
                     <h3 class="title"><a href="/blog/chien-luoc-ban-hang-la-gi-new14585.html">Bật mí xây dựng chiến
                           lược bán hàng hiệu quả cho người kinh doanh</a></h3>
                  </div>
               </div>
               <div class="box_see_2"><a id="see_more"
                     href="/blog/c121/chia-se-kinh-nghiem-nganh-kinh-doanh-ban-hang">Xem thêm </a></div>
            </div>
            <div class="box_tag">
               <p class="tklq">Từ khóa liên quan</p>
            </div>
            <div class="chude hiden_dtblog">
               <a href="/bieu-mau/bien-ban-ban-giao-cong-viec-moi-nhat-2018-tl19.html">biên bản bàn
                  giao</a><span>-</span>
               <a href="/bieu-mau/bien-ban-ban-giao-cong-viec-moi-nhat-2018-tl19.html">maẫu biên bản bàn
                  giao</a><span>-</span>
               <a href="/bieu-mau/bien-ban-ban-giao-cong-viec-moi-nhat-2018-tl19.html">mau bien ban ban
                  giao</a><span>-</span>
               <a href="/blog/bien-ban-ban-giao-hang-hoa-new3941.html">biên bản bàn giao hàng hóa</a><span>-</span>
               <a href="/bieu-mau/bien-ban-ban-giao-cong-cu-tai-san-moi-va-day-du-nhat-tl20.html">biên bản bàn giao tài
                  sản</a><span>-</span>
               <a href="/bieu-mau/bien-ban-ban-giao-cong-cu-tai-san-moi-va-day-du-nhat-tl20.html">biên bản bàn giao giấy
                  tờ</a><span>-</span>
               <a href="/blog/ky-nang-ban-hang-la-gi-new5357.html">kỹ năng bán hàng cơ bản</a><span>-</span>
               <a href="/blog/kich-ban-goi-dien-thoai-cho-khach-hang-new5547.html">kịch bản bán hàng qua điện
                  thoại</a><span>-</span>
               <a href="/bieu-mau/bien-ban-ban-giao-cong-viec-moi-nhat-2018-tl19.html">mẫu biên bản bàn giao công
                  việc</a><span>-</span>
               <a href="/bieu-mau/bien-ban-ban-giao-cong-cu-tai-san-moi-va-day-du-nhat-tl20.html">xin mẫu biên bản bàn
                  giao tiền</a><span>-</span>
               <a href="/bieu-mau/tong-hop-cac-mau-bien-ban-cuoc-hop-chuan-nhat-2018-tl213.html">mẫu biên bản cuộc họp
                  giao ban</a><span>-</span>
               <a href="/blog/bien-ban-ban-giao-hang-hoa-new3941.html">mẫu biên bản bàn giao hàng hóa</a><span>-</span>
               <span class="show_cd"><img src="/images/icons_more.png" alt="Xem thêm gợi ý"></span>
               <span class="hiden_cd"><img src="/images/icons_hiden.png" alt="Xem thêm gợi ý"></span>
            </div>
            <div class="box_tag">
               <p class="tklq">Chuyên mục</p>
            </div>
            <div class="ct_cm hiden_dtblog">
               <a href="/blog/c24/bi-quyet-viet-cv">Bí quyết viết CV</a><span>-</span>
               <a href="/blog/c25/chia-se-kinh-nghiem-tam-su-nghe-nghiep">Tâm sự Nghề nghiệp</a><span>-</span>
               <a href="/blog/c22/cam-nang-tim-viec">Cẩm Nang Tìm Việc</a><span>-</span>
               <a href="/blog/c23/ky-nang-tuyen-dung">Kỹ Năng Tuyển Dụng</a><span>-</span>
               <a href="/blog/c29/cam-nang-khoi-nghiep">Cẩm nang khởi nghiệp</a><span>-</span>
               <a href="/blog/c35/kinh-nghiem-ung-tuyen-viec-lam">Kinh nghiệm ứng tuyển việc làm</a><span>-</span>
               <a href="/blog/c55/ky-nang-ung-xu-van-phong">Kỹ năng ứng xử văn phòng</a><span>-</span>
               <a href="/blog/c65/quyen-loi-nguoi-lao-dong">Quyền lợi người lao động</a><span>-</span>
               <a href="/blog/c27/bi-quyet-dao-tao-nhan-luc">Bí quyết đào tạo nhân lực</a><span>-</span>
               <a href="/blog/c31/bi-quyet-lanh-dao">Bí quyết lãnh đạo</a><span>-</span>
               <a href="/blog/c33/bi-quyet-lam-viec-hieu-qua">Bí quyết làm việc hiệu quả</a><span>-</span>
               <a href="/blog/c37/bi-quyet-viet-don-xin-nghi-phep">Bí quyết viết đơn xin nghỉ phép</a><span>-</span>
               <a href="/blog/c39/bi-quyet-viet-thu-xin-thoi-viec">Bí quyết viết thư xin thôi việc</a><span>-</span>
               <a href="/blog/c41/cach-viet-don-xin-viec">Cách viết đơn xin việc</a><span>-</span>
               <a href="/blog/c43/bi-quyet-thanh-cong-trong-cong-viec">Bí quyết thành công trong công
                  việc</a><span>-</span>
               <a href="/blog/c45/bi-quyet-tang-luong">Bí quyết tăng lương</a><span>-</span>
               <a href="/blog/c47/bi-quyet-tim-viec-danh-cho-sinh-vien">Bí quyết tìm việc dành cho sinh
                  viên</a><span>-</span>
               <a href="/blog/c49/ky-nang-dam-phan-luong">Kỹ năng đàm phán lương</a><span>-</span>
               <a href="/blog/c51/ky-nang-phong-van">Kỹ năng phỏng vấn</a><span>-</span>
               <a href="/blog/c53/ky-nang-quan-tri-doanh-nghiep">Kỹ năng quản trị doanh nghiệp</a><span>-</span>
               <a href="/blog/c123/kinh-nghiem-tim-viec-lam-tai-ha-noi">Kinh nghiệm tìm việc làm tại Hà
                  Nội</a><span>-</span>
               <a href="/blog/c125/kinh-nghiem-tim-viec-lam-tai-da-nang">Kinh nghiệm tìm việc làm tại Đà
                  Nẵng</a><span>-</span>
               <a href="/blog/c61/meo-viet-ho-so-xin-viec">Mẹo viết hồ sơ xin việc</a><span>-</span>
               <a href="/blog/c63/meo-viet-thu-xin-viec">Mẹo viết thư xin việc</a><span>-</span>
               <a href="/blog/c121/chia-se-kinh-nghiem-nganh-kinh-doanh-ban-hang">Chia sẻ kinh nghiệm ngành Kinh doanh -
                  Bán hàng</a><span>-</span>
               <a href="/blog/c69/dinh-huong-nghe-nghiep">Định hướng nghề nghiệp</a><span>-</span>
               <a href="/blog/c71/top-viec-lam-hap-dan">Top việc làm hấp dẫn</a><span>-</span>
               <a href="/blog/c73/tu-van-nghe-nghiep-lao-dong-pho-thong">Tư vấn nghề nghiệp lao động phổ
                  thông</a><span>-</span>
               <a href="/blog/c75/tu-van-viec-lam-hanh-chinh-van-phong">Tư vấn việc làm Hành chính văn
                  phòng</a><span>-</span>
               <a href="/blog/c77/tu-van-viec-lam-nganh-bao-chi">Tư vấn việc làm ngành Báo chí</a><span>-</span>
               <a href="/blog/c79/tu-van-tim-viec-lam-them">Tư vấn tìm việc làm thêm</a><span>-</span>
               <a href="/blog/c81/tu-van-viec-lam-nganh-bat-dong-san">Tư vấn việc làm ngành Bất động
                  sản</a><span>-</span>
               <a href="/blog/c83/tu-van-viec-lam-nganh-cong-nghe-thong-tin">Tư vấn việc làm ngành Công nghệ thông
                  tin</a><span>-</span>
               <a href="/blog/c85/tu-van-viec-lam-nganh-du-lich">Tư vấn việc làm ngành Du lịch</a><span>-</span>
               <a href="/blog/c87/tu-van-viec-lam-nganh-ke-toan">Tư vấn việc làm ngành Kế toán</a><span>-</span>
               <a href="/blog/c89/tu-van-viec-lam-nganh-ky-thuat">Tư vấn việc làm ngành Kỹ thuật</a><span>-</span>
               <a href="/blog/c91/tu-van-viec-lam-nganh-su-pham">Tư vấn việc làm ngành Sư phạm</a><span>-</span>
               <a href="/blog/c93/tu-van-viec-lam-nganh-luat">Tư vấn việc làm ngành Luật</a><span>-</span>
               <a href="/blog/c95/tu-van-viec-lam-tham-dinh">Tư vấn việc làm thẩm định</a><span>-</span>
               <a href="/blog/c97/tu-van-viec-lam-vi-tri-content">Tư vấn việc làm vị trí Content</a><span>-</span>
               <a href="/blog/c99/tu-van-viec-lam-nganh-nha-hang-khach-san">Tư vấn việc làm ngành Nhà hàng - Khách
                  sạn</a><span>-</span>
               <a href="/blog/c101/tu-van-viec-lam-quan-ly">Tư vấn việc làm quản lý</a><span>-</span>
               <a href="/blog/c223/ky-nang-van-phong">Kỹ năng văn phòng</a><span>-</span>
               <a href="/blog/c225/nghe-truyen-thong">Nghề truyền thống</a><span>-</span>
               <a href="/blog/c105/cac-van-de-ve-luong">Các vấn đề về lương</a><span>-</span>
               <a href="/blog/c107/tu-van-tim-viec-lam-thoi-vu">Tư vấn tìm việc làm thời vụ</a><span>-</span>
               <a href="/blog/c109/cach-viet-so-yeu-ly-lich">Cách viết Sơ yếu lý lịch</a><span>-</span>
               <a href="/blog/c111/cach-gui-ho-so-xin-viec">Cách gửi hồ sơ xin việc</a><span>-</span>
               <a href="/blog/c113/bieu-mau">Biểu mẫu phục vụ công việc</a><span>-</span>
               <a href="/blog/c115/tin-tuc-tong-hop">Tin tức tổng hợp</a><span>-</span>
               <a href="/blog/c117/y-tuong-kinh-doanh">Ý tưởng kinh doanh</a><span>-</span>
               <a href="/blog/c119/chia-se-kinh-nghiem-nganh-marketing">Chia sẻ kinh nghiệm ngành
                  Marketing</a><span>-</span>
               <a href="/blog/c127/kinh-nghiem-tim-viec-lam-tai-binh-duong">Kinh nghiệm tìm việc làm tại Bình
                  Dương</a><span>-</span>
               <a href="/blog/c129/kinh-nghiem-tim-viec-lam-tai-ho-chi-minh">Kinh nghiệm tìm việc làm tại Hồ Chí
                  Minh</a><span>-</span>
               <a href="/blog/c131/meo-viet-thu-cam-on">Mẹo viết Thư cảm ơn</a><span>-</span>
               <a href="/blog/c133/cau-chuyen-van-phong">Góc Công Sở</a><span>-</span>
               <a href="/blog/c135/cau-chuyen-nghe-nghiep">Câu chuyện nghề nghiệp</a><span>-</span>
               <a href="/blog/c137/hoat-dong-doan-the">Hoạt động đoàn thể</a><span>-</span>
               <a href="/blog/c139/tu-van-viec-lam-bien-phien-dich">Tư vấn việc làm Biên - Phiên dịch</a><span>-</span>
               <a href="/blog/c141/tu-van-viec-lam-nganh-nhan-su">Tư vấn việc làm Ngành Nhân Sự</a><span>-</span>
               <a href="/blog/c143/tu-van-viec-lam-nganh-xuat-nhap-khau-logistics">Tư vấn việc làm Ngành Xuất Nhập Khẩu
                  - Logistics</a><span>-</span>
               <a href="/blog/c145/tu-van-viec-lam-nganh-tai-chinh-ngan-hang">Tư vấn việc làm Ngành Tài Chính - Ngân
                  Hàng</a><span>-</span>
               <a href="/blog/c147/tu-van-viec-lam-nganh-xay-dung">Tư vấn việc làm Ngành Xây Dựng</a><span>-</span>
               <a href="/blog/c149/tu-van-viec-lam-nganh-thiet-ke-my-thuat">Tư vấn việc làm Ngành Thiết kế - Mỹ
                  thuật</a><span>-</span>
               <a href="/blog/c151/tu-van-viec-lam-nganh-van-tai-lai-xe">Tư vấn việc làm Ngành Vận tải - Lái
                  xe</a><span>-</span>
               <a href="/blog/c153/quan-tri-nhan-luc">Quản trị nhân lực </a><span>-</span>
               <a href="/blog/c155/quan-tri-san-xuat">Quản trị sản xuất</a><span>-</span>
               <a href="/blog/c157/cam-nang-kinh-doanh">Cẩm nang kinh doanh</a><span>-</span>
               <a href="/blog/c159/tu-van-viec-lam-nganh-thiet-ke-noi-that">Tư vấn việc làm Ngành Thiết kế - Nội
                  thất</a><span>-</span>
               <a href="/blog/c161/mo-ta-cong-viec-nganh-kinh-doanh">Mô tả công việc ngành Kinh doanh</a><span>-</span>
               <a href="/blog/c163/mo-ta-cong-viec-nganh-ban-hang">Mô tả công việc ngành Bán hàng</a><span>-</span>
               <a href="/blog/c165/mo-ta-cong-viec-tu-van-cham-soc-khach-hang">Mô tả công việc Tư vấn - Chăm sóc khách
                  hàng</a><span>-</span>
               <a href="/blog/c167/mo-ta-cong-viec-nganh-tai-chinh-ngan-hang">Mô tả công việc ngành Tài chính - Ngân
                  hàng</a><span>-</span>
               <a href="/blog/c169/mo-ta-cong-viec-nganh-ke-toan-kiem-toan">Mô tả công việc ngành Kế toán - Kiểm
                  toán</a><span>-</span>
               <a href="/blog/c171/mo-ta-cong-viec-nganh-marketing-pr">Mô tả công việc ngành Marketing -
                  PR</a><span>-</span>
               <a href="/blog/c173/mo-ta-cong-viec-nganh-nhan-su">Mô tả công việc ngành Nhân sự</a><span>-</span>
               <a href="/blog/c175/mo-ta-cong-viec-nganh-it-cong-nghe-thong-tin">Mô tả công việc ngành IT - Công nghệ
                  thông tin</a><span>-</span>
               <a href="/blog/c177/mo-ta-cong-viec-nganh-san-xuat">Mô tả công việc ngành Sản xuất</a><span>-</span>
               <a href="/blog/c179/mo-ta-cong-viec-nganh-giao-nhan-van-tai">Mô tả công việc ngành Giao nhận - Vận
                  tải</a><span>-</span>
               <a href="/blog/c181/mo-ta-cong-viec-kho-van-vat-tu">Mô tả công việc Kho vận - Vật tư</a><span>-</span>
               <a href="/blog/c183/mo-ta-cong-viec-nganh-xuat-nhap-khau-logistics">Mô tả công việc ngành Xuất nhập khẩu
                  – Logistics</a><span>-</span>
               <a href="/blog/c185/mo-ta-cong-viec-nganh-du-lich-nha-hang-khach-san">Mô tả công việc ngành Du lịch - Nhà
                  hàng - Khách sạn</a><span>-</span>
               <a href="/blog/c187/mo-ta-cong-viec-nganh-hang-khong">Mô tả công việc ngành Hàng không</a><span>-</span>
               <a href="/blog/c189/mo-ta-cong-viec-nganh-xay-dung">Mô tả công việc ngành Xây dựng</a><span>-</span>
               <a href="/blog/c191/mo-ta-cong-viec-nganh-y-te-duoc">Mô tả công việc ngành Y tế - Dược</a><span>-</span>
               <a href="/blog/c193/mo-ta-cong-viec-lao-dong-pho-thong">Mô tả công việc Lao động phổ
                  thông</a><span>-</span>
               <a href="/blog/c195/mo-ta-cong-viec-nganh-ky-thuat">Mô tả công việc ngành Kỹ thuật</a><span>-</span>
               <a href="/blog/c197/mo-ta-cong-viec-nha-nghien-cuu">Mô tả công việc Nhà nghiên cứu</a><span>-</span>
               <a href="/blog/c199/mo-ta-cong-viec-nganh-co-khi-che-tao">Mô tả công việc ngành Cơ khí - Chế
                  tạo</a><span>-</span>
               <a href="/blog/c201/mo-ta-cong-viec-bo-phan-quan-ly-hanh-chinh">Mô tả công việc bộ phận Quản lý hành
                  chính</a><span>-</span>
               <a href="/blog/c203/mo-ta-cong-viec-bien-phien-dich">Mô tả công việc Biên - Phiên dịch</a><span>-</span>
               <a href="/blog/c205/mo-ta-cong-viec-nganh-thiet-ke">Mô tả công việc ngành Thiết kế</a><span>-</span>
               <a href="/blog/c207/mo-ta-cong-viec-nganh-bao-chi-truyen-hinh">Mô tả công việc ngành Báo chí - Truyền
                  hình</a><span>-</span>
               <a href="/blog/c209/mo-ta-cong-viec-nganh-nghe-thuat-dien-anh">Mô tả công việc ngành Nghệ thuật - Điện
                  ảnh</a><span>-</span>
               <a href="/blog/c211/mo-ta-cong-viec-nganh-spa-lam-dep-the-luc">Mô tả công việc ngành Spa – Làm đẹp – Thể
                  lực</a><span>-</span>
               <a href="/blog/c213/mo-ta-cong-viec-nganh-giao-duc-dao-tao">Mô tả công việc ngành Giáo dục - Đào
                  tạo</a><span>-</span>
               <a href="/blog/c215/mo-ta-cong-viec-thuc-tap-sinh-intern">Mô tả công việc Thực tập sinh -
                  Intern</a><span>-</span>
               <a href="/blog/c217/mo-ta-cong-viec-nganh-freelancer">Mô tả công việc ngành Freelancer</a><span>-</span>
               <a href="/blog/c219/mo-ta-cong-viec-cong-chuc-vien-chuc">Mô tả công việc Công chức - Viên
                  chức</a><span>-</span>
               <a href="/blog/c221/mo-ta-cong-viec-nganh-luat-phap-ly">Mô tả công việc ngành Luật - Pháp
                  lý</a><span>-</span>
               <a href="/blog/c227/tu-van-viec-lam-cham-soc-khach-hang">Tư vấn việc làm Chăm Sóc Khách Hàng
               </a><span>-</span>
               <a href="/blog/c229/tu-van-viec-lam-vat-tu-kho-van">Tư vấn việc làm Vật Tư - Kho Vận</a><span>-</span>
               <a href="/blog/c231/ho-so-doanh-nhan">Hồ sơ doanh nhân</a><span>-</span>
               <a href="/blog/c233/viec-lam-theo-phuong">Việc làm theo phường</a><span>-</span>
               <a href="/blog/c234/danh-sach-cac-hoang-de-noi-tieng">Danh sách các hoàng đế nổi tiếng</a><span>-</span>
               <a href="/blog/c235/tai-lieu-gia-su">Tài liệu gia sư</a><span>-</span>
               <a href="/blog/c236/vi-nhan-thoi-xua">Vĩ Nhân Thời Xưa</a><span>-</span>
               <a href="/blog/c237/cham-cong">Chấm Công</a><span>-</span>
               <a href="/blog/c238/danh-muc-van-thu-luu-tru">Danh mục văn thư lưu trữ</a><span>-</span>
               <a href="/blog/c239/tai-san-doanh-nghiep">Tài Sản Doanh Nghiệp</a><span>-</span>
               <a href="/blog/c240/kpi-nang-luc">KPI Năng Lực</a><span>-</span>
               <a href="/blog/c241/noi-bo-cong-ty-van-hoa-doanh-nghiep">Nội Bộ Công Ty - Văn Hóa Doanh
                  Nghiệp</a><span>-</span>
               <a href="/blog/c242/quan-ly-quan-he-khach-hang">Quản Lý Quan Hệ Khách Hàng</a><span>-</span>
               <a href="/blog/c243/quan-ly-cong-viec-nhan-vien">Quản Lý Công Việc Nhân Viên</a><span>-</span>
               <a href="/blog/c244/chuyen-van-ban-thanh-giong-noi">Chuyển văn bản thành giọng nói</a><span>-</span>
               <a href="/blog/c245/gioi-thieu-app-phien-dich">Giới Thiệu App Phiên Dịch</a><span>-</span>
               <a href="/blog/c246/quan-ly-kenh-phan-phoi">Quản Lý Kênh Phân Phối</a><span>-</span>
               <a href="/blog/c247/danh-gia-nhan-vien">Đánh giá nhân viên</a><span>-</span>
               <a href="/blog/c248/quan-ly-nganh-xay-dung">Quản lý ngành xây dựng</a><span>-</span>
               <a href="/blog/c249/hoa-don-doanh-nghiep">Hóa đơn doanh nghiệp</a><span>-</span>
               <a href="/blog/c250/quan-ly-van-tai">Quản Lý Vận Tải</a><span>-</span>
               <a href="/blog/c251/kinh-nghiem-quan-ly-mua-hang">Kinh nghiệm Quản lý mua hàng</a><span>-</span>
               <a href="/blog/c252/danh-thiep-ca-nhan">Danh thiếp cá nhân</a><span>-</span>
               <a href="/blog/c253/quan-ly-truong-hoc">Quản Lý Trường Học</a><span>-</span>
               <a href="/blog/c254/quan-ly-dau-tu-xay-dung">Quản Lý Đầu Tư Xây Dựng</a><span>-</span>
               <a href="/blog/c255/kinh-nghiem-quan-ly-tai-chinh">Kinh Nghiệm Quản Lý Tài Chính</a><span>-</span>
               <a href="/blog/c256/kinh-nghiem-quan-ly-kho-hang">Kinh nghiệm Quản lý kho hàng</a><span>-</span>
               <a href="/blog/c257/quan-ly-gara-o-to">Quản Lý Gara Ô Tô</a><span>-</span>
               <span class="show_cm"><img src="/images/icons_more.png" alt="Xem thêm gợi ý"></span>
               <span class="hiden_cm"><img src="/images/icons_hiden.png" alt="Xem thêm gợi ý"></span>
            </div>
         </div>
      </div>
   </div>
   <!-- js mxh -->
   <div id="js_share"></div>

   <script type="text/javascript" defer>
   jQuery(window).scroll(function() {
      if (jQuery(this).scrollTop() > 400 && $('#box-social').hasClass('share') == false) {
         $('#box-social').append(
            '<div class="fb-like" data-href="https://timviec365.vn/blog/mo-ta-he-thong-quan-ly-ban-hang-new5591.html" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div><script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0";fjs.parentNode.insertBefore(js, fjs);}(document, "script", "facebook-jssdk"));<\/script><div class="fb-share-button"data-href="https://timviec365.vn/blog/mo-ta-he-thong-quan-ly-ban-hang-new5591.html"data-layout="button"></div><a rel="nofollow" href="https://twitter.com/share?ref_src=" class="twitter-share-button" data-show-count="false">Tweet</a><a id="pin_share" href="https://www.pinterest.com/pin/create/button/" data-pin-do="buttonBookmark"></a><a class="vnk_share" href="http://vk.com/share.php?url=https://timviec365.vn/blog/mo-ta-he-thong-quan-ly-ban-hang-new5591.html" target="_blank" rel="nofollow">Share in VK</a> <script type="IN/Share" data-url="https://timviec365.vn/blog/mo-ta-he-thong-quan-ly-ban-hang-new5591.html"><\/script>'
            );
         $('#js_share').append(
            "<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');<\/script><script type='text/javascript' async defer src='//assets.pinterest.com/js/pinit.js'><\/script><script defer src='https://platform.linkedin.com/in.js' type='text/javascript'>lang: en_US<\/script>"
            );
         $('#box-social').addClass('share');
      }
   });
   $(".show_cm").click(function() {
      $(this).hide();
      $(".hiden_cm").show();
      $(".ct_cm").removeClass("hiden_dtblog");
   });
   $(".hiden_cm").click(function() {
      $(this).hide();
      $('.show_cm').show();
      $(".ct_cm").addClass("hiden_dtblog");
   });
   $(".show_cd").click(function() {
      $(this).hide();
      $(".hiden_cd").show();
      $(".chude").removeClass("hiden_dtblog");
   });
   $(".hiden_cd").click(function() {
      $(this).hide();
      $('.show_cd').show();
      $(".chude").addClass("hiden_dtblog");
   });
   $(".chongiong").click(function() {
      $(this).parent().find(".tca_giong").toggle(500);
   })
   // $(".giong_moi").click(function() {
   // 	var id_g = $(this).attr("data");
   // 	var new_title = $(this).attr("data2");
   // 	var new_id = $(this).parents(".tca_giong").attr("data");
   // 	var pb = 1;
   // 	var src = $(this).attr("data-src");
   // 	var html = `<audio title="${new_title}" controls="" preload="none" controlslist="nodownload noplaybackrate">
   //             <source src="${src}" type="audio/wav">
   //         </audio>`;
   // 	$(".audio_news .ctn_audio").html(html);
   // 	$(".tca_giong").hide();
   // })
   function giong_noi(e) {
      let title_new = $(e).attr("data-title"),
         link_audio = $(e).attr("data-src");
      html_audio = `
	            <audio title="Audio : ${title_new}" controls preload="none" controlsList="nodownload noplaybackrate">
	                <source src="${link_audio}" type="audio/wav">
	            </audio>`;
      $(e).parents('.audio_news').find('.ctn_audio').html(html_audio);
      $(e).parents('.tca_giong').hide();
   }
   </script>
   <link rel="stylesheet" href="https://timviec365.vn/css/footer_new.css?v=4">

   <div class="footer_main">
      <div class="footer_content">
         <div class="footer_block1">
            <a rel="dofollow" target="_blank" href="https://timviec365.vn/cv365/" class="footer_block1_txt">Hồ sơ xin
               việc,</a>
            <a rel="dofollow" target="_blank" href="https://timviec365.vn/cv365/cv-tieng-anh"
               class="footer_block1_txt">cv tiếng anh,</a>
            <a rel="dofollow" target="_blank" href="https://timviec365.vn/cv365/cv-tieng-viet"
               class="footer_block1_txt">cv tiếng việt,</a>
            <a rel="dofollow" target="_blank" href="https://timviec365.vn/cv365/cv-tieng-han"
               class="footer_block1_txt">cv tiếng hàn,</a>
            <a rel="dofollow" target="_blank" href="https://timviec365.vn/cv365/cv-tieng-nhat"
               class="footer_block1_txt">cv tiếng nhật,</a>
            <a rel="dofollow" target="_blank" href="https://timviec365.vn/cv365/mau-don-xin-viec"
               class="footer_block1_txt">đơn xin việc,</a>
            <a rel="dofollow" target="_blank" href="https://timviec365.vn/cv365/mau-cover-letter-thu-xin-viec"
               class="footer_block1_txt">thư xin việc,</a>
            <a rel="dofollow" target="_blank" href="https://timviec365.vn/cv365/mau-so-yeu-ly-lich"
               class="footer_block1_txt">sơ yếu lý lịch,</a>
            <a rel="dofollow" target="_blank"
               href="https://timviec365.vn/cv365/cv-viet-tat-cua-tu-gi-nhung-dieu-can-biet-khi-viet-cv.html"
               class="footer_block1_txt">cv là gì,</a>
            <a rel="dofollow" target="_blank" href="https://timviec365.vn/cau-hoi-tuyen-dung"
               class="footer_block1_txt">câu hỏi phỏng vấn,</a>
            <a rel="dofollow" target="_blank" href="https://timviec365.vn/cv365/cv-ke-toan" class="footer_block1_txt">cv
               kế toán,</a>
            <a rel="dofollow" target="_blank" href="https://timviec365.vn/cv365/cv-kinh-doanh"
               class="footer_block1_txt">cv kinh doanh,</a>
            <a rel="dofollow" target="_blank" href="https://timviec365.vn/cv365/cv-it" class="footer_block1_txt">cv
               IT,</a>
            <a rel="dofollow" target="_blank" href="https://timviec365.vn/cv365/cv-hanh-chinh-nhan-su"
               class="footer_block1_txt">cv nhân sự,</a>
            <a rel="dofollow" target="_blank" href="https://timviec365.vn/cv365/cv-nhan-vien-ban-hang"
               class="footer_block1_txt">cv bán hàng,</a>
            <a rel="dofollow" target="_blank" href="https://timviec365.vn/cv365/cv-marketing"
               class="footer_block1_txt">CV marketing,</a>
            <a rel="dofollow" target="_blank" href="https://timviec365.vn/cv365/cv-xay-dung"
               class="footer_block1_txt">cv xây dựng,</a>
            <a rel="dofollow" target="_blank" href="https://timviec365.vn/cv365/cv-co-khi" class="footer_block1_txt">cv
               cơ khí,</a>
            <a rel="dofollow" target="_blank" href="https://timviec365.vn/cv365/cv-xuat-nhap-khau"
               class="footer_block1_txt">cv xuất nhập khẩu,</a>
            <a rel="dofollow" target="_blank" href="https://timviec365.vn/cv365/cv-sinh-vien-moi-ra-truong"
               class="footer_block1_txt">cv sinh viên mới ra trường,</a>
            <a rel="dofollow" target="_blank" href="https://timviec365.vn/cv365/cv-kien-truc-noi-that"
               class="footer_block1_txt">cv kiến trúc nội thất,</a>
            <a rel="dofollow" target="_blank" href="https://timviec365.vn/cv365/cv-cham-soc-khach-hang"
               class="footer_block1_txt">cv chăm sóc khách hàng,</a>
            <a rel="dofollow" target="_blank" href="https://timviec365.vn/cv365/cv-phat-trien-thi-truong"
               class="footer_block1_txt">cv phát triển thị trường,</a>
            <a rel="dofollow" target="_blank" href="https://timviec365.vn/cv365/cv-du-lich" class="footer_block1_txt">cv
               du lịch,</a>
            <a rel="dofollow" target="_blank" href="https://timviec365.vn/cv365/cv-thu-ngan"
               class="footer_block1_txt">cv thu ngân,</a>
            <a rel="dofollow" target="_blank" href="https://timviec365.vn/cv365/cv-viec-lam-telesale"
               class="footer_block1_txt">cv telesale,</a>
            <a rel="dofollow" target="_blank" href="https://timviec365.vn/cv365/cv-tai-chinh"
               class="footer_block1_txt">cv tài chính,</a>
            <a rel="dofollow" target="_blank" href="https://timviec365.vn/cv365/cv-logistic"
               class="footer_block1_txt">cv logistic,</a>
            <a rel="dofollow" target="_blank" href="https://timviec365.vn/cv365/cv-nha-hang-khach-san"
               class="footer_block1_txt">cv nhà hàng khách sạn</a>
         </div>
         <div class="gach_ngang"></div>
         <div class="footer_block2">
            <div class="about_365">
               <div class="wrap_arr open_content">
                  <p class="footer_block2_header">Về Timviec365</p>
                  <div class="arr_respon hidden">
                     <img src="https://timviec365.vn/images/arr_up.svg" class="hidden" alt="arrow_up">
                     <img src="https://timviec365.vn/images/arr_down.svg" alt="arrow_down">
                  </div>
               </div>
               <div class="list_about_365 content_show">
                  <div class="timviec_item">
                     <div class="content_item">
                        <a rel="nofollow" href="https://timviec365.vn/gioi-thieu-chung.html">Giới thiệu</a>
                        <a rel="nofollow" href="https://timviec365.vn/thong-tin-can-biet.html">Thông tin</a>
                        <a rel="nofollow"
                           href="https://timviec365.vn/blog/hoi-va-dap-ve-timviec365vn-chat365-va-cac-ung-dung-chuyen-doi-so-new16648.html">Hỏi
                           đáp</a>
                        <a rel="nofollow" href="https://timviec365.vn/blog">Cẩm nang</a>
                        <a rel="nofollow" href="https://timviec365.vn/thoa-thuan-su-dung.html">Thỏa thuận</a>
                        <a rel="nofollow" href="https://timviec365.vn/quy-dinh-bao-mat.html">Bảo mật</a>
                     </div>
                     <div class="content_item">
                        <a rel="nofollow" href="https://timviec365.vn/giai-quyet-tranh-chap.html">Giải quyết tranh
                           chấp</a>
                        <a rel="nofollow" href="https://timviec365.vn/so-do-trang-web.html">Sơ đồ Website</a>
                        <a rel="nofollow" target="_blank" href="https://www.youtube.com/watch?v=UssNzo6m1p8">Video</a>
                        <a rel="nofollow"
                           href="https://timviec365.vn/blog/ung-dung-cua-trinh-sat-ai365-new16655.html">AI365</a>
                        <a rel="nofollow" href="https://timviec365.vn/blog/huy-hieu-tia-set-new16722.html">Huy hiệu tia
                           sét</a>
                     </div>
                  </div>
               </div>
            </div>
            <div class="footer_block2_right">
               <div class="for_uv">
                  <div class="wrap_arr open_content">
                     <p class="footer_block2_header">Dành cho ứng viên</p>
                     <div class="arr_respon hidden">
                        <img src="https://timviec365.vn/images/arr_up.svg" class="arr_up hidden" alt="arrow_up">
                        <img src="https://timviec365.vn/images/arr_down.svg" class="arr_down" alt="arrow_down">
                     </div>
                  </div>
                  <div class="list_for_uv content_show">
                     <div class="timviec_item">
                        <div class="content_item">
                           <a href="https://timviec365.vn/cv-xin-viec">Mẫu CV xin việc</a>
                           <a href="https://timviec365.vn/cv365/mau-cover-letter-thu-xin-viec">Thư xin việc</a>
                           <a href="https://timviec365.vn/cv365/mau-don-xin-viec">Hồ sơ xin việc</a>
                        </div>
                        <div class="content_item">
                           <a href="https://timviec365.vn/blog/c24/bi-quyet-viet-cv">Bí quyết viết CV</a>
                           <a rel="nofollow" href="https://timviec365.vn/trang-vang-doanh-nghiep.html">Trang vàng</a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="for_ntd">
                  <div class="wrap_arr open_content">
                     <p class="footer_block2_header">Dành cho nhà tuyển dụng</p>
                     <div class="arr_respon hidden">
                        <img src="https://timviec365.vn/images/arr_up.svg" class="arr_up hidden" alt="arrow_up">
                        <img src="https://timviec365.vn/images/arr_down.svg" class="arr_down" alt="arrow_down">
                     </div>
                  </div>
                  <div class="list_for_ntd content_show">
                     <div class="timviec_item">
                        <div class="content_item">
                           <a href="https://timviec365.vn/dang-tin-tuyen-dung-mien-phi.html">Đăng tuyển dụng</a>
                           <a href="https://timviec365.vn/blog">Cẩm nang tuyển dụng</a>
                           <a href="https://timviec365.vn/nguoi-tim-viec.html">Tìm hồ sơ</a>
                        </div>
                        <div class="content_item">
                           <a rel="nofollow" href="https://quanlychung.timviec365.vn/">Ứng dụng chuyển đổi số</a>
                           <a href="https://timviec365.vn/bieu-mau">Biểu mẫu</a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="tien_ich">
                  <div class="wrap_arr open_content">
                     <p class="footer_block2_header">Tiện ích</p>
                     <div class="arr_respon hidden">
                        <img src="https://timviec365.vn/images/arr_up.svg" class="arr_up hidden" alt="arrow_up">
                        <img src="https://timviec365.vn/images/arr_down.svg" class="arr_down" alt="arrow_down">
                     </div>
                  </div>
                  <div class="list_tien_ich content_show">
                     <div class="timviec_item">
                        <div class="content_item">
                           <a rel="nofollow" href="https://timviec365.vn/ssl/so-sanh-luong.html">Tra cứu lương</a>
                           <a href="https://timviec365.vn/tinh-luong-gross-net.html">Lương Gross - Net</a>
                           <a rel="nofollow" href="https://timviec365.vn/mail365/">Email365</a>
                        </div>
                        <div class="content_item">
                           <a href="https://timviec365.vn/gioi-thieu-app-tim-viec.html">Tải app</a>
                           <a href="https://timviec365.vn/tinh-bao-hiem-that-nghiep" rel="nofollow">Tính bảo hiểm thất
                              nghiệp</a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="work_area">
                  <div class="wrap_arr open_content">
                     <p class="footer_block2_header">Việc làm theo khu vực</p>
                     <div class="arr_respon hidden">
                        <img src="https://timviec365.vn/images/arr_up.svg" class="arr_up hidden" alt="arrow_up">
                        <img src="https://timviec365.vn/images/arr_down.svg" class=" arr_down" alt="arrow_down">
                     </div>
                  </div>
                  <div class="list_work_area content_show">
                     <div class="timviec_item">
                        <div class="content_item">
                           <a href="https://timviec365.vn/tim-viec-lam-tai-ha-noi.html">Việc làm tại Hà Nội</a>
                           <a href="https://timviec365.vn/viec-lam-tai-ho-chi-minh-c0v45">Việc làm tại Hồ Chí Minh</a>
                           <a href="https://timviec365.vn/viec-lam-tai-da-nang-c0v26">Việc làm tại Đà Nẵng</a>
                           <a href="https://timviec365.vn/viec-lam-tai-hai-phong-c0v2">Việc làm tại Hải Phòng</a>
                        </div>
                        <div class="content_item">
                           <a href="https://timviec365.vn/viec-lam-tai-binh-duong-c0v46">Việc làm tại Bình Dương</a>
                           <a href="https://timviec365.vn/viec-lam-tai-can-tho-c0v48">Việc làm tại Cần Thơ</a>
                           <a href="https://timviec365.vn/viec-lam-tai-dong-nai-c0v55">Việc làm tại Đồng Nai</a>
                           <a href="https://timviec365.vn/viec-lam-tai-bac-ninh-c0v5">Việc làm tại Bắc Ninh</a>
                        </div>
                     </div>
                     <a rel="nofollow" href="https://timviec365.vn/viec-lam-tai-tinh-thanh" class="seen_all">Xem tất cả
                        <img src="https://timviec365.vn/images/2arr_right.svg" alt="see_all"></a>
                  </div>
               </div>
               <div class="work_job">
                  <div class="wrap_arr open_content">
                     <p class="footer_block2_header">Việc làm theo ngành nghề</p>
                     <div class="arr_respon hidden">
                        <img src="https://timviec365.vn/images/arr_up.svg" class="arr_up hidden" alt="arrow_up">
                        <img src="https://timviec365.vn/images/arr_down.svg" class="arr_down" alt="arrow_down">
                     </div>
                  </div>
                  <div class="list_work_job content_show">
                     <div class="timviec_item">
                        <div class="content_item">
                           <a href="https://timviec365.vn/viec-lam-nhan-vien-kinh-doanh-c9v0">Việc làm kinh doanh</a>
                           <a href="https://timviec365.vn/viec-lam-kd-bat-dong-san-c33v0">Việc làm bất động sản</a>
                           <a href="https://timviec365.vn/viec-lam-bao-hiem-c66v0">Việc làm bảo hiểm</a>
                           <a href="https://timviec365.vn/viec-lam-it-phan-mem-c13v0">Việc làm IT</a>
                        </div>
                        <div class="content_item">
                           <a href="https://timviec365.vn/viec-lam-nhan-su-c27v0">Việc làm nhân sự</a>
                           <a href="https://timviec365.vn/viec-lam-ban-hang-c10v0">Việc làm bán hàng</a>
                           <a href="https://timviec365.vn/viec-lam-luong-cao.html">Việc làm lương cao</a>
                           <a href="https://timviec365.vn/viec-lam-ke-toan-kiem-toan-c1v0">Việc làm kế toán</a>
                        </div>
                     </div>
                     <a rel="nofollow" href="https://timviec365.vn/danh-sach-nganh-nghe" class="seen_all">Xem tất cả
                        <img src="https://timviec365.vn/images/2arr_right.svg" alt="see_all"></a>
                  </div>
               </div>
               <div class="work_tag">
                  <div class="wrap_arr open_content">
                     <p class="footer_block2_header">Việc làm theo tag</p>
                     <div class="arr_respon hidden">
                        <img src="https://timviec365.vn/images/arr_up.svg" class="arr_up hidden" alt="arrow_up">
                        <img src="https://timviec365.vn/images/arr_down.svg" class="arr_down" alt="arrow_down">
                     </div>
                  </div>
                  <div class="list_work_tag content_show">
                     <div class="timviec_item">
                        <div class="content_item">
                           <a href="https://timviec365.vn/tim-viec-lam-php-t11394.html">Việc làm PHP</a>
                           <a href="https://timviec365.vn/tag7/DS-viec-lam-tuyen-dung-ke-toan-noi-bo-866">Việc làm Kế
                              toán nội bộ</a>
                           <a href="https://timviec365.vn/tag7/DS-viec-lam-tuyen-dung-digital-marketing-521">Việc làm
                              Digital Marketing</a>
                           <a href="https://timviec365.vn/tag7/DS-viec-lam-tuyen-dung-chuyen-vien-seo-2070">Việc làm
                              chuyên viên seo</a>
                        </div>
                        <div class="content_item">
                           <a href="https://timviec365.vn/tag7/DS-viec-lam-tuyen-dung-tu-van-bat-dong-san-2737">Việc làm
                              bất động sản</a>
                           <a href="https://timviec365.vn/tag7/DS-viec-lam-tuyen-dung-thuc-tap-sinh-1265">Việc làm thực
                              tập sinh</a>
                           <a href="https://timviec365.vn/tag7/DS-viec-lam-tuyen-dung-nhan-vien-bao-hiem-900">Việc làm
                              nhân viên bảo hiểm</a>
                           <a href="https://timviec365.vn/tag7/DS-viec-lam-tuyen-dung-content-526">Việc làm Content</a>
                        </div>
                     </div>
                     <a rel="nofollow" href="https://timviec365.vn/danh-sach-viec-lam-theo-tags" class="seen_all">Xem
                        tất cả <img src="https://timviec365.vn/images/2arr_right.svg" alt="see_all"></a>
                  </div>
               </div>
            </div>
         </div>
         <div class="gach_ngang"></div>
         <div class="footer_block3">
            <div class="wrap_365">
               <div>
                  <img class="lazyload" src="https://timviec365.vn/images/365timviec.png" alt="timviec365">
               </div>
               <span class="wrap_365_txt">KẾT NỐI VỚI TIMVIEC365.VN</span>
               <div class="wrap_block_connect">
                  <div class="wrap_icon_connet"><a href="https://chat365.timviec365.vn/" rel="nofollow"
                        target="_blank"><img src="https://timviec365.vn/images/icon365.svg" alt="chat"></a></div>
                  <div class="wrap_icon_connet"><a href="https://www.facebook.com/Timviec365.Vn/" rel="nofollow"
                        target="_blank"><img src="https://timviec365.vn/images/icon_fb.svg" alt="facebook"></a></div>
                  <div class="wrap_icon_connet"><a href="https://twitter.com/timviec365vn" rel="nofollow"
                        target="_blank"><img src="https://timviec365.vn/images/icon_witter.svg" alt="witter"></a></div>
                  <div class="wrap_icon_connet"><a
                        href="https://www.youtube.com/channel/UCI6_mZYL8exLuvmtipBFrkg/videos" rel="nofollow"
                        target="_blank"><img src="https://timviec365.vn/images/icon_youtube.svg" alt="youtube"></a>
                  </div>
               </div>
               <div class="wrap_certify">
                  <a rel="nofollow" href="http://online.gov.vn/Home/WebDetails/35979">
                     <img class="lazyload icon_bct" src="https://timviec365.vn/images/DK_bocongthuong.png"
                        alt="Đã đăng ký bộ công thương">
                  </a>
                  <a rel="nofollow"
                     href="//www.dmca.com/Protection/Status.aspx?ID=5b1070f1-e6fb-4ba4-8283-84c7da8f8398">
                     <img class="lazyload icon_dmca" src="https://timviec365.vn/images/dmca.png"
                        alt="DMCA.com Protection Status">
                  </a>
               </div>
            </div>
            <div class="wrap_address">
               <p class="wrap_address_header">CÔNG TY CỔ PHẦN THANH TOÁN HƯNG HÀ</p>
               <!-- <a href="https://goo.gl/maps/stYYuH5Ln5U2" rel="nofollow" target="_blank" class="wrap_address_txt">VP 1: Tầng 4, B50, Lô 6, KĐT Định Công - Hoàng Mai - Hà Nội</a> -->
               <p class="wrap_address_txt">Địa chỉ: Thôn Thanh Miếu, Xã Việt Hưng, Huyện Văn Lâm, Tỉnh Hưng Yên</p>
               <!-- <p class="wrap_address_txt">VP3: Tầng 3, Số 1 đường Trần Nguyên Đán, Khu Đô Thị Định Công, Hoàng Mai, Hà Nội</p> -->
               <p class="wrap_address_txt">Hotline: 0982079209, 1900633682 - ấn phím 1</p>
               <p class="wrap_address_txt">Email: timviec365.vn@gmail.com</p>
            </div>
            <div class="wrap_qr">
               <p class="wrap_qr_header">TẢI APP ĐỂ TÌM VIỆC SIÊU TỐC</p>
               <div class="wrap_qr_block">
                  <div class="wrap_qr_child">
                     <img class="qr_img lazyload" style="width: 101.5%;"
                        src="https://timviec365.vn/images/qr_timviec_uv.png" alt="download_app">
                     <p class="qr_txt">App Timviec365 UV</p>
                  </div>
                  <div class="wrap_qr_child">
                     <img class="qr_img lazyload" src="https://timviec365.vn/images/New_images/new_qr_ft1.png"
                        alt="download_app">
                     <p class="qr_txt">App Timviec365 NTD</p>
                  </div>
                  <div class="wrap_qr_child">
                     <!-- <img class="qr_img lazyload" src="https://timviec365.vn/images/qr_cv_365.png" alt="download_app"> -->
                     <img class="qr_img lazyload" src="https://timviec365.vn/images/qr_app_cv_new.png"
                        alt="download_app">
                     <p class="qr_txt">App CV365</p>
                  </div>
                  <div class="wrap_qr_child">
                     <img class="qr_img lazyload" src="https://timviec365.vn/images/qr_chat_365.png" alt="download_app">
                     <p class="qr_txt">App Chat365</p>
                  </div>
               </div>
            </div>
         </div>
         <div class="footer_block3_2 hidden">
            <div>
               <img class="lazyload" src="https://timviec365.vn/images/365timviec.png" alt="timviec365">
            </div>
            <div class="wrap_address">
               <p class="wrap_address_header">CÔNG TY CỔ PHẦN THANH TOÁN HƯNG HÀ</p>
               <!-- <p class="wrap_address_txt">VP 1: Tầng 4, B50, Lô 6, KĐT Định Công - Hoàng Mai - Hà Nội</p> -->
               <p class="wrap_address_txt">Địa chỉ: Thôn Thanh Miếu, Xã Việt Hưng, Huyện Văn Lâm, Tỉnh Hưng Yên</p>
               <!-- <p class="wrap_address_txt">VP3: Tầng 3, Số 1 đường Trần Nguyên Đán, Khu Đô Thị Định Công, Hoàng Mai, Hà Nội</p> -->
               <p class="wrap_address_txt">Hotline: 0982079209, 1900633682 - ấn phím 1</p>
               <p class="wrap_address_txt">Email: timviec365.vn@gmail.com</p>
            </div>
            <div class="flex jtf_sb">
               <div class="wrap_certify">
                  <a rel="nofollow" target="_blank" href="http://online.gov.vn/Home/WebDetails/35979">
                     <img class="lazyload icon_bct" src="https://timviec365.vn/images/DK_bocongthuong.png"
                        alt="Đã đăng ký bộ công thương">
                  </a>
                  <a rel="nofollow"
                     href="//www.dmca.com/Protection/Status.aspx?ID=5b1070f1-e6fb-4ba4-8283-84c7da8f8398">
                     <img class="lazyload icon_dmca" src="https://timviec365.vn/images/dmca.png"
                        alt="DMCA.com Protection Status">
                  </a>
               </div>
               <div class="wrap_block_connect">
                  <div class="wrap_icon_connet"><a href="https://chat365.timviec365.vn/" rel="nofollow"
                        target="_blank"><img src="https://timviec365.vn/images/icon365.svg" alt="chat"></a></div>
                  <div class="wrap_icon_connet"><a href="https://www.facebook.com/Timviec365.Vn/" rel="nofollow"
                        target="_blank"><img src="https://timviec365.vn/images/icon_fb.svg" alt="facebook"></a></div>
                  <div class="wrap_icon_connet"><a href="https://twitter.com/timviec365vn" rel="nofollow"
                        target="_blank"><img src="https://timviec365.vn/images/icon_witter.svg" alt="witter"></a></div>
                  <div class="wrap_icon_connet"><a
                        href="https://www.youtube.com/channel/UCI6_mZYL8exLuvmtipBFrkg/videos" rel="nofollow"
                        target="_blank"><img src="https://timviec365.vn/images/icon_youtube.svg" alt="youtube"></a>
                  </div>
               </div>
            </div>
         </div>
         <div class="gach_ngang respon_1200 hidden"></div>
         <div class="footer_block4 hidden">
            <p class="wrap_qr_header">TẢI APP ĐỂ TÌM VIỆC SIÊU TỐC</p>
            <p class="wrap_qr_header_2">Tải app để tìm việc siêu tốc Tạo CV đẹp với 365+ mẫu CV xin việc</p>
            <div class="wrap_qr_block">
               <button class="wrap_qr_child">
                  <a href="https://play.google.com/store/apps/details?id=timviec365vn.timviec365_vn"
                     ios-href="https://apps.apple.com/vn/app/t%C3%ACm-vi%E1%BB%87c-365-t%C3%ACm-vi%E1%BB%87c-online/id1597712953?l=vi"
                     class="ios_check" rel="nofollow" target="_blank">
                     <p class="qr_txt">Tải app Timviec365 UV</p>
                     <img class="download_img" src="https://timviec365.vn/images/download.svg" alt="download">
                  </a>
               </button>
               <button class="wrap_qr_child">
                  <a href="https://play.google.com/store/apps/details?id=vn.timviec365.company"
                     ios-href="https://apps.apple.com/vn/app/nh%C3%A0-tuy%E1%BB%83n-d%E1%BB%A5ng-timviec365-vn/id1606069668"
                     rel="nofollow" class="ios_check" target="_blank">
                     <p class="qr_txt">Tải app Timviec365 NTD</p>
                     <img class="download_img" src="https://timviec365.vn/images/download.svg" alt="download">
                  </a>
               </button>
               <button class="wrap_qr_child wrap_qr_child_respon">
                  <a href="https://play.google.com/store/apps/details?id=vn.timviec365.cv.cv365_vn" class="ios_check"
                     ios-href="https://apps.apple.com/us/app/cv-xin-vi%E1%BB%87c-365-t%E1%BA%A1o-cv-%C4%91%E1%BA%B9p/id1631076979"
                     rel="nofollow" target="_blank">
                     <p class="qr_txt">Tải app CV365</p>
                     <img class="download_img" src="https://timviec365.vn/images/download.svg" alt="download">
                  </a>
               </button>
               <button class="wrap_qr_child wrap_qr_child_respon">
                  <a href="https://play.google.com/store/apps/details?id=vn.timviec365.chat_365" class="ios_check"
                     ios-href="https://apps.apple.com/us/app/chat365-nh%E1%BA%AFn-tin-nhanh-ch%C3%B3ng/id1623353330"
                     rel="nofollow" target="_blank">
                     <p class="qr_txt">Tải app Chat365</p>
                     <img class="download_img" src="https://timviec365.vn/images/download.svg" alt="download">
                  </a>
               </button>
            </div>
         </div>
      </div>
   </div>
   </div>
   <div class="loading" style="display:none">
      <div class="loading_gif">
         <img src="https://timviec365.vn/images/loading_ajax.gif" alt="Đang tải">
      </div>
   </div>

   <script>
   $(".open_content").on('click', function() {
      let content = $(this).parent().find('.content_show');
      if (content.is(':hidden')) {
         content.css('display', 'block');
         $(this).find('.arr_respon img').css('transform', 'rotate(180deg)')
      } else {
         content.removeAttr('style');
         $(this).find('.arr_respon img').css('transform', 'rotate(0deg)')
      }
   })
   </script>
   <script src="/js/streamSaver.js"></script>
   <div class="modal pop_tk_gnoi" id="pop_tk_gnoi">
      <div class="modal-content">
         <div class="close_ghiam"><span>X</span></div>
         <div class="pop_md_butt">
            <p class="logo_tviec"><img src="/images/img_new/exp_logo_timviec.png"></p>
            <p class="tde_pop"><img src="/images/img_new/exp_ghiam_gnoi.gif"></p>
            <div class="dung_ghiam">
               <button id="stopButton" disabled>Dừng</button>
            </div>
         </div>
      </div>
   </div>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.min.js"
      integrity="sha512-eVL5Lb9al9FzgR63gDs1MxcDS2wFu3loYAgjIH0+Hg38tCS8Ag62dwKyH+wzDb+QauDpEZjXbMn11blw8cbTJQ=="
      crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script src="/js/chat365.js"></script>
   <script src="/js/livechat/app.js?v=396"></script>
   <!-- <script>
      jQuery(window).scroll(function(){
        if(jQuery(this).scrollTop()>100 && $('#add_jslivechat').hasClass('add_js_done') == false){
          file_get_contents("https://timviec365.vn/js/livechat/app.js");
          $('#add_jslivechat').addClass('add_js_done');
        }
      });
      function file_get_contents(filename) {
          fetch(filename).then((resp) => resp.text()).then(function(data) {
              // document.getElementById("js_livechat").innerHTML = data;
            // document.getElementById("#js_livechat").innerHTML ='<script>'+data+'<\/script>';
            var s = document.createElement('script');
            s.type = 'text/javascript';
            var code = data;
            try {
              s.appendChild(document.createTextNode(code));
              document.body.appendChild(s);
            } catch (e) {
              s.text = code;
              document.body.appendChild(s);
            }
          });
      }

    </script> -->

   <script src="/js/style_header.js?v=396"></script>
   <script>
   $(document).ready(function() {
      $('#btn-top').click(function() {
         $('body,html').animate({
            scrollTop: 0
         }, 800);
      });

      // $('.right_avatar').on('click', function() {
      //   if ($('.mobi-sel').is(':hidden')) {
      //     $('.mobi-ful').toggle();
      //   }
      // });

      // $(window).click(function() {
      //   if ($("#mobi_ul").hasClass('displayblock') == true) {
      //     $("#mobi_ul").toggle().removeClass('displayblock');
      //   }
      // });

      // $(".mobi-sel").click(function() {
      //   if ($("#mobi_ul").hasClass('displayblock') == true) {
      //     $(".mobi_sh_ul").removeAttr("style");
      //     $("#mobi_ul").toggle().removeClass('displayblock')
      //     event.stopPropagation();
      //   } else {
      //     $(".mobi_sh_ul").attr('style', 'display: block');
      //     $("#mobi_ul").toggle().addClass('displayblock')
      //     event.stopPropagation();
      //   }
      // });

      //   $(".close_mobi_sel").click(function() {
      //     $("#mobi-sel").show();
      //     $('.ctn_mobi_sh_ul').hide();
      //     // $(".mobi_sh_ul").attr('style', 'display: block');
      //     $("#mobi_ul").removeClass('displayblock');
      //     $(this).hide();
      //     event.stopPropagation();
      // })

      // $(".mobi_sh_ul").click(function() {
      //   $(".mobi_sh_ul").removeAttr("style");
      // });

      // $("#mobi").click(function() {
      //   $("#mobi, .mobi-bac, .mobi-ful").toggle();
      //   $(".mobi-from").removeClass('mobi-from-login');
      //   $('.box_dangky').removeClass('hidden');
      //   $('.box_dangnhap_2').removeClass('hidden');
      //   $('.box_dangky').removeClass('top-34');
      // });

      // $(".mobi-from").click(function(e) {
      //   e.stopPropagation();
      // });

   });

   //   jQuery(window).scroll(function(){
   //     if(jQuery(this).scrollTop()>300){
   //       jQuery('#btn-top').fadeIn(800);
   //     }else{
   //       jQuery('#btn-top').fadeOut(800);
   //     }
   //  });
   // $(".sub_domain_ul").click(function(){
   //   $(".box_sub").toggle();
   // });

   function iOS() {
      return [
            'iPad Simulator',
            'iPhone Simulator',
            'iPod Simulator',
            'iPad',
            'iPhone',
            'iPod'
         ].includes(navigator.platform)
         // iPad on iOS 13 detection
         ||
         (navigator.userAgent.includes("Mac") && "ontouchend" in document)
   }
   if (iOS()) {
      $('.ios_check').each(function(index) {
         var rl_href = $(this).attr('ios-href');
         if (rl_href != '') {
            $(this).attr('href', rl_href).removeAttr('target');
         }
      });
   }
   </script>
   <!-- Global site tag (gtag.js) - Google Analytics -->
   <script async src="https://www.googletagmanager.com/gtag/js?id=UA-158369192-1"></script>
   <script>
   window.dataLayer = window.dataLayer || [];

   function gtag() {
      dataLayer.push(arguments);
   }
   gtag('js', new Date());
   gtag('config', 'UA-158369192-1');
   </script>
   <script async src="/js/lazysizes.min.js"></script>
   <style type="text/css">
   * {
      font-family: Roboto-Regular, sans-serif;
      box-sizing: border-box
   }

   .widget.show_footer_intro_cv_job.b_0 {
      bottom: 0 !important;
   }

   #footer-intro-cv-job {
      z-index: 1000;
      display: none;
      width: 100%;
      position: fixed;
      bottom: 0;
      left: 0;
      min-height: 47px;
      background: #032456;
      opacity: .9;
      padding: 0
   }

   .text-white {
      color: #fff
   }

   #footer-intro-cv-job>a.slide-down,
   #footer-intro-cv-job>a.slide-up {
      color: #aaa;
      opacity: .8;
      font-size: 12px;
      line-height: 12px;
      right: 10px;
      top: 3px;
      position: absolute
   }

   #footer-intro-cv-job.collapsed .intro-items,
   #footer-intro-cv-job.collapsed .slide-up,
   #footer-intro-cv-job>a.slide-up,
   .hide {
      display: none
   }

   #footer-intro-cv-job .container {
      padding-left: 0;
      padding-right: 0;
      width: 82%;
      margin: 0 auto;
      background: 0 0
   }

   #footer-intro-cv-job.minimize .container {
      width: 100%;
   }

   .text-center {
      text-align: center
   }

   #footer-intro-cv-job .bottom-buttons {
      margin-bottom: 9px;
      padding-top: 0
   }

   #footer-intro-cv-job p {
      padding-top: 4px;
      margin: 9px 0 0;
      font-weight: 700;
      font-size: 20px;
      line-height: 28px;
      float: left
   }

   #footer-intro-cv-job .intro-headline {
      margin-right: 20px
   }

   #footer-intro-cv-job .btn-topcv-primary {
      background: #ffb229;
      color: #000;
      padding: 6px 60px
   }

   #footer-intro-cv-job .btn {
      width: 169px;
      height: 33px;
      font-weight: 700;
      text-align: center;
      border-radius: 10px;
      font-size: 14px;
      display: flex;
      align-items: center;
      padding: 0;
      justify-content: center
   }

   #footer-intro-cv-job .btn-danger {
      color: #000;
      background: #fff600;
      border-color: #d43f3a
   }

   .container:after,
   .container:before {
      display: table;
      content: " "
   }

   #footer-intro-cv-job .slide-down .fa-angle-down::before {
      content: '';
      background: url(/images/icons/close_btndo.png) 0 0/100% 100% no-repeat;
      width: 12px;
      height: 12px;
      display: none
   }

   .collapsed .fa-angle-up::before {
      content: '';
      background: url(/images/icon_fa_angle_up.png) no-repeat;
      width: 19px;
      height: 12px;
      display: none
   }

   #footer-intro-cv-job.collapsed .intro-headline {
      width: 100%;
      float: left;
      font-size: 20px;
      text-align: center;
      padding-top: 15px;
      margin-top: 0
   }

   #footer-intro-cv-job.collapsed .bottom-buttons {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-top: 8px;
      width: 100%;
   }

   a {
      text-decoration: none
   }

   #footer-intro-cv-job .close_intro {
      font-family: Roboto-Medium;
      cursor: pointer;
      position: absolute;
      right: 10px;
      height: 40px;
   }

   .widget.show_footer_intro_cv_job {
      bottom: 66px;
      right: 7px
   }

   .main-intro-cv-job {
      display: flex;
      justify-content: center;
      padding: 32.5px 0;
   }

   .main-intro-cv-image {
      width: 40%;
      text-align: right;
   }

   .main-intro-cv-infor {
      width: 60%;

   }

   #footer-intro-cv-job.collapsed .intro-headline-first {
      font-size: 28px;
      line-height: 38px
   }

   #footer-intro-cv-job.minimize .close_intro {
      transform: rotate(180deg);
      margin: 0;
   }

   #footer-intro-cv-job.minimize .main-intro-cv-job {
      padding: 0;
   }

   #footer-intro-cv-job.minimize .main-intro-cv-infor {
      width: 100%;
      display: flex;
      justify-content: space-between;
      padding: 8px;
   }

   #footer-intro-cv-job.minimize .intro-headline-first {
      font-size: 22px;
      line-height: 44px;
      width: 50%;
      padding: unset;
   }

   #footer-intro-cv-job.minimize .bottom-buttons {
      width: 50%;
   }

   @media(max-width:1024px) {

      /* #footer-intro-cv-job.collapsed .bottom-buttons,
      #footer-intro-cv-job.collapsed .intro-headline {
        width: 100%;
        text-align: center
      } */
      #footer-intro-cv-job.minimize .btn {
         width: 150px;
      }

      #footer-intro-cv-job.minimize .intro-headline-first {
         font-size: 18px;
         line-height: 50px;
      }

      #footer-intro-cv-job.minimize .bottom-buttons {
         padding-right: 20px;
      }
   }

   @media(min-width:1367px) {
      #footer-intro-cv-job {
         min-height: 60px
      }

      #footer-intro-cv-job .btn {
         width: 174px;
         height: 42px
      }

      #footer-intro-cv-job .btn-topcv-primary {
         padding: 10px 60px
      }
   }

   @media(max-width:768px) {

      #footer-intro-cv-job.collapsed .bottom-buttons,
      #footer-intro-cv-job.collapsed .intro-headline {
         width: 100%;
         text-align: center
      }

      #footer-intro-cv-job.minimize .main-intro-cv-infor {
         flex-direction: column;
         justify-content: center;
         align-items: center;
      }

      .widget.show_footer_intro_cv_job {
         bottom: 116px
      }
   }

   @media(max-width:668px) {
      .main-intro-cv-image {
         display: none !important;
      }

      .main-intro-cv-infor {
         width: 100%;
      }
   }

   @media(max-width:415px) {

      #footer-intro-cv-job,
      #footer-intro-cv-job .container {
         width: 100%;
         min-width: 100%
      }

      .main-intro-cv-infor {
         width: 85%;
      }

      #footer-intro-cv-job .slide-down,
      #footer-intro-cv-job.collapsed .slide-up {
         left: 10px
      }

      #footer-intro-cv-job.collapsed .intro-headline {
         width: 100%;
         font-size: 18px;
         line-height: 20px;
         text-align: center;
         padding-top: 20px
      }

      #footer-intro-cv-job .main-intro-cv-job p {
         width: 100%;
         font-size: 18px;
         line-height: 20px;
         text-align: left;
         padding-top: 20px
      }

      #footer-intro-cv-job li {
         font-size: 16px;
         line-height: 20px;
         font-weight: 400
      }

      #footer-intro-cv-job .btn-topcv-primary {
         padding: 9px 40px
      }

      #footer-intro-cv-job .btn-danger {
         padding: 9px 15px;
         margin-left: 15px !important
      }

      #footer-intro-cv-job.collapsed .bottom-buttons {
         text-align: left;
         margin-top: 10px;
         margin-bottom: 10px
      }

      #footer-intro-cv-job.collapsed .btn-danger {
         margin-left: 15px !important
      }

      #footer-intro-cv-job .text-center {
         width: 96%;
         margin: 0 auto
      }

      .widget.show_footer_intro_cv_job {
         bottom: 109px;
         right: 7px
      }

      #footer-intro-cv-job.minimize .bottom-buttons {
         padding-right: 0px;
         padding-top: 0;
      }
   }
   </style>
   <div id="footer-intro-cv-job" class="text-white text-center-sm">
      <a class="slide-down"><span class="fa fa-angle-down"></span></a>
      <a class="slide-up"><span class="fa fa-angle-up"></span></a>
      <div class="container">
         <div class="text-center">
            <p class="close_intro"><img src="/images/blog/btn_minimize.svg" alt="thu gọn"></p>
            <div class="main-intro-cv-job">
               <div class="main-intro-cv-image">
                  <img class="lazyload" src="/images/load.gif" data-src="/images/blog/popupcvblog.png" alt="ảnh">
               </div>
               <div class="main-intro-cv-infor">
                  <p class="intro-headline intro-headline-first">Tạo CV online có ngay việc làm mơ ước</p>
                  <p class="intro-headline">[3500+] mẫu CV "tuyệt đẹp", chỉnh sửa dễ dàng trong 3 phút</p>
                  <p class="intro-headline">Trang việc làm ứng dụng sâu AI</p>
                  <p class="intro-headline">Tạo cv – tìm việc làm</p>
                  <p class="bottom-buttons">
                     <a href="/cv-xin-viec" class="btn btn-topcv-primary">Tạo CV</a>
                     <a href="/" class="btn btn-danger" style="margin-left: 20px;">Tìm việc làm</a>
                  </p>
               </div>
            </div>
         </div>
      </div>
   </div>
   <script async>
   $(document).ready(function() {
      $(window).scroll(function() {
         if ($('#footer-intro-cv-job').hasClass('hide')) return true;
         var position = $(this).scrollTop();
         if (position > 400) {
            $('#footer-intro-cv-job').addClass('collapsed');
            $('#footer-intro-cv-job').slideDown(300);
            $('.widget').addClass('show_footer_intro_cv_job');
            if (!$('#footer-intro-cv-job').hasClass('minimize')) {
               $('.widget').addClass('b_0');
            } else {
               $('.widget').removeClass('b_0');
            }
         } else {
            $('#footer-intro-cv-job').slideUp(300);
            $('.widget').removeClass('show_footer_intro_cv_job');
         }
      });
      $(".close_intro").click(function() {
         // $("#footer-intro-cv-job").remove();
         if (!$('#footer-intro-cv-job').hasClass('minimize')) {
            $('.main-intro-cv-image').hide();
            $('.intro-headline:not(.intro-headline-first)').hide();
            $('#footer-intro-cv-job').addClass('minimize');
            $('.widget.show_footer_intro_cv_job').removeClass('b_0');
         } else {
            $('.main-intro-cv-image').show();
            $('.intro-headline:not(.intro-headline-first)').show();
            $('#footer-intro-cv-job').removeClass('minimize');
            $('.widget.show_footer_intro_cv_job').addClass('b_0');
         }
      });
   });
   </script>
</body>

</html>