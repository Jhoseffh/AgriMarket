
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgriMarket - Reports</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/exceljs@4.4.0/dist/exceljs.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.4/jspdf.plugin.autotable.min.js"></script>

    <style>
        :root {
            --primary-dark:#1e3a2b;
            --primary-green:#2d5a3f;
            --accent-terracotta:#d36b48;
            --accent-terracotta-hover:#be5937;
            --bg-cream:#f9f8f3;
            --bg-card:#ffffff;
            --text-main:#1a1a1a;
            --text-muted:#667085;
            --border-color:#e4e7ec;
            --soft-green:#eef4f0;
            --soft-terracotta:#f8e9e3;
            --shadow-sm:0 4px 20px rgba(0,0,0,.045);
            --shadow-md:0 12px 32px rgba(30,58,43,.08);
            --shadow-lg:0 20px 45px rgba(30,58,43,.12);
            --ease:cubic-bezier(.16,1,.3,1);
            --spring:cubic-bezier(.22,1.2,.36,1);
        }

        * {
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:"Plus Jakarta Sans",sans-serif;
        }

        html { scroll-behavior:smooth; }

        body {
            background:var(--bg-cream);
            color:var(--text-main);
            line-height:1.55;
            overflow-x:hidden;
        }

        button,input { font:inherit; }
        button,a { -webkit-tap-highlight-color:transparent; }
        a { color:inherit; }

        /* AMBIENT BACKGROUND */

        .ambient-bg {
            position:fixed;
            inset:0;
            z-index:-5;
            pointer-events:none;
            overflow:hidden;
            background:
                radial-gradient(circle at 10% 10%,rgba(45,90,63,.09),transparent 28%),
                radial-gradient(circle at 90% 72%,rgba(211,107,72,.08),transparent 26%),
                linear-gradient(180deg,#fbfaf6 0%,#f4f6ef 48%,#faf8f2 100%);
        }

        .ambient-bg::after {
            content:"";
            position:absolute;
            inset:0;
            opacity:.2;
            background-image:
                linear-gradient(rgba(30,58,43,.035) 1px,transparent 1px),
                linear-gradient(90deg,rgba(30,58,43,.035) 1px,transparent 1px);
            background-size:60px 60px;
            mask-image:linear-gradient(to bottom,black,transparent 80%);
        }

        .ambient-shape {
            position:absolute;
            width:34vw;
            height:34vw;
            min-width:250px;
            min-height:250px;
            border-radius:48% 52% 65% 35% / 38% 45% 55% 62%;
            filter:blur(3px);
            opacity:.3;
        }

        .shape-a {
            top:-14vw;
            left:-12vw;
            background:radial-gradient(circle at 40% 40%,rgba(82,145,104,.22),transparent 68%);
            animation:driftA 18s ease-in-out infinite alternate;
        }

        .shape-b {
            right:-13vw;
            top:28vh;
            background:radial-gradient(circle at 45% 45%,rgba(211,107,72,.18),transparent 68%);
            animation:driftB 23s ease-in-out infinite alternate;
        }

        @keyframes driftA {
            to { transform:translate(10vw,9vh) rotate(25deg) scale(1.12); }
        }

        @keyframes driftB {
            to { transform:translate(-8vw,-12vh) rotate(-30deg) scale(1.16); }
        }

        /* NAVIGATION */

        .navbar {
            position:fixed;
            top:0;
            left:0;
            right:0;
            z-index:1000;
            display:flex;
            align-items:center;
            gap:22px;
            padding:16px 5%;
            background:rgba(249,248,243,.9);
            backdrop-filter:blur(14px);
            border-bottom:1px solid rgba(0,0,0,.05);
            transition:padding .45s var(--ease),box-shadow .45s ease,background .45s ease;
        }

        .navbar.scrolled {
            padding-top:10px;
            padding-bottom:10px;
            background:rgba(249,248,243,.78);
            box-shadow:0 12px 35px rgba(30,58,43,.08);
        }

        .brand {
            display:flex;
            align-items:center;
            gap:9px;
            color:var(--primary-dark);
            text-decoration:none;
            font-size:1.45rem;
            font-weight:800;
            white-space:nowrap;
        }

        .brand i { color:var(--primary-green); }
        .nav-spacer { flex:1; }

        .nav-actions {
            display:flex;
            align-items:center;
            gap:7px;
        }

        .icon-btn {
            position:relative;
            width:42px;
            height:42px;
            display:grid;
            place-items:center;
            border:1px solid transparent;
            background:transparent;
            color:var(--primary-dark);
            border-radius:10px;
            cursor:pointer;
            transition:.3s var(--ease);
        }

        .icon-btn:hover {
            background:#fff;
            border-color:var(--border-color);
            transform:translateY(-2px);
        }

        /* SHOPPING CART BUTTON - FIXED */
        .nav-actions .cart-icon-btn {
            position:relative;
            width:42px;
            min-width:42px;
            max-width:42px;
            height:42px;
            min-height:42px;
            flex:0 0 42px;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:0;
            margin:0;
            overflow:visible;
            isolation:isolate;
            border:1px solid transparent;
            border-radius:10px;
            background:transparent;
            color:var(--primary-dark);
            text-decoration:none;
            line-height:1;
            vertical-align:middle;
            white-space:nowrap;
            transition:
                background .3s ease,
                border-color .3s ease,
                color .3s ease,
                transform .3s var(--ease);
        }

        .nav-actions .cart-icon-btn i {
            position:relative;
            display:block;
            width:auto;
            height:auto;
            margin:0;
            padding:0;
            font-size:1.08rem;
            line-height:1;
            text-align:center;
            color:inherit;
            transform:none;
        }

        .nav-actions .cart-icon-btn:hover {
            background:#fff;
            border-color:var(--border-color);
            color:var(--primary-green);
            transform:translateY(-2px);
        }

        .nav-actions .cart-icon-btn:focus-visible {
            outline:3px solid rgba(45,90,63,.25);
            outline-offset:3px;
        }

        .nav-actions .cart-icon-btn:active {
            transform:scale(.94);
        }


        .badge {
            position:absolute;
            top:3px;
            right:2px;
            min-width:17px;
            height:17px;
            padding:0 4px;
            display:grid;
            place-items:center;
            border-radius:20px;
            background:var(--accent-terracotta);
            color:#fff;
            font-size:.6rem;
            font-weight:800;
        }

        .dropdown-wrap { position:relative; }

        .dropdown {
            position:absolute;
            right:0;
            top:calc(100% + 10px);
            width:210px;
            padding:8px;
            background:#fff;
            border:1px solid var(--border-color);
            border-radius:14px;
            box-shadow:var(--shadow-lg);
            opacity:0;
            visibility:hidden;
            transform:translateY(-8px) scale(.97);
            transition:.3s var(--ease);
        }

        .dropdown.open {
            opacity:1;
            visibility:visible;
            transform:none;
        }

        .dropdown a,.dropdown button {
            width:100%;
            display:flex;
            align-items:center;
            gap:10px;
            padding:11px 12px;
            border:0;
            background:transparent;
            color:var(--text-main);
            text-decoration:none;
            border-radius:9px;
            cursor:pointer;
            text-align:left;
            font-size:.88rem;
        }

        .dropdown a:hover,.dropdown button:hover {
            background:var(--soft-green);
            color:var(--primary-green);
        }

        /* PAGE HEADER */

        .reports-page {
            width:min(1400px,90%);
            margin:0 auto;
            padding:125px 0 35px;
        }

        .page-heading {
            display:flex;
            align-items:flex-end;
            justify-content:space-between;
            gap:25px;
            margin-bottom:25px;
        }

        .heading-left .eyebrow {
            display:inline-block;
            padding:4px 11px;
            border-radius:20px;
            background:var(--soft-green);
            color:var(--primary-green);
            font-size:.68rem;
            font-weight:800;
            letter-spacing:1px;
            text-transform:uppercase;
        }

        .heading-left h1 {
            margin-top:9px;
            color:var(--primary-dark);
            font-size:clamp(1.8rem,3vw,2.6rem);
            line-height:1.15;
            font-weight:800;
        }

        .heading-left p {
            margin-top:7px;
            color:var(--text-muted);
            font-size:.88rem;
        }

        /* REPORT CARDS */

        .report-card {
            position:relative;
            margin-bottom:28px;
            background:rgba(255,255,255,.93);
            border:1px solid rgba(228,231,236,.9);
            border-radius:18px;
            box-shadow:var(--shadow-md);
            overflow:hidden;
            transition:transform .35s var(--spring),box-shadow .35s ease;
        }

        .report-card:hover { box-shadow:var(--shadow-lg); }

        .report-card-header {
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:20px;
            padding:21px 23px;
            border-bottom:1px solid var(--border-color);
            background:rgba(255,255,255,.7);
        }

        .report-title {
            display:flex;
            align-items:center;
            gap:12px;
        }

        .report-icon {
            width:42px;
            height:42px;
            display:grid;
            place-items:center;
            flex:0 0 auto;
            border-radius:11px;
            background:var(--soft-green);
            color:var(--primary-green);
            font-size:.95rem;
        }

        .report-title h2 {
            color:var(--primary-dark);
            font-size:1.1rem;
            font-weight:800;
        }

        .report-title p {
            margin-top:2px;
            color:var(--text-muted);
            font-size:.72rem;
        }

        /* EXPORT BUTTON */

        .export-btn {
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:8px;
            padding:10px 14px;
            border:0;
            border-radius:9px;
            background:var(--primary-dark);
            color:#fff;
            cursor:pointer;
            font-size:.72rem;
            font-weight:800;
            white-space:nowrap;
            transition:transform .3s var(--spring),background .3s ease,box-shadow .3s ease;
        }

        .export-btn:hover {
            background:var(--primary-green);
            transform:translateY(-2px);
            box-shadow:0 8px 18px rgba(30,58,43,.15);
        }

        .export-btn:active { transform:scale(.97); }
        .export-btn i { font-size:.78rem; }

        
    /* TABLE */

    .table-container {
        position: relative;
        width: 100%;
        max-height: 420px;
        overflow: auto;
        scrollbar-width: thin;
        scrollbar-color: #aab7ad #f1f4f0;
        overscroll-behavior: contain;
    }

    /* CUSTOM SCROLLBAR */

    .table-container::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    .table-container::-webkit-scrollbar-track {
        background: #f1f4f0;
        border-radius: 10px;
    }

    .table-container::-webkit-scrollbar-thumb {
        background: #aab7ad;
        border-radius: 10px;
    }

    .table-container::-webkit-scrollbar-thumb:hover {
        background: var(--primary-green);
    }

    /* TABLE STRUCTURE */

    .report-table {
        width: 100%;
        min-width: 760px;
        border-collapse: separate;
        border-spacing: 0;
    }

    /* STICKY TABLE HEADERS */

    .report-table thead th {
        position: sticky;
        top: 0;
        z-index: 5;
        padding: 13px 17px;
        background: var(--soft-green);
        color: var(--primary-dark);
        border-bottom: 1px solid var(--border-color);
        text-align: left;
        font-size: .67rem;
        font-weight: 800;
        letter-spacing: .25px;
        white-space: nowrap;
    }

    .report-table th:first-child {
        padding-left: 23px;
    }

    .report-table th:last-child {
        padding-right: 23px;
    }

    .report-table td {
        padding: 15px 17px;
        border-bottom: 1px solid #edf0ed;
        color: var(--text-main);
        font-size: .73rem;
        white-space: nowrap;
    }

    .report-table td:first-child {
        padding-left: 23px;
    }

    .report-table td:last-child {
        padding-right: 23px;
    }

    .report-table tbody tr {
        cursor: pointer;
        transition: background .25s ease, transform .25s ease;
    }

    .report-table tbody tr:hover {
        background: #fafcf9;
    }

    .report-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .order-id {
        color: var(--primary-green);
        font-weight: 800;
    }

    .product-cell {
        color: var(--primary-dark);
        font-weight: 700;
    }

    .money {
        color: var(--accent-terracotta);
        font-weight: 800;
    }

    .quantity {
        font-weight: 700;
    }


        /* STATUS BADGES */

        .status {
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:5px 9px;
            border-radius:20px;
            font-size:.62rem;
            font-weight:800;
            white-space:nowrap;
        }

        .status::before {
            content:"";
            width:6px;
            height:6px;
            border-radius:50%;
        }

        .status.completed,.status.in-stock {
            background:var(--soft-green);
            color:var(--primary-green);
        }

        .status.completed::before,.status.in-stock::before {
            background:var(--primary-green);
        }

        .status.shipping {
            background:var(--soft-terracotta);
            color:var(--accent-terracotta);
        }

        .status.shipping::before { background:var(--accent-terracotta); }

        .status.low-stock {
            background:#fff4dc;
            color:#a76a00;
        }

        .status.low-stock::before { background:#d68b23; }

        .status.out-stock {
            background:#f4e8e8;
            color:#9c3d3d;
        }

        .status.out-stock::before { background:#b84b4b; }

        .status.inactive {
            background:#eef0f2;
            color:#667085;
        }

        .status.inactive::before { background:#667085; }

        /* TABLE FOOTER */

        .table-note {
            padding:11px 23px;
            border-top:1px solid #edf0ed;
            color:var(--text-muted);
            font-size:.67rem;
            background:#fcfdfb;
        }

        .table-note i {
            margin-right:5px;
            color:var(--primary-green);
        }

        /* EMPTY STATE */

        .empty-state {
            padding:35px 20px !important;
            text-align:center;
            color:var(--text-muted) !important;
            cursor:default !important;
        }

        .empty-state i {
            display:block;
            margin-bottom:9px;
            color:#aab7ad;
            font-size:1.5rem;
        }

        /* MODAL */

        .modal-overlay {
            position:fixed;
            inset:0;
            z-index:5000;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:20px;
            background:rgba(30,58,43,.38);
            backdrop-filter:blur(7px);
            opacity:0;
            visibility:hidden;
            transition:opacity .3s ease,visibility .3s ease;
        }

        .modal-overlay.open {
            opacity:1;
            visibility:visible;
        }

        .modal {
            width:min(620px,100%);
            max-height:min(720px,92vh);
            overflow-y:auto;
            background:#fff;
            border:1px solid var(--border-color);
            border-radius:18px;
            box-shadow:0 25px 70px rgba(30,58,43,.22);
            transform:translateY(30px) scale(.96);
            transition:transform .4s var(--spring);
        }

        .modal-overlay.open .modal { transform:none; }

        .modal-header {
            position:sticky;
            top:0;
            z-index:2;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:15px;
            padding:18px 20px;
            background:rgba(255,255,255,.95);
            backdrop-filter:blur(10px);
            border-bottom:1px solid var(--border-color);
        }

        .modal-heading {
            display:flex;
            align-items:center;
            gap:11px;
        }

        .modal-heading-icon {
            width:40px;
            height:40px;
            display:grid;
            place-items:center;
            border-radius:10px;
            background:var(--soft-green);
            color:var(--primary-green);
        }

        .modal-heading h3 {
            color:var(--primary-dark);
            font-size:1rem;
            font-weight:800;
        }

        .modal-heading p {
            margin-top:1px;
            color:var(--text-muted);
            font-size:.66rem;
        }

        .close-modal {
            width:36px;
            height:36px;
            display:grid;
            place-items:center;
            border:0;
            border-radius:9px;
            background:#f5f6f4;
            color:var(--text-muted);
            cursor:pointer;
            transition:.25s ease;
        }

        .close-modal:hover {
            background:var(--soft-terracotta);
            color:var(--accent-terracotta);
            transform:rotate(5deg);
        }

        .modal-body { padding:21px; }

        .detail-grid {
            display:grid;
            grid-template-columns:repeat(2,minmax(0,1fr));
            gap:10px;
        }

        .detail-item {
            padding:13px 14px;
            background:#fafbf9;
            border:1px solid #edf0ed;
            border-radius:11px;
        }

        .detail-item.full { grid-column:1/-1; }

        .detail-label {
            display:block;
            margin-bottom:4px;
            color:var(--text-muted);
            font-size:.62rem;
            font-weight:700;
        }

        .detail-value {
            display:block;
            color:var(--primary-dark);
            font-size:.78rem;
            font-weight:800;
            word-break:break-word;
        }

        .detail-value.money { color:var(--accent-terracotta); }

        .modal-footer {
            display:flex;
            justify-content:flex-end;
            gap:8px;
            padding:16px 21px;
            border-top:1px solid var(--border-color);
            background:#fcfdfb;
        }

        .modal-btn {
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:8px;
            padding:10px 14px;
            border-radius:9px;
            border:0;
            cursor:pointer;
            font-size:.7rem;
            font-weight:800;
            transition:transform .3s var(--spring),background .3s ease;
        }

        .modal-btn:hover { transform:translateY(-2px); }

        .modal-btn.secondary {
            background:#eef0ed;
            color:var(--primary-dark);
        }

        .modal-btn.secondary:hover { background:#e3e7e3; }

        .modal-btn.primary {
            background:var(--primary-dark);
            color:#fff;
        }

        .modal-btn.primary:hover { background:var(--accent-terracotta); }

        /* REVEAL ANIMATIONS */

        .reveal {
            opacity:0;
            transform:translateY(48px) scale(.98);
            filter:blur(5px);
            transition:opacity .75s var(--ease),transform .85s var(--ease),filter .75s var(--ease);
        }

        .reveal.visible {
            opacity:1;
            transform:none;
            filter:blur(0);
        }

        .stagger > * {
            opacity:0;
            transform:translateY(25px);
            transition:opacity .6s var(--ease),transform .65s var(--ease);
        }

        .stagger.visible > * {
            opacity:1;
            transform:none;
        }

        .stagger.visible > *:nth-child(1) { transition-delay:.03s; }
        .stagger.visible > *:nth-child(2) { transition-delay:.08s; }
        .stagger.visible > *:nth-child(3) { transition-delay:.13s; }
        .stagger.visible > *:nth-child(4) { transition-delay:.18s; }
        .stagger.visible > *:nth-child(5) { transition-delay:.23s; }
        .stagger.visible > *:nth-child(6) { transition-delay:.28s; }

        /* TOAST */

        .toast-container {
            position:fixed;
            right:22px;
            bottom:22px;
            z-index:6000;
            display:flex;
            flex-direction:column;
            gap:8px;
        }

        .toast {
            min-width:250px;
            max-width:340px;
            padding:13px 15px;
            display:flex;
            align-items:center;
            gap:10px;
            border-radius:12px;
            background:var(--primary-dark);
            color:#fff;
            box-shadow:var(--shadow-lg);
            animation:toastIn .45s var(--spring);
            font-size:.78rem;
        }

        .toast i { color:#b9d7c0; }

        @keyframes toastIn {
            from { opacity:0; transform:translateY(20px) scale(.92); }
            to { opacity:1; transform:none; }
        }

        /* CLICK POP */

        .click-pop {
            position:fixed;
            width:8px;
            height:8px;
            border-radius:50%;
            pointer-events:none;
            z-index:7000;
            background:rgba(45,90,63,.45);
            transform:translate(-50%,-50%);
            animation:pop .7s ease-out forwards;
        }

        @keyframes pop {
            0% { opacity:.85; transform:translate(-50%,-50%) scale(1); }
            100% { opacity:0; transform:translate(-50%,-50%) scale(8); }
        }

        /* FOOTER */

        footer {
            margin-top:18px;
            padding:38px 5% 18px;
            background:var(--primary-dark);
            color:#fff;
        }

        .footer-grid {
            width:min(1400px,100%);
            margin:0 auto;
            display:grid;
            grid-template-columns:2fr 1fr 1fr 1.3fr;
            gap:35px;
            padding-bottom:24px;
            border-bottom:1px solid rgba(255,255,255,.1);
        }

        .footer-brand p {
            max-width:430px;
            margin-top:8px;
            color:#a0aec0;
            font-size:.8rem;
        }

        .footer-links h4 {
            margin-bottom:9px;
            font-size:.9rem;
        }

        .footer-links ul { list-style:none; }
        .footer-links li { margin-bottom:5px; }

        .footer-links a {
            color:#a0aec0;
            text-decoration:none;
            font-size:.76rem;
            transition:.25s ease;
        }

        .footer-links a:hover { color:#fff; }

        .copyright {
            width:min(1400px,100%);
            margin:0 auto;
            padding-top:15px;
            text-align:center;
            color:#a0aec0;
            font-size:.72rem;
        }

        /* RESPONSIVE */

        @media(max-width:900px) {
            .navbar { gap:10px; }
            .nav-spacer { flex:1; }
            .reports-page { width:92%; }
            .footer-grid { grid-template-columns:1fr 1fr; }
        }

        @media(max-width:650px) {
            .reports-page {
                width:92%;
                padding-top:105px;
            }

            .brand { font-size:1.2rem; }

            .icon-btn {
                width:37px;
                height:37px;
            }

            .page-heading {
                align-items:flex-start;
                flex-direction:column;
                gap:7px;
            }

            .report-card-header {
                align-items:flex-start;
                flex-direction:column;
            }

            .export-btn { width:100%; }
            .report-table { min-width:760px; }
            .detail-grid { grid-template-columns:1fr; }
            .detail-item.full { grid-column:auto; }
            .modal { border-radius:15px; }
            .modal-body { padding:16px; }
            .modal-footer { flex-direction:column; }
            .modal-btn { width:100%; }

            .footer-grid {
                grid-template-columns:1fr 1fr;
                gap:22px;
            }

            .footer-brand { grid-column:1/-1; }

            .toast-container {
                left:15px;
                right:15px;
                bottom:15px;
            }

            .toast {
                min-width:0;
                max-width:none;
                width:100%;
            }
        }

        @media(max-width:430px) {
            .footer-grid { grid-template-columns:1fr; }
            .report-title h2 { font-size:1rem; }
            .report-title p { font-size:.64rem; }
        }

        @media(prefers-reduced-motion:reduce) {
            *,*::before,*::after {
                animation-duration:.001ms!important;
                animation-iteration-count:1!important;
                transition-duration:.001ms!important;
                scroll-behavior:auto!important;
            }

            .reveal,.stagger > * {
                opacity:1;
                transform:none;
                filter:none;
            }
        }
    </style>
</head>

<body>

    <div class="ambient-bg">
        <div class="ambient-shape shape-a"></div>
        <div class="ambient-shape shape-b"></div>
    </div>

    <!-- NAVIGATION -->

    <nav class="navbar" id="navbar">

        <a href="{{ route('shop') }}" class="brand">
            <i class="fa-solid fa-leaf"></i>
            <span>agrimarket</span>
        </a>

        <div class="nav-spacer"></div>

        <div class="nav-actions">

            <!-- FIXED SHOPPING CART BUTTON -->
            <a
                href="{{ route('cart') }}"
                class="icon-btn cart-icon-btn"
                title="Shopping Cart"
                aria-label="Shopping Cart"
            >
                <i class="fa-solid fa-cart-shopping" aria-hidden="true"></i>
            </a>

            <div class="dropdown-wrap">

                <button
                    class="icon-btn"
                    id="profileButton"
                    title="Profile"
                    type="button"
                >
                    <i class="fa-regular fa-user"></i>
                </button>

                <div class="dropdown" id="profileMenu">

                    <a href="{{ route('profile') }}">
                        <i class="fa-regular fa-user"></i>
                        Profile
                    </a>

                    <a href="{{ route('orders') }}">
                        <i class="fa-solid fa-box"></i>
                        My Orders
                    </a>

                    <a href="{{ url('/settings') }}">
                        <i class="fa-solid fa-gear"></i>
                        Settings
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            Logout
                        </button>
                    </form>

                </div>

            </div>

        </div>

    </nav>

    <!-- MAIN -->

    <main>
        <div class="reports-page">

            <section class="page-heading reveal">
                <div class="heading-left">
                    <span class="eyebrow">Reports</span>

                    <h1>Sales & Inventory Reports</h1>

                    <p>
                        View, review and download your sales and inventory records.
                    </p>
                </div>
            </section>

            <!-- SALES REPORT -->

            <section class="report-card reveal">

                <div class="report-card-header">

                    <div class="report-title">

                        <div class="report-icon">
                            <i class="fa-solid fa-chart-column"></i>
                        </div>

                        <div>
                            <h2>Sales Report</h2>
                            <p>View completed and active sales records.</p>
                        </div>

                    </div>

                    <button
                        class="export-btn"
                        type="button"
                        onclick="exportSalesExcel()"
                    >
                        <i class="fa-solid fa-file-excel"></i>
                        Download Excel
                    </button>

                </div>

                <div class="table-container">

                    <table class="report-table" id="salesTable">

                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th>Total Sales</th>
                            </tr>
                        </thead>

                        <tbody id="salesTableBody"></tbody>

                    </table>

                </div>

                <div class="table-note">
                    <i class="fa-solid fa-circle-info"></i>
                    Click any sales record to view complete order information and download its PDF report.
                </div>

            </section>

            <!-- INVENTORY REPORT -->

            <section class="report-card reveal">

                <div class="report-card-header">

                    <div class="report-title">

                        <div class="report-icon">
                            <i class="fa-solid fa-boxes-stacked"></i>
                        </div>

                        <div>
                            <h2>Inventory Report</h2>
                            <p>View your current stock and estimated inventory selling value.</p>
                        </div>

                    </div>

                    <button
                        class="export-btn"
                        type="button"
                        onclick="exportInventoryExcel()"
                    >
                        <i class="fa-solid fa-file-excel"></i>
                        Download Excel
                    </button>

                </div>

                <div class="table-container">

                    <table class="report-table" id="inventoryTable">

                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Current Stock</th>
                                <th>Recently Added</th>
                                <th>Unit Price</th>
                                <th>Inventory Value</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody id="inventoryTableBody"></tbody>

                    </table>

                </div>

                <div class="table-note">
                    <i class="fa-solid fa-circle-info"></i>
                    Click any inventory record to view complete stock information and download its PDF report.
                    Inventory value is calculated using the product's selling price multiplied by its current stock.
                </div>

            </section>

        </div>
    </main>

    <!-- DETAIL MODAL -->

    <div class="modal-overlay" id="detailModal">

        <div class="modal" role="dialog" aria-modal="true">

            <div class="modal-header">

                <div class="modal-heading">

                    <div class="modal-heading-icon" id="modalIcon">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>

                    <div>
                        <h3 id="modalTitle">Record Details</h3>
                        <p id="modalSubtitle">AgriMarket Report</p>
                    </div>

                </div>

                <button
                    class="close-modal"
                    id="closeModal"
                    title="Close"
                    type="button"
                >
                    <i class="fa-solid fa-xmark"></i>
                </button>

            </div>

            <div class="modal-body">
                <div class="detail-grid" id="detailGrid"></div>
            </div>

            <div class="modal-footer">

                <button
                    class="modal-btn secondary"
                    id="closeModalButton"
                    type="button"
                >
                    <i class="fa-solid fa-xmark"></i>
                    Close
                </button>

                <button
                    class="modal-btn primary"
                    id="downloadPdfButton"
                    type="button"
                >
                    <i class="fa-solid fa-file-pdf"></i>
                    Download PDF
                </button>

            </div>

        </div>

    </div>

    <!-- FOOTER -->

    <footer>

        <div class="footer-grid">

            <div class="footer-brand">

                <a href="{{ route('shop') }}" class="brand" style="color:#fff">
                    <i class="fa-solid fa-leaf"></i>
                    <span>agrimarket</span>
                </a>

                <p>
                    A modern agricultural marketplace connecting buyers and sellers of farm products, supplies and services.
                </p>

            </div>

            <div class="footer-links">
                <h4>AgriMarket</h4>
                <ul>
                    <li><a href="">About Us</a></li>
                    <li><a href="">Contact</a></li>
                    <li><a href="">Help & Support</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h4>Legal</h4>
                <ul>
                    <li><a href="">Terms & Conditions</a></li>
                    <li><a href="">Privacy Policy</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h4>Marketplace</h4>
                <ul>
                    <li><a href="">New & Fresh</a></li>
                    <li><a href="">Best Sellers</a></li>
                    <li><a href="">Groceries</a></li>
                </ul>
            </div>

        </div>

        <div class="copyright">
            © 2026 AgriMarket. All rights reserved.
        </div>

    </footer>

    <!-- TOAST -->

    <div class="toast-container" id="toastContainer"></div>

    <script>
        /*
        |--------------------------------------------------------------------------
        | DATABASE DATA
        |--------------------------------------------------------------------------
        | These variables are supplied by UserController.
        |
        | SALES:
        | transactions.transaction_id
        | transactions.order_id
        | transactions.created_at
        | transactions.product_name
        | transactions.customer_name
        | transactions.quantity
        | transactions.total_amount
        | transactions.status
        |
        | INVENTORY:
        | products.product_id
        | products.product_name
        | products.category
        | products.price
        | products.quantity
        | products.oum
        | products.status
        | products.created_at
        | products.updated_at
        */

        const rawSales = @json($sales ?? []);
        const rawInventory = @json($inventory ?? []);

        /*
        |--------------------------------------------------------------------------
        | SAFE TEXT OUTPUT
        |--------------------------------------------------------------------------
        */

        function escapeHTML(value) {
            return String(value ?? '').replace(/[&<>"']/g, character => {
                const entities = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                };

                return entities[character];
            });
        }

        /*
        |--------------------------------------------------------------------------
        | DATE FORMATTING
        |--------------------------------------------------------------------------
        */

        function formatDate(value) {
            if (!value) {
                return 'N/A';
            }

            const date = new Date(value);

            if (Number.isNaN(date.getTime())) {
                return String(value);
            }

            return date.toLocaleDateString('en-PH', {
                year: 'numeric',
                month: 'short',
                day: '2-digit'
            });
        }

        function formatDateTime(value) {
            if (!value) {
                return 'N/A';
            }

            const date = new Date(value);

            if (Number.isNaN(date.getTime())) {
                return String(value);
            }

            return date.toLocaleString('en-PH', {
                year: 'numeric',
                month: 'short',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit'
            });
        }

        /*
        |--------------------------------------------------------------------------
        | FORMAT MONEY
        |--------------------------------------------------------------------------
        */

        function formatMoney(value) {
            const amount = Number(value) || 0;

            return amount.toLocaleString('en-PH', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        /*
        |--------------------------------------------------------------------------
        | NORMALIZE SALES DATABASE RECORDS
        |--------------------------------------------------------------------------
        */

        const sales = (Array.isArray(rawSales) ? rawSales : []).map(sale => {
            const quantity = Number(sale.quantity) || 0;
            const totalSales = Number(sale.total_amount ?? sale.totalSales ?? 0);

            return {
                transactionId: sale.transaction_id ?? '',
                orderId: sale.order_id || `TRX-${sale.order_id ?? ''}`,
                date: formatDate(sale.created_at ?? sale.date),
                rawDate: sale.created_at ?? sale.date ?? '',
                product: sale.product_name ?? sale.product ?? 'Unknown Product',
                buyer: sale.customer_name ?? sale.buyer ?? 'N/A',
                quantity: quantity,
                unitPrice: quantity > 0 ? totalSales / quantity : 0,
                totalSales: totalSales,
                orderStatus: sale.status ?? sale.orderStatus ?? 'N/A'
            };
        });

        /*
        |--------------------------------------------------------------------------
        | CALCULATE UNITS SOLD PER PRODUCT
        |--------------------------------------------------------------------------
        */

        const unitsSoldByProduct = {};

        sales.forEach(sale => {
            const productName = String(sale.product).toLowerCase();

            unitsSoldByProduct[productName] =
                (unitsSoldByProduct[productName] || 0) + sale.quantity;
        });

        /*
        |--------------------------------------------------------------------------
        | NORMALIZE INVENTORY DATABASE RECORDS
        |--------------------------------------------------------------------------
        */

        const inventory = (Array.isArray(rawInventory) ? rawInventory : []).map(item => {
            const currentStock = Number(item.quantity ?? item.currentStock ?? 0);
            const unitPrice = Number(item.price ?? item.unitPrice ?? item.unitCost ?? 0);
            const productName = item.product_name ?? item.product ?? 'Unknown Product';

            let stockStatus;

            if (currentStock <= 0) {
                stockStatus = 'Out of Stock';
            } else if (currentStock <= 10) {
                stockStatus = 'Low Stock';
            } else {
                stockStatus = 'In Stock';
            }

            return {
                productId: item.product_id ?? '',
                product: productName,
                category: item.category ?? 'N/A',
                currentStock: currentStock,
                unitsSold: unitsSoldByProduct[String(productName).toLowerCase()] || 0,
                recentlyAdded: formatDate(item.created_at ?? item.recentlyAdded),
                rawCreatedAt: item.created_at ?? '',
                unitPrice: unitPrice,
                inventoryValue: currentStock * unitPrice,
                status: stockStatus,
                productStatus: item.status ?? 'N/A',
                unit: item.oum ?? 'N/A',
                lastUpdated: formatDateTime(item.updated_at ?? item.created_at)
            };
        });

        /*
        |--------------------------------------------------------------------------
        | STATUS CLASS
        |--------------------------------------------------------------------------
        */

        function getStatusClass(status) {
            const normalized = String(status ?? '')
                .toLowerCase()
                .replace(/\s+/g, '-');

            if (normalized === 'completed') return 'completed';
            if (normalized === 'shipping') return 'shipping';
            if (normalized === 'in-stock') return 'in-stock';
            if (normalized === 'low-stock') return 'low-stock';
            if (normalized === 'out-of-stock') return 'out-stock';
            if (normalized === 'inactive') return 'inactive';

            return '';
        }

        /*
        |--------------------------------------------------------------------------
        | RENDER SALES TABLE
        |--------------------------------------------------------------------------
        */

        function renderSalesTable() {
            const tbody = document.getElementById('salesTableBody');

            if (!sales.length) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="empty-state">
                            <i class="fa-solid fa-receipt"></i>
                            No sales records found.
                        </td>
                    </tr>
                `;

                return;
            }

            tbody.innerHTML = sales.map((sale, index) => `
                <tr class="sales-row" data-index="${index}">
                    <td>
                        <span class="order-id">
                            ${escapeHTML(sale.orderId)}
                        </span>
                    </td>

                    <td>${escapeHTML(sale.date)}</td>

                    <td>
                        <span class="product-cell">
                            ${escapeHTML(sale.product)}
                        </span>
                    </td>

                    <td>
                        <span class="quantity">
                            ${sale.quantity}
                        </span>
                    </td>

                    <td>₱${formatMoney(sale.unitPrice)}</td>

                    <td>
                        <span class="money">
                            ₱${formatMoney(sale.totalSales)}
                        </span>
                    </td>
                </tr>
            `).join('');

            document.querySelectorAll('.sales-row').forEach(row => {
                row.addEventListener('click', () => {
                    const index = Number(row.dataset.index);
                    openSalesModal(sales[index]);
                });
            });
        }

        /*
        |--------------------------------------------------------------------------
        | RENDER INVENTORY TABLE
        |--------------------------------------------------------------------------
        */

        function renderInventoryTable() {
            const tbody = document.getElementById('inventoryTableBody');

            if (!inventory.length) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="empty-state">
                            <i class="fa-solid fa-box-open"></i>
                            No inventory records found.
                        </td>
                    </tr>
                `;

                return;
            }

            tbody.innerHTML = inventory.map((item, index) => `
                <tr class="inventory-row" data-index="${index}">
                    <td>
                        <span class="product-cell">
                            ${escapeHTML(item.product)}
                        </span>
                    </td>

                    <td>
                        <span class="quantity">
                            ${item.currentStock}
                            ${escapeHTML(item.unit)}
                        </span>
                    </td>

                    <td>${escapeHTML(item.recentlyAdded)}</td>

                    <td>₱${formatMoney(item.unitPrice)}</td>

                    <td>
                        <span class="money">
                            ₱${formatMoney(item.inventoryValue)}
                        </span>
                    </td>

                    <td>
                        <span class="status ${getStatusClass(item.status)}">
                            ${escapeHTML(item.status)}
                        </span>
                    </td>
                </tr>
            `).join('');

            document.querySelectorAll('.inventory-row').forEach(row => {
                row.addEventListener('click', () => {
                    const index = Number(row.dataset.index);
                    openInventoryModal(inventory[index]);
                });
            });
        }

        /*
        |--------------------------------------------------------------------------
        | MODAL ELEMENTS
        |--------------------------------------------------------------------------
        */

        const detailModal = document.getElementById('detailModal');
        const detailGrid = document.getElementById('detailGrid');
        const modalTitle = document.getElementById('modalTitle');
        const modalSubtitle = document.getElementById('modalSubtitle');
        const modalIcon = document.getElementById('modalIcon');
        const downloadPdfButton = document.getElementById('downloadPdfButton');

        let currentModalType = null;
        let currentModalRecord = null;

        /*
        |--------------------------------------------------------------------------
        | CREATE DETAIL ITEM
        |--------------------------------------------------------------------------
        */

        function detailItem(label, value, extraClass = '') {
            return `
                <div class="detail-item ${extraClass}">
                    <span class="detail-label">${escapeHTML(label)}</span>
                    <span class="detail-value">${value}</span>
                </div>
            `;
        }

        /*
        |--------------------------------------------------------------------------
        | OPEN SALES MODAL
        |--------------------------------------------------------------------------
        */

        function openSalesModal(sale) {
            currentModalType = 'sales';
            currentModalRecord = sale;

            modalIcon.innerHTML =
                '<i class="fa-solid fa-chart-column"></i>';

            modalTitle.textContent = 'Sales Record';
            modalSubtitle.textContent = sale.orderId;

            detailGrid.innerHTML =
                detailItem('Order ID', escapeHTML(sale.orderId)) +
                detailItem('Date', escapeHTML(sale.date)) +
                detailItem('Product', escapeHTML(sale.product)) +
                detailItem('Buyer', escapeHTML(sale.buyer)) +
                detailItem('Quantity', escapeHTML(sale.quantity)) +
                detailItem('Unit Price', `₱${formatMoney(sale.unitPrice)}`) +
                detailItem('Total Sales', `₱${formatMoney(sale.totalSales)}`) +
                detailItem(
                    'Order Status',
                    `<span class="status ${getStatusClass(sale.orderStatus)}">${escapeHTML(sale.orderStatus)}</span>`
                );

            downloadPdfButton.innerHTML =
                '<i class="fa-solid fa-file-pdf"></i> Download PDF';

            detailModal.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        /*
        |--------------------------------------------------------------------------
        | OPEN INVENTORY MODAL
        |--------------------------------------------------------------------------
        */

        function openInventoryModal(item) {
            currentModalType = 'inventory';
            currentModalRecord = item;

            modalIcon.innerHTML =
                '<i class="fa-solid fa-boxes-stacked"></i>';

            modalTitle.textContent = 'Inventory Record';
            modalSubtitle.textContent = item.product;

            detailGrid.innerHTML =
                detailItem('Product Name', escapeHTML(item.product), 'full') +
                detailItem('Category', escapeHTML(item.category)) +
                detailItem('Current Stock', `${item.currentStock} ${escapeHTML(item.unit)}`) +
                detailItem('Units Sold', escapeHTML(item.unitsSold)) +
                detailItem('Date Added', escapeHTML(item.recentlyAdded)) +
                detailItem(
                    'Stock Status',
                    `<span class="status ${getStatusClass(item.status)}">${escapeHTML(item.status)}</span>`
                ) +
                detailItem('Unit Price', `₱${formatMoney(item.unitPrice)}`) +
                detailItem('Inventory Value', `₱${formatMoney(item.inventoryValue)}`) +
                detailItem('Product Status', escapeHTML(item.productStatus)) +
                detailItem('Last Updated', escapeHTML(item.lastUpdated), 'full');

            downloadPdfButton.innerHTML =
                '<i class="fa-solid fa-file-pdf"></i> Download PDF';

            detailModal.classList.add('open');
            document.body.style.overflow = 'hidden';
        }

        /*
        |--------------------------------------------------------------------------
        | CLOSE MODAL
        |--------------------------------------------------------------------------
        */

        function closeModal() {
            detailModal.classList.remove('open');
            document.body.style.overflow = '';
        }

        document.getElementById('closeModal').addEventListener('click', closeModal);
        document.getElementById('closeModalButton').addEventListener('click', closeModal);

        detailModal.addEventListener('click', event => {
            if (event.target === detailModal) {
                closeModal();
            }
        });

        document.addEventListener('keydown', event => {
            if (event.key === 'Escape' && detailModal.classList.contains('open')) {
                closeModal();
            }
        });

        /*
        |--------------------------------------------------------------------------
        | EXCEL EXPORT - SALES
        |--------------------------------------------------------------------------
        */

        async function exportSalesExcel() {
            try {
                if (!sales.length) {
                    showToast('There are no sales records to export.');
                    return;
                }

                showToast('Preparing Sales Excel report...');

                const workbook = new ExcelJS.Workbook();

                workbook.creator = 'AgriMarket';
                workbook.created = new Date();

                const worksheet = workbook.addWorksheet('Sales Report');

                worksheet.properties.defaultRowHeight = 21;

                worksheet.mergeCells('A1:F1');

                const titleCell = worksheet.getCell('A1');

                titleCell.value = 'AgriMarket - Sales Report';
                titleCell.font = {
                    name: 'Arial',
                    size: 16,
                    bold: true,
                    color: { argb: 'FFFFFFFF' }
                };

                titleCell.alignment = {
                    horizontal: 'center',
                    vertical: 'middle'
                };

                titleCell.fill = {
                    type: 'pattern',
                    pattern: 'solid',
                    fgColor: { argb: 'FF1E3A2B' }
                };

                worksheet.getRow(1).height = 32;

                worksheet.mergeCells('A2:F2');

                const dateCell = worksheet.getCell('A2');

                dateCell.value = `Generated: ${new Date().toLocaleString('en-PH')}`;
                dateCell.font = {
                    name: 'Arial',
                    size: 10,
                    italic: true,
                    color: { argb: 'FF667085' }
                };

                dateCell.alignment = { horizontal: 'right' };

                worksheet.addRow([
                    'Order ID',
                    'Date',
                    'Product',
                    'Qty',
                    'Unit Price',
                    'Total Sales'
                ]);

                const headerRow = worksheet.getRow(3);

                headerRow.height = 25;

                headerRow.eachCell(cell => {
                    cell.font = {
                        name: 'Arial',
                        size: 10,
                        bold: true,
                        color: { argb: 'FF1E3A2B' }
                    };

                    cell.fill = {
                        type: 'pattern',
                        pattern: 'solid',
                        fgColor: { argb: 'FFEEF4F0' }
                    };

                    cell.alignment = { vertical: 'middle' };

                    cell.border = {
                        top: { style: 'thin', color: { argb: 'FFE4E7EC' } },
                        bottom: { style: 'thin', color: { argb: 'FFE4E7EC' } },
                        left: { style: 'thin', color: { argb: 'FFE4E7EC' } },
                        right: { style: 'thin', color: { argb: 'FFE4E7EC' } }
                    };
                });

                sales.forEach(sale => {
                    const row = worksheet.addRow([
                        sale.orderId,
                        sale.date,
                        sale.product,
                        sale.quantity,
                        sale.unitPrice,
                        sale.totalSales
                    ]);

                    row.eachCell(cell => {
                        cell.font = { name: 'Arial', size: 10 };

                        cell.border = {
                            top: { style: 'thin', color: { argb: 'FFEDF0ED' } },
                            bottom: { style: 'thin', color: { argb: 'FFEDF0ED' } },
                            left: { style: 'thin', color: { argb: 'FFEDF0ED' } },
                            right: { style: 'thin', color: { argb: 'FFEDF0ED' } }
                        };
                    });

                    row.getCell(5).numFmt = '₱#,##0.00';
                    row.getCell(6).numFmt = '₱#,##0.00';

                    row.getCell(1).font = {
                        name: 'Arial',
                        size: 10,
                        bold: true,
                        color: { argb: 'FF2D5A3F' }
                    };

                    row.getCell(6).font = {
                        name: 'Arial',
                        size: 10,
                        bold: true,
                        color: { argb: 'FFD36B48' }
                    };
                });

                worksheet.columns = [
                    { key: 'orderId', width: 22 },
                    { key: 'date', width: 16 },
                    { key: 'product', width: 28 },
                    { key: 'quantity', width: 10 },
                    { key: 'unitPrice', width: 16 },
                    { key: 'totalSales', width: 18 }
                ];

                worksheet.views = [{ state: 'frozen', ySplit: 3 }];
                worksheet.autoFilter = { from: 'A3', to: 'F3' };

                const buffer = await workbook.xlsx.writeBuffer();

                downloadBlob(
                    buffer,
                    'AgriMarket_Sales_Report.xlsx',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                );

                showToast('Sales Excel report downloaded successfully.');
            } catch (error) {
                console.error(error);
                showToast('Unable to generate the Sales Excel report.');
            }
        }

        /*
        |--------------------------------------------------------------------------
        | EXCEL EXPORT - INVENTORY
        |--------------------------------------------------------------------------
        */

        async function exportInventoryExcel() {
            try {
                if (!inventory.length) {
                    showToast('There are no inventory records to export.');
                    return;
                }

                showToast('Preparing Inventory Excel report...');

                const workbook = new ExcelJS.Workbook();

                workbook.creator = 'AgriMarket';
                workbook.created = new Date();

                const worksheet = workbook.addWorksheet('Inventory Report');

                worksheet.properties.defaultRowHeight = 21;

                worksheet.mergeCells('A1:F1');

                const titleCell = worksheet.getCell('A1');

                titleCell.value = 'AgriMarket - Inventory Report';
                titleCell.font = {
                    name: 'Arial',
                    size: 16,
                    bold: true,
                    color: { argb: 'FFFFFFFF' }
                };

                titleCell.alignment = {
                    horizontal: 'center',
                    vertical: 'middle'
                };

                titleCell.fill = {
                    type: 'pattern',
                    pattern: 'solid',
                    fgColor: { argb: 'FF1E3A2B' }
                };

                worksheet.getRow(1).height = 32;

                worksheet.mergeCells('A2:F2');

                const dateCell = worksheet.getCell('A2');

                dateCell.value = `Generated: ${new Date().toLocaleString('en-PH')}`;
                dateCell.font = {
                    name: 'Arial',
                    size: 10,
                    italic: true,
                    color: { argb: 'FF667085' }
                };

                dateCell.alignment = { horizontal: 'right' };

                worksheet.addRow([
                    'Product',
                    'Current Stock',
                    'Recently Added',
                    'Unit Price',
                    'Inventory Value',
                    'Status'
                ]);

                const headerRow = worksheet.getRow(3);

                headerRow.height = 25;

                headerRow.eachCell(cell => {
                    cell.font = {
                        name: 'Arial',
                        size: 10,
                        bold: true,
                        color: { argb: 'FF1E3A2B' }
                    };

                    cell.fill = {
                        type: 'pattern',
                        pattern: 'solid',
                        fgColor: { argb: 'FFEEF4F0' }
                    };

                    cell.alignment = { vertical: 'middle' };

                    cell.border = {
                        top: { style: 'thin', color: { argb: 'FFE4E7EC' } },
                        bottom: { style: 'thin', color: { argb: 'FFE4E7EC' } },
                        left: { style: 'thin', color: { argb: 'FFE4E7EC' } },
                        right: { style: 'thin', color: { argb: 'FFE4E7EC' } }
                    };
                });

                inventory.forEach(item => {
                    const row = worksheet.addRow([
                        item.product,
                        `${item.currentStock} ${item.unit}`,
                        item.recentlyAdded,
                        item.unitPrice,
                        item.inventoryValue,
                        item.status
                    ]);

                    row.eachCell(cell => {
                        cell.font = { name: 'Arial', size: 10 };

                        cell.border = {
                            top: { style: 'thin', color: { argb: 'FFEDF0ED' } },
                            bottom: { style: 'thin', color: { argb: 'FFEDF0ED' } },
                            left: { style: 'thin', color: { argb: 'FFEDF0ED' } },
                            right: { style: 'thin', color: { argb: 'FFEDF0ED' } }
                        };
                    });

                    row.getCell(4).numFmt = '₱#,##0.00';
                    row.getCell(5).numFmt = '₱#,##0.00';

                    row.getCell(1).font = {
                        name: 'Arial',
                        size: 10,
                        bold: true,
                        color: { argb: 'FF1E3A2B' }
                    };

                    row.getCell(5).font = {
                        name: 'Arial',
                        size: 10,
                        bold: true,
                        color: { argb: 'FFD36B48' }
                    };

                    if (item.status === 'In Stock') {
                        row.getCell(6).font = {
                            name: 'Arial',
                            size: 10,
                            bold: true,
                            color: { argb: 'FF2D5A3F' }
                        };
                    } else if (item.status === 'Low Stock') {
                        row.getCell(6).font = {
                            name: 'Arial',
                            size: 10,
                            bold: true,
                            color: { argb: 'FFA76A00' }
                        };
                    } else {
                        row.getCell(6).font = {
                            name: 'Arial',
                            size: 10,
                            bold: true,
                            color: { argb: 'FF9C3D3D' }
                        };
                    }
                });

                worksheet.columns = [
                    { key: 'product', width: 28 },
                    { key: 'currentStock', width: 18 },
                    { key: 'recentlyAdded', width: 20 },
                    { key: 'unitPrice', width: 16 },
                    { key: 'inventoryValue', width: 20 },
                    { key: 'status', width: 18 }
                ];

                worksheet.views = [{ state: 'frozen', ySplit: 3 }];
                worksheet.autoFilter = { from: 'A3', to: 'F3' };

                const buffer = await workbook.xlsx.writeBuffer();

                downloadBlob(
                    buffer,
                    'AgriMarket_Inventory_Report.xlsx',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                );

                showToast('Inventory Excel report downloaded successfully.');
            } catch (error) {
                console.error(error);
                showToast('Unable to generate the Inventory Excel report.');
            }
        }

        /*
        |--------------------------------------------------------------------------
        | GENERIC FILE DOWNLOAD
        |--------------------------------------------------------------------------
        */

        function downloadBlob(data, filename, mimeType) {
            const blob = new Blob([data], { type: mimeType });
            const url = URL.createObjectURL(blob);

            const link = document.createElement('a');

            link.href = url;
            link.download = filename;

            document.body.appendChild(link);
            link.click();
            link.remove();

            setTimeout(() => {
                URL.revokeObjectURL(url);
            }, 1000);
        }

        /*
        |--------------------------------------------------------------------------
        | PDF DOWNLOAD
        |--------------------------------------------------------------------------
        */

        function downloadCurrentPDF() {
            if (!currentModalRecord || !currentModalType) {
                return;
            }

            if (currentModalType === 'sales') {
                generateSalesPDF(currentModalRecord);
            } else {
                generateInventoryPDF(currentModalRecord);
            }
        }

        downloadPdfButton.addEventListener('click', downloadCurrentPDF);

        /*
        |--------------------------------------------------------------------------
        | SALES PDF
        |--------------------------------------------------------------------------
        */

        function generateSalesPDF(sale) {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            const pageWidth = doc.internal.pageSize.getWidth();

            doc.setFillColor(30, 58, 43);
            doc.rect(0, 0, pageWidth, 34, 'F');

            doc.setTextColor(255, 255, 255);
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(18);
            doc.text('AgriMarket', 20, 15);

            doc.setFontSize(10);
            doc.setFont('helvetica', 'normal');
            doc.text('Sales Report', 20, 24);

            doc.setTextColor(30, 58, 43);
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(15);
            doc.text(String(sale.orderId), 20, 50);

            doc.setFont('helvetica', 'normal');
            doc.setFontSize(9);
            doc.setTextColor(102, 112, 133);
            doc.text(`Generated: ${new Date().toLocaleString('en-PH')}`, 20, 58);

            doc.autoTable({
                startY:70,
                head:[['Field','Information']],
                body:[
                    ['Order ID',String(sale.orderId)],
                    ['Date',String(sale.date)],
                    ['Product',String(sale.product)],
                    ['Buyer',String(sale.buyer)],
                    ['Quantity',String(sale.quantity)],
                    ['Unit Price',`PHP ${formatMoney(sale.unitPrice)}`],
                    ['Total Sales',`PHP ${formatMoney(sale.totalSales)}`],
                    ['Order Status',String(sale.orderStatus)]
                ],
                theme:'grid',
                headStyles:{
                    fillColor:[238,244,240],
                    textColor:[30,58,43],
                    fontStyle:'bold',
                    lineColor:[228,231,236]
                },
                bodyStyles:{
                    textColor:[26,26,26],
                    lineColor:[228,231,236],
                    lineWidth:.2
                },
                alternateRowStyles:{
                    fillColor:[250,251,249]
                },
                columnStyles:{
                    0:{cellWidth:55,fontStyle:'bold'},
                    1:{cellWidth:'auto'}
                },
                margin:{left:20,right:20}
            });

            const pageHeight = doc.internal.pageSize.getHeight();

            doc.setFontSize(8);
            doc.setTextColor(102,112,133);
            doc.text('AgriMarket - Sales Report',20,pageHeight-15);

            const safeOrderId = String(sale.orderId).replace(/[^a-z0-9-_]/gi,'-');

            doc.save(`AgriMarket_Sale_Order-${safeOrderId}.pdf`);

            showToast('Sales PDF downloaded successfully.');
        }

        /*
        |--------------------------------------------------------------------------
        | INVENTORY PDF
        |--------------------------------------------------------------------------
        */

        function generateInventoryPDF(item) {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            const pageWidth = doc.internal.pageSize.getWidth();

            doc.setFillColor(30,58,43);
            doc.rect(0,0,pageWidth,34,'F');

            doc.setTextColor(255,255,255);
            doc.setFont('helvetica','bold');
            doc.setFontSize(18);
            doc.text('AgriMarket',20,15);

            doc.setFontSize(10);
            doc.setFont('helvetica','normal');
            doc.text('Inventory Report',20,24);

            doc.setTextColor(30,58,43);
            doc.setFont('helvetica','bold');
            doc.setFontSize(15);
            doc.text(String(item.product).substring(0,45),20,50);

            doc.setFont('helvetica','normal');
            doc.setFontSize(9);
            doc.setTextColor(102,112,133);
            doc.text(`Generated: ${new Date().toLocaleString('en-PH')}`,20,58);

            doc.autoTable({
                startY:70,
                head:[['Field','Information']],
                body:[
                    ['Product Name',String(item.product)],
                    ['Category',String(item.category)],
                    ['Current Stock',`${item.currentStock} ${item.unit}`],
                    ['Units Sold',String(item.unitsSold)],
                    ['Date Added',String(item.recentlyAdded)],
                    ['Stock Status',String(item.status)],
                    ['Unit Price',`PHP ${formatMoney(item.unitPrice)}`],
                    ['Inventory Value',`PHP ${formatMoney(item.inventoryValue)}`],
                    ['Product Status',String(item.productStatus)],
                    ['Last Updated',String(item.lastUpdated)]
                ],
                theme:'grid',
                headStyles:{
                    fillColor:[238,244,240],
                    textColor:[30,58,43],
                    fontStyle:'bold',
                    lineColor:[228,231,236]
                },
                bodyStyles:{
                    textColor:[26,26,26],
                    lineColor:[228,231,236],
                    lineWidth:.2
                },
                alternateRowStyles:{
                    fillColor:[250,251,249]
                },
                columnStyles:{
                    0:{cellWidth:55,fontStyle:'bold'},
                    1:{cellWidth:'auto'}
                },
                margin:{left:20,right:20}
            });

            const pageHeight = doc.internal.pageSize.getHeight();

            doc.setFontSize(8);
            doc.setTextColor(102,112,133);
            doc.text('AgriMarket - Inventory Report',20,pageHeight-15);

            const safeProductName = String(item.product).replace(/[^a-z0-9-_]/gi,'-');

            doc.save(`AgriMarket_Inventory_Report-${safeProductName}.pdf`);

            showToast('Inventory PDF downloaded successfully.');
        }

        /*
        |--------------------------------------------------------------------------
        | PROFILE DROPDOWN
        |--------------------------------------------------------------------------
        */

        const profileButton = document.getElementById('profileButton');
        const profileMenu = document.getElementById('profileMenu');

        profileButton.addEventListener('click', event => {
            event.stopPropagation();
            profileMenu.classList.toggle('open');
        });

        profileMenu.addEventListener('click', event => {
            event.stopPropagation();
        });

        document.addEventListener('click', () => {
            profileMenu.classList.remove('open');
        });

        /*
        |--------------------------------------------------------------------------
        | NAVBAR SCROLL EFFECT
        |--------------------------------------------------------------------------
        */

        window.addEventListener('scroll', () => {
            document.getElementById('navbar').classList.toggle(
                'scrolled',
                window.scrollY > 25
            );
        }, { passive:true });

        /*
        |--------------------------------------------------------------------------
        | TOAST
        |--------------------------------------------------------------------------
        */

        function showToast(message) {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');

            toast.className = 'toast';

            const icon = document.createElement('i');
            icon.className = 'fa-solid fa-circle-check';

            const text = document.createElement('span');
            text.textContent = message;

            toast.appendChild(icon);
            toast.appendChild(text);

            container.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(10px)';
                toast.style.transition = '.3s ease';

                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 2600);
        }

        /*
        |--------------------------------------------------------------------------
        | REPEATING SCROLL REVEAL
        |--------------------------------------------------------------------------
        */

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                } else {
                    entry.target.classList.remove('visible');
                }
            });
        }, {
            threshold:.12,
            rootMargin:'0px 0px -45px 0px'
        });

        function setupReveal() {
            document.querySelectorAll('.reveal,.stagger').forEach(element => {
                observer.observe(element);
            });
        }

        /*
        |--------------------------------------------------------------------------
        | CLICK POP
        |--------------------------------------------------------------------------
        */

        document.addEventListener('click', event => {
            const pop = document.createElement('span');

            pop.className = 'click-pop';
            pop.style.left = `${event.clientX}px`;
            pop.style.top = `${event.clientY}px`;

            document.body.appendChild(pop);

            setTimeout(() => {
                pop.remove();
            },700);
        });

        /*
        |--------------------------------------------------------------------------
        | INITIALIZATION
        |--------------------------------------------------------------------------
        */

        renderSalesTable();
        renderInventoryTable();
        setupReveal();

    </script>

</body>
</html>
