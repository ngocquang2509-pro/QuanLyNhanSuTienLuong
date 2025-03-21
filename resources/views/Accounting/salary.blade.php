<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Hệ thống quản lý lương</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS cho trang Salary -->
    <style>
    .table-header {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    .sub-header {
        background-color: #e9ecef;
    }

    .salary-table th,
    .salary-table td {
        font-size: 0.85rem;
        vertical-align: middle;
    }

    .department {
        background-color: #f1f3f5;
        font-weight: bold;
    }

    .action-btn {
        color: #0d6efd;
        cursor: pointer;
        padding: 5px;
        transition: color 0.2s;
    }

    .action-btn:hover {
        color: #0a58ca;
    }

    .tax-button {
        padding: 4px 8px;
        font-size: 0.8rem;
    }

    .modal.fade .modal-dialog {
        transform: scale(0.7);
        opacity: 0;
        transition: all 0.3s ease-in-out;
    }

    .modal.show .modal-dialog {
        transform: scale(1);
        opacity: 1;
    }

    .modal-content {
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }

    .modal-header {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        color: white;
        border-radius: 15px 15px 0 0;
        padding: 1.5rem;
    }

    .modal-title {
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-footer {
        background-color: #f8f9fa;
        border-radius: 0 0 15px 15px;
        padding: 1rem;
    }

    .detail-row {
        display: flex;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #dee2e6;
    }

    .detail-label {
        width: 180px;
        font-weight: 600;
        color: #495057;
    }

    .detail-value {
        flex: 1;
        color: #212529;
    }

    .modal .close {
        color: white;
        opacity: 1;
    }

    .modal .close:hover {
        color: #dee2e6;
    }

    .highlight-section {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 1rem;
        margin: 1rem 0;
    }

    .tax-modal .modal-content {
        background: #f8f9fa;
        border: none;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .tax-modal .modal-header {
        background: linear-gradient(135deg, #20bf55 0%, #01baef 100%);
        color: white;
        border-radius: 20px 20px 0 0;
        padding: 1.5rem;
    }

    .tax-calculation-table {
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin: 1rem 0;
    }

    .tax-calculation-table th {
        background: #e9ecef;
        border: none;
    }

    .tax-calculation-table td,
    .tax-calculation-table th {
        padding: 1rem;
        vertical-align: middle;
    }

    .tax-result {
        background: #e8f5e9;
        border-radius: 10px;
        padding: 1.5rem;
        margin-top: 1.5rem;
    }

    .tax-value {
        font-size: 1.2rem;
        font-weight: bold;
        color: #2e7d32;
    }

    /* Animation for tax modal */
    @keyframes slideIn {
        from {
            transform: translateY(-100px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .tax-modal.fade .modal-dialog {
        transform: translateY(-100px);
        opacity: 0;
        transition: all 0.3s ease-out;
    }

    .tax-modal.show .modal-dialog {
        transform: translateY(0);
        opacity: 1;
    }

    .tax-row {
        animation: slideIn 0.3s ease-out forwards;
    }

    .tax-row:nth-child(2) {
        animation-delay: 0.1s;
    }

    .tax-row:nth-child(3) {
        animation-delay: 0.2s;
    }

    .tax-row:nth-child(4) {
        animation-delay: 0.3s;
    }

    .tax-row:nth-child(5) {
        animation-delay: 0.4s;
    }

    .calculation-step {
        background: white;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .step-number {
        width: 30px;
        height: 30px;
        background: #20bf55;
        color: white;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
    }
    </style>

    @include('Accounting.layouts.head')
</head>

<body class="bg-light">
    <!-- Header Bar -->
    @include('Accounting.layouts.header')

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @if(Auth::user()->type == 'CTO')
            @include('CTO.layouts.navigation')
            @else
            @include('Accounting.layouts.navigation')
            @endif
            <!-- Main Content -->
            @include('Accounting.contents.salary')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
    @include('Accounting.layouts.script')
</body>

</html>