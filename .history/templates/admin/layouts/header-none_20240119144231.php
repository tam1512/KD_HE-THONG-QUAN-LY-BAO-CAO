<!DOCTYPE html>
<html>

<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>export</title>
   <!-- Tell the browser to be responsive to screen width -->
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <!-- Font Awesome -->
   <link rel="stylesheet"
      href="<?php echo _WEB_HOST_TEMPLATE_ADMIN.'/assets/' ?>plugins/fontawesome-free/css/all.min.css">
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.10.2/jspdf.umd.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>
   <style type="text/css">
   * {
      padding: 0;
      margin: 0;
      box-sizing: border-box;
      font-family: "Times New Roman", Times, serif;
      ;
   }

   /* 
   @font-face {
      font-family: latha;
      font-style: normal;
      font-weight: 400;
      src: url(http://eclecticgeek.com/dompdf/fonts/latha.ttf) format('true-type');
   } */

   .container {
      width: 98%;
      /* max-width: 100% !important; */
      padding: 8px;
      /* overflow: hidden; */
   }

   .row {
      display: -ms-flexbox;
      display: flex;
      -ms-flex-wrap: wrap;
      flex-wrap: wrap;
      margin-right: -7.5px;
      margin-left: -7.5px;
   }

   .col {
      -ms-flex-preferred-size: 0;
      flex-basis: 0;
      -ms-flex-positive: 1;
      flex-grow: 1;
      max-width: 100%;
   }

   .mb-0 {
      margin-bottom: 0px !important;
   }

   .mr-2 {
      margin-right: 2px;
   }

   .d-flex {
      display: flex;
   }

   .border-none {
      border: none;
   }

   .flex-1 {
      flex: 1;
   }

   .text-center {
      text-align: center;
   }

   table {
      border-collapse: collapse;
   }

   .table {
      width: 100%;
      margin-bottom: 1rem;
      color: #212529;
      background-color: transparent;
   }

   .table th,
   .table td {
      padding: 0.75rem;
      vertical-align: top;
      border-top: 1px solid #000;
   }

   .table thead th {
      vertical-align: bottom;
      border-bottom: 2px solid #000;
   }

   .table-bordered {
      border: 1px solid #000;
   }

   .table-bordered th,
   .table-bordered td {
      border: 1px solid #000;
   }

   .table-bordered thead th,
   .table-bordered thead td {
      border-bottom-width: 2px;
   }

   .sign {
      width: 180px;
      height: 90px;
      border: none;
      pointer-events: none;
   }
   </style>
</head>

<body>