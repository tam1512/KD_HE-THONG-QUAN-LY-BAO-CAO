/**
 * @license Copyright (c) 2003-2020, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function (config) {
  // Define changes to default configuration here. For example:
  // config.language = 'fr';
  // config.uiColor = '#AADC6E';
  console.log(config);
  config.filebrowserBrowseUrl =
    "/PHP/PHP_co_ban/module05/radix/templates/admin/assets/ckfinder/ckfinder.html";
  config.filebrowserImageBrowseUrl =
    "/PHP/PHP_co_ban/module05/radix/templates/admin/assets/ckfinder/ckfinder.html?type=Images";
  config.filebrowserUploadUrl =
    "/PHP/PHP_co_ban/module05/radix/templates/admin/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files";
  config.filebrowserImageUploadUrl =
    "/PHP/PHP_co_ban/module05/radix/templates/admin/assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images";
};
