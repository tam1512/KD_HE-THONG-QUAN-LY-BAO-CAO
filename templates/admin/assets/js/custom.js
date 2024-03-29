let isDeBug = true;

//Hiển thị số lượng sản phẩm test
let renderQuantityCheck = document.querySelector("#render-quantity-check span");
let quantityDeliver = document.getElementById("quantity_deliver");
let quantityInspect = document.querySelector("[name='quantity_inspect']");

if (
  renderQuantityCheck != null &&
  quantityDeliver != null &&
  quantityInspect != null
) {
  if (quantityDeliver.value != "") {
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
    renderQuantityCheck.innerHTML = AQL(quantityDeliver.value)["simpleSize"];
    quantityInspect.value = AQL(quantityDeliver.value)["simpleSize"];
    handelResult(
      AQL(quantityDeliver.value),
      sumCriticalDefects,
      sumMajorDefects,
      sumMinorDefects
    );
  }

  quantityDeliver.addEventListener("change", function () {
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
    renderQuantityCheck.innerHTML = AQL(quantityDeliver.value)["simpleSize"];
    quantityInspect.value = AQL(quantityDeliver.value)["simpleSize"];
    handelResult(
      AQL(quantityDeliver.value),
      sumCriticalDefects,
      sumMajorDefects,
      sumMinorDefects
    );
  });
  quantityDeliver.addEventListener("keyup", function () {
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
    renderQuantityCheck.innerHTML = AQL(quantityDeliver.value)["simpleSize"];
    quantityInspect.value = AQL(quantityDeliver.value)["simpleSize"];
    handelResult(
      AQL(quantityDeliver.value),
      sumCriticalDefects,
      sumMajorDefects,
      sumMinorDefects
    );
  });
}

let renderCodeReport = document.querySelector("#render-code-report span");
let pxElement = document.getElementById("PX");
let codeReportElement = document.querySelector('input[name="code_report"]');

if (
  renderCodeReport != null &&
  pxElement != null &&
  codeReportElement != null
) {
  let url = `${rootUrlAdmin}?module=reports&action=create_code_report`;

  if (pxElement.value != "") {
    $.ajax({
      url: url,
      method: "POST",
      data: { px: pxElement.value },
      success: function (data) {
        renderCodeReport.innerText = data;
        codeReportElement.value = data;
      },
    });
  }

  pxElement.addEventListener("change", () => {
    $.ajax({
      url: url,
      method: "POST",
      data: { px: pxElement.value },
      success: function (data) {
        renderCodeReport.innerText = data;
        codeReportElement.value = data;
      },
    });
  });
  pxElement.addEventListener("keyup", () => {
    $.ajax({
      url: url,
      method: "POST",
      data: { px: pxElement.value },
      success: function (data) {
        renderCodeReport.innerText = data;
        codeReportElement.value = data;
      },
    });
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

  if (simpleSize == "") {
    simpleSize = 0;
    majorDefects = 0;
    minorDefects = 0;
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

if (
  levelDefectElement !== null &&
  unit != null &&
  heavy != null &&
  light != null
) {
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

//Xử lý hiển thị mức độ lỗi theo lỗi
let defectElement = document.getElementById("defect");
let levelElement = document.getElementById("level");
let idDefectOrder = document.getElementById("idDefectOrder");

if (defectElement != null && levelElement != null) {
  if (idDefectOrder != null) {
    let valueIdDefectOrder = idDefectOrder.value;
    let url = `${rootUrlAdmin}?module=reports&action=get_level`;
    defectElement.addEventListener("change", function () {
      let valueDefect = defectElement.value;
      if (valueIdDefectOrder != valueDefect) {
        $.ajax({
          url: url,
          method: "POST",
          data: { defectId: valueDefect },
          success: function (data) {
            levelElement.value = data;
            levelElement.disabled = true;
          },
        });
      } else {
        levelElement.disabled = false;
      }
    });
  }
}

//Xử lý khi bấm nút thêm
let quantityDefect = document.querySelector("#defect_quantity");
let fileAdd = document.querySelector("#images_defect");
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
          if (
            data[i]["defect_id"] == defectElement.value &&
            defectElement.value != idDefectOrder.value
          ) {
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
  // var files = fileAdd.files;

  // for (var i = 0; i < files.length; i++) {
  //   formData.append("files[]", files[i]);
  // }
  formData.append("images_defect", fileAdd.value);
  formData.append("defect_id", defectElement.value);
  formData.append("defect_quantity", quantityDefect.value);
  formData.append("note", note.value);
  formData.append("report_id", reportId);

  if (defectElement.value == idDefectOrder.value) {
    formData.append("level", levelElement.value);
  }

  if (!isErrorCate && !isErrorDefect && !isErrorQuantity) {
    url = `${rootUrlAdmin}?module=reports&action=handle_add`;
    $.ajax({
      url: url,
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (data) {
        // console.log(data);
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
              <input type="number" class="form-control mw-80" name="${index}" value = "${
            data[index]["defect_quantity"]
          }"/>
            </td>
            <td class="defect-note">
              ${data[index]["note"]}
            </td>
            <td>
              ${data[index]["create_at"]}
            </td>
            <td>
              <a class="btn btn-success" href="${rootUrlAdmin}bien-ban/xem-anh-loi/id=${reportId}?key=${index}">
                  <i class="far fa-eye"></i>
              </a>
            </td>
            <td>
              <button class="btn btn-danger btnDeleteDefect" data-id="${reportId}" data-key="${index}">
                  <i class="fa fa-trash"></i>
              </button>
            </td>
          </tr>`;
        }
        contentTable.innerHTML = html;
        document.querySelector("#sumCriticalDefects").innerHTML =
          sumCriticalDefects;
        document.querySelector("#sumMajorDefects").innerHTML = sumMajorDefects;
        document.querySelector("#sumMinorDefects").innerHTML = sumMinorDefects;
        resetForm();
        // console.log(contentTable);
        changDefectQuantity(contentTable);

        handelResult(
          AQL(quantityDeliver.value),
          sumCriticalDefects,
          sumMajorDefects,
          sumMinorDefects
        );
      },
      error: function (xhr, status, err) {
        console.log("Add error:", err);
      },
    });
  }
}

function resetForm() {
  quantityDefect.value = "";
  fileAdd.value = "";
  note.value = "";
}

function changDefectQuantity(contentTable) {
  //Xử lý khi input number của defect trong trang add hoặc edit thay đổi cập nhật lại session
  if (contentTable != null) {
    let listTrTable = contentTable.querySelectorAll("tr");
    if (listTrTable != null && listTrTable.length > 0) {
      listTrTable.forEach((item) => {
        let inputNumber = item.querySelector('input[type="number"]');
        if (inputNumber != null) {
          inputNumber.addEventListener("change", () => {
            let key = inputNumber.name;
            let defect_quantity = inputNumber.value;
            // console.log(defect_quantity);
            let url = `${rootUrlAdmin}?module=reports&action=chang_defect_quantity_input`;

            $.ajax({
              url: url,
              method: "POST",
              data: {
                key: key,
                defect_quantity: defect_quantity,
                report_id: reportId,
              },
              success: function (data) {
                data = JSON.parse(data);
                $("#sumCriticalDefects").text(data["sumCriticalDefects"]);
                $("#sumMajorDefects").text(data["sumMajorDefects"]);
                $("#sumMinorDefects").text(data["sumMinorDefects"]);

                handelResult(
                  AQL(quantityDeliver.value),
                  data["sumCriticalDefects"],
                  data["sumMajorDefects"],
                  data["sumMinorDefects"]
                );
              },
            });
          });
        }
      });
    }
  }
}
changDefectQuantity(contentTable);

function deleteDefect(contentTable) {
  //Xử lý khi input number của defect trong trang add hoặc edit thay đổi cập nhật lại session
  if (contentTable != null) {
    let listTrTable = contentTable.querySelectorAll("tr");
    if (listTrTable != null && listTrTable.length > 0) {
      listTrTable.forEach((item) => {
        let btnDelete = item.querySelector(".btnDeleteDefect");
        if (btnDelete != null) {
          btnDelete.addEventListener("click", (e) => {
            e.preventDefault();
            let isDelete = confirm("Bạn có chắc chắn muốn xóa lỗi này ?");
            if (isDelete) {
              let id = btnDelete.getAttribute("data-id");
              let key = btnDelete.getAttribute("data-key");
              let url = `${rootUrlAdmin}?module=reports&action=report_defect_delete`;

              $.ajax({
                url: url,
                method: "POST",
                data: {
                  key,
                  id,
                },
                success: function (data) {
                  let sumCriticalDefects = 0;
                  let sumMajorDefects = 0;
                  let sumMinorDefects = 0;
                  console.log(data);
                  data = JSON.parse(data);
                  // console.log(data);
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

                    if (index != "empty") {
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
                                    <input type="number" class="form-control mw-80" name="${index}" value = "${
                        data[index]["defect_quantity"]
                      }"/>
                                </td>
                                <td class="defect-note">
                                    ${data[index]["note"]}
                                </td>
                                <td>
                                    ${data[index]["create_at"]}
                                </td>
                                <td>
                                    <a class="btn btn-success" href="${rootUrlAdmin}bien-ban/xem-anh-loi/id=${reportId}?key=${index}">
                                        <i class="far fa-eye"></i>
                                    </a>
                                </td>
                                <td>
                                    <button class="btn btn-danger btnDeleteDefect" data-id="${reportId}" data-key="${index}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                                </tr>`;
                    }
                  }
                  if (html == "") {
                    html = `<tr>
                    <td colspan="10" class="text-center alert alert-danger">Không có lỗi</td>
                 </tr>`;
                  }
                  contentTable.innerHTML = html;
                  document.querySelector("#sumCriticalDefects").innerHTML =
                    sumCriticalDefects;
                  document.querySelector("#sumMajorDefects").innerHTML =
                    sumMajorDefects;
                  document.querySelector("#sumMinorDefects").innerHTML =
                    sumMinorDefects;
                  // console.log(contentTable);
                  changDefectQuantity(contentTable);
                  deleteDefect(contentTable);
                  handelResult(
                    AQL(quantityDeliver.value),
                    sumCriticalDefects,
                    sumMajorDefects,
                    sumMinorDefects
                  );
                },
              });
            }
          });
        }
      });
    }
  }
}
deleteDefect(contentTable);

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

function handelResult(
  AQL,
  sumCriticalDefects,
  sumMajorDefects,
  sumMinorDefects
) {
  // console.log(AQL);
  // Lây ra số lỗi cho phép
  let majorDefects = AQL["majorDefects"];
  let minorDefects = AQL["minorDefects"];

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

// console.log($("#signature").signature("toDataURL"))

//sign
$(function () {
  if ($("#signature") != null) {
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

      if (disable) {
        //xử lý trường hợp input tự động set giá trị default khi bấm chỉnh sửa mà không có thay đổi gì, lấy giá trị đang có trong sign, vì nó tự động set giá trị ban đầu là rỗng nên khi chỉnh sửa mà k thay đổi thì sẽ thành hình rỗng
        var signatureData = sign.signature("toDataURL");
        if (signText.val() != "") {
          $('[name="sign_text"').val(signatureData);
        }
      }
    });
    $("#clear").click(function (e) {
      e.preventDefault();
      var disable = $("#disable").text() === "Xác nhận";
      // console.log(disable);
      if (disable) {
        sign.signature("clear");
        signText.val("");
        $('[name="sign_text"').val("");
      }
    });
  }
});

//sign trang seen
//sign nhà gia công

$(function () {
  if ($("#sign_GC") != null) {
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
      let fullname = $("#fullname_GC").val();
      // Xác nhận -> chỉnh sửa khi đủ thông tin
      var disable = $(this).text() === "Xác nhận" && fullname != "";
      if (!disable) {
        validateSignGC();
      }

      $(this).text(disable ? "Chỉnh sửa" : "Xác nhận");
      sign.signature(disable ? "disable" : "enable");
      // console.log(disable);
      if (disable) {
        validateSignGC();
        //xử lý trường hợp input tự động set giá trị default khi bấm chỉnh sửa mà không có thay đổi gì, lấy giá trị đang có trong sign, vì nó tự động set giá trị ban đầu là rỗng nên khi chỉnh sửa mà k thay đổi thì sẽ thành hình rỗng
        var signatureData = sign.signature("toDataURL");
        $("#fullname_GC").prop("disabled", true);

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
        let reportIdSign = document.getElementById("id").value;
        let link = `${rootUrlAdmin}?module=reports&action=quick_sign&id=${reportIdSign}`;
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
  }
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

//xử lý thông báo
function loadNotifications() {
  $.ajax({
    url: `${rootUrlAdmin}?module=reports&action=notifications`,
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
      url: `${rootUrlAdmin}?module=reports&action=notifications`,
      method: "POST",
      data: { count: true },
      success: function (data) {
        document.getElementById("count_notification").innerHTML = data;
      },
      error: function (error) {},
    });
  }, 1000);
}
function showToast() {
  setInterval(function () {
    $.ajax({
      url: `${rootUrlAdmin}?module=reports&action=notifications`,
      method: "POST",
      data: { toast: true },
      success: function (data) {
        $("#toast-content").html(data);
        $(".toast").each(function () {
          $(this).toast("show");
        });
      },
      error: function (error) {},
    });
  }, 5000);
}

loadCountNotifications();
showToast();
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
var btnCreateChart = document.getElementById("btnCreateChart");
let isChart = false;
//điều kiện cho chart đầu hiển thị đầu tiên
let conditionDefault = {
  valueObj: "all",
  valueType: 1,
  valueMonth: new Date().getMonth() + 1,
  valueYear: new Date().getFullYear(),
  valueSkip: 1,
  valueFull: 0,
};
if (btnCreateChart != null) {
  renderChart(conditionDefault, true);
}
if (typeTimeObj != null) {
  typeTimeObj.addEventListener("change", () => {
    let value = typeTimeObj.value;
    if (value == 2 || value == 3) {
      monthObj.disabled = true;
    } else {
      monthObj.disabled = false;
    }
  });
}
if (btnCreateChart != null) {
  btnCreateChart.addEventListener("click", function (e) {
    e.preventDefault();
    let condition = validateStatisticalReports();
    // console.log(condition);
    if (condition) {
      renderChart(condition);
    }
  });
}

function validateStatisticalReports() {
  var typeTimeObj = document.getElementById("type_time");
  var objectObj = document.getElementById("object");
  var monthObj = document.getElementById("month");
  var yearObj = document.getElementById("year");
  var skipObj = document.getElementById("skip-statistical");
  var fullObj = document.getElementById("full-statistical");

  var valueSkip = 0;
  var valueFull = 0;
  var valueType = typeTimeObj.value;
  var valueObj = objectObj.value;
  var valueMonth = monthObj.value;
  var valueYear = yearObj.value;

  if (skipObj.checked) {
    valueSkip = 1;
  }
  if (fullObj.checked) {
    valueFull = 1;
  }

  var errorType = document.getElementById("error-type");
  var errorObject = document.getElementById("error-object");
  var errorMonth = document.getElementById("error-month");
  var errorYear = document.getElementById("error-year");

  var check = true;

  if (valueType == 0) {
    errorType.innerText = "Chưa chọn loại thời gian";
    check = false;
  } else {
    errorType.innerText = "";
  }

  if (valueObj == 0) {
    errorObject.innerText = "Chưa chọn loại đối tượng";
    check = false;
  } else {
    errorObject.innerText = "";
  }

  if (valueType == 1) {
    if (valueMonth == 0) {
      errorMonth.innerText = "Chưa chọn tháng";
      check = false;
    } else {
      errorMonth.innerText = "";
    }
    if (valueYear == 0) {
      errorYear.innerText = "Chưa chọn năm";
      check = false;
    } else {
      errorYear.innerText = "";
    }
  }

  if (valueType == 2 || valueType == 3) {
    if (valueYear == 0) {
      errorYear.innerText = "Chưa chọn năm";
      check = false;
    } else {
      errorYear.innerText = "";
    }
  }

  if (check) {
    if (valueType == 1) {
      return {
        valueObj,
        valueType,
        valueMonth,
        valueYear,
        valueSkip,
        valueFull,
      };
    }
    if (valueType == 2 || valueType == 3) {
      return {
        valueObj,
        valueType,
        valueYear,
        valueSkip,
        valueFull,
      };
    }
  }
  return false;
}
function renderChart(condition, first = false) {
  // setup

  //Lấy dữ liệu theo điều kiện
  let url = `${rootUrlAdmin}?module=statistical_reports&action=get_data_chart`;
  $.ajax({
    url: url,
    data: { condition: condition, first: first },
    method: "POST",
    success: function (data) {
      // console.log(data);
      try {
        data = JSON.parse(data);
        // console.log(JSON.parse(data.dataTableExcel));
        //Chart
        $("#dataTableExcel").val(data.dataTableExcel);
        $("#chartBox").html(data.dataChart);
        let config = JSON.parse($("#myChart").data("settings"));
        $("#myChart").chart = new Chart($("#myChart"), config);

        //table
        $("#contentTable").html(data.dataTable);
      } catch (error) {}
    },
  });
}
// Xử lý Thay đổi status và suggest
let changeStatus = document.getElementById("chang_status");
let addSuggest = document.getElementById("add_suggest");
let btnAddSuggest = document.getElementById("btnAddSuggest");
let deduction = document.getElementById("deduction-content");
let deductionValue = null;
let deductionUnit = null;
//Xử lý khi chọn Nhận tiền trừ
if (changeStatus != null) {
  if (changeStatus.value == "4") {
    deduction.classList.remove("d-none");
  } else {
    deduction.classList.add("d-none");
  }
  changeStatus.addEventListener("change", function () {
    if (this.value == "4") {
      deduction.classList.remove("d-none");
    } else {
      deduction.classList.add("d-none");
    }
  });
}

if (btnAddSuggest && addSuggest && changeStatus) {
  btnAddSuggest.addEventListener("click", (e) => {
    e.preventDefault();
    let status = changeStatus.value;
    let suggest = addSuggest.value;
    let reportId = document.getElementById("id").value;
    deductionValue = document.getElementById("deduction").value;
    deductionUnit = document.getElementById("unit").value;

    let url = `${rootUrlAdmin}?module=reports&action=change_suggest_status`;
    let isContinue = true;

    if (changeStatus.value == 4) {
      if (deductionValue == "") {
        document.getElementById("deduction-error").innerHTML =
          "Vui lòng nhập số trừ tiền";
        isContinue = false;
      } else {
        document.getElementById("deduction-error").innerHTML = "";
      }
      if (deductionUnit == "") {
        document.getElementById("unit-error").innerHTML =
          "Vui lòng chọn đơn vị";
        isContinue = false;
      } else {
        document.getElementById("unit-error").innerHTML = "";
      }
    }

    if (isContinue == true) {
      $.ajax({
        url: url,
        method: "POST",
        data: {
          status: status,
          suggest: suggest,
          reportId: reportId,
          deductionValue: deductionValue,
          unit: deductionUnit,
        },
        success: function (data) {
          // console.log(data);
          if (data) {
            $("#content_suggest").text(suggest);
          }
        },
      });
    }
  });
}

function openCkfinderMulti() {
  let ckfinderChooseImages = document.querySelectorAll(
    ".ckfinder-choose-multi-image"
  );
  if (ckfinderChooseImages !== null) {
    ckfinderChooseImages.forEach((item) => {
      item.addEventListener("click", () => {
        let parentElementObject = item.parentElement;
        let parent = "ckfinder-group";
        while (parentElementObject) {
          if (parentElementObject.classList.contains(parent)) {
            break;
          } else {
            parentElementObject = parentElementObject.parentElement;
          }
        }

        let imageLink = parentElementObject.querySelector(".image-link");
        // console.log(imageLink)
        CKFinder.popup({
          chooseFiles: true,
          width: 800,
          height: 600,
          onInit: function (finder) {
            finder.on("files:choose", function (evt) {
              let fileUrls = evt.data.files
                .map((file) => file.getUrl())
                .map((element) => {
                  return rootUrl + element;
                });
              // Xử lý chèn các đường dẫn ảnh vào input hoặc làm gì đó với mảng fileUrls
              imageLink.value = fileUrls.join(", "); // Ví dụ: ghép các đường dẫn bằng dấu phẩy và khoảng trắng
            });
            finder.on("file:choose:resizedImage", function (evt) {
              let fileUrls = evt.data.resizedUrl.map((item) => {
                return rootUrl + item;
              });
              // Xử lý chèn các đường dẫn ảnh vào input hoặc làm gì đó với mảng fileUrls
              imageLink.value = fileUrls.join(", "); // Ví dụ: ghép các đường dẫn bằng dấu phẩy và khoảng trắng
            });
          },
        });
      });
    });
  }
}

openCkfinderMulti();

function openCkfinder() {
  let ckfinderChooseImages = document.querySelectorAll(
    ".ckfinder-choose-image"
  );
  if (ckfinderChooseImages !== null) {
    ckfinderChooseImages.forEach((item) => {
      item.addEventListener("click", () => {
        let parentElementObject = item.parentElement;
        let parent = "ckfinder-group";
        while (parentElementObject) {
          if (parentElementObject.classList.contains(parent)) {
            break;
          } else {
            parentElementObject = parentElementObject.parentElement;
          }
        }

        let imageLink = parentElementObject.querySelector(".image-link");

        CKFinder.popup({
          chooseFiles: true,
          width: 800,
          height: 600,
          onInit: function (finder) {
            finder.on("files:choose", function (evt) {
              let fileUrl = rootUrl + evt.data.files.first().getUrl();
              //Xử lý chèn link ảnh vào input
              imageLink.value = fileUrl;
            });
            finder.on("file:choose:resizedImage", function (evt) {
              let fileUrl = rootUrl + evt.data.resizedUrl;
              //Xử lý chèn link ảnh vào input
              imageLink.value = fileUrl;
            });
          },
        });
      });
    });
  }
}

openCkfinder();

//Xử lý thêm ảnh report_defect_images
let galleryImagesObject = document.querySelector(".gallery-images");
let btnAddImage = document.querySelector("#addImage");
let htmlGalleryItem = `
<div class="gallery-item mb-2">
  <div class="row ckfinder-group">
    <div class="col-9">
        <input type="text" id="gallery" name="gallery[]" class="form-control image-link"
          placeholder="Đường dẫn ảnh...">
    </div>
    <div class="col-2">
        <button type="button" class="btn btn-success btn-block ckfinder-choose-image">Chọn
          ảnh</button>
    </div>
    <div class="col-1">
        <button type="button" class="btn btn-danger btn-block btn-remove-image"><i
              class="fa fa-times"></i></button>
    </div>
  </div>
</div>`;

if (galleryImagesObject !== null && btnAddImage !== null) {
  btnAddImage.addEventListener("click", (e) => {
    e.preventDefault();
    let galleryItemHtmlNode = new DOMParser()
      .parseFromString(htmlGalleryItem, "text/html")
      .querySelector(".gallery-item");
    galleryImagesObject.appendChild(galleryItemHtmlNode);
    openCkfinder();
  });

  galleryImagesObject.addEventListener("click", function (e) {
    e.preventDefault();
    if (
      e.target.classList.contains("btn-remove-image") ||
      e.target.parentElement.classList.contains("btn-remove-image")
    ) {
      if (confirm("Bạn có chắc chắn muốn xóa?")) {
        let galleryItem = e.target;
        while (galleryItem) {
          galleryItem = galleryItem.parentElement;
          if (galleryItem.classList.contains("gallery-item")) {
            break;
          }
        }
        if (galleryItem !== null) {
          galleryItem.remove();
        }
      }
    }
  });
}

//Xử lý lưu giữ thông tin report add vào session add
let infoAdd = document.querySelector("#infoAdd");
if (infoAdd != null) {
  let listFormGroup = infoAdd.querySelectorAll(".form-group");
  if (listFormGroup != null && listFormGroup.length > 0) {
    listFormGroup.forEach((item) => {
      let formControl = item.querySelector(".form-control");
      if (formControl != null) {
        formControl.addEventListener("change", () => {
          let name = formControl.getAttribute("name");
          let value = formControl.value;
          let url = `${rootUrlAdmin}?module=reports&action=save_info_report_add`;

          $.ajax({
            url: url,
            method: "POST",
            data: {
              name,
              value,
            },
            success: function (data) {
              // console.log(data);
            },
          });
        });
      }
    });
  }
}

function clearConsole() {
  if (!isDeBug) {
    console.clear();
  }
}
clearConsole();
