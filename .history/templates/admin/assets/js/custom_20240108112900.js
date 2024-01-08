//Hiển thị số lượng sản phẩm test
let renderQuantityCheck = document.querySelector("#render-quantity-check span");
let quantityDeliver = document.getElementById("quantity_deliver");
let quantityInspect = document.querySelector("[name='quantity_inspect']");

if (quantityDeliver !== null) {
  if (quantityDeliver.value != "") {
    renderQuantityCheck.innerHTML = AQL(quantityDeliver.value)["simpleSize"];
    quantityInspect.value = AQL(quantityDeliver.value)["simpleSize"];
    handelResult(AQL(quantityDeliver.value));
  }
}

if (quantityDeliver !== null) {
  quantityDeliver.addEventListener("change", function () {
    renderQuantityCheck.innerHTML = AQL(quantityDeliver.value)["simpleSize"];
    quantityInspect.value = AQL(quantityDeliver.value)["simpleSize"];
    handelResult(AQL(quantityDeliver.value));
  });
  quantityDeliver.addEventListener("keyup", function () {
    renderQuantityCheck.innerHTML = AQL(quantityDeliver.value)["simpleSize"];
    quantityInspect.value = AQL(quantityDeliver.value)["simpleSize"];
    handelResult(AQL(quantityDeliver.value));
  });
}

function AQL(quantityDeliver) {
  let simpleSize = "";
  let majorDefects = null;
  let minorDefects = null;

  if (quantityDeliver >= 2 && quantityDeliver <= 8) {
    simpleSize = 2;
    majorDefects = 0;
    minorDefects = 0;
  } else if (quantityDeliver > 8 && quantityDeliver <= 15) {
    simpleSize = 3;
    majorDefects = 0;
    minorDefects = 0;
  } else if (quantityDeliver > 15 && quantityDeliver <= 25) {
    simpleSize = 5;
    majorDefects = 0;
    minorDefects = 1;
  } else if (quantityDeliver > 25 && quantityDeliver <= 50) {
    simpleSize = 8;
    majorDefects = 1;
    minorDefects = 1;
  } else if (quantityDeliver > 50 && quantityDeliver <= 90) {
    simpleSize = 13;
    majorDefects = 1;
    minorDefects = 1;
  } else if (quantityDeliver > 90 && quantityDeliver <= 150) {
    simpleSize = 20;
    majorDefects = 1;
    minorDefects = 2;
  } else if (quantityDeliver > 150 && quantityDeliver <= 280) {
    simpleSize = 32;
    majorDefects = 2;
    minorDefects = 3;
  } else if (quantityDeliver > 280 && quantityDeliver <= 500) {
    simpleSize = 50;
    majorDefects = 5;
    minorDefects = 3;
  } else if (quantityDeliver > 500 && quantityDeliver <= 1200) {
    simpleSize = 80;
    majorDefects = 5;
    minorDefects = 7;
  } else if (quantityDeliver > 1200 && quantityDeliver <= 3200) {
    simpleSize = 125;
    majorDefects = 7;
    minorDefects = 10;
  } else if (quantityDeliver > 3200 && quantityDeliver <= 10000) {
    simpleSize = 200;
    majorDefects = 10;
    minorDefects = 14;
  } else if (quantityDeliver > 10000 && quantityDeliver <= 35000) {
    simpleSize = 315;
    majorDefects = 14;
    minorDefects = 21;
  } else if (quantityDeliver > 35000 && quantityDeliver <= 150000) {
    simpleSize = 500;
    majorDefects = 21;
    minorDefects = 21;
  } else if (quantityDeliver > 150000 && quantityDeliver <= 500000) {
    simpleSize = 800;
    majorDefects = 21;
    minorDefects = 21;
  } else if (quantityDeliver > 500000) {
    simpleSize = 1250;
    majorDefects = 21;
    minorDefects = 21;
  }

  return {
    simpleSize: simpleSize,
    majorDefects: majorDefects,
    minorDefects: minorDefects,
  };
}

//Xử lý mức độ lỗi
let levelDefectElement = document.querySelector("#level");
let unit = document.querySelector("#unit");
let heavy = document.querySelector("#heavy");
let light = document.querySelector("#light");

if (levelDefectElement !== null) {
  levelDefectElement.addEventListener("change", (e) => {
    if (e.target.value == "Có điều kiện") {
      unit.removeAttribute("disabled");
      heavy.removeAttribute("disabled");
      light.removeAttribute("disabled");
    } else {
      unit.setAttribute("disabled", "disabled");
      heavy.setAttribute("disabled", "disabled");
      light.setAttribute("disabled", "disabled");
    }
  });
}

//Xử lý hiển thị danh sách danh mục theo lỗi và ngược lại
let cateDefect = document.querySelector("#cate_defect");
let defect = document.querySelector("#defect");

if (cateDefect != null) {
  cateDefect.addEventListener("change", () => {
    let url = `${rootUrlAdmin}?module=reports&action=handle_defect_cate&cate_id=${cateDefect.value}`;
    console.log(url);
    $.ajax({
      url: url,
      method: "GET",
      success: function (response) {
        try {
          let listDefects = JSON.parse(response);
          let html = "<option value=0>Chọn tên lỗi</option>";
          listDefects.forEach((item) => {
            html += `<option value=${item["id"]}>${item["name"]}</option>`;
          });
          defect.innerHTML = html;
        } catch (error) {
          console.log(response);
        }
      },
      error: function (xhr, status, err) {
        console.log("Error Ajax:", err);
      },
    });
  });
}
if (defect != null) {
  defect.addEventListener("change", () => {
    let url = `${rootUrlAdmin}?module=reports&action=handle_defect_cate&defect_id=${defect.value}`;
    // console.log(url);
    $.ajax({
      url: url,
      method: "GET",
      success: function (response) {
        try {
          let listCateDefects = JSON.parse(response);
          let html = "";
          if (listCateDefects.length == undefined) {
            html = `<option value = ${listCateDefects["cate_id"]}>${listCateDefects["cate_name"]}</option>`;
          } else {
            html = "<option value=0>Chọn danh mục lỗi</option>";
            listCateDefects.forEach((item) => {
              html += `<option value=${item["id"]}>${item["name"]}</option>`;
            });
          }
          // console.log(listCateDefects);
          cateDefect.innerHTML = html;
        } catch (error) {
          console.log(error);
        }
      },
      error: function (xhr, status, err) {
        console.log("Error Ajax:", err);
      },
    });
  });
}

//Xử lý khi bấm nút thêm
let quantityDefect = document.querySelector("#defect_quantity");
let fileAdd = document.querySelector("#file");
let note = document.querySelector("#note");
let quantityDefectSpan = document.querySelector("#defect_quantity + span");
let errorCate = document.querySelector("#error-cate");
let errorDefect = document.querySelector("#error-defect");
let btnAddDefect = document.querySelector("#btnAddDefect");
let reportIdElement = document.querySelector('[name="id"]');
let contentTable = document.querySelector("#content-table");

let reportId = null;
if (reportIdElement != null) {
  reportId = reportIdElement.value;
}
if (btnAddDefect != null) {
  btnAddDefect.addEventListener("click", (e) => {
    e.preventDefault();
    $.ajax({
      url: `${rootUrlAdmin}?module=reports&action=get_session`,
      method: "POST",
      data: { report_id: reportId },
      success: (data) => {
        data = JSON.parse(data);
        let mathDefectError = false;
        for (let i = 0; i < data.length; i++) {
          if (data[i]["defect_id"] == defect.value) {
            mathDefectError = true;
            break;
          }
        }
        handelFormSubmit(mathDefectError);
      },
      error: (e) => {
        console.log(e);
      },
    });
  });
}

function handelFormSubmit(mathDefectError) {
  let isErrorCate = false;
  let isErrorDefect = false;
  let isErrorQuantity = false;
  if (cateDefect.value == 0) {
    errorCate.innerHTML = "Vui lòng chọn danh mục lỗi";
    isErrorCate = true;
  } else {
    errorCate.innerHTML = "";
    isErrorCate = false;
  }

  if (defect.value == 0) {
    errorDefect.innerHTML = "Vui lòng chọn lỗi";
    isErrorDefect = true;
  } else if (mathDefectError) {
    errorDefect.innerHTML = "Lỗi này đã có không thể chọn";
    isErrorDefect = true;
  } else {
    errorDefect.innerHTML = "";
    isErrorDefect = false;
  }
  if (quantityDefect.value == "") {
    quantityDefectSpan.innerHTML = "Số lượng lỗi không được bỏ trống";
    isErrorQuantity = true;
  } else {
    let numberRegex = /^[0-9]+$/;
    if (!numberRegex.test(quantityDefect.value)) {
      quantityDefectSpan.innerHTML = "Số lượng lỗi phải là số";
      isErrorQuantity = true;
    } else {
      quantityDefectSpan.innerHTML = "";
      isErrorQuantity = false;
    }
  }

  var formData = new FormData();
  var files = fileAdd.files;

  for (var i = 0; i < files.length; i++) {
    formData.append("files[]", files[i]);
  }
  formData.append("cate_id", cateDefect.value);
  formData.append("defect_id", defect.value);
  formData.append("defect_quantity", quantityDefect.value);
  formData.append("note", note.value);
  formData.append("report_id", reportId);

  if (!isErrorCate && !isErrorDefect && !isErrorQuantity) {
    url = `${rootUrlAdmin}?module=reports&action=handle_add`;
    $.ajax({
      url: url,
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        let sumCriticalDefects = 0;
        let sumMajorDefects = 0;
        let sumMinorDefects = 0;

        data = JSON.parse(data);
        html = "";
        let count = 0;
        for (let index in data) {
          count++;
          if (data[index]["skip"] == 0) {
            if (data[index]["level"] === "Nghiêm trọng") {
              sumCriticalDefects += +data[index]["defect_quantity"];
            }
            if (
              getLevelReportDefect(
                data[index]["defect_quantity"],
                data[index]["level"]
              ) === "Nặng"
            ) {
              sumMajorDefects += +data[index]["defect_quantity"];
            }
            if (
              getLevelReportDefect(
                data[index]["defect_quantity"],
                data[index]["level"]
              ) === "Nhẹ"
            ) {
              sumMinorDefects += +data[index]["defect_quantity"];
            }
          }
          html += `<tr>
            <td>${count}</td>
            <td>${data[index]["name"]}</td>
            <td>${getLevelReportDefect(
              data[index]["defect_quantity"],
              data[index]["level"]
            )}</td>
            <td>
              ${data[index]["cate_defect_name"]}
            </td>
            <td>
              ${data[index]["defect_quantity"]}
            </td>
            <td>
              ${data[index]["note"]}
            </td>
            <td>
              ${data[index]["create_at"]}
            </td>
            <td>
              <a class="btn btn-success" href="${rootUrlAdmin}?module=reports&action=seen_images_report_defect&report_id=${reportId}&key=${index}">
                  <i class="far fa-eye"></i>
              </a>
            </td>
            <td>
              <a class="btn btn-danger" href="${rootUrlAdmin}?module=reports&action=report_defect_delete&report_id=${reportId}&key=${index}" onclick="confirm('Bạn có chắc chắn muốn xóa lỗi này ?')">
                  <i class="fa fa-trash"></i>
              </a>
            </td>
          </tr>`;
        }
        contentTable.innerHTML = html;
        document.querySelector("#sumCriticalDefects").innerHTML =
          sumCriticalDefects;
        document.querySelector("#sumMajorDefects").innerHTML = sumMajorDefects;
        document.querySelector("#sumMinorDefects").innerHTML = sumMinorDefects;
        resetForm();
      },
      error: function (xhr, status, err) {
        console.log("Add error:", err);
      },
    });
  }
}

function resetForm() {
  resetDefect();
  resetCateDefect();
  quantityDefect.value = "";
  fileAdd.value = "";
  note.value = "";
}

function resetDefect() {
  if (defect != null) {
    $.ajax({
      url: `${rootUrlAdmin}?module=reports&action=get_all_defect`,
      success: (data) => {
        let listDefects = JSON.parse(data);
        let html = "<option value=0>Chọn tên lỗi</option>";
        listDefects.forEach((item) => {
          html += `<option value=${item["id"]}>${item["name"]}</option>`;
        });
        defect.innerHTML = html;
      },
    });
  }
}

function resetCateDefect() {
  if (cateDefect != null) {
    $.ajax({
      url: `${rootUrlAdmin}?module=reports&action=get_all_cate_defect`,
      success: (data) => {
        let listCateDefects = JSON.parse(data);
        let html = "<option value=0>Chọn tên danh mục lỗi</option>";
        listCateDefects.forEach((item) => {
          html += `<option value=${item["id"]}>${item["name"]}</option>`;
        });
        cateDefect.innerHTML = html;
      },
    });
  }
}

//Xử lý xuất PDF
$(document).ready(function () {
  let listReports = $(".export");
  if (listReports != null) {
    listReports.each(function () {
      $(this).click(function (e) {
        e.preventDefault();
        let link = $(this).attr("href");
        $.ajax({
          url: link,
          method: "POST",
          success: function (response) {
            exportPDF(response);
          },
          error: function () {
            console.log("Lỗi khi xuất file PDF");
          },
        });
      });
    });
  }
});

window.jsPDF = window.jspdf.jsPDF;

function exportPDF(htmlContent) {
  const doc = new jsPDF("p", "mm", "a4"); // Tạo một trang PDF mới với kích thước A4

  const container = document.createElement("div");
  container.innerHTML = htmlContent;
  document.body.appendChild(container);

  const htmlElements = container.querySelectorAll(".content-pdf");

  const promises = Array.from(htmlElements).map((element) => {
    let elementHeight = element.clientHeight;
    //Chuyển đổi về cùng đơn vị mm
    const mmPerPixel = 0.264583;
    elementHeight = elementHeight * mmPerPixel;
    return html2canvas(element).then(function (canvas) {
      const imgData = canvas.toDataURL("image/png");
      doc.addImage(imgData, "PNG", 10, 10, 190, 0);
      doc.addPage();
    });
  });

  // Đợi cho tất cả các hình ảnh được tạo thành công
  Promise.all(promises)
    .then(() => {
      // Lưu tệp PDF
      doc.save("file.pdf"); // Sử dụng saveAs thay vì save
      document.body.removeChild(container);
    })
    .catch((error) => {
      console.error("Lỗi khi tạo tệp PDF:", error);
      document.body.removeChild(container);
    });
}

function getLevelString(level) {
  try {
    let levelData = JSON.parse(level);
    let unit = levelData.unit;
    let conditions = levelData.conditions;
    let resultString = "";
    for (let i = 0; i < conditions.length; i++) {
      let name = conditions[i].name;
      let condition = conditions[i].condition;
      let value = conditions[i].value;

      if (condition === "<=") {
        condition = "≤";
      }

      resultString +=
        name + " " + condition + " " + value + " " + unit + "<br>";
    }
    return resultString;
  } catch (error) {
    return level;
  }
}

function getLevelReportDefect($defect_quantity, level) {
  try {
    let levelData = JSON.parse(level);
    let conditions = levelData.conditions;
    for (let i = 0; i < conditions.length; i++) {
      let name = conditions[i].name;
      let condition = conditions[i].condition;
      let value = conditions[i].value;

      if (condition === "<=") {
        if ($defect_quantity <= value) {
          return name;
        }
      }
      if (condition === ">") {
        if ($defect_quantity > value) {
          return name;
        }
      }
    }
  } catch (error) {
    return level;
  }
}

function handelResult(AQL) {
  // Lây ra số lỗi cho phép
  let majorDefects = AQL["majorDefects"];
  let minorDefects = AQL["minorDefects"];
  // Lấy ra số lỗi thực tế
  let sumCriticalDefects = Number(
    document.querySelector("#sumCriticalDefects").innerHTML
  );
  let sumMajorDefects = Number(
    document.querySelector("#sumMajorDefects").innerHTML
  );
  let sumMinorDefects = Number(
    document.querySelector("#sumMinorDefects").innerHTML
  );

  // Tính xem đạt hay không đạt
  let resultAQL = true;
  if (
    sumCriticalDefects > 0 ||
    sumMajorDefects > majorDefects ||
    sumMinorDefects > minorDefects
  ) {
    resultAQL = false;
  }
  // innerHTML
  document.querySelector("#majorDefects").innerHTML = majorDefects;
  document.querySelector("#minorDefects").innerHTML = minorDefects;
  if (resultAQL) {
    document.querySelector("#achieve").innerHTML = `<i
    class="far fa-check-square mr-2"></i>ĐẠT`;
    document.querySelector("#not-achieve").innerHTML = `<i
    class="far fa-square mr-2"></i>KHÔNG ĐẠT`;
  } else {
    document.querySelector("#achieve").innerHTML = `<i
    class="far fa-square mr-2"></i>ĐẠT`;
    document.querySelector("#not-achieve").innerHTML = `<i
    class="far fa-check-square mr-2"></i>KHÔNG ĐẠT`;
  }
}

//sign
$(function () {
  var sign = $("#signature").signature({
    syncField: "#sign-text",
    syncFormat: "PNG",
  });
  var signText = $("#sign-text");
  var signTextVal = signText.val();
  if (signTextVal) {
    $("#signature")
      .signature("enable")
      .signature("draw", signTextVal)
      .signature("disable");
    $("#disable").text("Chỉnh sửa");
  }
  $("#disable").click(function (e) {
    e.preventDefault();
    var disable = $(this).text() === "Xác nhận";
    $(this).text(disable ? "Chỉnh sửa" : "Xác nhận");
    sign.signature(disable ? "disable" : "enable");
  });
  $("#clear").click(function (e) {
    e.preventDefault();
    sign.signature("clear");
    signText.val("");
  });
});

//sign trang seen
//sign nhà gia công

$(function () {
  var sign = $("#sign_GC").signature({
    syncField: "#sign-text_GC",
    syncFormat: "PNG",
  });

  var signText = $("#sign-text_GC");
  var signTextVal = signText.val();
  if (signTextVal) {
    $("#sign_GC")
      .signature("enable")
      .signature("draw", signTextVal)
      .signature("disable");
    $("#disable_GC").text("Chỉnh sửa");
  }

  $("#disable_GC").click(function (e) {
    e.preventDefault();
    // Xác nhận -> chỉnh sửa khi đủ thông tin
    var disable = $(this).text() === "Xác nhận";
    $(this).text(disable ? "Chỉnh sửa" : "Xác nhận");
    sign.signature(disable ? "disable" : "enable");
    // console.log(disable);
    if (disable) {
      //xử lý trường hợp input tự động set giá trị default khi bấm chỉnh sửa mà không có thay đổi gì, lấy giá trị đang có trong sign, vì nó tự động set giá trị ban đầu là rỗng nên khi chỉnh sửa mà k thay đổi thì sẽ thành hình rỗng
      var signatureData = sign.signature("toDataURL");
      $("#fullname_GC").prop("disabled", true);

      if (validateSignGC()) {
        let fullname = $("#fullname_GC").val();

        //Hiển thị chữ ký sau khi Xác nhận hợp lệ
        if (signatureData) {
          // Thời gian hiện tại
          var currentDate = new Date();

          var day = currentDate.getDate();
          var month = currentDate.getMonth() + 1; // Ghi chú: Tháng bắt đầu từ 0 (0 - 11)
          var year = currentDate.getFullYear();
          var hours = currentDate.getHours();
          var minutes = currentDate.getMinutes();
          var seconds = currentDate.getSeconds();

          // Định dạng lại chuỗi ngày tháng năm
          var formattedDate = day + "-" + month + "-" + year;

          // Định dạng lại chuỗi giờ phút giây
          var formattedTime = hours + ":" + minutes + ":" + seconds;

          // Kết hợp chuỗi ngày tháng và chuỗi giờ phút giây
          var dateTime = formattedDate + " " + formattedTime;

          let html = `
        <img src="${signatureData}" alt="" class="sign"><p class="d-block text-center mt-2">${fullname}</p><p class="d-block text-center">${dateTime}</p> 
        `;
          // console.log(html);
          document.getElementById("sign_GC_content").innerHTML = html;
        }

        //lưu fullname, sign GC vào csdl
        let reportIdSign = document.getElementById("report_id").value;
        let link = `http://localhost/KimDuc/radix/admin/?module=users&action=quick_sign&report_id=${reportIdSign}`;
        let data = { fullname: fullname, sign: signatureData };
        $.ajax({
          url: link,
          method: "POST",
          data: data,
          success: function (response) {
            // console.log(response);
          },
          error: function () {
            console.log("Lỗi lưu chữ ký cơ sở gia công");
          },
        });
      }
    } else {
      $("#fullname_GC").removeAttr("disabled");
    }
  });

  $("#clear_GC").click(function (e) {
    e.preventDefault();
    var disable = $("#disable_GC").text() === "Xác nhận";
    if (disable) {
      sign.signature("clear");
      signText.val("");
      $("#fullname_GC").val("");
      $("#error_sign_GC").text("");
      $("#error_fullname_GC").text("");
    }
  });
});

function validateSignGC() {
  let errorSign = document.getElementById("error_sign_GC");
  let errorFullname = document.getElementById("error_fullname_GC");
  let signInput = document.getElementById("sign-text_GC");
  let fullnameInput = document.getElementById("fullname_GC");
  let valueSign = signInput.value;
  let valueFullname = fullnameInput.value;
  let check = true;
  if (errorSign != undefined) {
    if (valueSign == "") {
      errorSign.innerText = "Hãy ký và xác nhận";
      check = false;
    } else {
      errorSign.innerText = "";
    }
  }
  if (errorFullname != undefined) {
    if (valueFullname == "") {
      errorFullname.innerText = "Vui lòng nhập họ tên đầy đủ";
      check = false;
    } else {
      errorFullname.innerText = "";
    }
  }
  return check;
}

function loadNotifications() {
  $.ajax({
    url: "http://localhost/KimDuc/radix/admin/?module=users&action=notifications",
    method: "POST",
    data: { list: true },
    success: function (data) {
      document.getElementById("notification").innerHTML = data;
    },
    error: function (error) {},
  });
}
function loadCountNotifications() {
  setInterval(function () {
    $.ajax({
      url: "http://localhost/KimDuc/radix/admin/?module=users&action=notifications",
      method: "POST",
      data: { count: true },
      success: function (data) {
        document.getElementById("count_notification").innerHTML = data;
      },
      error: function (error) {},
    });
  }, 1000);
}
loadCountNotifications();

document.getElementById("notification_click").addEventListener("click", () => {
  loadNotifications();
});

//Xử lý phân quyền
var permissionObj = document.querySelector(".permission-list");
if (permissionObj != null) {
  var allowArr = ["add", "edit", "delete", "permission"];
  var listTr = document.querySelectorAll("tr");
  if (listTr != null) {
    listTr.forEach(function (item) {
      var listInput = item.querySelectorAll('input[type="checkbox"]');
      if (listInput != null) {
        listInput.forEach((input) => {
          input.addEventListener("click", () => {
            let valueInput = input.value;
            if (valueInput.trim() !== "" && allowArr.includes(valueInput)) {
              let listsObj = item.querySelector('input[value="lists"]');
              if (listsObj != null) {
                listsObj.checked = true;
              }
            } else if (valueInput == "lists") {
              if (input.checked == false) {
                listInput.forEach((itemInput) => {
                  if (itemInput.value != "lists") {
                    itemInput.checked = false;
                  }
                });
              }
            }
          });
        });
      }
    });
  }
}

//Xử lý báo cáo thống kê
var typeTimeObj = document.getElementById("type_time");
var monthObj = document.getElementById("month");
typeTimeObj.addEventListener("change", () => {
  let value = typeTimeObj.value;
  if (value == 2) {
    monthObj.disabled = true;
  } else {
    monthObj.disabled = false;
  }
});

function validateStatisticalReports() {
  var typeTimeObj = document.getElementById("type_time");
  var objectObj = document.getElementById("object");
  var monthObj = document.getElementById("month");
  var yearObj = document.getElementById("year");

  var valueType = typeTimeObj.value;
  var valueObj = objectObj.value;
  var valueMonth = monthObj.value;
  var valueYear = yearObj.value;

  let errors;

  if (valueType == 0) {
    errors.type_time = {};
    errors.type_time.required = "Chưa chọn loại thời gian";
  }

  if (valueObj == 0) {
    errors["object"]["required"] = "Chưa chọn loại đối tượng";
  }

  if (valueType == 1) {
    if (valueMonth == 0) {
      errors["month"]["required"] = "Chưa chọn tháng";
    }
    if (valueYear == 0) {
      errors["year"]["required"] = "Chưa chọn năm";
    }
  }

  if (valueType == 2) {
    if (valueYear == 0) {
      errors["year"]["required"] = "Chưa chọn năm";
    }
  }

  console.log($errors);
}

validateStatisticalReports();
