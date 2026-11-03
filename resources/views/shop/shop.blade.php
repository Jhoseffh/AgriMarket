
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AgriMarket - Shop</title>
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
            --bg-card:#fff;
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

        /* Ambient background */
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

        /* Navigation */
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
            transition:
                padding .45s var(--ease),
                box-shadow .45s ease,
                background .45s ease;
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

        /* Search */
        .nav-search-wrap {
            position:relative;
            flex:1;
            max-width:600px;
            margin:0 auto;
        }

        .nav-search {
            width:100%;
            display:flex;
            align-items:center;
            gap:7px;
            padding:5px 6px 5px 14px;
            background:#fff;
            border:1px solid var(--border-color);
            border-radius:12px;
            box-shadow:var(--shadow-sm);
        }

        .nav-search i { color:var(--text-muted); }

        .nav-search input {
            flex:1;
            min-width:0;
            border:0;
            outline:0;
            color:var(--text-main);
            background:transparent;
            padding:9px 4px;
        }

        .nav-search button {
            border:0;
            background:var(--primary-dark);
            color:#fff;
            width:38px;
            height:38px;
            border-radius:9px;
            cursor:pointer;
            transition:transform .3s var(--spring),background .3s ease;
        }

        .nav-search button:hover {
            background:var(--primary-green);
            transform:translateY(-2px);
        }

        /* Search suggestions */
        .search-suggestions {
            position:absolute;
            top:calc(100% + 8px);
            left:0;
            right:0;
            width:100%;
            padding:7px;
            background:#fff;
            border:1px solid var(--border-color);
            border-radius:12px;
            box-shadow:var(--shadow-lg);
            opacity:0;
            visibility:hidden;
            transform:translateY(-7px);
            transition:.3s var(--ease);
            z-index:2100;
        }

        .search-suggestions.open {
            opacity:1;
            visibility:visible;
            transform:translateY(0);
        }

        .search-suggestion {
            width:100%;
            display:flex;
            align-items:center;
            gap:10px;
            padding:10px 11px;
            border:0;
            border-radius:9px;
            background:transparent;
            color:var(--text-main);
            text-decoration:none;
            text-align:left;
            cursor:pointer;
            font-size:.82rem;
            transition:.25s var(--ease);
        }

        .search-suggestion:hover {
            background:var(--soft-green);
            color:var(--primary-green);
        }

        .search-suggestion i {
            flex:0 0 auto;
            color:var(--primary-green);
            font-size:.78rem;
        }

        .search-suggestion span {
            min-width:0;
            overflow:hidden;
            text-overflow:ellipsis;
            white-space:nowrap;
        }

        .search-no-result {
            padding:11px 12px;
            color:var(--text-muted);
            font-size:.78rem;
        }

        .nav-actions {
            display:flex;
            align-items:center;
            justify-content:flex-end;
            gap:7px;
            flex:0 0 auto;
            min-width:max-content;
        }

        .icon-btn {
            position:relative;
            width:42px;
            height:42px;
            min-width:42px;
            flex:0 0 42px;
            display:grid;
            place-items:center;
            padding:0;
            border:1px solid transparent;
            background:transparent;
            color:var(--primary-dark);
            border-radius:10px;
            cursor:pointer;
            text-decoration:none;
            line-height:1;
            transition:.3s var(--ease);
        }

        .icon-btn > i {
            display:block;
            line-height:1;
            font-size:1rem;
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

        /* Category button */
        .category-desktop { flex:0 0 auto; }

        .category-desktop .icon-btn {
            width:auto;
            min-width:105px;
            height:42px;
            padding:0 13px;
            display:flex;
            align-items:center;
            justify-content:center;
            gap:8px;
            background:#fff;
            border-color:var(--border-color);
            color:var(--primary-dark);
            font-size:.78rem;
            font-weight:800;
            white-space:nowrap;
        }

        .category-desktop .icon-btn i {
            font-size:.95rem;
            color:var(--primary-green);
        }

        .category-desktop .icon-btn:hover {
            background:var(--soft-green);
            border-color:rgba(45,90,63,.2);
            color:var(--primary-green);
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

        /* Category dropdown */
        .category-dropdown {
            left:50%;
            right:auto;
            width:590px;
            display:grid;
            grid-template-columns:repeat(3,1fr);
            gap:5px;
            padding:10px;
            transform:translateX(-52%) translateY(-8px) scale(.97);
        }

        .category-dropdown.open {
            opacity:1;
            visibility:visible;
            transform:translateX(-52%);
        }

        .category-dropdown a {
            min-width:0;
            padding:10px 9px;
            gap:8px;
            font-size:.78rem;
            white-space:nowrap;
        }

        .category-dropdown a i {
            width:17px;
            flex:0 0 17px;
            text-align:center;
            color:var(--primary-green);
            font-size:.82rem;
        }

        .category-dropdown a:hover i { color:var(--accent-terracotta); }
        .mobile-menu-btn { display:none; }

        /* General sections */
        .section {
            width:min(1400px,90%);
            margin:0 auto;
            padding:24px 0;
        }

        .section-heading {
            display:flex;
            align-items:end;
            justify-content:space-between;
            gap:20px;
            margin-bottom:14px;
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

        .heading-left h2 {
            margin-top:8px;
            color:var(--primary-dark);
            font-size:clamp(1.55rem,2.5vw,2.25rem);
            line-height:1.15;
            font-weight:800;
        }

        .heading-left p {
            margin-top:5px;
            color:var(--text-muted);
            font-size:.88rem;
        }

        .view-all {
            color:var(--accent-terracotta);
            text-decoration:none;
            font-size:.82rem;
            font-weight:800;
            white-space:nowrap;
        }

        .view-all:hover { color:var(--accent-terracotta-hover); }

        /* Hero */
        .hero {
            width:min(1400px,90%);
            margin:0 auto;
            padding:116px 0 24px;
        }

        .hero-grid {
            display:grid;
            grid-template-columns:1.42fr .78fr;
            grid-template-rows:215px 215px;
            gap:14px;
            min-height:444px;
        }

        .hero-slot {
            position:relative;
            overflow:hidden;
            border-radius:20px;
            border:1px solid #cbd4cd;
            background:#e9ecef;
            box-shadow:var(--shadow-md);
        }

        .hero-slot img,
        .promo-slot img {
            width:100%;
            height:100%;
            display:block;
            object-fit:cover;
            transition:transform .6s var(--ease);
        }

        .hero-slot:hover img,
        .promo-slot:hover img { transform:scale(1.045); }

        .hero-slot.main { grid-row:1 / 3; }
        .hero-slot:nth-child(2),
        .hero-slot:nth-child(3) { transform:none; }

        .placeholder {
            position:absolute;
            inset:0;
            display:grid;
            place-items:center;
            text-align:center;
            padding:20px;
            color:#6c757d;
            background:linear-gradient(135deg,rgba(255,255,255,.38),transparent 50%),#e9ecef;
        }

        .placeholder::before {
            content:"";
            position:absolute;
            width:180%;
            height:50%;
            background:rgba(255,255,255,.34);
            transform:rotate(-18deg) translateX(-80%);
            transition:transform .9s var(--ease);
        }

        .product-card:hover .placeholder::before,
        .hero-slot:hover .placeholder::before,
        .promo-slot:hover .placeholder::before,
        .quick-slot:hover .placeholder::before {
            transform:rotate(-18deg) translateX(80%);
        }

        .placeholder-content { position:relative; z-index:1; }

        .placeholder i {
            font-size:2rem;
            color:#a8b0b5;
            margin-bottom:7px;
        }

        .placeholder strong {
            display:block;
            font-size:.8rem;
        }

        .placeholder small {
            display:block;
            margin-top:3px;
            font-size:.68rem;
        }

        /* Promo row */
        .promo-grid {
            display:grid;
            grid-template-columns:repeat(4,1fr);
            gap:15px;
        }

        .promo-slot {
            position:relative;
            min-height:175px;
            overflow:hidden;
            border-radius:16px;
            border:1px solid #cbd4cd;
            background:#e9ecef;
            box-shadow:var(--shadow-sm);
            transition:transform .35s var(--ease),box-shadow .35s ease;
        }

        .promo-slot:hover {
            transform:translateY(-6px);
            box-shadow:var(--shadow-md);
        }

        /* Quick navigation */
        .quick-scroll {
            display:grid;
            grid-template-columns:repeat(10,minmax(105px,1fr));
            gap:12px;
        }

        .quick-item {
            min-width:0;
            text-align:center;
            text-decoration:none;
            color:var(--text-main);
        }

        .quick-slot {
            position:relative;
            height:105px;
            overflow:hidden;
            border-radius:15px;
            border:1px solid #cbd4cd;
            background:#e9ecef;
            box-shadow:var(--shadow-sm);
            transition:transform .3s var(--spring),box-shadow .3s ease;
        }

        .quick-item:hover .quick-slot {
            transform:translateY(-6px) scale(1.02);
            box-shadow:var(--shadow-md);
        }

        .quick-slot img {
            width:100%;
            height:100%;
            display:block;
            object-fit:cover;
            transition:transform .45s var(--ease);
        }

        .quick-item:hover .quick-slot img { transform:scale(1.045); }

        .quick-item span {
            display:block;
            margin-top:8px;
            color:var(--primary-dark);
            font-size:.72rem;
            font-weight:700;
            white-space:nowrap;
            overflow:hidden;
            text-overflow:ellipsis;
        }

        /* Products */
        .product-grid {
            display:grid;
            grid-template-columns:repeat(6,minmax(0,1fr));
            gap:13px;
        }

        .product-card {
            position:relative;
            min-width:0;
            overflow:hidden;
            background:#fff;
            border:1px solid rgba(228,231,236,.85);
            border-radius:15px;
            box-shadow:var(--shadow-sm);
            transition:transform .35s var(--spring),box-shadow .35s ease,border-color .35s ease;
        }

        .product-card:hover {
            transform:translateY(-8px);
            box-shadow:var(--shadow-lg);
            border-color:rgba(45,90,63,.15);
        }

        .product-image {
            position:relative;
            height:190px;
            overflow:hidden;
            background:#e9ecef;
        }

        .product-image .placeholder { transition:transform .45s var(--ease); }
        .product-card:hover .product-image .placeholder { transform:scale(1.045); }

        .product-image img {
            width:100%;
            height:100%;
            display:block;
            object-fit:cover;
            transition:transform .45s var(--ease);
        }

        .product-card:hover .product-image img { transform:scale(1.045); }

        .product-badge {
            position:absolute;
            top:9px;
            left:9px;
            z-index:2;
            padding:4px 8px;
            border-radius:7px;
            background:var(--accent-terracotta);
            color:#fff;
            font-size:.58rem;
            font-weight:800;
        }

        .product-info { padding:12px; }

        .product-name {
            min-height:38px;
            color:var(--primary-dark);
            font-size:.8rem;
            font-weight:800;
            line-height:1.35;
        }

        .product-price {
            margin-top:5px;
            color:var(--accent-terracotta);
            font-size:1rem;
            font-weight:800;
        }

        .product-meta {
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:5px;
            margin-top:3px;
            color:var(--text-muted);
            font-size:.65rem;
        }

        .product-stock { color:var(--text-muted); }
        .product-uom { color:var(--primary-green); font-weight:700; }

        .card-actions {
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:6px;
            margin-top:11px;
        }

        .card-btn {
            border:0;
            border-radius:8px;
            padding:8px 5px;
            cursor:pointer;
            font-size:.65rem;
            font-weight:800;
            transition:.3s var(--ease);
        }

        .cart-btn {
            background:var(--soft-green);
            color:var(--primary-green);
        }

        .cart-btn:hover {
            background:var(--primary-green);
            color:#fff;
            transform:translateY(-2px);
        }

        .buy-btn {
            background:var(--primary-dark);
            color:#fff;
        }

        .buy-btn:hover {
            background:var(--accent-terracotta);
            transform:translateY(-2px);
        }

        /* Add to Cart confirmation modal */
        .cart-modal-overlay {
            position:fixed;
            inset:0;
            z-index:5000;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:20px;
            background:rgba(15,28,20,.48);
            backdrop-filter:blur(5px);
            opacity:0;
            visibility:hidden;
            transition:opacity .3s ease,visibility .3s ease;
        }

        .cart-modal-overlay.open {
            opacity:1;
            visibility:visible;
        }

        .cart-modal {
            width:min(420px,100%);
            padding:28px;
            background:#fff;
            border:1px solid rgba(228,231,236,.9);
            border-radius:20px;
            box-shadow:0 25px 70px rgba(0,0,0,.2);
            text-align:center;
            transform:translateY(18px) scale(.96);
            transition:transform .35s var(--spring);
        }

        .cart-modal-overlay.open .cart-modal {
            transform:translateY(0) scale(1);
        }

        .cart-modal-icon {
            width:62px;
            height:62px;
            display:grid;
            place-items:center;
            margin:0 auto 16px;
            border-radius:18px;
            background:var(--soft-green);
            color:var(--primary-green);
            font-size:1.55rem;
        }

        .cart-modal h3 {
            color:var(--primary-dark);
            font-size:1.2rem;
            font-weight:800;
        }

        .cart-modal p {
            margin-top:8px;
            color:var(--text-muted);
            font-size:.85rem;
            line-height:1.6;
        }

        .cart-modal-product {
            margin-top:12px;
            padding:11px 13px;
            border-radius:10px;
            background:var(--bg-cream);
            color:var(--primary-dark);
            font-size:.86rem;
            font-weight:800;
            overflow-wrap:anywhere;
        }

        .cart-modal-actions {
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:9px;
            margin-top:22px;
        }

        .cart-modal-btn {
            min-height:43px;
            border:0;
            border-radius:10px;
            cursor:pointer;
            font-size:.8rem;
            font-weight:800;
            transition:.25s var(--ease);
        }

        .cart-modal-cancel {
            background:#f1f2f3;
            color:#475467;
        }

        .cart-modal-cancel:hover {
            background:#e5e7eb;
            transform:translateY(-2px);
        }

        .cart-modal-confirm {
            background:var(--primary-dark);
            color:#fff;
        }

        .cart-modal-confirm:hover {
            background:var(--primary-green);
            transform:translateY(-2px);
        }

        .cart-modal-confirm:disabled {
            opacity:.65;
            cursor:not-allowed;
            transform:none;
        }

        /* Reveal animation */
        .reveal {
            opacity:0;
            transform:translateY(48px) scale(.98);
            filter:blur(5px);
            transition:opacity .75s var(--ease),transform .85s var(--ease),filter .75s var(--ease);
        }

        .reveal.from-left { transform:translateX(-55px); }
        .reveal.from-right { transform:translateX(55px); }

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

        /* Toast */
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

        /* Click pop */
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
            0% { opacity:.85; transform:translate(-50%,-50%) scale(1); }
            100% { opacity:0; transform:translate(-50%,-50%) scale(8); }
        }

        /* Footer */
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

        .footer-links h4 { margin-bottom:9px; font-size:.9rem; }
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

        /* Mobile */
        @media (max-width:1200px) {
            .product-grid { grid-template-columns:repeat(4,minmax(0,1fr)); }

            .quick-scroll {
                display:flex;
                overflow-x:auto;
                padding:3px 3px 12px;
                scrollbar-width:thin;
            }

            .quick-item { flex:0 0 105px; }

            .category-dropdown {
                width:500px;
                grid-template-columns:repeat(2,1fr);
            }
        }

        @media (max-width:900px) {
            .navbar { gap:10px; flex-wrap:wrap; }

            .nav-search-wrap {
                order:3;
                flex-basis:100%;
                max-width:none;
            }

            .nav-actions {
                margin-left:auto;
                flex:0 0 auto;
                min-width:max-content;
            }

            .mobile-menu-btn { display:grid; }
            .category-desktop { display:block; }
            .category-desktop > #categoryButton { display:none; }

            .category-dropdown {
                position:fixed;
                top:62px;
                left:auto;
                right:5%;
                width:420px;
                grid-template-columns:repeat(2,1fr);
                z-index:2000;
                transform:translateY(-8px) scale(.97);
            }

            .category-dropdown.open { transform:none; }
            .promo-grid { grid-template-columns:repeat(2,1fr); }
            .footer-grid { grid-template-columns:1fr 1fr; }
        }

        @media (max-width:650px) {
            .section,.hero { width:92%; }
            .hero { padding-top:145px; }

            .hero-grid {
                display:grid;
                grid-template-columns:1fr 1fr;
                grid-template-rows:220px 150px;
                gap:9px;
            }

            .hero-slot:nth-child(2) { margin-bottom:10px; }
            .hero-slot.main { grid-column:1 / 3; grid-row:auto; }

            .hero-slot:nth-child(2),
            .hero-slot:nth-child(3),
            .hero-slot:nth-child(4) { transform:none; }

            .product-grid {
                grid-template-columns:repeat(2,minmax(0,1fr));
                gap:10px;
            }

            .product-image { height:155px; }
            .product-info { padding:10px; }
            .card-actions { grid-template-columns:1fr; }
            .section { padding:20px 0; }
            .section-heading { align-items:start; }
            .section-heading .view-all { margin-top:8px; }

            .footer-grid {
                grid-template-columns:1fr 1fr;
                gap:22px;
            }

            .footer-brand { grid-column:1 / -1; }
            .nav-actions .hide-mobile { display:none; }
            .brand { font-size:1.2rem; }

            .icon-btn {
                width:37px;
                min-width:37px;
                height:37px;
                flex-basis:37px;
            }

            /* Keep the cart button aligned with the other mobile icons. */
            .nav-actions .cart-icon-btn {
                width:37px;
                min-width:37px;
                max-width:37px;
                height:37px;
                min-height:37px;
                flex:0 0 37px;
                padding:0;
                margin:0;
            }

            .nav-actions .cart-icon-btn i {
                font-size:1rem;
                line-height:1;
            }

            .category-dropdown {
                top:58px;
                right:4%;
                width:92%;
                grid-template-columns:repeat(2,1fr);
            }

            .category-dropdown a { font-size:.73rem; padding:9px 8px; }
            .search-suggestions { top:calc(100% + 7px); }
        }

        @media (max-width:430px) {
            .product-image { height:135px; }
            .product-name { font-size:.73rem; }
            .product-price { font-size:.9rem; }
            .promo-grid { gap:9px; }
            .promo-slot { min-height:130px; }
            .footer-grid { grid-template-columns:1fr; }

            .category-dropdown { grid-template-columns:1fr 1fr; }
            .category-dropdown a { font-size:.69rem; gap:6px; }

            .category-dropdown a i {
                width:15px;
                flex-basis:15px;
                font-size:.75rem;
            }
        }

        @media (max-width:400px) {
            .cart-modal { padding:23px 19px; }
        }

        @media (prefers-reduced-motion:reduce) {
            *,
            *::before,
            *::after {
                animation-duration:.001ms !important;
                animation-iteration-count:1 !important;
                transition-duration:.001ms !important;
                scroll-behavior:auto !important;
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

    <!-- TOP NAVIGATION -->
    <nav class="navbar" id="navbar">
        <a href="{{ url('/') }}" class="brand">
            <i class="fa-solid fa-leaf"></i>
            <span>agrimarket</span>
        </a>

        <!-- SEARCH -->
        <div class="nav-search-wrap">
            <form class="nav-search" id="searchForm">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input id="searchInput" type="search" placeholder="Search products" aria-label="Search products" autocomplete="off">
                <button type="submit" title="Search">
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>
            <div class="search-suggestions" id="searchSuggestions"></div>
        </div>

        <div class="dropdown-wrap category-desktop">
            <button class="icon-btn" id="categoryButton" title="Category">
                <i class="fa-solid fa-grip"></i>
                <span>Category</span>
            </button>

            <div class="dropdown category-dropdown" id="categoryMenu">
                <a href="{{ url('/category/Fruits') }}"><i class="fa-solid fa-apple-whole"></i>Fruits</a>
                <a href="{{ url('/category/Vegetables') }}"><i class="fa-solid fa-carrot"></i>Vegetables</a>
                <a href="{{ url('/category/Grains & Rice') }}"><i class="fa-solid fa-wheat-awn"></i>Grains & Rice</a>
                <a href="{{ url('/category/Seeds') }}"><i class="fa-solid fa-seedling"></i>Seeds</a>
                <a href="{{ url('/category/Organic Products') }}"><i class="fa-solid fa-leaf"></i>Organic Products</a>
                <a href="{{ url('/category/Herbs & Spices') }}"><i class="fa-solid fa-mortar-pestle"></i>Herbs & Spices</a>
                <a href="{{ url('/category/Meat & Poultry') }}"><i class="fa-solid fa-drumstick-bite"></i>Meat & Poultry</a>
                <a href="{{ url('/category/Fish & Seafood') }}"><i class="fa-solid fa-fish"></i>Fish & Seafood</a>
                <a href="{{ url('/category/Dairy & Eggs') }}"><i class="fa-solid fa-egg"></i>Dairy & Eggs</a>
                <a href="{{ url('/category/Processed Foods') }}"><i class="fa-solid fa-jar"></i>Processed Foods</a>
                <a href="{{ url('/category/New Arrivals') }}"><i class="fa-solid fa-star"></i>New Arrivals</a>
                <a href="{{ url('/category/Best Sellers') }}"><i class="fa-solid fa-trophy"></i>Best Sellers</a>
                <a href="{{ url('/category/Below ₱100') }}"><i class="fa-solid fa-tags"></i>Below 100</a>
                <a href="{{ url('/category/All Products') }}"><i class="fa-solid fa-boxes-stacked"></i>All Products</a>
            </div>
        </div>

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
                <button class="icon-btn" id="profileButton" title="Profile">
                    <i class="fa-regular fa-user"></i>
                </button>

                <div class="dropdown" id="profileMenu">
                    <a href="{{ route('profile') }}"><i class="fa-regular fa-user"></i>Profile</a>
                    <a href="{{ route('orders') }}"><i class="fa-solid fa-box"></i> My Orders</a>
                    <a href="{{ route('settings') }}"><i class="fa-solid fa-gear"></i>Settings</a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-right-from-bracket"></i>Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                        @csrf
                    </form>
                </div>
            </div>

            <button class="icon-btn mobile-menu-btn" id="mobileCategoryButton" title="Categories">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </nav>

    <main>
        <!-- MAIN BANNER / HERO -->
        <section class="hero">
            <div class="hero-grid reveal">
                <div class="hero-slot main">
                    <img src="{{ asset('image/static/page1-slot1.jpg') }}" alt="Rice and grains">
                </div>
                <div class="hero-slot">
                    <img src="{{ asset('image/static/page1-slot2.jpg') }}" alt="Fresh fish and seafood">
                </div>
                <div class="hero-slot">
                    <img src="{{ asset('image/static/page1-slot3.jpg') }}" alt="Fresh meat and poultry">
                </div>
            </div>
        </section>

        <!-- PROMOTIONAL / FEATURE SECTION -->
        <section class="section reveal">
            <div class="section-heading">
                <div class="heading-left">
                    <span class="eyebrow">Discover</span>
                    <h2>Featured for You</h2>
                    <p>Promotions, announcements and featured agricultural services.</p>
                </div>
            </div>

            <div class="promo-grid stagger">
                <div class="promo-slot"><img src="{{ asset('image/static/page2-slot1.jpg') }}" alt="Fresh agricultural products"></div>
                <div class="promo-slot"><img src="{{ asset('image/static/page2-slot2.jpg') }}" alt="Affordable agricultural products"></div>
                <div class="promo-slot"><img src="{{ asset('image/static/page2-slot3.jpg') }}" alt="Rice and grains"></div>
                <div class="promo-slot"><img src="{{ asset('image/static/page2-slot4.jpg') }}" alt="Fresh farm produce"></div>
            </div>
        </section>

        <!-- QUICK NAVIGATION -->
        <section class="section reveal">
            <div class="section-heading">
                <div class="heading-left">
                    <span class="eyebrow">Quick access</span>
                    <h2>Explore AgriMarket</h2>
                </div>
            </div>

            <div class="quick-scroll stagger">
                <a class="quick-item" href="#fruits">
                    <div class="quick-slot"><img src="{{ asset('image/static/mango.jpg') }}" alt="Mango"></div>
                    <span>Fruits</span>
                </a>
                <a class="quick-item" href="#vegetables">
                    <div class="quick-slot"><img src="{{ asset('image/static/carrot.jpg') }}" alt="Carrot"></div>
                    <span>Vegetables</span>
                </a>
                <a class="quick-item" href="#grains-rice">
                    <div class="quick-slot"><img src="{{ asset('image/static/white-rice.jpg') }}" alt="White Rice"></div>
                    <span>Grains & Rice</span>
                </a>
                <a class="quick-item" href="#seeds">
                    <div class="quick-slot"><img src="{{ asset('image/static/sunflower-seeds.jpg') }}" alt="Sunflower Seeds"></div>
                    <span>Seeds</span>
                </a>
                <a class="quick-item" href="#organic-products">
                    <div class="quick-slot"><img src="{{ asset('image/static/organic-lettuce.jpg') }}" alt="Organic Lettuce"></div>
                    <span>Organic Products</span>
                </a>
                <a class="quick-item" href="#herbs-spices">
                    <div class="quick-slot"><img src="{{ asset('image/static/cinnamon.jpg') }}" alt="Cinnamon"></div>
                    <span>Herbs & Spices</span>
                </a>
                <a class="quick-item" href="#meat-poultry">
                    <div class="quick-slot"><img src="{{ asset('image/static/chicken.jpg') }}" alt="Chicken"></div>
                    <span>Meat & Poultry</span>
                </a>
                <a class="quick-item" href="#fish-seafood">
                    <div class="quick-slot"><img src="{{ asset('image/static/tilapia.jpg') }}" alt="Tilapia"></div>
                    <span>Fish & Seafood</span>
                </a>
                <a class="quick-item" href="#dairy-eggs">
                    <div class="quick-slot"><img src="{{ asset('image/static/milk-eggs.jpg') }}" alt="Milk and Eggs"></div>
                    <span>Dairy & Eggs</span>
                </a>
                <a class="quick-item" href="#processed-foods">
                    <div class="quick-slot"><img src="{{ asset('image/static/tomato-sauce.jpg') }}" alt="Tomato Sauce"></div>
                    <span>Processed Foods</span>
                </a>
            </div>
        </section>

        <!-- New & Fresh -->
        <section class="section product-section reveal" id="new-fresh">
            <div class="section-heading">
                <div class="heading-left">
                    <span class="eyebrow">Featured</span>
                    <h2>New & Fresh</h2>
                    <p>Freshly listed products from agricultural sellers.</p>
                </div>
                <a class="view-all" href="{{ url('/category/New Arrivals') }}">View All</a>
            </div>
            <div class="product-grid stagger"></div>
        </section>

        <!-- Best Sellers -->
        <section class="section product-section reveal" id="best-sellers">
            <div class="section-heading">
                <div class="heading-left">
                    <span class="eyebrow">Featured</span>
                    <h2>Best Sellers</h2>
                    <p>Popular products from agricultural sellers.</p>
                </div>
                <a class="view-all" href="{{ url('/category/Best Sellers') }}">View All</a>
            </div>
            <div class="product-grid stagger"></div>
        </section>

        <!-- FRUITS -->
        <section class="section product-section reveal" id="fruits">
            <div class="section-heading">
                <div class="heading-left">
                    <span class="eyebrow">Category 01</span>
                    <h2>Fruits</h2>
                    <p>Fresh fruits from agricultural sellers.</p>
                </div>
                <a class="view-all" href="{{ url('/category/Fruits') }}">View All</a>
            </div>
            <div class="product-grid stagger"></div>
        </section>

        <!-- VEGETABLES -->
        <section class="section product-section reveal" id="vegetables">
            <div class="section-heading">
                <div class="heading-left">
                    <span class="eyebrow">Category 02</span>
                    <h2>Vegetables</h2>
                    <p>Fresh vegetables for everyday cooking.</p>
                </div>
                <a class="view-all" href="{{ url('/category/Vegetables') }}">View All</a>
            </div>
            <div class="product-grid stagger"></div>
        </section>

        <!-- GRAINS & RICE -->
        <section class="section product-section reveal" id="grains-rice">
            <div class="section-heading">
                <div class="heading-left">
                    <span class="eyebrow">Category 03</span>
                    <h2>Grains & Rice</h2>
                    <p>Rice, grains and staple agricultural products.</p>
                </div>
                <a class="view-all" href="{{ url('/category/Grains & Rice') }}">View All</a>
            </div>
            <div class="product-grid stagger"></div>
        </section>

        <!-- SEEDS -->
        <section class="section product-section reveal" id="seeds">
            <div class="section-heading">
                <div class="heading-left">
                    <span class="eyebrow">Category 04</span>
                    <h2>Seeds</h2>
                    <p>Seeds for farms, gardens and growing projects.</p>
                </div>
                <a class="view-all" href="{{ url('/category/Seeds') }}">View All</a>
            </div>
            <div class="product-grid stagger"></div>
        </section>

        <!-- ORGANIC PRODUCTS -->
        <section class="section product-section reveal" id="organic-products">
            <div class="section-heading">
                <div class="heading-left">
                    <span class="eyebrow">Category 05</span>
                    <h2>Organic Products</h2>
                    <p>Natural and organic agricultural products.</p>
                </div>
                <a class="view-all" href="{{ url('/category/Organic Products') }}">View All</a>
            </div>
            <div class="product-grid stagger"></div>
        </section>

        <!-- HERBS & SPICES -->
        <section class="section product-section reveal" id="herbs-spices">
            <div class="section-heading">
                <div class="heading-left">
                    <span class="eyebrow">Category 06</span>
                    <h2>Herbs & Spices</h2>
                    <p>Fresh and dried herbs and spices for everyday cooking.</p>
                </div>
                <a class="view-all" href="{{ url('/category/Herbs & Spices') }}">View All</a>
            </div>
            <div class="product-grid stagger"></div>
        </section>

        <!-- MEAT & POULTRY -->
        <section class="section product-section reveal" id="meat-poultry">
            <div class="section-heading">
                <div class="heading-left">
                    <span class="eyebrow">Category 07</span>
                    <h2>Meat & Poultry</h2>
                    <p>Fresh meat and poultry products from agricultural sellers.</p>
                </div>
                <a class="view-all" href="{{ url('/category/Meat & Poultry') }}">View All</a>
            </div>
            <div class="product-grid stagger"></div>
        </section>

        <!-- FISH & SEAFOOD -->
        <section class="section product-section reveal" id="fish-seafood">
            <div class="section-heading">
                <div class="heading-left">
                    <span class="eyebrow">Category 08</span>
                    <h2>Fish & Seafood</h2>
                    <p>Fresh fish and seafood products for everyday meals.</p>
                </div>
                <a class="view-all" href="{{ url('/category/Fish & Seafood') }}">View All</a>
            </div>
            <div class="product-grid stagger"></div>
        </section>

        <!-- DAIRY & EGGS -->
        <section class="section product-section reveal" id="dairy-eggs">
            <div class="section-heading">
                <div class="heading-left">
                    <span class="eyebrow">Category 09</span>
                    <h2>Dairy & Eggs</h2>
                    <p>Fresh dairy products and eggs from agricultural sellers.</p>
                </div>
                <a class="view-all" href="{{ url('/category/Dairy & Eggs') }}">View All</a>
            </div>
            <div class="product-grid stagger"></div>
        </section>

        <!-- PROCESSED FOODS -->
        <section class="section product-section reveal" id="processed-foods">
            <div class="section-heading">
                <div class="heading-left">
                    <span class="eyebrow">Category 10</span>
                    <h2>Processed Foods</h2>
                    <p>Prepared and processed food products from agricultural sellers.</p>
                </div>
                <a class="view-all" href="{{ url('/category/Processed Foods') }}">View All</a>
            </div>
            <div class="product-grid stagger"></div>
        </section>

        <!-- BELOW 100 -->
        <section class="section product-section reveal" id="below-100">
            <div class="section-heading">
                <div class="heading-left">
                    <span class="eyebrow">Budget picks</span>
                    <h2>Below ₱100</h2>
                    <p>Affordable agricultural products under one hundred pesos.</p>
                </div>
                <a class="view-all" href="{{ url('/category/Below 100') }}">View All</a>
            </div>
            <div class="product-grid stagger"></div>
        </section>

        <!-- ALL GROCERIES -->
        <section class="section product-section reveal" id="groceries">
            <div class="section-heading">
                <div class="heading-left">
                    <span class="eyebrow">Food & essentials</span>
                    <h2>All Groceries</h2>
                    <p>Grocery and food-related agricultural products.</p>
                </div>
                <a class="view-all" href="{{ url('/category/All Products') }}">View All</a>
            </div>
            <div class="product-grid stagger"></div>
        </section>
    </main>

    <!-- FOOTER -->
    <footer>
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="#" class="brand" style="color:#fff">
                    <i class="fa-solid fa-leaf"></i>
                    <span>agrimarket</span>
                </a>
                <p>A modern agricultural marketplace connecting buyers and sellers of farm products, supplies and services.</p>
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
                    <li><a href="#new-fresh">New & Fresh</a></li>
                    <li><a href="#best-sellers">Best Sellers</a></li>
                    <li><a href="#groceries">Groceries</a></li>
                </ul>
            </div>
        </div>

        <div class="copyright">
            © 2026 AgriMarket. All rights reserved.
        </div>
    </footer>

    <!-- ADD TO CART CONFIRMATION POPUP -->
    <div class="cart-modal-overlay" id="cartModal" aria-hidden="true">
        <div class="cart-modal" role="dialog" aria-modal="true" aria-labelledby="cartModalTitle">
            <div class="cart-modal-icon">
                <i class="fa-solid fa-cart-shopping"></i>
            </div>

            <h3 id="cartModalTitle">Add to Cart?</h3>

            <p>Are you sure you want to add this product to your shopping cart?</p>

            <div class="cart-modal-product" id="cartModalProduct">
                Product name
            </div>

            <div class="cart-modal-actions">
                <button type="button" class="cart-modal-btn cart-modal-cancel" id="cancelCartButton">
                    Cancel
                </button>

                <button type="button" class="cart-modal-btn cart-modal-confirm" id="confirmCartButton">
                    <i class="fa-solid fa-cart-plus"></i>
                    Yes, Add to Cart
                </button>
            </div>
        </div>
    </div>

    <div class="toast-container" id="toastContainer"></div>

    <script>
        const products = {
            "New & Fresh":[
                @php
                    $newFreshProducts = $products->filter(function ($product) {
                        return $product->created_at >= now()->subHours(24);
                    });

                    if ($newFreshProducts->isEmpty()) {
                        $newFreshProducts = $products->filter(function ($product) {
                            return $product->created_at >= now()->subDays(2);
                        });
                    }

                    if ($newFreshProducts->isEmpty()) {
                        $newFreshProducts = $products->filter(function ($product) {
                            return $product->created_at >= now()->subDays(3);
                        });
                    }

                    $newFreshProducts = $newFreshProducts
                        ->sortByDesc('product_id')
                        ->take(6);
                @endphp

                @foreach($newFreshProducts as $product)
                    [
                        {{ $product->product_id }},
                        @json($product->product_name),
                        {{ $product->price }},
                        {{ $product->quantity }},
                        @json($product->oum),
                        @json($product->image)
                    ],
                @endforeach
            ],

            "Best Sellers":[
                @foreach($bestSellerProducts as $product)
                    [
                        {{ $product->product_id }},
                        @json($product->product_name),
                        {{ $product->price }},
                        {{ $product->quantity }},
                        @json($product->oum),
                        @json($product->image)
                    ],
                @endforeach
            ],

            "Fruits":[
                @foreach($products->where('category','Fruits')->shuffle()->take(6) as $product)
                    [
                        {{ $product->product_id }},
                        @json($product->product_name),
                        {{ $product->price }},
                        {{ $product->quantity }},
                        @json($product->oum),
                        @json($product->image)
                    ],
                @endforeach
            ],

            "Vegetables":[
                @foreach($products->where('category','Vegetables')->shuffle()->take(6) as $product)
                    [
                        {{ $product->product_id }},
                        @json($product->product_name),
                        {{ $product->price }},
                        {{ $product->quantity }},
                        @json($product->oum),
                        @json($product->image)
                    ],
                @endforeach
            ],

            "Grains & Rice":[
                @foreach($products->where('category','Grains & Rice')->shuffle()->take(6) as $product)
                    [
                        {{ $product->product_id }},
                        @json($product->product_name),
                        {{ $product->price }},
                        {{ $product->quantity }},
                        @json($product->oum),
                        @json($product->image)
                    ],
                @endforeach
            ],

            "Seeds":[
                @foreach($products->where('category','Seeds')->shuffle()->take(6) as $product)
                    [
                        {{ $product->product_id }},
                        @json($product->product_name),
                        {{ $product->price }},
                        {{ $product->quantity }},
                        @json($product->oum),
                        @json($product->image)
                    ],
                @endforeach
            ],

            "Organic Products":[
                @foreach($products->where('category','Organic Products')->shuffle()->take(6) as $product)
                    [
                        {{ $product->product_id }},
                        @json($product->product_name),
                        {{ $product->price }},
                        {{ $product->quantity }},
                        @json($product->oum),
                        @json($product->image)
                    ],
                @endforeach
            ],

            "Herbs & Spices":[
                @foreach($products->where('category','Herbs & Spices')->shuffle()->take(6) as $product)
                    [
                        {{ $product->product_id }},
                        @json($product->product_name),
                        {{ $product->price }},
                        {{ $product->quantity }},
                        @json($product->oum),
                        @json($product->image)
                    ],
                @endforeach
            ],

            "Meat & Poultry":[
                @foreach($products->where('category','Meat & Poultry')->shuffle()->take(6) as $product)
                    [
                        {{ $product->product_id }},
                        @json($product->product_name),
                        {{ $product->price }},
                        {{ $product->quantity }},
                        @json($product->oum),
                        @json($product->image)
                    ],
                @endforeach
            ],

            "Fish & Seafood":[
                @foreach($products->where('category','Fish & Seafood')->shuffle()->take(6) as $product)
                    [
                        {{ $product->product_id }},
                        @json($product->product_name),
                        {{ $product->price }},
                        {{ $product->quantity }},
                        @json($product->oum),
                        @json($product->image)
                    ],
                @endforeach
            ],

            "Dairy & Eggs":[
                @foreach($products->where('category','Dairy & Eggs')->shuffle()->take(6) as $product)
                    [
                        {{ $product->product_id }},
                        @json($product->product_name),
                        {{ $product->price }},
                        {{ $product->quantity }},
                        @json($product->oum),
                        @json($product->image)
                    ],
                @endforeach
            ],

            "Processed Foods":[
                @foreach($products->where('category','Processed Foods')->shuffle()->take(6) as $product)
                    [
                        {{ $product->product_id }},
                        @json($product->product_name),
                        {{ $product->price }},
                        {{ $product->quantity }},
                        @json($product->oum),
                        @json($product->image)
                    ],
                @endforeach
            ],

            "Below ₱100":[
                @foreach($products->where('price', '<', 100)->shuffle()->take(6) as $product)
                    [
                        {{ $product->product_id }},
                        @json($product->product_name),
                        {{ $product->price }},
                        {{ $product->quantity }},
                        @json($product->oum),
                        @json($product->image)
                    ],
                @endforeach
            ],

            "All Groceries":[
                @foreach($products->shuffle()->take(6) as $product)
                    [
                        {{ $product->product_id }},
                        @json($product->product_name),
                        {{ $product->price }},
                        {{ $product->quantity }},
                        @json($product->oum),
                        @json($product->image)
                    ],
                @endforeach
            ]
        };

        const shopCategories = [
            "New & Fresh",
            "Best Sellers",
            "Fruits",
            "Vegetables",
            "Grains & Rice",
            "Seeds",
            "Organic Products",
            "Herbs & Spices",
            "Meat & Poultry",
            "Fish & Seafood",
            "Dairy & Eggs",
            "Processed Foods",
            "Below ₱100",
            "All Groceries"
        ];

        
        function productCard(product, index) {
            const [id, name, price, quantity, uom, image] = product;

            const escapedName = String(name)
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");

            const safeImage = image == null ? "" : String(image)
                .trim()
                .replace(/"/g, "&quot;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;");

            const safeUom = uom == null ? "" : String(uom)
                .replace(/&/g, "&amp;")
                .replace(/"/g, "&quot;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;");

            const validProductId = Number.isInteger(Number(id)) && Number(id) > 0
                ? Number(id)
                : "";

            // Only accept database image data URIs.
            const validImage = /^data:image\/(jpeg|png|gif|webp|avif);base64,[A-Za-z0-9+/=]+$/i.test(safeImage);

            return `
                <article class="product-card" data-name="${escapedName.toLowerCase()}">
                    ${index === 0 ? '<span class="product-badge">FEATURED</span>' : ''}

                    <div class="product-image">
                        ${validImage ? `
                            <img
                                src="${safeImage}"
                                alt="${escapedName}"
                                class="product-photo"
                                loading="lazy"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='grid';"
                            >

                            <div class="placeholder" style="display:none;">
                                <div class="placeholder-content">
                                    <i class="fa-regular fa-image"></i>
                                    <strong>PRODUCT IMAGE</strong>
                                    <small>${escapedName}</small>
                                </div>
                            </div>
                        ` : `
                            <div class="placeholder">
                                <div class="placeholder-content">
                                    <i class="fa-regular fa-image"></i>
                                    <strong>PRODUCT IMAGE</strong>
                                    <small>${escapedName}</small>
                                </div>
                            </div>
                        `}
                    </div>

                    <div class="product-info">
                        <div class="product-name">${escapedName}</div>

                        <div class="product-price">
                            ₱${Number(price).toLocaleString("en-PH", {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            })}
                        </div>

                        <div class="product-meta">
                            <span class="product-stock">${quantity} available</span>
                            <span class="product-uom">${safeUom}</span>
                        </div>

                        <div class="card-actions">
                            <button
                                type="button"
                                class="card-btn cart-btn"
                                data-product-id="${validProductId}"
                                data-product-name="${escapedName}"
                                ${validProductId === "" ? "disabled" : ""}
                            >
                                <i class="fa-solid fa-cart-plus"></i>
                                Add to Cart
                            </button>

                            <button
                                type="button"
                                class="card-btn buy-btn"
                                onclick="buyNow(${id === null ? 'null' : Number(id)})"
                            >
                                Buy Now
                            </button>
                        </div>
                    </div>
                </article>
            `;
        }


        function renderProducts() {
            document.querySelectorAll(".product-section").forEach(section => {
                const title = section.querySelector("h2").textContent.trim();
                const grid = section.querySelector(".product-grid");

                if (!grid || !products[title]) return;

                if (title === "New & Fresh" && products[title].length === 0) {
                    section.style.display = "none";

                    const footerLink = document.querySelector('footer a[href="#new-fresh"]');
                    if (footerLink) {
                        footerLink.closest("li").style.display = "none";
                    }

                    return;
                }

                section.style.display = "";
                grid.innerHTML = products[title].map(productCard).join("");
            });
        }

        /* Search suggestions */
        const searchableProducts = [
            @foreach($products->unique('product_name')->values() as $product)
                { name:@json($product->product_name) },
            @endforeach
        ];

        const searchInput = document.getElementById("searchInput");
        const searchSuggestions = document.getElementById("searchSuggestions");

        function showSearchSuggestions(query) {
            const normalizedQuery = query.trim().toLowerCase();

            if (!normalizedQuery) {
                searchSuggestions.innerHTML = "";
                searchSuggestions.classList.remove("open");
                return;
            }

            const matches = searchableProducts
                .filter(product => product.name.toLowerCase().includes(normalizedQuery))
                .slice(0,8);

            if (!matches.length) {
                searchSuggestions.innerHTML = `
                    <div class="search-no-result">
                        No products found for "${query.trim()}".
                    </div>
                `;
                searchSuggestions.classList.add("open");
                return;
            }

            searchSuggestions.innerHTML = matches.map(product => {
                const name = String(product.name);
                const escapedName = name
                    .replace(/&/g,"&amp;")
                    .replace(/</g,"&lt;")
                    .replace(/>/g,"&gt;")
                    .replace(/"/g,"&quot;")
                    .replace(/'/g,"&#039;");

                const productUrl =
                    "{{ url('/search') }}/" +
                    encodeURIComponent(product.name);

                return `
                    <a href="${productUrl}" class="search-suggestion" data-product-id="${escapedName}">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>${escapedName}</span>
                    </a>
                `;
            }).join("");

            searchSuggestions.classList.add("open");
        }

        searchInput.addEventListener("input",() => {
            showSearchSuggestions(searchInput.value);
        });

        searchSuggestions.addEventListener("click",e => {
            const suggestion = e.target.closest(".search-suggestion");
            if (!suggestion) return;
            searchSuggestions.classList.remove("open");
        });

        document.getElementById("searchForm").addEventListener("submit",e => {
            e.preventDefault();

            const query = searchInput.value.trim();

            if (!query) {
                showToast("Enter a product or category to search.");
                return;
            }

            const searchUrl =
                "{{ url('/search') }}/" +
                encodeURIComponent(query);

            window.location.href = searchUrl;
        });

        document.addEventListener("click",e => {
            if (!e.target.closest(".nav-search-wrap")) {
                searchSuggestions.classList.remove("open");
            }
        });

        /* ADD TO CART CONFIRMATION */
        const cartModal = document.getElementById("cartModal");
        const cartModalProduct = document.getElementById("cartModalProduct");
        const cancelCartButton = document.getElementById("cancelCartButton");
        const confirmCartButton = document.getElementById("confirmCartButton");

        let selectedCartProductId = null;
        let selectedCartProductName = "";

        function addToCart(productId,productName) {
            if (!Number.isInteger(productId) || productId <= 0) {
                showToast("This demo product cannot be added to your cart.");
                return;
            }

            selectedCartProductId = productId;
            selectedCartProductName = productName;

            cartModalProduct.textContent = productName;

            cartModal.classList.add("open");
            cartModal.setAttribute("aria-hidden","false");

            document.body.style.overflow = "hidden";
        }

        function closeCartModal() {
            cartModal.classList.remove("open");
            cartModal.setAttribute("aria-hidden","true");

            document.body.style.overflow = "";

            selectedCartProductId = null;
            selectedCartProductName = "";

            confirmCartButton.disabled = false;
            confirmCartButton.innerHTML = `
                <i class="fa-solid fa-cart-plus"></i>
                Yes, Add to Cart
            `;
        }

        /* ADD TO CART BUTTON CLICK */
        document.addEventListener("click", function(e) {
            const button = e.target.closest(".cart-btn");

            if (!button) return;

            const productId = Number(button.dataset.productId);
            const productName = button.dataset.productName;

            if (!Number.isInteger(productId) || productId <= 0) {
                showToast("This product cannot be added to your cart.");
                return;
            }

            addToCart(productId, productName);
        });

        cancelCartButton.addEventListener("click", closeCartModal);
        cartModal.addEventListener("click",e => {
            if (e.target === cartModal) {
                closeCartModal();
            }
        });

        document.addEventListener("keydown",e => {
            if (e.key === "Escape" && cartModal.classList.contains("open")) {
                closeCartModal();
            }
        });

        /* Only save to the database after the buyer confirms. */
        confirmCartButton.addEventListener("click",async () => {
            if (!selectedCartProductId) {
                showToast("Please select a valid product.");
                closeCartModal();
                return;
            }

            const productId = selectedCartProductId;

            confirmCartButton.disabled = true;
            confirmCartButton.innerHTML = `
                <i class="fa-solid fa-spinner fa-spin"></i>
                Adding...
            `;

            try {
                const response = await fetch("{{ route('cart.add') }}",{
                    method:"POST",
                    headers:{
                        "Content-Type":"application/json",
                        "Accept":"application/json",
                        "X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').content,
                        "X-Requested-With":"XMLHttpRequest"
                    },
                    body:JSON.stringify({
                        product_id:productId
                    })
                });

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.message || "Unable to add this product to your cart.");
                }

                const addedProductName = selectedCartProductName || "Product";

                closeCartModal();
                showToast(result.message || `${addedProductName} was added to your cart.`);

            } catch (error) {
                confirmCartButton.disabled = false;
                confirmCartButton.innerHTML = `
                    <i class="fa-solid fa-cart-plus"></i>
                    Yes, Add to Cart
                `;

                showToast(error.message || "Something went wrong. Please try again.");
            }
        });

        /* BUY NOW */
        function buyNow(productId) {
            if (!Number.isInteger(productId) || productId <= 0) {
                showToast("This demo product cannot be purchased. Please select an available product.");
                return;
            }

            const form = document.createElement("form");

            form.method = "POST";
            form.action = "{{ route('ordersummary') }}";

            const csrf = document.createElement("input");
            csrf.type = "hidden";
            csrf.name = "_token";
            csrf.value = "{{ csrf_token() }}";

            const productInput = document.createElement("input");
            productInput.type = "hidden";
            productInput.name = "product_id";
            productInput.value = productId;

            form.appendChild(csrf);
            form.appendChild(productInput);

            document.body.appendChild(form);
            form.submit();
        }

        /* TOAST */
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

                setTimeout(() => toast.remove(),300);
            },2600);
        }

        /* REVEAL ANIMATION */
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("visible");
                } else {
                    entry.target.classList.remove("visible");
                }
            });
        },{
            threshold:.12,
            rootMargin:"0px 0px -45px 0px"
        });

        function setupReveal() {
            document.querySelectorAll(".reveal,.stagger").forEach(el => {
                observer.observe(el);
            });
        }

        /* NAVBAR SCROLL */
        window.addEventListener("scroll",() => {
            document.getElementById("navbar").classList.toggle(
                "scrolled",
                window.scrollY > 25
            );
        },{
            passive:true
        });

        /* DROPDOWNS */
        const profileButton = document.getElementById("profileButton");
        const profileMenu = document.getElementById("profileMenu");
        const categoryButton = document.getElementById("categoryButton");
        const categoryMenu = document.getElementById("categoryMenu");
        const mobileCategoryButton = document.getElementById("mobileCategoryButton");

        profileButton.addEventListener("click",e => {
            e.stopPropagation();
            profileMenu.classList.toggle("open");
            categoryMenu?.classList.remove("open");
        });

        categoryButton?.addEventListener("click",e => {
            e.stopPropagation();
            categoryMenu.classList.toggle("open");
            profileMenu.classList.remove("open");
        });

        mobileCategoryButton?.addEventListener("click",e => {
            e.stopPropagation();
            categoryMenu.classList.toggle("open");
            profileMenu.classList.remove("open");
        });

        document.addEventListener("click",() => {
            profileMenu.classList.remove("open");
            categoryMenu?.classList.remove("open");
        });

        /* CLICK POP */
        document.addEventListener("click",e => {
            const pop = document.createElement("span");

            pop.className = "click-pop";
            pop.style.left = `${e.clientX}px`;
            pop.style.top = `${e.clientY}px`;

            document.body.appendChild(pop);

            setTimeout(() => pop.remove(),700);
        });

        renderProducts();
        setupReveal();
    </script>
</body>
</html>
