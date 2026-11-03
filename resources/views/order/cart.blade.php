<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AgriMarket - My Purchases & Shopping Cart</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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
            to {
                transform:translate(10vw,9vh) rotate(25deg) scale(1.12);
            }
        }

        @keyframes driftB {
            to {
                transform:translate(-8vw,-12vh) rotate(-30deg) scale(1.16);
            }
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

        .nav-actions {
            display:flex;
            align-items:center;
            gap:7px;
            margin-left:auto;
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

        .dropdown a,
        .dropdown button {
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

        .dropdown a:hover,
        .dropdown button:hover {
            background:var(--soft-green);
            color:var(--primary-green);
        }

        /* MAIN PAGE */

        .cart-page {
            width:min(1400px,90%);
            margin:0 auto;
            padding:126px 0 45px;
        }

        .cart-header {
            display:flex;
            align-items:flex-end;
            justify-content:space-between;
            gap:20px;
            margin-bottom:20px;
        }

        .cart-header-left .eyebrow {
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

        .cart-header-left h1 {
            margin-top:8px;
            color:var(--primary-dark);
            font-size:clamp(1.7rem,3vw,2.5rem);
            line-height:1.15;
            font-weight:800;
        }

        .cart-header-left p {
            margin-top:6px;
            color:var(--text-muted);
            font-size:.86rem;
        }

        /* MY PURCHASES */

        .purchases-section {
            margin-bottom:55px;
        }

        .purchases-container {
            background:#fff;
            border:1px solid rgba(228,231,236,.85);
            border-radius:17px;
            box-shadow:var(--shadow-md);
            overflow:hidden;
        }

        .purchases-table-wrap {
            width:100%;
            overflow-x:auto;
        }

        .purchases-table {
            width:100%;
            min-width:700px;
            border-collapse:separate;
            border-spacing:0;
            text-align:left;
        }

        .purchases-table thead {
            background:var(--primary-dark);
            color:#fff;
        }

        .purchases-table th {
            padding:15px 16px;
            color:#fff;
            font-size:.67rem;
            font-weight:800;
            white-space:nowrap;
        }

        .purchases-table th:first-child {
            border-top-left-radius:14px;
        }

        .purchases-table th:last-child {
            border-top-right-radius:14px;
        }

        .purchases-table td {
            padding:17px 16px;
            border-bottom:1px solid #edf0f1;
            color:#4b5563;
            font-size:.73rem;
            font-weight:500;
            white-space:nowrap;
        }

        .purchases-table tbody tr {
            background:#fff;
            cursor:pointer;
            transition:background .25s ease;
        }

        .purchases-table tbody tr:hover {
            background:#f7faf8;
        }

        .purchases-table tbody tr:last-child td {
            border-bottom:0;
        }

        .order-id {
            color:var(--primary-green);
            font-weight:800;
        }

        .purchase-amount {
            color:var(--accent-terracotta);
            font-weight:800;
        }

        .status {
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:6px;
            padding:6px 10px;
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
            background:currentColor;
        }

        .status-delivered,
        .status-completed {
            background:#e8f5ec;
            color:#287443;
        }

        .status-processing {
            background:#fff4df;
            color:#a66a13;
        }

        .status-shipped,
        .status-shipping {
            background:#f9e9e4;
            color:#d36b48;
        }

        .status-cancelled {
            background:#fbeae7;
            color:#bd4c3b;
        }

        .status-pending {
            background:#fff4df;
            color:#a66a13;
        }

        .empty-purchases {
            display:none;
            padding:55px 20px;
            text-align:center;
        }

        .empty-purchases.visible { display:block; }

        .empty-purchases-icon {
            width:65px;
            height:65px;
            margin:0 auto 14px;
            display:grid;
            place-items:center;
            border-radius:50%;
            background:var(--soft-green);
            color:var(--primary-green);
            font-size:1.4rem;
        }

        .empty-purchases h3 {
            color:var(--primary-dark);
            font-size:.95rem;
            font-weight:800;
        }

        .empty-purchases p {
            margin-top:5px;
            color:var(--text-muted);
            font-size:.75rem;
        }

        .purchases-footer {
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:15px;
            padding:14px 17px;
            background:#fbfcfa;
            border-top:1px solid var(--border-color);
            color:var(--text-muted);
            font-size:.68rem;
            font-weight:600;
        }

        .purchases-footer i {
            margin-right:5px;
            color:var(--primary-green);
        }

        /* PURCHASE DETAILS MODAL */

        .purchase-modal-overlay {
            position:fixed;
            inset:0;
            z-index:4000;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:20px;
            background:rgba(16,32,23,.48);
            backdrop-filter:blur(7px);
            opacity:0;
            visibility:hidden;
            transition:opacity .3s ease,visibility .3s ease;
        }

        .purchase-modal-overlay.open {
            opacity:1;
            visibility:visible;
        }

        .purchase-modal {
            width:min(620px,100%);
            max-height:92vh;
            overflow-y:auto;
            background:#fff;
            border:1px solid rgba(255,255,255,.7);
            border-radius:20px;
            box-shadow:0 25px 70px rgba(0,0,0,.2);
            transform:translateY(22px) scale(.97);
            transition:transform .4s var(--ease);
        }

        .purchase-modal-overlay.open .purchase-modal {
            transform:translateY(0) scale(1);
        }

        .purchase-modal-header {
            display:flex;
            align-items:flex-start;
            justify-content:space-between;
            gap:15px;
            padding:20px 22px;
            border-bottom:1px solid #edf0f1;
        }

        .purchase-modal-heading h2 {
            color:var(--primary-dark);
            font-size:1.05rem;
            font-weight:800;
        }

        .purchase-modal-heading p {
            margin-top:3px;
            color:#84909e;
            font-size:.7rem;
            font-weight:500;
        }

        .modal-close {
            width:36px;
            height:36px;
            flex:0 0 auto;
            display:grid;
            place-items:center;
            border:0;
            border-radius:10px;
            background:var(--soft-green);
            color:var(--primary-dark);
            cursor:pointer;
            transition:.25s ease;
        }

        .modal-close:hover {
            background:var(--soft-terracotta);
            color:var(--accent-terracotta);
            transform:rotate(90deg);
        }

        .purchase-modal-body {
            padding:19px 22px 24px;
        }

        .purchase-detail-grid {
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:10px;
        }

        .purchase-detail-card {
            min-width:0;
            padding:12px;
            border:1px solid #edf0f1;
            border-radius:11px;
            background:#fbfcfa;
        }

        .purchase-detail-card.full {
            grid-column:1 / -1;
        }

        .purchase-detail-label {
            display:block;
            margin-bottom:4px;
            color:#84909e;
            font-size:.63rem;
            font-weight:700;
        }

        .purchase-detail-value {
            display:block;
            color:var(--primary-dark);
            font-size:.76rem;
            font-weight:800;
            overflow-wrap:anywhere;
        }

        .purchase-detail-value.amount {
            color:var(--accent-terracotta);
            font-size:.88rem;
        }

        .purchase-products-heading {
            display:flex;
            align-items:center;
            gap:7px;
            margin:17px 0 11px;
            color:var(--primary-dark);
            font-size:.83rem;
            font-weight:800;
        }

        .purchase-products-heading i {
            color:var(--primary-green);
        }

        .purchase-products-list {
            display:flex;
            flex-direction:column;
            gap:12px;
        }

        .purchase-product-row {
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:15px;
            padding:2px 0;
        }

        .purchase-product-name {
            color:var(--primary-dark);
            font-size:.73rem;
            font-weight:800;
        }

        .purchase-product-price {
            color:#84909e;
            font-size:.72rem;
            font-weight:500;
            white-space:nowrap;
        }

        /* CANCEL PURCHASE BUTTON */

        .cancel-purchase-container {
            display:none;
            margin-top:22px;
        }

        .cancel-purchase-btn {
            width:100%;
            padding:12px;
            display:flex;
            align-items:center;
            justify-content:center;
            gap:9px;
            border:1px solid rgba(211,107,72,.25);
            border-radius:10px;
            background:var(--soft-terracotta);
            color:#bd4c3b;
            font-size:.78rem;
            font-weight:800;
            cursor:pointer;
            transition:.3s var(--ease);
        }

        .cancel-purchase-btn:hover:not(:disabled) {
            background:var(--accent-terracotta);
            border-color:var(--accent-terracotta);
            color:#fff;
            transform:translateY(-2px);
            box-shadow:0 8px 18px rgba(211,107,72,.15);
        }

        .cancel-purchase-btn:disabled {
            opacity:.6;
            cursor:not-allowed;
            transform:none;
        }

        /* CART CONTAINER */

        .cart-container {
            background:#fff;
            border:1px solid rgba(228,231,236,.85);
            border-radius:18px;
            box-shadow:var(--shadow-md);
            overflow:hidden;
        }

        .cart-table-header {
            display:grid;
            grid-template-columns:minmax(0,1fr) 180px 110px;
            align-items:center;
            padding:16px 24px;
            background:#fbfcfa;
            border-bottom:1px solid var(--border-color);
            color:var(--text-muted);
            font-size:.72rem;
            font-weight:800;
            text-transform:uppercase;
            letter-spacing:.7px;
        }

        .cart-table-header .price-header { text-align:right; }
        .cart-table-header .remove-header { text-align:center; }

        /* SELECT ALL */

        .select-all-row {
            display:flex;
            align-items:center;
            gap:12px;
            padding:13px 24px;
            background:rgba(238,244,240,.5);
            border-bottom:1px solid var(--border-color);
        }

        .select-all-text {
            color:var(--primary-dark);
            font-size:.78rem;
            font-weight:800;
        }

        .selection-count {
            color:var(--text-muted);
            font-size:.7rem;
            font-weight:600;
        }

        .circle-select {
            position:relative;
            flex:0 0 auto;
            width:22px;
            height:22px;
            border:2px solid #b8c4bc;
            border-radius:50%;
            background:#fff;
            cursor:pointer;
            transition:border-color .3s var(--ease),background .3s var(--ease),transform .25s var(--spring);
        }

        .circle-select:hover {
            border-color:var(--primary-green);
            transform:scale(1.08);
        }

        .circle-select.selected {
            border-color:var(--primary-green);
            background:var(--primary-green);
        }

        .circle-select.selected::after,
        .circle-select.all-selected::after {
            content:"";
            position:absolute;
            top:50%;
            left:50%;
            border-radius:50%;
            background:#fff;
            transform:translate(-50%,-50%);
        }

        .circle-select.selected::after {
            width:7px;
            height:7px;
        }

        .circle-select.all-selected {
            border-color:var(--accent-terracotta);
            background:var(--accent-terracotta);
        }

        .circle-select.all-selected::after {
            width:8px;
            height:8px;
        }

        /* CART ITEM */

        .cart-item {
            display:grid;
            grid-template-columns:minmax(0,1fr) 180px 110px;
            align-items:center;
            padding:18px 24px;
            border-bottom:1px solid var(--border-color);
            transition:background .3s ease,opacity .3s ease,transform .3s var(--ease);
        }

        .cart-item:last-child { border-bottom:0; }

        .cart-item:hover { background:rgba(249,248,243,.65); }

        .cart-item.removing {
            opacity:0;
            transform:translateX(30px);
        }

        .product-column {
            display:flex;
            align-items:center;
            min-width:0;
            gap:15px;
        }

        .item-image {
            position:relative;
            flex:0 0 auto;
            width:82px;
            height:82px;
            overflow:hidden;
            display:grid;
            place-items:center;
            border-radius:13px;
            background:linear-gradient(135deg,rgba(255,255,255,.38),transparent 50%),#e9ecef;
            border:1px dashed #cbd4cd;
        }

        .item-image img {
            width:100%;
            height:100%;
            object-fit:cover;
        }

        .item-image i {
            color:#a8b0b5;
            font-size:1.45rem;
        }

        .item-details { min-width:0; }

        .item-name {
            color:var(--primary-dark);
            font-size:.88rem;
            font-weight:800;
            line-height:1.35;
            overflow:hidden;
            text-overflow:ellipsis;
        }

        .item-unit {
            display:flex;
            align-items:center;
            gap:5px;
            margin-top:5px;
            color:var(--text-muted);
            font-size:.7rem;
            font-weight:600;
        }

        .item-unit i {
            color:var(--primary-green);
            font-size:.65rem;
        }

        .item-price {
            text-align:right;
            color:var(--accent-terracotta);
            font-size:.98rem;
            font-weight:800;
        }

        .remove-column {
            display:flex;
            justify-content:center;
        }

        .remove-btn {
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:6px;
            padding:8px 11px;
            border:1px solid rgba(211,107,72,.18);
            border-radius:8px;
            background:var(--soft-terracotta);
            color:var(--accent-terracotta);
            cursor:pointer;
            font-size:.65rem;
            font-weight:800;
            transition:.3s var(--ease);
        }

        .remove-btn:hover {
            background:var(--accent-terracotta);
            color:#fff;
            border-color:var(--accent-terracotta);
            transform:translateY(-2px);
        }

        .remove-btn:disabled {
            opacity:.6;
            cursor:not-allowed;
            transform:none;
        }

        /* CHECKOUT */

        .checkout-section {
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:30px;
            padding:22px 24px;
            background:#fbfcfa;
            border-top:1px solid var(--border-color);
        }

        .checkout-info { min-width:0; }

        .checkout-selected {
            color:var(--text-muted);
            font-size:.7rem;
            font-weight:700;
        }

        .checkout-total-label {
            margin-top:3px;
            color:var(--primary-dark);
            font-size:.75rem;
            font-weight:800;
        }

        .checkout-total {
            margin-top:2px;
            color:var(--accent-terracotta);
            font-size:clamp(1.25rem,2vw,1.55rem);
            font-weight:800;
        }

        .shipping-note {
            display:flex;
            align-items:center;
            gap:6px;
            margin-top:5px;
            color:var(--text-muted);
            font-size:.65rem;
            line-height:1.4;
        }

        .shipping-note i { color:var(--primary-green); }

        .checkout-btn {
            flex:0 0 auto;
            min-width:175px;
            padding:13px 18px;
            border:0;
            border-radius:10px;
            background:var(--primary-dark);
            color:#fff;
            cursor:pointer;
            font-size:.78rem;
            font-weight:800;
            box-shadow:0 8px 20px rgba(30,58,43,.12);
            transition:transform .3s var(--spring),background .3s ease,box-shadow .3s ease;
        }

        .checkout-btn:hover:not(:disabled) {
            background:var(--accent-terracotta);
            transform:translateY(-3px);
            box-shadow:0 12px 25px rgba(211,107,72,.2);
        }

        .checkout-btn:disabled {
            cursor:not-allowed;
            opacity:.5;
            box-shadow:none;
        }

        /* EMPTY CART */

        .empty-cart {
            display:none;
            padding:70px 25px;
            text-align:center;
        }

        .empty-cart.visible { display:block; }

        .empty-cart-icon {
            width:70px;
            height:70px;
            margin:0 auto 15px;
            display:grid;
            place-items:center;
            border-radius:50%;
            background:var(--soft-green);
            color:var(--primary-green);
            font-size:1.5rem;
        }

        .empty-cart h3 {
            color:var(--primary-dark);
            font-size:1rem;
            font-weight:800;
        }

        .empty-cart p {
            margin-top:5px;
            color:var(--text-muted);
            font-size:.75rem;
        }

        .continue-shopping {
            display:inline-flex;
            align-items:center;
            gap:7px;
            margin-top:18px;
            padding:10px 15px;
            border-radius:9px;
            background:var(--primary-dark);
            color:#fff;
            text-decoration:none;
            font-size:.7rem;
            font-weight:800;
            transition:.3s var(--ease);
        }

        .continue-shopping:hover {
            background:var(--primary-green);
            transform:translateY(-2px);
        }

        /* REVEAL */

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

        /* TOAST */

        .toast-container {
            position:fixed;
            right:22px;
            bottom:22px;
            z-index:5000;
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
            from {
                opacity:0;
                transform:translateY(20px) scale(.92);
            }
            to {
                opacity:1;
                transform:none;
            }
        }

        /* CLICK POP */

        .click-pop {
            position:fixed;
            width:8px;
            height:8px;
            border-radius:50%;
            pointer-events:none;
            z-index:6000;
            background:rgba(45,90,63,.45);
            transform:translate(-50%,-50%);
            animation:pop .7s ease-out forwards;
        }

        @keyframes pop {
            0% {
                opacity:.85;
                transform:translate(-50%,-50%) scale(1);
            }
            100% {
                opacity:0;
                transform:translate(-50%,-50%) scale(8);
            }
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

        /* TABLET */

        @media (max-width:900px) {
            .navbar { gap:10px; }

            .cart-page { width:92%; }

            .cart-table-header,
            .cart-item {
                grid-template-columns:minmax(0,1fr) 140px 95px;
            }

            .footer-grid { grid-template-columns:1fr 1fr; }
        }

        /* MOBILE */

        @media (max-width:650px) {
            .cart-page {
                width:92%;
                padding-top:100px;
            }

            .cart-header { align-items:flex-start; }

            .cart-header-left h1 { font-size:1.55rem; }
            .cart-header-left p { font-size:.75rem; }

            .purchases-section { margin-bottom:42px; }

            .purchases-table {
                min-width:680px;
            }

            .purchases-table th {
                padding:14px 13px;
                font-size:.6rem;
            }

            .purchases-table td {
                padding:14px 13px;
                font-size:.66rem;
            }

            .purchases-footer {
                align-items:flex-start;
                flex-direction:column;
                gap:5px;
                padding:13px;
                font-size:.62rem;
            }

            .purchase-modal-overlay {
                padding:12px;
            }

            .purchase-modal {
                max-height:92vh;
                border-radius:16px;
            }

            .purchase-modal-header {
                padding:17px 18px;
            }

            .purchase-modal-body {
                padding:16px 18px 20px;
            }

            .purchase-detail-grid {
                gap:8px;
            }

            .purchase-detail-card {
                padding:10px;
            }

            .purchase-detail-value {
                font-size:.7rem;
            }

            .cart-table-header {
                display:grid;
                grid-template-columns:minmax(0,1fr) 90px 72px;
                padding:12px 13px;
                font-size:.6rem;
            }

            .select-all-row {
                padding:12px 13px;
                gap:9px;
            }

            .cart-item {
                grid-template-columns:minmax(0,1fr) 90px 72px;
                padding:14px 13px;
                gap:6px;
            }

            .product-column { gap:9px; }

            .item-image {
                width:62px;
                height:62px;
                border-radius:10px;
            }

            .item-image i { font-size:1.15rem; }
            .item-name { font-size:.73rem; }
            .item-unit { font-size:.61rem; }
            .item-price { font-size:.78rem; }

            .remove-btn {
                padding:7px 8px;
                font-size:.57rem;
            }

            .remove-btn span { display:none; }

            .checkout-section {
                align-items:stretch;
                flex-direction:column;
                gap:15px;
                padding:18px 14px;
            }

            .checkout-info { width:100%; }
            .checkout-btn { width:100%; }

            .footer-grid {
                grid-template-columns:1fr 1fr;
                gap:22px;
            }

            .footer-brand { grid-column:1 / -1; }

            .brand { font-size:1.2rem; }

            .icon-btn {
                width:37px;
                height:37px;
            }

            .toast-container {
                left:15px;
                right:15px;
                bottom:15px;
            }

            .toast {
                min-width:0;
                width:100%;
            }
        }

        /* SMALL MOBILE */

        @media (max-width:430px) {
            .cart-table-header {
                grid-template-columns:minmax(0,1fr) 78px 65px;
            }

            .cart-item {
                grid-template-columns:minmax(0,1fr) 78px 65px;
            }

            .item-image {
                width:54px;
                height:54px;
            }

            .item-name { font-size:.68rem; }
            .item-unit { font-size:.57rem; }
            .item-price { font-size:.72rem; }

            .circle-select {
                width:20px;
                height:20px;
            }

            .product-column { gap:7px; }
            .footer-grid { grid-template-columns:1fr; }

            .purchase-detail-grid {
                grid-template-columns:1fr 1fr;
            }

            .purchase-detail-card.full {
                grid-column:1 / -1;
            }
        }

        /* REDUCED MOTION */

        @media (prefers-reduced-motion:reduce) {
            *,
            *::before,
            *::after {
                animation-duration:.001ms !important;
                animation-iteration-count:1 !important;
                transition-duration:.001ms !important;
                scroll-behavior:auto !important;
            }

            .reveal {
                opacity:1;
                transform:none;
                filter:none;
            }
        }
    </style>
</head>

<body>

    <!-- AMBIENT BACKGROUND -->

    <div class="ambient-bg">
        <div class="ambient-shape shape-a"></div>
        <div class="ambient-shape shape-b"></div>
    </div>

    <!-- TOP NAVIGATION -->

    <nav class="navbar" id="navbar">

        <a href="{{ url('/') }}" class="brand">
            <i class="fa-solid fa-leaf"></i>
            <span>agrimarket</span>
        </a>

        <div class="nav-actions">

            <button class="icon-btn" title="Notifications" onclick="showToast('You have no new notifications.')">
                <i class="fa-regular fa-bell"></i>
            </button>

            <button class="icon-btn" title="Shopping Cart" onclick="document.getElementById('shoppingCartSection').scrollIntoView({behavior:'smooth'})">
                <i class="fa-solid fa-cart-shopping"></i>
            </button>

            <!-- PROFILE -->

            <div class="dropdown-wrap">

                <button class="icon-btn" id="profileButton" title="Profile">
                    <i class="fa-regular fa-user"></i>
                </button>

                <div class="dropdown" id="profileMenu">

                    <a href="#">
                        <i class="fa-regular fa-user"></i>Profile
                    </a>

                    <a href="#">
                        <i class="fa-solid fa-box"></i>My Orders
                    </a>

                    <a href="#myPurchasesSection">
                        <i class="fa-solid fa-bag-shopping"></i>My Purchases
                    </a>

                    <a href="#">
                        <i class="fa-solid fa-gear"></i>Settings
                    </a>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit">
                            <i class="fa-solid fa-right-from-bracket"></i>Logout
                        </button>
                    </form>

                </div>

            </div>

        </div>
    </nav>

    <!-- MAIN -->

    <main>

        <section class="cart-page">

            <!-- MY PURCHASES SECTION -->

            <section class="purchases-section reveal" id="myPurchasesSection">

                <div class="cart-header">

                    <div class="cart-header-left">

                        <span class="eyebrow">Your Orders</span>

                        <h1>My Purchases</h1>

                        <p>View the products you have ordered from other sellers.</p>

                    </div>

                </div>

                <div class="purchases-container">

                    <div class="purchases-table-wrap">

                        <table class="purchases-table" id="purchasesTable">

                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Seller Name</th>
                                    <th>Product</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>

                            <tbody id="purchasesTableBody">
                            </tbody>

                        </table>

                    </div>

                    <!-- EMPTY PURCHASES -->

                    <div class="empty-purchases" id="emptyPurchases">

                        <div class="empty-purchases-icon">
                            <i class="fa-solid fa-bag-shopping"></i>
                        </div>

                        <h3>No purchases yet</h3>

                        <p>Your orders from other sellers will appear here.</p>

                    </div>

                    <div class="purchases-footer">

                        <span>
                            <i class="fa-solid fa-circle-info"></i>
                            Click a purchase to view its complete details.
                        </span>

                        <span id="purchaseCount">0 purchases</span>

                    </div>

                </div>

            </section>

            <!-- SHOPPING CART SECTION -->

            <section class="reveal" id="shoppingCartSection">

                <div class="cart-header">

                    <div class="cart-header-left">

                        <span class="eyebrow">Your Items</span>

                        <h1>
                            Shopping Cart
                            <span id="headerCartCount">(0)</span>
                        </h1>

                        <p>Review your selected products before checkout.</p>

                    </div>

                </div>

                <div class="cart-container">

                    <div class="cart-table-header">
                        <div>Product</div>
                        <div class="price-header">Price</div>
                        <div class="remove-header"></div>
                    </div>

                    <div class="select-all-row">

                        <button
                            class="circle-select"
                            id="selectAllButton"
                            type="button"
                            aria-label="Select all items"
                            aria-pressed="false"
                        ></button>

                        <span class="select-all-text">All</span>

                        <span class="selection-count" id="selectionCount">
                            0 selected
                        </span>

                    </div>

                    <div id="cartItems"></div>

                    <div class="empty-cart" id="emptyCart">

                        <div class="empty-cart-icon">
                            <i class="fa-solid fa-cart-shopping"></i>
                        </div>

                        <h3>Your cart is empty</h3>

                        <p>Add some agricultural products to get started.</p>

                        <a href="{{ url('/') }}" class="continue-shopping">
                            Continue Shopping
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>

                    </div>

                    <div class="checkout-section" id="checkoutSection">

                        <div class="checkout-info">

                            <div class="checkout-selected" id="checkoutSelected">
                                0 items selected
                            </div>

                            <div class="checkout-total-label">
                                Total
                            </div>

                            <div class="checkout-total" id="checkoutTotal">
                                ₱0.00
                            </div>

                            <div class="shipping-note">

                                <i class="fa-solid fa-truck"></i>

                                <span>
                                    Shipping fee will be added after checkout.
                                </span>

                            </div>

                        </div>

                        <button
                            class="checkout-btn"
                            id="checkoutButton"
                            type="button"
                            disabled
                        >
                            Check out (0)
                        </button>

                    </div>

                </div>

            </section>

        </section>

    </main>

    <!-- PURCHASE DETAILS MODAL -->

    <div
        class="purchase-modal-overlay"
        id="purchaseModal"
        aria-hidden="true"
    >

        <div
            class="purchase-modal"
            role="dialog"
            aria-modal="true"
            aria-labelledby="purchaseModalTitle"
        >

            <div class="purchase-modal-header">

                <div class="purchase-modal-heading">

                    <h2 id="purchaseModalTitle">
                        Purchase Details
                    </h2>

                </div>

                <button
                    class="modal-close"
                    id="closePurchaseModal"
                    type="button"
                    aria-label="Close purchase details"
                >
                    <i class="fa-solid fa-xmark"></i>
                </button>

            </div>

            <div class="purchase-modal-body">

                <!-- ORDER INFORMATION -->

                <div class="purchase-detail-grid">

                    <div class="purchase-detail-card">

                        <span class="purchase-detail-label">
                            Order ID
                        </span>

                        <span class="purchase-detail-value" id="detailOrderId">
                            —
                        </span>

                    </div>

                    <div class="purchase-detail-card">

                        <span class="purchase-detail-label">
                            Order Status
                        </span>

                        <span class="purchase-detail-value" id="detailStatus">
                            —
                        </span>

                    </div>

                    <div class="purchase-detail-card">

                        <span class="purchase-detail-label">
                            Seller Name
                        </span>

                        <span class="purchase-detail-value" id="detailSeller">
                            —
                        </span>

                    </div>

                    <div class="purchase-detail-card">

                        <span class="purchase-detail-label">
                            Order Date
                        </span>

                        <span class="purchase-detail-value" id="detailDate">
                            —
                        </span>

                    </div>

                    <div class="purchase-detail-card">

                        <span class="purchase-detail-label">
                            Total Amount
                        </span>

                        <span class="purchase-detail-value amount" id="detailTotalAmount">
                            ₱0.00
                        </span>

                    </div>

                </div>

                <!-- PRODUCTS ORDERED -->

                <div class="purchase-products-heading">

                    <i class="fa-solid fa-basket-shopping"></i>

                    <span>Product Purchased</span>

                </div>

                <div class="purchase-products-list" id="detailProducts">
                </div>

                <!-- CANCEL PENDING PURCHASE -->

                <div
                    class="cancel-purchase-container"
                    id="cancelPurchaseContainer"
                >

                    <button
                        type="button"
                        class="cancel-purchase-btn"
                        id="cancelPurchaseButton"
                    >
                        <i class="fa-solid fa-ban"></i>
                        Cancel Order
                    </button>

                </div>

            </div>

        </div>

    </div>

    <!-- FOOTER -->

    <footer>

        <div class="footer-grid">

            <div class="footer-brand">

                <a href="{{ url('/') }}" class="brand" style="color:#fff">

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
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">Help & Support</a></li>
                </ul>

            </div>

            <div class="footer-links">

                <h4>Legal</h4>

                <ul>
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>

            </div>

            <div class="footer-links">

                <h4>Marketplace</h4>

                <ul>
                    <li><a href="#">New & Fresh</a></li>
                    <li><a href="#">Best Sellers</a></li>
                    <li><a href="#">Groceries</a></li>
                </ul>

            </div>

        </div>

        <div class="copyright">
            © 2026 AgriMarket. All rights reserved.
        </div>

    </footer>

    <!-- TOAST -->

    <div class="toast-container" id="toastContainer"></div>

    <!-- JAVASCRIPT -->

    <script>

        /*
        |--------------------------------------------------------------------------
        | DATABASE PURCHASE DATA
        |--------------------------------------------------------------------------
        */

        let purchases = @json($purchases ?? []);

        /*
        |--------------------------------------------------------------------------
        | DATABASE CART ROUTES
        |--------------------------------------------------------------------------
        */

        const cartItemsRoute = @json(route('cart.items'));

        const removeCartRoute = @json(
            route('cart.remove', ['cartId' => '__CART_ID__'])
        );

        const cancelPurchaseRoute = @json(
            route('orders.cancelPurchase', ['requestId' => '__REQUEST_ID__'])
        );

        /*
        |--------------------------------------------------------------------------
        | ORDER SUMMARY ROUTE
        |--------------------------------------------------------------------------
        */

        const orderSummaryRoute = @json(route('ordersummary'));

        /*
        |--------------------------------------------------------------------------
        | CSRF TOKEN
        |--------------------------------------------------------------------------
        */

        const csrfToken = document.querySelector(
            'meta[name="csrf-token"]'
        ).content;

        /*
        |--------------------------------------------------------------------------
        | PURCHASE VARIABLES
        |--------------------------------------------------------------------------
        */

        let currentPurchaseIndex = null;

        let isCancellingPurchase = false;

        /*
        |--------------------------------------------------------------------------
        | CART VARIABLES
        |--------------------------------------------------------------------------
        */

        let cartItems = [];

        let selectedItems = new Set();

        let isLoadingCart = false;

        let isRemovingItem = false;

        let isCheckingOut = false;

        /*
        |--------------------------------------------------------------------------
        | FORMAT PRICE
        |--------------------------------------------------------------------------
        */

        function formatPrice(price) {

            return Number(price || 0).toLocaleString("en-PH", {
                minimumFractionDigits:2,
                maximumFractionDigits:2
            });

        }

        /*
        |--------------------------------------------------------------------------
        | ESCAPE DATABASE TEXT
        |--------------------------------------------------------------------------
        */

        function escapeHTML(value) {

            return String(value ?? "").replace(/[&<>"']/g, character => {

                const entities = {
                    "&":"&amp;",
                    "<":"&lt;",
                    ">":"&gt;",
                    '"':"&quot;",
                    "'":"&#039;"
                };

                return entities[character];

            });

        }

        /*
        |--------------------------------------------------------------------------
        | GET STATUS CLASS
        |--------------------------------------------------------------------------
        */

        function getStatusClass(status) {

            const normalizedStatus = String(status ?? "").toLowerCase();

            if (
                normalizedStatus === "delivered" ||
                normalizedStatus === "completed"
            ) {
                return "status-completed";
            }

            if (normalizedStatus === "processing") {
                return "status-processing";
            }

            if (normalizedStatus === "pending") {
                return "status-pending";
            }

            if (
                normalizedStatus === "shipping" ||
                normalizedStatus === "shipped" ||
                normalizedStatus === "in transit"
            ) {
                return "status-shipping";
            }

            if (
                normalizedStatus === "cancelled" ||
                normalizedStatus === "canceled"
            ) {
                return "status-cancelled";
            }

            return "status-processing";

        }

        /*
        |--------------------------------------------------------------------------
        | RENDER MY PURCHASES
        |--------------------------------------------------------------------------
        */

        function renderPurchases() {

            const tableBody = document.getElementById("purchasesTableBody");

            const emptyPurchases = document.getElementById("emptyPurchases");

            const table = document.getElementById("purchasesTable");

            const purchaseCount = document.getElementById("purchaseCount");

            purchaseCount.textContent =
                `${purchases.length} ${purchases.length === 1 ? "purchase" : "purchases"}`;

            if (purchases.length === 0) {

                tableBody.innerHTML = "";

                table.style.display = "none";

                emptyPurchases.classList.add("visible");

                return;

            }

            table.style.display = "table";

            emptyPurchases.classList.remove("visible");

            tableBody.innerHTML = purchases.map((purchase,index) => {

                const products = Array.isArray(purchase.products)
                    ? purchase.products
                    : [];

                const productNames = products.map(product => {

                    return `${escapeHTML(product.name)} × ${Number(product.quantity)}`;

                }).join(", ");

                const status = escapeHTML(purchase.status);

                const statusClass = getStatusClass(purchase.status);

                return `

                    <tr
                        onclick="openPurchaseDetails(${index})"
                        tabindex="0"
                        role="button"
                        aria-label="View order ${escapeHTML(purchase.id)} details"
                        onkeydown="if(event.key === 'Enter' || event.key === ' ') {
                            event.preventDefault();
                            openPurchaseDetails(${index});
                        }"
                    >

                        <td>
                            <span class="order-id">
                                ${escapeHTML(purchase.id)}
                            </span>
                        </td>

                        <td>
                            ${escapeHTML(purchase.seller)}
                        </td>

                        <td>
                            ${productNames}
                        </td>

                        <td>
                            <span class="purchase-amount">
                                ₱${formatPrice(purchase.amount)}
                            </span>
                        </td>

                        <td>
                            <span class="status ${statusClass}">
                                ${status}
                            </span>
                        </td>

                    </tr>

                `;

            }).join("");

        }

        /*
        |--------------------------------------------------------------------------
        | OPEN PURCHASE DETAILS
        |--------------------------------------------------------------------------
        */

        function openPurchaseDetails(index) {

            const purchase = purchases[index];

            if (!purchase) return;

            currentPurchaseIndex = index;

            document.getElementById("detailOrderId").textContent =
                purchase.id;

            document.getElementById("detailSeller").textContent =
                purchase.seller;

            document.getElementById("detailDate").textContent =
                purchase.date;

            document.getElementById("detailTotalAmount").textContent =
                `₱${formatPrice(purchase.amount)}`;

            const status = escapeHTML(purchase.status);

            document.getElementById("detailStatus").innerHTML = `

                <span class="status ${getStatusClass(purchase.status)}">
                    ${status}
                </span>

            `;

            /*
            |--------------------------------------------------------------------------
            | RENDER ORDERED PRODUCTS
            |--------------------------------------------------------------------------
            */

            const products = Array.isArray(purchase.products)
                ? purchase.products
                : [];

            document.getElementById("detailProducts").innerHTML =

                products.map(product => `

                    <div class="purchase-product-row">

                        <span class="purchase-product-name">
                            ${escapeHTML(product.name)}
                        </span>

                        <span class="purchase-product-price">

                            ${Number(product.quantity)}
                            ${escapeHTML(product.unit || "")}

                        </span>

                    </div>

                `).join("");

            /*
            |--------------------------------------------------------------------------
            | SHOW CANCEL BUTTON ONLY FOR PENDING PURCHASES
            |--------------------------------------------------------------------------
            */

            const cancelContainer = document.getElementById(
                "cancelPurchaseContainer"
            );

            const cancelButton = document.getElementById(
                "cancelPurchaseButton"
            );

            const isPending =
                String(purchase.status).toLowerCase() === "pending";

            const canCancel =
                isPending &&
                purchase.request_id !== null &&
                purchase.request_id !== undefined &&
                purchase.request_id !== "";

            cancelContainer.style.display =
                canCancel ? "block" : "none";

            cancelButton.disabled = false;

            cancelButton.innerHTML = `
                <i class="fa-solid fa-ban"></i>
                Cancel Order
            `;

            const modal = document.getElementById("purchaseModal");

            modal.classList.add("open");

            modal.setAttribute("aria-hidden","false");

            document.body.style.overflow = "hidden";

        }

        /*
        |--------------------------------------------------------------------------
        | CLOSE PURCHASE DETAILS
        |--------------------------------------------------------------------------
        */

        function closePurchaseDetails() {

            const modal = document.getElementById("purchaseModal");

            modal.classList.remove("open");

            modal.setAttribute("aria-hidden","true");

            document.body.style.overflow = "";

            currentPurchaseIndex = null;

        }

        /*
        |--------------------------------------------------------------------------
        | PURCHASE MODAL EVENTS
        |--------------------------------------------------------------------------
        */

        document
            .getElementById("closePurchaseModal")
            .addEventListener("click",closePurchaseDetails);

        document
            .getElementById("purchaseModal")
            .addEventListener("click",e => {

                if (e.target.id === "purchaseModal") {

                    closePurchaseDetails();

                }

            });

        /*
        |--------------------------------------------------------------------------
        | CLOSE MODAL WITH ESCAPE KEY
        |--------------------------------------------------------------------------
        */

        document.addEventListener("keydown",e => {

            if (e.key === "Escape") {

                closePurchaseDetails();

            }

        });

        /*
        |--------------------------------------------------------------------------
        | CANCEL PENDING PURCHASE
        |--------------------------------------------------------------------------
        */

        async function cancelPurchase() {

            if (
                currentPurchaseIndex === null ||
                isCancellingPurchase
            ) {
                return;
            }

            const purchase = purchases[currentPurchaseIndex];

            if (!purchase || !purchase.request_id) {
                showToast("Unable to identify this order request.");
                return;
            }

            if (
                String(purchase.status).toLowerCase() !== "pending"
            ) {

                showToast("Only pending orders can be cancelled.");

                return;

            }

            const confirmed = window.confirm(
                "Are you sure you want to cancel this order?\n\n" +
                "Once cancelled, this order request will be permanently removed."
            );

            if (!confirmed) return;

            const button = document.getElementById(
                "cancelPurchaseButton"
            );

            isCancellingPurchase = true;

            button.disabled = true;

            button.innerHTML = `
                <i class="fa-solid fa-spinner fa-spin"></i>
                Cancelling...
            `;

            try {

                const url = cancelPurchaseRoute.replace(
                    "__REQUEST_ID__",
                    encodeURIComponent(purchase.request_id)
                );

                const response = await fetch(url, {

                    method:"DELETE",

                    headers:{

                        "X-CSRF-TOKEN":csrfToken,

                        "Accept":"application/json",

                        "Content-Type":"application/json"

                    }

                });

                const result = await response.json();

                if (!response.ok || !result.success) {

                    throw new Error(
                        result.message || "Unable to cancel your order."
                    );

                }

                purchases.splice(currentPurchaseIndex,1);

                closePurchaseDetails();

                renderPurchases();

                showToast(result.message);

            } catch (error) {

                showToast(error.message);

                button.disabled = false;

                button.innerHTML = `
                    <i class="fa-solid fa-ban"></i>
                    Cancel Order
                `;

            } finally {

                isCancellingPurchase = false;

            }

        }

        /*
        |--------------------------------------------------------------------------
        | CANCEL BUTTON EVENT
        |--------------------------------------------------------------------------
        */

        document
            .getElementById("cancelPurchaseButton")
            .addEventListener("click",cancelPurchase);

        /*
        |--------------------------------------------------------------------------
        | LOAD CART ITEMS FROM DATABASE
        |--------------------------------------------------------------------------
        */

        async function loadCart() {

            if (isLoadingCart) return;

            isLoadingCart = true;

            const container = document.getElementById("cartItems");

            container.innerHTML = `
                <div style="padding:35px 20px;text-align:center;color:#667085;font-size:.78rem;">
                    <i class="fa-solid fa-spinner fa-spin" style="margin-right:7px;"></i>
                    Loading your cart...
                </div>
            `;

            try {

                const response = await fetch(cartItemsRoute, {

                    method:"GET",

                    headers:{

                        "Accept":"application/json",

                        "X-Requested-With":"XMLHttpRequest"

                    }

                });

                const result = await response.json();

                if (!response.ok) {

                    throw new Error(
                        result.message || "Unable to load your cart."
                    );

                }

                /*
                |--------------------------------------------------------------------------
                | SUPPORT BOTH ARRAY AND OBJECT RESPONSES
                |--------------------------------------------------------------------------
                */

                const databaseItems = Array.isArray(result)
                    ? result
                    : (result.cartItems || result.items || []);

                /*
                |--------------------------------------------------------------------------
                | CONVERT DATABASE RECORDS INTO CART ITEMS
                |--------------------------------------------------------------------------
                */

                cartItems = databaseItems.map(item => {

                    const quantity = Number(item.quantity || 1);

                    const totalAmount = Number(
                        item.total_amount ?? item.product_amount ?? item.price ?? 0
                    );

                    const unitPrice = Number(
                        item.unit_price ?? (
                            quantity > 0
                                ? totalAmount / quantity
                                : totalAmount
                        )
                    );

                    return {

                        id:Number(item.cart_id),

                        cart_id:Number(item.cart_id),

                        product_id:item.product_id,

                        seller_id:item.seller_id,

                        name:item.product_name,

                        seller:item.seller_name,

                        unit:item.oum || "",

                        quantity:quantity,

                        price:unitPrice,

                        total_amount:totalAmount,

                        image:item.image || null

                    };

                });

                selectedItems.clear();

                renderCart();

            } catch (error) {

                container.innerHTML = `
                    <div style="padding:35px 20px;text-align:center;color:#bd4c3b;font-size:.78rem;">
                        <i class="fa-solid fa-circle-exclamation" style="margin-right:7px;"></i>
                        ${escapeHTML(error.message)}
                    </div>
                `;

                showToast(error.message);

                document.getElementById("checkoutSection").style.display = "none";

            } finally {

                isLoadingCart = false;

            }

        }

        /*
        |--------------------------------------------------------------------------
        | CREATE CART ITEM
        |--------------------------------------------------------------------------
        */

        function createCartItem(item) {

            const isSelected = selectedItems.has(item.id);

            const imageHTML = item.image
                ? `
                    <img
                        src="{{ asset('image') }}/${encodeURIComponent(item.image)}"
                        alt="${escapeHTML(item.name)}"
                        onerror="this.style.display='none';this.nextElementSibling.style.display='block';"
                    >
                    <i class="fa-regular fa-image" style="display:none;"></i>
                `
                : `<i class="fa-regular fa-image"></i>`;

            return `

                <div class="cart-item" data-id="${item.id}" id="cart-item-${item.id}">

                    <div class="product-column">

                        <button
                            type="button"
                            class="circle-select ${isSelected ? "selected" : ""}"
                            onclick="toggleItem(${item.id})"
                            aria-label="Select ${escapeHTML(item.name)}"
                            aria-pressed="${isSelected}"
                        ></button>

                        <div class="item-image">
                            ${imageHTML}
                        </div>

                        <div class="item-details">

                            <div class="item-name">
                                ${escapeHTML(item.name)}
                            </div>

                            <div class="item-unit">

                                <i class="fa-solid fa-scale-balanced"></i>

                                ${escapeHTML(item.quantity)} ${escapeHTML(item.unit)}

                            </div>

                        </div>

                    </div>

                    <div class="item-price">
                        ₱${formatPrice(item.total_amount)}
                    </div>

                    <div class="remove-column">

                        <button
                            type="button"
                            class="remove-btn"
                            onclick="removeItem(${item.id})"
                            aria-label="Remove ${escapeHTML(item.name)}"
                        >

                            <i class="fa-solid fa-trash-can"></i>

                            <span>Remove</span>

                        </button>

                    </div>

                </div>

            `;

        }

        /*
        |--------------------------------------------------------------------------
        | RENDER CART
        |--------------------------------------------------------------------------
        */

        function renderCart() {

            const container = document.getElementById("cartItems");

            const emptyCart = document.getElementById("emptyCart");

            const checkoutSection = document.getElementById("checkoutSection");

            selectedItems = new Set(

                [...selectedItems].filter(id =>

                    cartItems.some(item => item.id === id)

                )

            );

            if (cartItems.length === 0) {

                container.innerHTML = "";

                emptyCart.classList.add("visible");

                checkoutSection.style.display = "none";

            } else {

                emptyCart.classList.remove("visible");

                checkoutSection.style.display = "flex";

                container.innerHTML = cartItems.map(createCartItem).join("");

            }

            updateCartSummary();

        }

        /*
        |--------------------------------------------------------------------------
        | TOGGLE INDIVIDUAL ITEM
        |--------------------------------------------------------------------------
        */

        function toggleItem(id) {

            if (selectedItems.has(id)) {

                selectedItems.delete(id);

            } else {

                selectedItems.add(id);

            }

            renderCart();

        }

        /*
        |--------------------------------------------------------------------------
        | SELECT ALL
        |--------------------------------------------------------------------------
        */

        function toggleSelectAll() {

            if (cartItems.length === 0) return;

            const allSelected = selectedItems.size === cartItems.length;

            if (allSelected) {

                selectedItems.clear();

            } else {

                selectedItems = new Set(cartItems.map(item => item.id));

            }

            renderCart();

        }

        /*
        |--------------------------------------------------------------------------
        | REMOVE ITEM FROM DATABASE
        |--------------------------------------------------------------------------
        */

        async function removeItem(id) {

            if (isRemovingItem) return;

            const item = cartItems.find(product => product.id === id);

            if (!item) return;

            const element = document.getElementById(`cart-item-${id}`);

            const removeButton = element?.querySelector(".remove-btn");

            if (removeButton) {

                removeButton.disabled = true;

                removeButton.innerHTML = `
                    <i class="fa-solid fa-spinner fa-spin"></i>
                    <span>Removing</span>
                `;

            }

            isRemovingItem = true;

            try {

                const url = removeCartRoute.replace(
                    "__CART_ID__",
                    encodeURIComponent(item.cart_id)
                );

                const response = await fetch(url, {

                    method:"DELETE",

                    headers:{

                        "X-CSRF-TOKEN":csrfToken,

                        "Accept":"application/json",

                        "Content-Type":"application/json"

                    }

                });

                const result = await response.json();

                if (!response.ok || !result.success) {

                    throw new Error(
                        result.message || "Unable to remove this item."
                    );

                }

                if (element) {

                    element.classList.add("removing");

                }

                setTimeout(() => {

                    cartItems = cartItems.filter(
                        product => product.id !== id
                    );

                    selectedItems.delete(id);

                    renderCart();

                    showToast(result.message || `${item.name} was removed from your cart.`);

                },300);

            } catch (error) {

                showToast(error.message);

                if (removeButton) {

                    removeButton.disabled = false;

                    removeButton.innerHTML = `
                        <i class="fa-solid fa-trash-can"></i>
                        <span>Remove</span>
                    `;

                }

            } finally {

                isRemovingItem = false;

            }

        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE CART SUMMARY
        |--------------------------------------------------------------------------
        */

        function updateCartSummary() {

            const totalItems = cartItems.length;

            const selectedCount = selectedItems.size;

            const total = cartItems

                .filter(item => selectedItems.has(item.id))

                .reduce(

                    (sum,item) =>

                        sum + Number(item.total_amount),

                    0

                );

            document.getElementById("headerCartCount").textContent =
                `(${totalItems})`;

            document.getElementById("selectionCount").textContent =
                `${selectedCount} selected`;

            document.getElementById("checkoutSelected").textContent =

                `${selectedCount} ${selectedCount === 1 ? "item" : "items"} selected`;

            document.getElementById("checkoutTotal").textContent =

                `₱${formatPrice(total)}`;

            const checkoutButton = document.getElementById("checkoutButton");

            checkoutButton.textContent = `Check out (${selectedCount})`;

            checkoutButton.disabled = selectedCount === 0 || isCheckingOut;

            const selectAllButton = document.getElementById("selectAllButton");

            const allSelected =

                totalItems > 0 &&

                selectedCount === totalItems;

            selectAllButton.classList.toggle("all-selected",allSelected);

            selectAllButton.setAttribute("aria-pressed",allSelected);

        }

        /*
        |--------------------------------------------------------------------------
        | CHECKOUT SELECTED CART ITEMS
        |--------------------------------------------------------------------------
        */

        function checkout() {
        const selectedCartItems = cartItems.filter(item =>
            selectedItems.has(item.id)
        );

        if (selectedCartItems.length === 0) {
            showToast('Please select at least one product.');
            return;
        }

        const form = document.createElement('form');

        form.method = 'POST';

        form.action = orderSummaryRoute;

        const token = document.createElement('input');

        token.type = 'hidden';
        token.name = '_token';
        token.value = csrfToken;

        form.appendChild(token);

        selectedCartItems.forEach(item => {

            const input = document.createElement('input');

            input.type = 'hidden';
            input.name = 'cart_ids[]';
            input.value = item.cart_id;

            form.appendChild(input);

        });

        document.body.appendChild(form);

        form.submit();

    }

        /*
        |--------------------------------------------------------------------------
        | TOAST
        |--------------------------------------------------------------------------
        */

        function showToast(message) {

            const container = document.getElementById("toastContainer");

            const toast = document.createElement("div");

            toast.className = "toast";

            const icon = document.createElement("i");

            icon.className = "fa-solid fa-circle-check";

            const text = document.createElement("span");

            text.textContent = message;

            toast.appendChild(icon);

            toast.appendChild(text);

            container.appendChild(toast);

            setTimeout(() => {

                toast.style.opacity = "0";

                toast.style.transform = "translateY(10px)";

                toast.style.transition = ".3s ease";

                setTimeout(() => {

                    toast.remove();

                },300);

            },2600);

        }

        /*
        |--------------------------------------------------------------------------
        | SELECT ALL BUTTON
        |--------------------------------------------------------------------------
        */

        document
            .getElementById("selectAllButton")
            .addEventListener("click",toggleSelectAll);

        /*
        |--------------------------------------------------------------------------
        | CHECKOUT BUTTON
        |--------------------------------------------------------------------------
        */

        document
            .getElementById("checkoutButton")
            .addEventListener("click",checkout);

        /*
        |--------------------------------------------------------------------------
        | NAVBAR SCROLL EFFECT
        |--------------------------------------------------------------------------
        */

        window.addEventListener(

            "scroll",

            () => {

                document

                    .getElementById("navbar")

                    .classList

                    .toggle("scrolled",window.scrollY > 25);

            },

            { passive:true }

        );

        /*
        |--------------------------------------------------------------------------
        | PROFILE DROPDOWN
        |--------------------------------------------------------------------------
        */

        const profileButton = document.getElementById("profileButton");

        const profileMenu = document.getElementById("profileMenu");

        profileButton.addEventListener("click",e => {

            e.stopPropagation();

            profileMenu.classList.toggle("open");

        });

        /*
        |--------------------------------------------------------------------------
        | CLOSE DROPDOWN
        |--------------------------------------------------------------------------
        */

        document.addEventListener("click",() => {

            profileMenu.classList.remove("open");

        });

        /*
        |--------------------------------------------------------------------------
        | CLICK POP
        |--------------------------------------------------------------------------
        */

        document.addEventListener("click",e => {

            const pop = document.createElement("span");

            pop.className = "click-pop";

            pop.style.left = `${e.clientX}px`;

            pop.style.top = `${e.clientY}px`;

            document.body.appendChild(pop);

            setTimeout(() => pop.remove(),700);

        });

        /*
        |--------------------------------------------------------------------------
        | INITIAL SETUP
        |--------------------------------------------------------------------------
        */

        const observer = new IntersectionObserver(

            entries => {

                entries.forEach(entry => {

                    if (entry.isIntersecting) {

                        entry.target.classList.add("visible");

                    } else {

                        entry.target.classList.remove("visible");

                    }

                });

            },

            {

                threshold:.12,

                rootMargin:"0px 0px -45px 0px"

            }

        );

        document

            .querySelectorAll(".reveal")

            .forEach(element => observer.observe(element));

        /*
        |--------------------------------------------------------------------------
        | RENDER INITIAL CONTENT
        |--------------------------------------------------------------------------
        */

        renderPurchases();

        loadCart();

    </script>

</body>
</html>