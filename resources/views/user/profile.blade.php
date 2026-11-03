
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AgriMarket - Profile</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary-dark: #1e3a2b;
            --primary-green: #2d5a3f;
            --accent-terracotta: #d36b48;
            --accent-terracotta-hover: #be5937;
            --bg-cream: #f9f8f3;
            --bg-card: #ffffff;
            --text-main: #1a1a1a;
            --text-muted: #667085;
            --border-color: #e4e7ec;
            --soft-green: #eef4f0;
            --soft-terracotta: #f8e9e3;
            --shadow-sm: 0 4px 20px rgba(0,0,0,.045);
            --shadow-md: 0 12px 32px rgba(30,58,43,.08);
            --shadow-lg: 0 20px 45px rgba(30,58,43,.12);
            --ease: cubic-bezier(.16,1,.3,1);
            --spring: cubic-bezier(.22,1.2,.36,1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Plus Jakarta Sans", sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background: var(--bg-cream);
            color: var(--text-main);
            line-height: 1.55;
            overflow-x: hidden;
        }

        button, input, select {
            font: inherit;
        }

        button, a {
            -webkit-tap-highlight-color: transparent;
        }

        a {
            color: inherit;
        }

        /* =========================================
           AMBIENT BACKGROUND
        ========================================= */

        .ambient-bg {
            position: fixed;
            inset: 0;
            z-index: -5;
            pointer-events: none;
            overflow: hidden;
            background:
                radial-gradient(circle at 10% 10%, rgba(45,90,63,.09), transparent 28%),
                radial-gradient(circle at 90% 72%, rgba(211,107,72,.08), transparent 26%),
                linear-gradient(180deg, #fbfaf6 0%, #f4f6ef 48%, #faf8f2 100%);
        }

        .ambient-bg::after {
            content: "";
            position: absolute;
            inset: 0;
            opacity: .2;
            background-image:
                linear-gradient(rgba(30,58,43,.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(30,58,43,.035) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: linear-gradient(to bottom, black, transparent 80%);
        }

        .ambient-shape {
            position: absolute;
            width: 34vw;
            height: 34vw;
            min-width: 250px;
            min-height: 250px;
            border-radius: 48% 52% 65% 35% / 38% 45% 55% 62%;
            filter: blur(3px);
            opacity: .3;
        }

        .shape-a {
            top: -14vw;
            left: -12vw;
            background: radial-gradient(circle at 40% 40%, rgba(82,145,104,.22), transparent 68%);
            animation: driftA 18s ease-in-out infinite alternate;
        }

        .shape-b {
            right: -13vw;
            top: 28vh;
            background: radial-gradient(circle at 45% 45%, rgba(211,107,72,.18), transparent 68%);
            animation: driftB 23s ease-in-out infinite alternate;
        }

        @keyframes driftA {
            to {
                transform: translate(10vw,9vh) rotate(25deg) scale(1.12);
            }
        }

        @keyframes driftB {
            to {
                transform: translate(-8vw,-12vh) rotate(-30deg) scale(1.16);
            }
        }

        /* =========================================
           NAVIGATION
        ========================================= */

        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 22px;
            padding: 16px 5%;
            background: rgba(249,248,243,.9);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(0,0,0,.05);
            transition: padding .45s var(--ease), box-shadow .45s ease, background .45s ease;
        }

        .navbar.scrolled {
            padding-top: 10px;
            padding-bottom: 10px;
            background: rgba(249,248,243,.78);
            box-shadow: 0 12px 35px rgba(30,58,43,.08);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 9px;
            color: var(--primary-dark);
            text-decoration: none;
            font-size: 1.45rem;
            font-weight: 800;
            white-space: nowrap;
        }

        .brand i {
            color: var(--primary-green);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 7px;
            margin-left: auto;
        }

        .icon-btn {
            position: relative;
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border: 1px solid transparent;
            background: transparent;
            color: var(--primary-dark);
            border-radius: 10px;
            cursor: pointer;
            transition: .3s var(--ease);
        }

        .icon-btn:hover {
            background: #fff;
            border-color: var(--border-color);
            transform: translateY(-2px);
        }

        .badge {
            position: absolute;
            top: 3px;
            right: 2px;
            min-width: 17px;
            height: 17px;
            padding: 0 4px;
            display: grid;
            place-items: center;
            border-radius: 20px;
            background: var(--accent-terracotta);
            color: #fff;
            font-size: .6rem;
            font-weight: 800;
        }

        .dropdown-wrap {
            position: relative;
        }

        .dropdown {
            position: absolute;
            right: 0;
            top: calc(100% + 10px);
            width: 210px;
            padding: 8px;
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: 14px;
            box-shadow: var(--shadow-lg);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px) scale(.97);
            transition: .3s var(--ease);
        }

        .dropdown.open {
            opacity: 1;
            visibility: visible;
            transform: none;
        }

        .dropdown a,
        .dropdown button {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 12px;
            border: 0;
            background: transparent;
            color: var(--text-main);
            text-decoration: none;
            border-radius: 9px;
            cursor: pointer;
            text-align: left;
            font-size: .88rem;
        }

        .dropdown a:hover,
        .dropdown button:hover {
            background: var(--soft-green);
            color: var(--primary-green);
        }

        /* =========================================
           PROFILE PAGE
        ========================================= */

        .profile-page {
            width: min(1400px, 90%);
            margin: 0 auto;
            padding: 86px 0 45px;
        }

        .profile-first-view {
            min-height: auto;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 40px 0;
        }

        /* =========================================
           PROFILE INFORMATION CARD
        ========================================= */

        .profile-card {
            position: relative;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            gap: 20px;
            padding: 45px 30px;
            background: var(--bg-card);
            border: 1px solid rgba(228,231,236,.85);
            border-radius: 20px;
            box-shadow: var(--shadow-sm);
            transition: transform .35s var(--spring), box-shadow .35s ease;
        }

        .profile-card:hover {
            box-shadow: var(--shadow-md);
        }

        /* Profile picture */

        .profile-picture-wrapper {
            position: relative;
            width: 160px;
            height: 160px;
        }

        .profile-picture {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            overflow: hidden;
            background: var(--soft-green);
            border: 5px solid #fff;
            box-shadow: 0 8px 25px rgba(30,58,43,.12);
            display: grid;
            place-items: center;
        }

        .profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .profile-picture-placeholder {
            width: 100%;
            height: 100%;
            display: grid;
            place-items: center;
            color: var(--primary-green);
            font-size: 3.8rem;
            background: linear-gradient(145deg, var(--soft-green), #e2ece5);
        }

        .profile-upload {
            position: absolute;
            right: 3px;
            bottom: 3px;
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border: 3px solid #fff;
            border-radius: 50%;
            background: var(--accent-terracotta);
            color: #fff;
            cursor: pointer;
            box-shadow: var(--shadow-md);
            transition: transform .3s var(--spring), background .3s ease;
        }

        .profile-upload:hover {
            background: var(--accent-terracotta-hover);
            transform: translateY(-3px) scale(1.05);
        }

        #profilePictureInput {
            display: none;
        }

        /* Profile details */

        .profile-details {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .profile-details h2 {
            color: var(--primary-dark);
            font-size: clamp(1.5rem, 2.5vw, 2rem);
            font-weight: 800;
        }

        .profile-address {
            margin-top: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            color: var(--text-muted);
            font-size: .85rem;
        }

        .profile-address i {
            color: var(--accent-terracotta);
        }

        .profile-bio {
            max-width: 700px;
            margin-top: 8px;
            color: var(--text-muted);
            font-size: .85rem;
            line-height: 1.7;
        }

        /* Report */

        .report-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .report-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-width: 125px;
            padding: 11px 17px;
            border: 0;
            border-radius: 9px;
            background: var(--primary-dark);
            color: #fff;
            text-decoration: none;
            font-size: .76rem;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 7px 18px rgba(30,58,43,.12);
            transition: transform .3s var(--spring), background .3s ease, box-shadow .3s ease;
        }

        .report-btn:hover {
            background: var(--accent-terracotta);
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(211,107,72,.18);
        }

        /* =========================================
           ANALYTICS
        ========================================= */

        .analytics-section {
            padding-top: 25px;
        }

        .analytics-heading {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 20px;
            margin-top: 34px;
            margin-bottom: 15px;
        }

        .analytics-heading h2 {
            color: var(--primary-dark);
            font-size: clamp(1.35rem, 2vw, 1.8rem);
            font-weight: 800;
        }

        .analytics-heading p {
            margin-top: 4px;
            color: var(--text-muted);
            font-size: .8rem;
        }

        .analytics-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0,1fr));
            gap: 16px;
        }

        .chart-card {
            min-width: 0;
            padding: 20px;
            background: var(--bg-card);
            border: 1px solid rgba(228,231,236,.85);
            border-radius: 16px;
            box-shadow: var(--shadow-sm);
            transition: transform .35s var(--spring), box-shadow .35s ease;
        }

        .chart-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-md);
        }

        .chart-card.full-width {
            grid-column: 1 / -1;
        }

        .chart-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 15px;
        }

        .chart-title h3 {
            color: var(--primary-dark);
            font-size: .95rem;
            font-weight: 800;
        }

        .chart-title p {
            margin-top: 3px;
            color: var(--text-muted);
            font-size: .68rem;
        }

        .chart-icon {
            width: 36px;
            height: 36px;
            flex: 0 0 36px;
            display: grid;
            place-items: center;
            border-radius: 9px;
            background: var(--soft-green);
            color: var(--primary-green);
            font-size: .85rem;
        }

        /* Analytics filters */

        .chart-filter {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .chart-filter select {
            min-width: 130px;
            padding: 8px 30px 8px 11px;
            border: 1px solid var(--border-color);
            border-radius: 9px;
            background: #fff;
            color: var(--primary-dark);
            font-size: .68rem;
            font-weight: 700;
            outline: none;
            cursor: pointer;
            transition: border-color .25s ease, box-shadow .25s ease;
        }

        .chart-filter select:hover {
            border-color: var(--primary-green);
        }

        .chart-filter select:focus {
            border-color: var(--primary-green);
            box-shadow: 0 0 0 3px rgba(45,90,63,.08);
        }

        .chart-wrapper {
            position: relative;
            width: 100%;
            height: 290px;
        }

        .chart-wrapper.small {
            height: 270px;
        }

        .chart-wrapper.doughnut-wrapper {
            height: 290px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* =========================================
           FOOTER
        ========================================= */

        footer {
            margin-top: 18px;
            padding: 38px 5% 18px;
            background: var(--primary-dark);
            color: #fff;
        }

        .footer-grid {
            width: min(1400px,100%);
            margin: 0 auto;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.3fr;
            gap: 35px;
            padding-bottom: 24px;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }

        .footer-brand p {
            max-width: 430px;
            margin-top: 8px;
            color: #a0aec0;
            font-size: .8rem;
        }

        .footer-links h4 {
            margin-bottom: 9px;
            font-size: .9rem;
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 5px;
        }

        .footer-links a {
            color: #a0aec0;
            text-decoration: none;
            font-size: .76rem;
            transition: .25s ease;
        }

        .footer-links a:hover {
            color: #fff;
        }

        .copyright {
            width: min(1400px,100%);
            margin: 0 auto;
            padding-top: 15px;
            text-align: center;
            color: #a0aec0;
            font-size: .72rem;
        }

        /* =========================================
           TOAST
        ========================================= */

        .toast-container {
            position: fixed;
            right: 22px;
            bottom: 22px;
            z-index: 3000;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .toast {
            min-width: 250px;
            max-width: 340px;
            padding: 13px 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-radius: 12px;
            background: var(--primary-dark);
            color: #fff;
            box-shadow: var(--shadow-lg);
            animation: toastIn .45s var(--spring);
            font-size: .78rem;
        }

        .toast i {
            color: #b9d7c0;
        }

        .toast.error i {
            color: #ffb4a0;
        }

        @keyframes toastIn {
            from {
                opacity: 0;
                transform: translateY(20px) scale(.92);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }

        /* =========================================
           CLICK POP
        ========================================= */

        .click-pop {
            position: fixed;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            pointer-events: none;
            z-index: 6000;
            background: rgba(45,90,63,.45);
            transform: translate(-50%,-50%);
            animation: pop .7s ease-out forwards;
        }

        @keyframes pop {
            0% {
                opacity: .85;
                transform: translate(-50%,-50%) scale(1);
            }

            100% {
                opacity: 0;
                transform: translate(-50%,-50%) scale(8);
            }
        }

        /* =========================================
           REVEAL ANIMATION
        ========================================= */

        .reveal {
            opacity: 0;
            transform: translateY(48px) scale(.98);
            filter: blur(5px);
            transition: opacity .75s var(--ease), transform .85s var(--ease), filter .75s var(--ease);
        }

        .reveal.visible {
            opacity: 1;
            transform: none;
            filter: blur(0);
        }

        .stagger > * {
            opacity: 0;
            transform: translateY(25px);
            transition: opacity .6s var(--ease), transform .65s var(--ease);
        }

        .stagger.visible > * {
            opacity: 1;
            transform: none;
        }

        .stagger.visible > *:nth-child(1) {
            transition-delay: .03s;
        }

        .stagger.visible > *:nth-child(2) {
            transition-delay: .08s;
        }

        .stagger.visible > *:nth-child(3) {
            transition-delay: .13s;
        }

        .stagger.visible > *:nth-child(4) {
            transition-delay: .18s;
        }

        /* =========================================
           TABLET
        ========================================= */

        @media (max-width: 1000px) {
            .analytics-grid {
                grid-template-columns: 1fr;
            }

            .chart-card.full-width {
                grid-column: auto;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        /* =========================================
           MOBILE
        ========================================= */

        @media (max-width: 650px) {
            .navbar {
                gap: 10px;
            }

            .profile-page {
                width: 92%;
                padding-top: 78px;
            }

            .profile-first-view {
                min-height: auto;
                padding: 25px 0;
            }

            .brand {
                font-size: 1.2rem;
            }

            .icon-btn {
                width: 37px;
                height: 37px;
            }

            .nav-actions {
                gap: 3px;
            }

            .nav-actions .hide-mobile {
                display: none;
            }

            .profile-card {
                gap: 18px;
                padding: 30px 18px;
            }

            .profile-picture-wrapper {
                width: 135px;
                height: 135px;
            }

            .profile-details h2 {
                font-size: 1.45rem;
            }

            .profile-address {
                font-size: .8rem;
            }

            .profile-bio {
                max-width: 100%;
            }

            .report-wrapper {
                justify-content: center;
            }

            .report-btn {
                width: 100%;
            }

            .analytics-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .analytics-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .chart-card {
                padding: 16px;
            }

            .chart-header {
                flex-wrap: wrap;
            }

            .chart-filter {
                width: 100%;
            }

            .chart-filter select {
                width: 100%;
            }

            .chart-wrapper {
                height: 245px;
            }

            .chart-wrapper.small {
                height: 240px;
            }

            .chart-wrapper.doughnut-wrapper {
                height: 250px;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 22px;
            }

            .footer-brand {
                grid-column: 1 / -1;
            }
        }

        @media (max-width: 430px) {
            .footer-grid {
                grid-template-columns: 1fr;
            }

            .chart-wrapper {
                height: 225px;
            }

            .chart-wrapper.small {
                height: 220px;
            }
        }

        /* =========================================
           REDUCED MOTION
        ========================================= */

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: .001ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .001ms !important;
                scroll-behavior: auto !important;
            }

            .reveal,
            .stagger > * {
                opacity: 1;
                transform: none;
                filter: none;
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

    <a href="{{ route('shop') }}" class="brand">
        <i class="fa-solid fa-leaf"></i>
        <span>agrimarket</span>
    </a>

    <div class="nav-actions">

        <button class="icon-btn" title="Notifications"
            onclick="showToast('You have no new notifications.')">
            <i class="fa-regular fa-bell"></i>
            <span class="badge">2</span>
        </button>

        <a href="{{ route('cart') }}" class="icon-btn" title="Shopping Cart">
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="badge" id="cartCount">0</span>
        </a>

        <div class="dropdown-wrap">

            <button class="icon-btn" id="profileButton" title="Profile">
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

                <a href="{{ route('settings') }}">
                    <i class="fa-solid fa-gear"></i>
                    Settings
                </a>

                <form action="{{ route('logout') }}" method="POST">
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

<!-- MAIN PROFILE PAGE -->
<main class="profile-page">

    <!-- FIRST VIEW: PROFILE INFORMATION -->
    <section class="profile-first-view">

        <section class="profile-card reveal">

            <!-- PROFILE PICTURE -->
            <div class="profile-picture-wrapper">

                <div class="profile-picture">

                    @if(!empty($user->profile_picture))

                        <img
                            id="profileImage"
                            src="{{ asset('image/profile/' . basename($user->profile_picture)) }}"
                            alt="Profile Picture"
                        >

                        <div class="profile-picture-placeholder"
                            id="profilePlaceholder"
                            style="display:none;">
                            <i class="fa-regular fa-user"></i>
                        </div>

                    @else

                        <div class="profile-picture-placeholder" id="profilePlaceholder">
                            <i class="fa-regular fa-user"></i>
                        </div>

                        <img
                            id="profileImage"
                            src=""
                            alt="Profile Picture"
                            style="display:none;"
                        >

                    @endif

                </div>

                <!-- PROFILE PICTURE UPLOAD FORM -->
                <form
                    action="{{ route('profile.update-picture') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    id="profilePictureForm"
                >
                    @csrf

                    <label
                        for="profilePictureInput"
                        class="profile-upload"
                        title="Change Profile Picture"
                    >
                        <i class="fa-solid fa-camera"></i>
                    </label>

                    <input
                        type="file"
                        id="profilePictureInput"
                        name="profile_picture"
                        accept="image/jpeg,image/png,image/webp"
                    >
                </form>

            </div>

            <!-- PROFILE DETAILS -->
            <div class="profile-details">

                <h2 id="profileName">
                    {{ $user->name ?: ($user->real_name ?: 'AgriMarket User') }}
                </h2>

                <p class="profile-address">

                    <i class="fa-solid fa-location-dot"></i>

                    <span>
                        {{ $user->active_address ?: 'No address added yet.' }}
                    </span>

                </p>

                <p class="profile-bio">
                    {{ $user->bio ?: 'No biography added yet.' }}
                </p>

            </div>

            <!-- REPORT BUTTON -->
            <div class="report-wrapper">

                <a href="{{ route('report') }}" class="report-btn" onclick="goToReport(event)">
                    <i class="fa-solid fa-chart-column"></i>
                    Report
                </a>

            </div>

        </section>

    </section>

    <!-- ANALYTICS SECTION -->
    <section class="analytics-section">

        <section class="analytics-heading reveal">

            <div>
                <h2>Sales & Inventory Analytics</h2>

                <p>
                    Monitor your sales performance, products, inventory, and revenue.
                </p>
            </div>

        </section>

        <!-- ANALYTICS GRID -->
        <section class="analytics-grid stagger">

            <!-- QUANTITY SALES -->
            <article class="chart-card full-width">

                <div class="chart-header">

                    <div class="chart-title">
                        <h3>Quantity Sales</h3>
                        <p>Number of items sold over time</p>
                    </div>

                    <div class="chart-filter">

                        <select
                            id="quantitySalesFilter"
                            aria-label="Quantity Sales Period"
                            onchange="updateQuantitySalesChart(this.value)"
                        >
                            <option value="7">Last 7 Days</option>
                            <option value="30">Last 30 Days</option>
                            <option value="60">Last 60 Days</option>
                            <option value="90">Last 90 Days</option>
                        </select>

                    </div>

                    <div class="chart-icon">
                        <i class="fa-solid fa-chart-line"></i>
                    </div>

                </div>

                <div class="chart-wrapper">
                    <canvas id="salesTrendChart"></canvas>
                </div>

            </article>

            <!-- BEST-SELLING PRODUCTS -->
            <article class="chart-card">

                <div class="chart-header">

                    <div class="chart-title">
                        <h3>Best-Selling Products</h3>
                        <p>Number of products sold</p>
                    </div>

                    <div class="chart-icon">
                        <i class="fa-solid fa-chart-column"></i>
                    </div>

                </div>

                <div class="chart-wrapper small">
                    <canvas id="bestSellingChart"></canvas>
                </div>

            </article>

            <!-- INVENTORY STATUS -->
            <article class="chart-card">

                <div class="chart-header">

                    <div class="chart-title">
                        <h3>Inventory Status</h3>
                        <p>Current inventory condition</p>
                    </div>

                    <div class="chart-icon">
                        <i class="fa-solid fa-boxes-stacked"></i>
                    </div>

                </div>

                <div class="chart-wrapper doughnut-wrapper">
                    <canvas id="inventoryChart"></canvas>
                </div>

            </article>

            <!-- SALES REVENUE -->
            <article class="chart-card full-width">

                <div class="chart-header">

                    <div class="chart-title">
                        <h3>Sales Revenue</h3>
                        <p>Sales revenue generated over time</p>
                    </div>

                    <div class="chart-filter">

                        <select
                            id="salesRevenueFilter"
                            aria-label="Sales Revenue Period"
                            onchange="updateSalesRevenueChart(this.value)"
                        >
                            <option value="7">Last 7 Days</option>
                            <option value="30">Last 30 Days</option>
                            <option value="60">Last 60 Days</option>
                            <option value="90">Last 90 Days</option>
                        </select>

                    </div>

                    <div class="chart-icon">
                        <i class="fa-solid fa-peso-sign"></i>
                    </div>

                </div>

                <div class="chart-wrapper">
                    <canvas id="revenueTrendChart"></canvas>
                </div>

            </article>

        </section>

    </section>

</main>

<!-- FOOTER -->
<footer>

    <div class="footer-grid">

        <div class="footer-brand">

            <a href="{{ route('shop') }}" class="brand" style="color:#fff">
                <i class="fa-solid fa-leaf"></i>
                <span>agrimarket</span>
            </a>

            <p>
                A modern agricultural marketplace connecting
                buyers and sellers of farm products, supplies
                and services.
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
                <li><a href="{{ route('shop') }}">New & Fresh</a></li>
                <li><a href="{{ route('shop') }}">Best Sellers</a></li>
                <li><a href="{{ route('shop') }}">Groceries</a></li>
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
    /* =====================================================
       DATABASE CHART DATA
       RECEIVED FROM USERCONTROLLER
    ===================================================== */

    const quantitySalesData = @json($quantitySalesData);

    const salesRevenueData = @json($salesRevenueData);

    const bestSellingProducts = @json($bestSellingProducts);

    const inventoryData = @json($inventoryData);


    /* =====================================================
       PROFILE PICTURE UPLOAD
    ===================================================== */

    const profilePictureInput = document.getElementById("profilePictureInput");

    const profileImage = document.getElementById("profileImage");

    const profilePlaceholder = document.getElementById("profilePlaceholder");

    const profilePictureForm = document.getElementById("profilePictureForm");

    profilePictureInput.addEventListener("change", function () {

        const file = this.files[0];

        if (!file) {
            return;
        }

        if (!file.type.startsWith("image/")) {
            showToast("Please select a valid image.", true);
            this.value = "";
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            showToast("Image must not exceed 2MB.", true);
            this.value = "";
            return;
        }

        const imageURL = URL.createObjectURL(file);

        profileImage.src = imageURL;
        profileImage.style.display = "block";

        profilePlaceholder.style.display = "none";

        showToast("Uploading your profile picture...");

        // Save the selected image to the database.
        profilePictureForm.submit();

    });


    /* =====================================================
       CHART DEFAULT SETTINGS
    ===================================================== */

    Chart.defaults.font.family = '"Plus Jakarta Sans", sans-serif';

    Chart.defaults.font.size = 11;

    Chart.defaults.color = "#667085";


    /* =====================================================
       COMMON CHART OPTIONS
    ===================================================== */

    const commonLineOptions = {

        responsive: true,

        maintainAspectRatio: false,

        interaction: {
            intersect: false,
            mode: "index"
        },

        plugins: {

            legend: {
                display: false
            },

            tooltip: {
                backgroundColor: "#1e3a2b",

                titleFont: {
                    weight: "700"
                },

                bodyFont: {
                    weight: "500"
                },

                padding: 10,

                cornerRadius: 9
            }

        },

        scales: {

            x: {
                grid: {
                    display: false
                },

                border: {
                    display: false
                }
            },

            y: {
                beginAtZero: true,

                grid: {
                    color: "rgba(30,58,43,.07)"
                },

                border: {
                    display: false
                }
            }

        }

    };


    /* =====================================================
       QUANTITY SALES CHART
       DATABASE: transactions.quantity
    ===================================================== */

    const salesTrendChart = new Chart(
        document.getElementById("salesTrendChart"),
        {
            type: "line",

            data: {

                labels: quantitySalesData[7].labels,

                datasets: [{

                    label: "Items Sold",

                    data: quantitySalesData[7].values,

                    borderColor: "#2d5a3f",

                    backgroundColor: "rgba(45,90,63,.10)",

                    borderWidth: 3,

                    pointBackgroundColor: "#d36b48",

                    pointBorderColor: "#ffffff",

                    pointBorderWidth: 2,

                    pointRadius: 4,

                    pointHoverRadius: 6,

                    tension: 0,

                    fill: true

                }]

            },

            options: {

                ...commonLineOptions,

                scales: {

                    x: {
                        grid: {
                            display: false
                        },

                        border: {
                            display: false
                        }
                    },

                    y: {
                        beginAtZero: true,

                        grid: {
                            color: "rgba(30,58,43,.07)"
                        },

                        border: {
                            display: false
                        },

                        ticks: {
                            callback: function (value) {
                                return Number(value).toLocaleString("en-PH");
                            }
                        }
                    }

                },

                plugins: {

                    ...commonLineOptions.plugins,

                    tooltip: {

                        ...commonLineOptions.plugins.tooltip,

                        callbacks: {

                            label: function (context) {

                                return " Items Sold: " +
                                    Number(context.parsed.y).toLocaleString("en-PH");

                            }

                        }

                    }

                }

            }

        }
    );


    /* =====================================================
       BEST-SELLING PRODUCTS BAR CHART
       DATABASE: transactions.product_name
       DATABASE: transactions.quantity
    ===================================================== */

    const bestSellingChart = new Chart(
        document.getElementById("bestSellingChart"),
        {
            type: "bar",

            data: {

                labels: bestSellingProducts.length
                    ? bestSellingProducts.map(product => product.name)
                    : ["No sales yet"],

                datasets: [{

                    label: "Products Sold",

                    data: bestSellingProducts.length
                        ? bestSellingProducts.map(product => product.sold)
                        : [0],

                    backgroundColor: "#2d5a3f",

                    borderRadius: 7,

                    borderSkipped: false

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        display: false
                    },

                    tooltip: {

                        backgroundColor: "#1e3a2b",

                        padding: 10,

                        cornerRadius: 9

                    }

                },

                scales: {

                    x: {
                        grid: {
                            display: false
                        },

                        border: {
                            display: false
                        }
                    },

                    y: {
                        beginAtZero: true,

                        grid: {
                            color: "rgba(30,58,43,.07)"
                        },

                        border: {
                            display: false
                        }
                    }

                }

            }

        }
    );


    /* =====================================================
       INVENTORY DOUGHNUT CHART
       DATABASE: products.quantity
       DATABASE: products.status
    ===================================================== */

    const inventoryChart = new Chart(
        document.getElementById("inventoryChart"),
        {
            type: "doughnut",

            data: {

                labels: [
                    "In Stock",
                    "Low Stock",
                    "Out of Stock"
                ],

                datasets: [{

                    data: [

                        inventoryData.inStock,

                        inventoryData.lowStock,

                        inventoryData.outOfStock

                    ],

                    backgroundColor: [

                        "#2d5a3f",

                        "#d36b48",

                        "#cbd4cd"

                    ],

                    borderColor: "#ffffff",

                    borderWidth: 4,

                    hoverOffset: 7

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                cutout: "67%",

                plugins: {

                    legend: {

                        position: "bottom",

                        labels: {

                            usePointStyle: true,

                            pointStyle: "circle",

                            padding: 18,

                            font: {
                                size: 10,
                                weight: "700"
                            }

                        }

                    },

                    tooltip: {

                        backgroundColor: "#1e3a2b",

                        padding: 10,

                        cornerRadius: 9

                    }

                }

            }

        }
    );


    /* =====================================================
       SALES REVENUE CHART
       DATABASE: transactions.total_amount
    ===================================================== */

    const revenueTrendChart = new Chart(
        document.getElementById("revenueTrendChart"),
        {
            type: "line",

            data: {

                labels: salesRevenueData[7].labels,

                datasets: [{

                    label: "Sales Revenue",

                    data: salesRevenueData[7].values,

                    borderColor: "#d36b48",

                    backgroundColor: "rgba(211,107,72,.10)",

                    borderWidth: 3,

                    pointBackgroundColor: "#2d5a3f",

                    pointBorderColor: "#ffffff",

                    pointBorderWidth: 2,

                    pointRadius: 4,

                    pointHoverRadius: 6,

                    tension: 0,

                    fill: true

                }]

            },

            options: {

                ...commonLineOptions,

                scales: {

                    x: {
                        grid: {
                            display: false
                        },

                        border: {
                            display: false
                        }
                    },

                    y: {

                        beginAtZero: true,

                        grid: {
                            color: "rgba(30,58,43,.07)"
                        },

                        border: {
                            display: false
                        },

                        ticks: {

                            callback: function (value) {

                                return "₱" +
                                    Number(value).toLocaleString("en-PH");

                            }

                        }

                    }

                },

                plugins: {

                    ...commonLineOptions.plugins,

                    tooltip: {

                        ...commonLineOptions.plugins.tooltip,

                        callbacks: {

                            label: function (context) {

                                return " Revenue: ₱" +
                                    Number(context.parsed.y).toLocaleString("en-PH");

                            }

                        }

                    }

                }

            }

        }
    );


    /* =====================================================
       QUANTITY SALES FILTER
    ===================================================== */

    function updateQuantitySalesChart(period) {

        if (!quantitySalesData[period]) {
            return;
        }

        salesTrendChart.data.labels =
            quantitySalesData[period].labels;

        salesTrendChart.data.datasets[0].data =
            quantitySalesData[period].values;

        salesTrendChart.update();

    }


    /* =====================================================
       SALES REVENUE FILTER
    ===================================================== */

    function updateSalesRevenueChart(period) {

        if (!salesRevenueData[period]) {
            return;
        }

        revenueTrendChart.data.labels =
            salesRevenueData[period].labels;

        revenueTrendChart.data.datasets[0].data =
            salesRevenueData[period].values;

        revenueTrendChart.update();

    }


    /* =====================================================
       PROFILE DROPDOWN
    ===================================================== */

    const profileButton = document.getElementById("profileButton");

    const profileMenu = document.getElementById("profileMenu");

    profileButton.addEventListener("click", function (e) {

        e.stopPropagation();

        profileMenu.classList.toggle("open");

    });

    profileMenu.addEventListener("click", function (e) {
        e.stopPropagation();
    });

    document.addEventListener("click", function () {

        profileMenu.classList.remove("open");

    });


    /* =====================================================
       NAVBAR SCROLL EFFECT
    ===================================================== */

    window.addEventListener("scroll", function () {

        document.getElementById("navbar").classList.toggle(
            "scrolled",
            window.scrollY > 25
        );

    }, {
        passive: true
    });


    /* =====================================================
       TOAST
    ===================================================== */

    function showToast(message, isError = false) {

        const container = document.getElementById("toastContainer");

        const toast = document.createElement("div");

        toast.className = isError ? "toast error" : "toast";

        const icon = document.createElement("i");

        icon.className = isError
            ? "fa-solid fa-circle-exclamation"
            : "fa-solid fa-circle-check";

        const text = document.createElement("span");

        text.textContent = message;

        toast.appendChild(icon);

        toast.appendChild(text);

        container.appendChild(toast);

        setTimeout(function () {

            toast.style.opacity = "0";

            toast.style.transform = "translateY(10px)";

            toast.style.transition = ".3s ease";

            setTimeout(function () {
                toast.remove();
            }, 300);

        }, 2600);

    }


    /* =====================================================
       LARAVEL SESSION MESSAGES
    ===================================================== */

    @if(session('status'))

        showToast(@json(session('status')));

    @endif

    @if($errors->any())

        @foreach($errors->all() as $error)

            showToast(@json($error), true);

        @endforeach

    @endif


    /* =====================================================
       REPEATING SCROLL REVEAL
    ===================================================== */

    const observer = new IntersectionObserver(

        function (entries) {

            entries.forEach(function (entry) {

                if (entry.isIntersecting) {

                    entry.target.classList.add("visible");

                } else {

                    entry.target.classList.remove("visible");

                }

            });

        },

        {
            threshold: .12,
            rootMargin: "0px 0px -45px 0px"
        }

    );

    document.querySelectorAll(".reveal, .stagger").forEach(function (element) {

        observer.observe(element);

    });


    /* =====================================================
       CLICK POP
    ===================================================== */

    document.addEventListener("click", function (e) {

        const pop = document.createElement("span");

        pop.className = "click-pop";

        pop.style.left = `${e.clientX}px`;

        pop.style.top = `${e.clientY}px`;

        document.body.appendChild(pop);

        setTimeout(function () {

            pop.remove();

        }, 700);

    });

</script>

</body>
</html>
