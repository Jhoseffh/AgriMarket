<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AgriMarket - Category</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-dark: #1e3a2b;
            --primary-green: #2d5a3f;
            --accent-terracotta: #d36b48;
            --accent-terracotta-hover: #be5937;
            --bg-cream: #f9f8f3;
            --bg-card: #a78686;
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

        button,
        input,
        select {
            font: inherit;
        }

        button,
        a {
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

        /* =========================================
           SEARCH
        ========================================= */

        .nav-search-wrap {
            position: relative;
            flex: 1;
            max-width: 600px;
            margin: 0 auto;
        }

        .nav-search {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 5px 6px 5px 14px;
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: var(--shadow-sm);
        }

        .nav-search > i {
            color: var(--text-muted);
        }

        .nav-search input {
            flex: 1;
            min-width: 0;
            border: 0;
            outline: 0;
            color: var(--text-main);
            background: transparent;
            padding: 9px 4px;
        }

        .nav-search input::placeholder {
            color: var(--text-muted);
        }

        .nav-search button {
            border: 0;
            background: var(--primary-dark);
            color: #fff;
            width: 38px;
            height: 38px;
            border-radius: 9px;
            cursor: pointer;
            transition: transform .3s var(--spring), background .3s ease;
        }

        .nav-search button:hover {
            background: var(--primary-green);
            transform: translateY(-2px);
        }

        /* =========================================
           SEARCH SUGGESTIONS
           REFERENCE DESIGN
        ========================================= */

        .search-suggestions {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            right: 0;
            width: 100%;
            padding: 7px;
            background: #fff;
            border: 1px solid var(--border-color);
            border-radius: 12px;
            box-shadow: var(--shadow-lg);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-7px);
            transition: .3s var(--ease);
            z-index: 2100;
        }

        .search-suggestions.open {
            opacity: 1;
            visibility: visible;
            transform: none;
        }

        .search-suggestion {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 11px;
            border: 0;
            border-radius: 9px;
            background: transparent;
            color: var(--text-main);
            text-decoration: none;
            text-align: left;
            cursor: pointer;
            font-size: .82rem;
            transition: .25s var(--ease);
        }

        .search-suggestion:hover {
            background: var(--soft-green);
            color: var(--primary-green);
        }

        .search-suggestion i {
            flex: 0 0 auto;
            width: auto;
            color: var(--primary-green);
            font-size: .78rem;
        }

        .search-suggestion-name {
            min-width: 0;
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .search-empty {
            padding: 11px 12px;
            color: var(--text-muted);
            font-size: .78rem;
        }

        /* =========================================
           NAV ACTIONS
        ========================================= */

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 7px;
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


        /* =========================================
           CATEGORY BUTTON
        ========================================= */

        .category-desktop {
            flex: 0 0 auto;
        }

        .category-desktop .icon-btn {
            width: auto;
            min-width: 105px;
            height: 42px;
            padding: 0 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: #fff;
            border-color: var(--border-color);
            color: var(--primary-dark);
            font-size: .78rem;
            font-weight: 800;
            white-space: nowrap;
        }

        .category-desktop .icon-btn i {
            font-size: .95rem;
            color: var(--primary-green);
        }

        .category-desktop .icon-btn:hover {
            background: var(--soft-green);
            border-color: rgba(45,90,63,.2);
            color: var(--primary-green);
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

        /* Category dropdown */
        .category-dropdown {
            left: 50%;
            right: auto;
            width: 590px;
            display: grid;
            grid-template-columns: repeat(3,1fr);
            gap: 5px;
            padding: 10px;
            transform: translateX(-52%) translateY(-8px) scale(.97);
        }

        .category-dropdown.open {
            opacity: 1;
            visibility: visible;
            transform: translateX(-52%);
        }

        .category-dropdown a {
            min-width: 0;
            padding: 10px 9px;
            gap: 8px;
            font-size: .78rem;
            white-space: nowrap;
        }

        .category-dropdown a i {
            width: 17px;
            flex: 0 0 17px;
            text-align: center;
            color: var(--primary-green);
            font-size: .82rem;
        }

        .category-dropdown a:hover i {
            color: var(--accent-terracotta);
        }

        .mobile-menu-btn {
            display: none;
        }

        /* =========================================
           CATEGORY PAGE
        ========================================= */

        .category-page {
            width: min(1400px, 90%);
            margin: 0 auto;
            padding-top: 116px;
            padding-bottom: 25px;
        }

        /* =========================================
           CATEGORY BANNER
        ========================================= */

        .category-banner {
            position: relative;
            min-height: 300px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding: 45px 7%;
            margin-bottom: 30px;
            border-radius: 22px;
            border: 1px solid rgba(228,231,236,.9);
            background:
                linear-gradient(105deg, rgba(30,58,43,.99) 0%, rgba(45,90,63,.97) 58%, rgba(45,90,63,.92) 100%);
            box-shadow: var(--shadow-lg);
            isolation: isolate;
        }

        /* =========================================
           AGRICULTURAL CATEGORY BANNER ARTWORK
        ========================================= */

        .category-banner {
            background:
                radial-gradient(ellipse at 78% 12%, rgba(245,198,104,.16), transparent 30%),
                linear-gradient(112deg, #173b2b 0%, #24583d 53%, #2e6544 100%);
        }

        .category-banner::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background:
                linear-gradient(90deg, rgba(17,48,34,.36) 0%, rgba(17,48,34,.18) 42%, transparent 72%),
                linear-gradient(0deg, rgba(12,40,28,.24), transparent 48%);
        }

        .banner-agriculture-art {
            position: absolute;
            inset: 0 0 0 auto;
            width: 70%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
            overflow: hidden;
            opacity: 1;
            -webkit-mask-image: linear-gradient(90deg, transparent 0%, rgba(0,0,0,.3) 12%, #000 34%);
            mask-image: linear-gradient(90deg, transparent 0%, rgba(0,0,0,.3) 12%, #000 34%);
        }

        .banner-agriculture-art::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(110deg, transparent 36%, rgba(255,255,255,.045) 57%, transparent 76%);
            transform: translateX(-100%);
            animation: bannerSunSweep 12s ease-in-out infinite;
        }

        .banner-agriculture-art svg {
            display: block;
            width: 100%;
            height: 100%;
            overflow: visible;
        }

        .category-banner-art-scene {
            transform: translate3d(var(--banner-art-shift-x, 0px), var(--banner-art-shift-y, 0px), 0);
            transition: transform .35s cubic-bezier(.16,1,.3,1);
            transform-origin: center;
        }


        /* Each product category owns its own banner palette and illustration. */
        .category-banner.banner-theme-fruits {
            background: radial-gradient(ellipse at 83% 20%, rgba(255,190,89,.22), transparent 32%), linear-gradient(112deg,#3e2928 0%,#693a36 53%,#8a4d3d 100%);
        }
        .category-banner.banner-theme-vegetables {
            background: radial-gradient(ellipse at 82% 16%,rgba(171,220,103,.2),transparent 32%),linear-gradient(112deg,#183c2c 0%,#276442 55%,#3b8150 100%);
        }
        .category-banner.banner-theme-grains {
            background: radial-gradient(ellipse at 82% 16%,rgba(255,211,111,.22),transparent 32%),linear-gradient(112deg,#3f3822 0%,#665a2e 55%,#85733a 100%);
        }
        .category-banner.banner-theme-seeds {
            background: radial-gradient(ellipse at 82% 16%,rgba(202,223,144,.2),transparent 32%),linear-gradient(112deg,#26392c 0%,#3f5c3d 55%,#5c7549 100%);
        }
        .category-banner.banner-theme-organic {
            background: radial-gradient(ellipse at 82% 16%,rgba(182,220,153,.2),transparent 32%),linear-gradient(112deg,#153b30 0%,#1e5c49 55%,#347b5b 100%);
        }
        .category-banner.banner-theme-herbs {
            background: radial-gradient(ellipse at 82% 16%,rgba(201,218,132,.18),transparent 32%),linear-gradient(112deg,#26362b 0%,#43543a 55%,#667443 100%);
        }
        .category-banner.banner-theme-meat {
            background: radial-gradient(ellipse at 82% 16%,rgba(242,190,127,.18),transparent 32%),linear-gradient(112deg,#382a26 0%,#604239 55%,#805442 100%);
        }
        .category-banner.banner-theme-fish {
            background: radial-gradient(ellipse at 82% 16%,rgba(125,217,214,.22),transparent 32%),linear-gradient(112deg,#173b3e 0%,#1e5960 55%,#2e7d80 100%);
        }
        .category-banner.banner-theme-dairy {
            background: radial-gradient(ellipse at 82% 16%,rgba(239,224,181,.22),transparent 32%),linear-gradient(112deg,#33433b 0%,#59745c 55%,#829b70 100%);
        }
        .category-banner.banner-theme-processed {
            background: radial-gradient(ellipse at 82% 16%,rgba(248,192,113,.2),transparent 32%),linear-gradient(112deg,#3e3029 0%,#694b37 55%,#936b45 100%);
        }
        .category-banner.banner-theme-general {
            background: radial-gradient(ellipse at 82% 16%,rgba(245,198,104,.16),transparent 30%),linear-gradient(112deg,#173b2b 0%,#24583d 53%,#2e6544 100%);
        }

        .banner-fruit-leaf { transform-box: fill-box; transform-origin: 50% 100%; animation: bannerLeafSway 5.8s ease-in-out infinite alternate; }
        .banner-fruit-bob { transform-box: fill-box; transform-origin: center; animation: bannerFruitBob 4.8s ease-in-out infinite alternate; }
        .banner-fruit-bob.fruit-two { animation-delay: -1.7s; }
        .banner-fruit-bob.fruit-three { animation-delay: -2.6s; }
        .banner-veg-leaf { transform-box: fill-box; transform-origin: bottom center; animation: bannerLeafSway 5.2s ease-in-out infinite alternate; }
        .banner-veg-tomato { transform-box: fill-box; transform-origin: center; animation: bannerFruitBob 4.2s ease-in-out infinite alternate; }
        .banner-grain-stalk { transform-box: fill-box; transform-origin: bottom center; animation: bannerCropSway 5.5s ease-in-out infinite alternate; }
        .banner-grain-head { transform-box: fill-box; transform-origin: bottom center; animation: bannerCropSway 5.9s ease-in-out infinite alternate-reverse; }
        .banner-seedling { transform-box: fill-box; transform-origin: bottom center; animation: bannerCropSway 6s ease-in-out infinite alternate; }
        .banner-seed-drift { animation: bannerSeedDrift 8s ease-in-out infinite alternate; }
        .banner-organic-leaf { transform-box: fill-box; transform-origin: bottom center; animation: bannerLeafSway 6.5s ease-in-out infinite alternate; }
        .banner-organic-leaf.leaf-left { animation-delay: -2s; animation-duration: 5.4s; }
        .banner-herb-sprig { transform-box: fill-box; transform-origin: bottom center; animation: bannerLeafSway 5.7s ease-in-out infinite alternate; }
        .banner-spice-pods { transform-box: fill-box; transform-origin: center; animation: bannerFruitBob 5s ease-in-out infinite alternate; }
        .banner-chicken { transform-box: fill-box; transform-origin: center; animation: bannerAnimalBob 4.5s ease-in-out infinite alternate; }
        .banner-livestock-hill { animation: bannerAnimalBob 6s ease-in-out infinite alternate-reverse; }
        .banner-fish-swim { animation: bannerFishSwim 7s ease-in-out infinite alternate; }
        .banner-fish-swim.fish-two { animation-delay: -3s; animation-duration: 8s; }
        .banner-water-bubble { animation: bannerBubbleRise 6s ease-in-out infinite alternate; }
        .banner-milk-bottle { transform-box: fill-box; transform-origin: bottom center; animation: bannerFruitBob 5s ease-in-out infinite alternate; }
        .banner-eggs { transform-box: fill-box; transform-origin: center; animation: bannerEggRock 5.5s ease-in-out infinite alternate; }
        .banner-package-float { transform-box: fill-box; transform-origin: center; animation: bannerPackageFloat 5s ease-in-out infinite alternate; }
        .banner-package-float.package-two { animation-delay: -2.1s; }
        .banner-jar { transform-box: fill-box; transform-origin: bottom center; animation: bannerPackageFloat 5.8s ease-in-out infinite alternate-reverse; }
        .banner-general-leaf { transform-box: fill-box; transform-origin: bottom center; animation: bannerLeafSway 6s ease-in-out infinite alternate; }

        @keyframes bannerLeafSway { from { transform: rotate(-2deg); } to { transform: rotate(3deg); } }
        @keyframes bannerFruitBob { from { transform: translateY(0); } to { transform: translateY(-5px); } }
        @keyframes bannerSeedDrift { from { transform: translateX(-3px); } to { transform: translateX(4px); } }
        @keyframes bannerAnimalBob { from { transform: translateY(0); } to { transform: translateY(-3px); } }
        @keyframes bannerFishSwim { from { transform: translateX(-5px); } to { transform: translateX(9px); } }
        @keyframes bannerBubbleRise { from { transform: translateY(6px); opacity: .45; } to { transform: translateY(-8px); opacity: .9; } }
        @keyframes bannerEggRock { from { transform: rotate(-1deg); } to { transform: rotate(1deg); } }
        @keyframes bannerPackageFloat { from { transform: translateY(2px) rotate(-1deg); } to { transform: translateY(-4px) rotate(1deg); } }

        @media (hover: hover) and (pointer: fine) {
            .category-banner:hover .banner-agriculture-art {
                filter: saturate(1.08);
            }
        }

        .banner-sun-glow {
            transform-origin: 440px 54px;
            animation: bannerSunGlow 7s ease-in-out infinite;
        }

        .banner-cloud {
            animation: bannerCloudDrift 24s ease-in-out infinite alternate;
        }

        .banner-cloud.cloud-two {
            animation-delay: -11s;
            animation-duration: 29s;
        }

        .banner-rice-stalk {
            transform-box: fill-box;
            transform-origin: bottom center;
            animation: bannerCropSway 5.5s ease-in-out infinite alternate;
        }

        .banner-rice-stalk.stalk-two {
            animation-delay: -2.2s;
            animation-duration: 6.4s;
        }

        .banner-rice-stalk.stalk-three {
            animation-delay: -3.4s;
            animation-duration: 5.9s;
        }

        .banner-terrace-highlight {
            animation: bannerTerraceShimmer 8s ease-in-out infinite alternate;
        }

        @keyframes bannerSunGlow {
            0%, 100% { opacity: .72; transform: scale(.96); }
            50% { opacity: 1; transform: scale(1.06); }
        }

        @keyframes bannerCloudDrift {
            from { transform: translateX(-7px); }
            to { transform: translateX(15px); }
        }

        @keyframes bannerCropSway {
            from { transform: rotate(-2deg); }
            to { transform: rotate(2.5deg); }
        }

        @keyframes bannerTerraceShimmer {
            from { opacity: .55; }
            to { opacity: .95; }
        }

        @keyframes bannerSunSweep {
            0%, 60% { transform: translateX(-100%); opacity: 0; }
            72% { opacity: .7; }
            100% { transform: translateX(100%); opacity: 0; }
        }

        .category-banner-content {
            position: relative;
            z-index: 2;
            max-width: 560px;
            text-align: left;
            margin-right: auto;
            margin-left: 0;
        }

        .category-banner-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 6px 11px;
            margin-bottom: 12px;
            border-radius: 20px;
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.16);
            color: #f3e7c7;
            font-size: .68rem;
            font-weight: 800;
            letter-spacing: 1.1px;
            text-transform: uppercase;
            backdrop-filter: blur(6px);
        }

        .category-banner-content h1 {
            color: #fff;
            font-size: clamp(2.5rem, 6vw, 5rem);
            line-height: 1;
            font-weight: 800;
            letter-spacing: -2px;
            text-shadow: 0 8px 30px rgba(0,0,0,.2);
        }

        .category-banner-content p {
            max-width: 560px;
            margin: 15px 0 0;
            color: rgba(255,255,255,.82);
            font-size: .88rem;
        }

        /* =========================================
           SORT
        ========================================= */

        .sort-section {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            margin-bottom: 27px;
        }

        .sort-label {
            color: var(--primary-dark);
            font-size: .8rem;
            font-weight: 800;
            white-space: nowrap;
        }

        .sort-control {
            position: relative;
        }

        .sort-select {
            min-width: 175px;
            height: 42px;
            padding: 0 38px 0 13px;
            appearance: none;
            border: 1px solid var(--border-color);
            border-radius: 10px;
            outline: none;
            background: #fff;
            color: var(--text-main);
            font-size: .76rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: var(--shadow-sm);
            transition: border-color .3s ease, box-shadow .3s ease, transform .3s var(--spring);
        }

        .sort-control i {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-green);
            font-size: .72rem;
            pointer-events: none;
        }

        .sort-select:hover {
            border-color: rgba(45,90,63,.3);
            transform: translateY(-2px);
        }

        .sort-select:focus {
            border-color: rgba(45,90,63,.4);
            box-shadow: 0 0 0 4px rgba(45,90,63,.07);
        }

        /* =========================================
           ITEMS HEADING
        ========================================= */

        .items-heading {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 30px;
            margin-bottom: 12px;
            color: var(--text-muted);
            font-size: .7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .8px;
        }

        .items-heading::after {
            content: "";
            flex: 1;
            height: 1px;
            background: var(--border-color);
        }

        .items-heading .eyebrow {
            display: block;
            padding: 0;
            border-radius: 0;
            background: transparent;
            color: var(--text-muted);
            font-size: .7rem;
            font-weight: 800;
            letter-spacing: .8px;
            text-transform: uppercase;
        }

        .items-heading h2,
        .items-heading p {
            display: none;
        }

        /* =========================================
           PRODUCTS
        ========================================= */

        .product-grid {
            display: grid;
            grid-template-columns: repeat(6,minmax(0,1fr));
            gap: 13px;
        }

        .product-card {
            position: relative;
            min-width: 0;
            overflow: hidden;
            background: #fff;
            border: 1px solid rgba(228,231,236,.85);
            border-radius: 15px;
            box-shadow: var(--shadow-sm);
            transition: transform .35s var(--spring), box-shadow .35s ease, border-color .35s ease;
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: rgba(45,90,63,.15);
        }

        .product-image {
            position: relative;
            height: 190px;
            overflow: hidden;
            background: #e9ecef;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
            transition: transform .45s var(--ease);
        }

        .product-card:hover .product-image img {
            transform: scale(1.045);
        }

        .placeholder {
            position: absolute;
            inset: 0;
            display: grid;
            place-items: center;
            text-align: center;
            padding: 20px;
            color: #6c757d;
            background: linear-gradient(135deg, rgba(255,255,255,.38), transparent 50%), #e9ecef;
            transition: transform .45s var(--ease);
        }

        .placeholder::before {
            content: "";
            position: absolute;
            width: 180%;
            height: 50%;
            background: rgba(255,255,255,.34);
            transform: rotate(-18deg) translateX(-80%);
            transition: transform .9s var(--ease);
        }

        .product-card:hover .placeholder::before {
            transform: rotate(-18deg) translateX(80%);
        }

        .product-card:hover .product-image .placeholder {
            transform: scale(1.045);
        }

        .placeholder-content {
            position: relative;
            z-index: 1;
        }

        .placeholder i {
            font-size: 2rem;
            color: #a8b0b5;
            margin-bottom: 7px;
        }

        .placeholder strong {
            display: block;
            font-size: .8rem;
        }

        .placeholder small {
            display: block;
            margin-top: 3px;
            font-size: .68rem;
        }

        .product-badge {
            position: absolute;
            top: 9px;
            left: 9px;
            z-index: 2;
            padding: 4px 8px;
            border-radius: 7px;
            background: var(--accent-terracotta);
            color: #fff;
            font-size: .58rem;
            font-weight: 800;
        }

        .product-info {
            padding: 12px;
        }

        .product-name {
            min-height: 38px;
            color: var(--primary-dark);
            font-size: .8rem;
            font-weight: 800;
            line-height: 1.35;
        }

        .product-price {
            margin-top: 5px;
            color: var(--accent-terracotta);
            font-size: 1rem;
            font-weight: 800;
        }

        .product-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 5px;
            margin-top: 3px;
            color: var(--text-muted);
            font-size: .65rem;
        }

        .product-meta .uom {
            color: var(--primary-green);
            font-weight: 700;
        }

        .product-meta .stock {
            color: var(--text-muted);
            text-align: right;
        }

        .card-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 6px;
            margin-top: 11px;
        }

        .card-btn {
            border: 0;
            border-radius: 8px;
            padding: 8px 5px;
            cursor: pointer;
            font-size: .65rem;
            font-weight: 800;
            transition: .3s var(--ease);
        }

        .cart-btn {
            background: var(--soft-green);
            color: var(--primary-green);
        }

        .cart-btn:hover {
            background: var(--primary-green);
            color: #fff;
            transform: translateY(-2px);
        }

        .buy-btn {
            background: var(--primary-dark);
            color: #fff;
        }

        .buy-btn:hover {
            background: var(--accent-terracotta);
            transform: translateY(-2px);
        }

        /* =========================================
           PAGINATION
        ========================================= */

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 40px;
        }

        .pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .page-link {
            min-width: 36px;
            height: 36px;
            padding: 0 10px;
            display: grid;
            place-items: center;
            border: 1px solid var(--border-color);
            border-radius: 9px;
            background: #fff;
            color: var(--primary-dark);
            text-decoration: none;
            font-size: .72rem;
            font-weight: 800;
            box-shadow: var(--shadow-sm);
            transition: .3s var(--ease);
        }

        .page-link:hover {
            background: var(--soft-green);
            border-color: rgba(45,90,63,.2);
            color: var(--primary-green);
            transform: translateY(-2px);
        }

        .page-link.active {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
            color: #fff;
        }

        .page-dots {
            color: var(--text-muted);
            font-size: .75rem;
            padding: 0 3px;
        }

        /* =========================================
           REVEAL
        ========================================= */

        .reveal {
            opacity: 0;
            transform: translateY(48px) scale(.98);
            filter: blur(5px);
            transition: opacity .75s var(--ease), transform .85s var(--ease), filter .75s var(--ease);
        }

        .reveal.from-left {
            transform: translateX(-55px);
        }

        .reveal.from-right {
            transform: translateX(55px);
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

        .stagger.visible > *:nth-child(5) {
            transition-delay: .23s;
        }

        .stagger.visible > *:nth-child(6) {
            transition-delay: .28s;
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
           TABLET
        ========================================= */

        @media (max-width: 1200px) {
            .product-grid {
                grid-template-columns: repeat(4,minmax(0,1fr));
            }
        }

        @media (max-width: 900px) {
            .navbar {
                gap: 10px;
                flex-wrap: wrap;
            }

            .nav-search-wrap {
                order: 3;
                flex-basis: 100%;
                max-width: none;
            }

            .nav-actions {
                margin-left: auto;
            }

            .mobile-menu-btn {
                display: grid;
            }

            .category-desktop {
                display: block;
            }

            .category-desktop > #categoryButton {
                display: none;
            }

            .category-dropdown {
                position: fixed;
                top: 62px;
                left: auto;
                right: 5%;
                width: 420px;
                grid-template-columns: repeat(2,1fr);
                z-index: 2000;
                transform: translateY(-8px) scale(.97);
            }

            .category-dropdown.open {
                transform: none;
            }

            .category-banner {
                min-height: 270px;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        /* =========================================
           MOBILE
        ========================================= */

        @media (max-width: 650px) {
            .category-page {
                width: 92%;
                padding-top: 145px;
            }

            .category-banner {
                min-height: 245px;
                padding: 35px 25px;
                border-radius: 18px;
                margin-bottom: 23px;
            }

            .banner-agriculture-art {
                width: 78%;
                opacity: .78;
                -webkit-mask-image: linear-gradient(90deg, transparent 0%, rgba(0,0,0,.22) 15%, #000 43%);
                mask-image: linear-gradient(90deg, transparent 0%, rgba(0,0,0,.22) 15%, #000 43%);
            }

            .category-banner-content {
                width: 100%;
                max-width: 100%;
            }

            .category-banner-content h1 {
                font-size: clamp(2.25rem,12vw,3.5rem);
                letter-spacing: -1.5px;
            }

            .category-banner-content p {
                font-size: .76rem;
                max-width: 420px;
            }

            .sort-section {
                align-items: center;
                justify-content: flex-end;
                flex-direction: row;
                gap: 8px;
                margin-top: 5px;
                margin-bottom: 23px;
            }

            .sort-label {
                color: var(--text-muted);
                font-size: .72rem;
                font-weight: 800;
            }

            .sort-control {
                width: auto;
            }

            .sort-select {
                min-width: 145px;
                width: auto;
                height: 38px;
                padding: 0 38px 0 11px;
                font-size: .72rem;
            }

            .items-heading {
                margin-top: 30px;
                margin-bottom: 12px;
            }

            .product-grid {
                grid-template-columns: repeat(2,minmax(0,1fr));
                gap: 10px;
            }

            .product-image {
                height: 155px;
            }

            .product-info {
                padding: 10px;
            }

            .card-actions {
                grid-template-columns: 1fr;
            }

            .pagination-wrapper {
                margin-top: 32px;
            }

            .pagination {
                gap: 4px;
            }

            .page-link {
                min-width: 32px;
                height: 32px;
                font-size: .65rem;
            }

            .page-dots {
                padding: 0 3px;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 22px;
            }

            .footer-brand {
                grid-column: 1 / -1;
            }

            .nav-actions .hide-mobile {
                display: none;
            }

            .brand {
                font-size: 1.2rem;
            }

            .icon-btn {
                width: 37px;
                height: 37px;
            }

            .category-dropdown {
                top: 58px;
                right: 4%;
                width: 92%;
                grid-template-columns: repeat(2,1fr);
            }

            .category-dropdown a {
                font-size: .73rem;
                padding: 9px 8px;
            }

            /* Reference search suggestion responsive behavior */
            .search-suggestions {
                top: calc(100% + 7px);
            }
        }

        @media (max-width: 430px) {
            .category-banner {
                min-height: 225px;
                padding: 28px 20px;
            }

            .banner-agriculture-art {
                width: 82%;
                opacity: 1;
                filter: brightness(1.15);
            }

            .category-banner-eyebrow {
                font-size: .59rem;
            }

            .category-banner-content h1 {
                font-size: 2.25rem;
            }

            .category-banner-content p {
                font-size: .7rem;
            }

            .product-image {
                height: 135px;
            }

            .product-name {
                font-size: .73rem;
            }

            .product-price {
                font-size: .9rem;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }

            .pagination {
                gap: 4px;
            }

            .page-link {
                min-width: 32px;
                height: 32px;
                font-size: .65rem;
            }
        }

        /* =========================================
           CATEGORY BANNER RESPONSIVE REFINEMENT
           Keep the original left-aligned text layout on mobile.
        ========================================= */
        @media (max-width: 650px) {
            .category-banner {
                min-height: 282px;
                padding: 30px 18px 34px;
                display: flex;
                align-items: center;
                justify-content: flex-start;
                text-align: left;
                isolation: isolate;
            }

            .category-banner::before {
                background: linear-gradient(180deg, rgba(15, 42, 29, .48) 0%, rgba(15, 42, 29, .3) 52%, rgba(15, 42, 29, .44) 100%);
            }

            .banner-agriculture-art {
                inset: 0;
                width: 100%;
                height: 100%;
                opacity: .38;
                -webkit-mask-image: linear-gradient(180deg, rgba(0,0,0,.52) 0%, #000 26%, #000 78%, rgba(0,0,0,.72) 100%);
                mask-image: linear-gradient(180deg, rgba(0,0,0,.52) 0%, #000 26%, #000 78%, rgba(0,0,0,.72) 100%);
            }

            .banner-agriculture-art::after {
                opacity: .55;
            }

            .banner-agriculture-art svg {
                width: 100%;
                height: 100%;
            }

            .category-banner-content {
                width: 100%;
                max-width: 440px;
                margin: 0;
                text-align: left;
                display: flex;
                flex-direction: column;
                align-items: flex-start;
            }

            .category-banner-eyebrow {
                margin-bottom: 10px;
                padding: 6px 10px;
                font-size: .61rem;
                letter-spacing: .9px;
                max-width: 100%;
            }

            .category-banner-content h1 {
                max-width: 100%;
                margin: 0;
                font-size: clamp(1.9rem, 8.5vw, 3.1rem);
                line-height: 1.08;
                letter-spacing: -.9px;
                overflow-wrap: anywhere;
                text-wrap: balance;
            }

            .category-banner-content p {
                max-width: 340px;
                margin: 12px 0 0;
                font-size: clamp(.72rem, 2.8vw, .82rem);
                line-height: 1.55;
                text-wrap: balance;
            }
        }

        /* Artwork-only mobile correction. Keep the artwork full-height and anchored
           to the right-hand focal area instead of shrinking the 760:300 scene into a
           narrow strip. Banner text/layout rules are intentionally not changed. */
        @media (max-width: 650px) {
            .banner-agriculture-art {
                inset: 0;
                width: 100%;
                height: 100%;
                aspect-ratio: auto;
                transform: none;
                overflow: hidden;
                opacity: .32;
                -webkit-mask-image: linear-gradient(90deg, rgba(0,0,0,.2) 0%, #000 28%, #000 100%);
                mask-image: linear-gradient(90deg, rgba(0,0,0,.2) 0%, #000 28%, #000 100%);
            }

            .banner-agriculture-art svg {
                display: block;
                width: 100%;
                height: 100%;
                overflow: hidden;
            }

            .category-banner-art-scene {
                --banner-art-shift-x: 0px;
                --banner-art-shift-y: 0px;
                transition: none;
            }

            /* Stop transform-based drifting on touch layouts; keep the artwork
               anchored while the light-sweep overlay remains decorative. */
            .category-banner-art-scene * {
                animation: none !important;
            }

            .banner-milk-bottle,
            .banner-eggs {
                animation: none !important;
                transform: none !important;
            }
        }

        @media (max-width: 430px) {
            .banner-agriculture-art {
                opacity: .28;
            }
        }

        @media (max-width: 430px) {
            .category-banner {
                min-height: 268px;
                padding: 26px 15px 30px;
                border-radius: 18px;
            }

            .category-banner-content h1 {
                font-size: clamp(1.8rem, 8.2vw, 2.45rem);
                letter-spacing: -.7px;
            }

            .category-banner-content p {
                max-width: 300px;
                margin-top: 10px;
                font-size: .72rem;
            }

            .category-banner-eyebrow {
                font-size: .56rem;
                letter-spacing: .7px;
            }
        }

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
    <div class="ambient-bg">
        <div class="ambient-shape shape-a"></div>
        <div class="ambient-shape shape-b"></div>
    </div>

    <!-- =========================================
         TOP NAVIGATION
    ========================================= -->

    <nav class="navbar" id="navbar">
        <a href="{{ url('/shop') }}" class="brand">
            <i class="fa-solid fa-leaf"></i>
            <span>agrimarket</span>
        </a>

        <!-- SEARCH -->

        <div class="nav-search-wrap">
            <form class="nav-search" id="searchForm" autocomplete="off">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input id="searchInput" type="search" placeholder="Search products" aria-label="Search products">

                <button type="submit" title="Search">
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>

            <div class="search-suggestions" id="searchSuggestions"></div>
        </div>

        <!-- CATEGORY -->

        <div class="dropdown-wrap category-desktop">
            <button class="icon-btn" id="categoryButton" title="Category" type="button">
                <i class="fa-solid fa-grip"></i>
                <span>Category</span>
            </button>

            <div class="dropdown category-dropdown" id="categoryMenu">
                @if(isset($categories) && count($categories) > 0)
                    @foreach($categories as $category)
                        @php
                            $categoryName = is_object($category)
                                ? ($category->name ?? $category->category ?? '')
                                : $category;

                            $categoryIcon = is_object($category)
                                ? ($category->icon ?? 'fa-solid fa-layer-group')
                                : 'fa-solid fa-layer-group';
                        @endphp

                        <a href="{{ url('/category/' . $categoryName) }}">
                            <i class="{{ $categoryIcon }}"></i>
                            {{ $categoryName }}
                        </a>
                    @endforeach
                @else
                    <a href="{{ url('/category/Fruits') }}">
                        <i class="fa-solid fa-apple-whole"></i>
                        Fruits
                    </a>

                    <a href="{{ url('/category/Vegetables') }}">
                        <i class="fa-solid fa-carrot"></i>
                        Vegetables
                    </a>

                    <a href="{{ url('/category/Grains & Rice') }}">
                        <i class="fa-solid fa-wheat-awn"></i>
                        Grains & Rice
                    </a>

                    <a href="{{ url('/category/Seeds') }}">
                        <i class="fa-solid fa-seedling"></i>
                        Seeds
                    </a>

                    <a href="{{ url('/category/Organic Products') }}">
                        <i class="fa-solid fa-leaf"></i>
                        Organic Products
                    </a>

                    <a href="{{ url('/category/Herbs & Spices') }}">
                        <i class="fa-solid fa-mortar-pestle"></i>
                        Herbs & Spices
                    </a>

                    <a href="{{ url('/category/Meat & Poultry') }}">
                        <i class="fa-solid fa-drumstick-bite"></i>
                        Meat & Poultry
                    </a>

                    <a href="{{ url('/category/Fish & Seafood') }}">
                        <i class="fa-solid fa-fish"></i>
                        Fish & Seafood
                    </a>

                    <a href="{{ url('/category/Dairy & Eggs') }}">
                        <i class="fa-solid fa-egg"></i>
                        Dairy & Eggs
                    </a>

                    <a href="{{ url('/category/Processed Foods') }}">
                        <i class="fa-solid fa-jar"></i>
                        Processed Foods
                    </a>


                @endif

                <a href="{{ url('/category/New Arrivals') }}">
                    <i class="fa-solid fa-star"></i>
                    New Arrivals
                </a>

                <a href="{{ url('/category/Best Sellers') }}">
                    <i class="fa-solid fa-trophy"></i>
                    Best Sellers
                </a>

                <a href="{{ url('/category/Below 100') }}">
                    <i class="fa-solid fa-tags"></i>
                    Below 100
                </a>

                <a href="{{ url('/category/All Products') }}">
                    <i class="fa-solid fa-boxes-stacked"></i>
                    All Products
                </a>
            </div>
        </div>

        <!-- NAV ACTIONS -->

        <div class="nav-actions">
            <a href="{{ route('cart') }}" class="icon-btn cart-icon-btn" title="Shopping Cart" aria-label="Shopping Cart">
                <i class="fa-solid fa-cart-shopping" aria-hidden="true"></i>
            </a>

            <div class="dropdown-wrap">
                <button class="icon-btn" id="profileButton" title="Profile" type="button">
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

                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                        @csrf
                    </form>
                </div>
            </div>

            <button
                class="icon-btn mobile-menu-btn"
                id="mobileCategoryButton"
                title="Categories"
                type="button"
            >
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </nav>

    <!-- =========================================
         CATEGORY PAGE
    ========================================= -->

    <main class="category-page">
        @php
            $category = $categoryName ?? request()->route('category');
            $bannerCategoryKey = strtolower(trim((string) $category));
            $bannerThemeClasses = [
                'fruits' => 'banner-theme-fruits',
                'vegetables' => 'banner-theme-vegetables',
                'grains & rice' => 'banner-theme-grains',
                'seeds' => 'banner-theme-seeds',
                'organic products' => 'banner-theme-organic',
                'herbs & spices' => 'banner-theme-herbs',
                'meat & poultry' => 'banner-theme-meat',
                'fish & seafood' => 'banner-theme-fish',
                'dairy & eggs' => 'banner-theme-dairy',
                'processed foods' => 'banner-theme-processed',
            ];
            $bannerThemeClass = $bannerThemeClasses[$bannerCategoryKey] ?? 'banner-theme-general';
        @endphp
        <section class="category-banner reveal {{ $bannerThemeClass }}" data-category="{{ $bannerCategoryKey }}">
            <div class="banner-agriculture-art" aria-hidden="true">
                @switch ($bannerCategoryKey)
                    @case('fruits')
                        <svg class="category-banner-art-scene banner-scene-fruits" viewBox="0 0 760 300" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" role="presentation">
                            <circle cx="585" cy="88" r="115" fill="#f7b85d" opacity=".13"/>
                            <path d="M420 300Q455 180 580 135T760 145V300Z" fill="#9bca78" opacity=".24"/>
                            <path d="M505 300Q540 205 650 185T760 190V300Z" fill="#4b8a4d" opacity=".52"/>
                            <g class="banner-fruit-branch" fill="none" stroke="#b6d58b" stroke-width="7" stroke-linecap="round"><path d="M548 18Q600 80 666 104T760 130"/><path d="M632 88Q650 49 693 32"/><path d="M676 107Q704 78 741 77"/></g>
                            <g class="banner-fruit-leaf" stroke="#d7e8a2" stroke-width="1.5"><path d="M600 55Q558 24 548 57Q568 82 600 55Z" fill="#70ae60"/><path d="M633 86Q611 45 644 42Q666 62 633 86Z" fill="#91c875"/><path d="M685 103Q654 75 680 59Q710 75 685 103Z" fill="#70ae60"/><path d="M706 83Q720 44 747 57Q750 83 706 83Z" fill="#a5d17a"/><path d="M651 98Q620 105 629 130Q654 128 651 98Z" fill="#a5d17a"/></g>
                            <g class="banner-fruit-bob"><circle cx="585" cy="112" r="27" fill="#e85d45"/><circle cx="585" cy="112" r="27" fill="none" stroke="#ffb17b" stroke-width="2"/><path d="M585 86q-1-14 12-19" stroke="#7eb567" stroke-width="5" fill="none" stroke-linecap="round"/><path d="M595 69q18-10 24 4-14 9-24-4" fill="#9acb76"/><ellipse cx="577" cy="103" rx="6" ry="10" fill="#ffb7a0" opacity=".6"/></g>
                            <g class="banner-fruit-bob fruit-two"><circle cx="678" cy="151" r="22" fill="#f5b936"/><path d="M677 129q-3-10 5-16" stroke="#83b56a" stroke-width="4" fill="none"/><path d="M682 115q15-7 20 5-12 7-20-5" fill="#acd27b"/></g>
                            <g class="banner-fruit-bob fruit-three"><circle cx="725" cy="206" r="18" fill="#7bba58"/><path d="M724 188q-3-8 3-12" stroke="#83b56a" stroke-width="4" fill="none"/></g>
                            <g fill="#d96d43" opacity=".95"><circle cx="535" cy="178" r="12"/><circle cx="554" cy="192" r="8"/></g>
                            <path d="M478 300Q500 235 547 214" stroke="#b8d789" stroke-width="5" fill="none" opacity=".8"/>
                        </svg>
                        @break
                    @case('vegetables')
                        <svg class="category-banner-art-scene banner-scene-vegetables" viewBox="0 0 760 300" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" role="presentation">
                            <path d="M440 300Q450 220 535 184T760 171V300Z" fill="#7fbf70" opacity=".2"/>
                            <path d="M468 300Q500 230 610 221T760 211V300Z" fill="#3d8750" opacity=".6"/>
                            <g class="banner-veg-leaf" stroke="#c7e69c" stroke-width="2"><path d="M605 284Q514 249 535 179Q602 192 605 284Z" fill="#5eaa55"/><path d="M605 284Q590 190 659 156Q689 224 605 284Z" fill="#83c96a"/><path d="M605 284Q639 211 714 224Q693 279 605 284Z" fill="#4c9b4d"/><path d="M605 284Q560 208 584 145Q635 193 605 284Z" fill="#9bd77b"/></g>
                            <g transform="translate(510 185) rotate(-12)"><path d="M0 0Q-10 37 1 74Q12 85 23 72Q34 35 19 0Z" fill="#e77745"/><path d="M7 2Q-2-12-14-15M11 1Q14-14 28-18M9 2Q3-15 1-23" stroke="#8dcc6c" stroke-width="5" stroke-linecap="round" fill="none"/><path d="M8 12l7 51" stroke="#f7ad73" stroke-width="3" opacity=".7"/></g>
                            <g transform="translate(666 197) rotate(15)"><path d="M0 0Q-5 27 0 57L10 71 20 56Q25 28 17 0Z" fill="#db5b4a"/><path d="M8 2Q-3-12-14-10M10 2Q19-12 29-10" stroke="#87c96d" stroke-width="5" stroke-linecap="round" fill="none"/></g>
                            <g class="banner-veg-tomato"><circle cx="573" cy="250" r="22" fill="#e95643"/><path d="M573 231l-5-8 9 4 9-5-3 10 8 5-12 1-6 8-2-11-10-3Z" fill="#79b95e"/></g>
                            <path d="M455 300Q475 245 494 231M470 300Q500 260 521 257" stroke="#c1d98b" stroke-width="4" fill="none"/>
                        </svg>
                        @break
                    @case('grains & rice')
                        <svg class="category-banner-art-scene banner-scene-grains" viewBox="0 0 760 300" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" role="presentation">
                            <circle cx="620" cy="64" r="39" fill="#f6d27d" opacity=".8"/><circle cx="620" cy="64" r="63" fill="#f6d27d" opacity=".13"/>
                            <path d="M290 177Q430 86 560 153T760 142V300H290Z" fill="#c2b75d" opacity=".4"/><path d="M330 208Q470 124 595 183T760 173V300H330Z" fill="#9baf52" opacity=".62"/>
                            <path d="M300 235Q455 158 595 213T760 204M280 263Q447 190 610 244T760 231M260 292Q435 224 620 275T760 262" fill="none" stroke="#e6d68a" stroke-width="5" opacity=".9"/>
                            <g class="banner-grain-stalk" stroke="#d9c56d" stroke-width="3" fill="none" stroke-linecap="round"><path d="M592 300Q590 190 626 104"/><path d="M652 300Q648 203 678 137"/><path d="M706 300Q699 219 724 163"/></g>
                            <g class="banner-grain-head" fill="#f1d77d" stroke="#f5e5a4" stroke-width="1"><ellipse cx="614" cy="113" rx="6" ry="11" transform="rotate(-35 614 113)"/><ellipse cx="627" cy="100" rx="6" ry="11" transform="rotate(25 627 100)"/><ellipse cx="633" cy="122" rx="6" ry="11" transform="rotate(35 633 122)"/><ellipse cx="601" cy="132" rx="6" ry="11" transform="rotate(-35 601 132)"/><ellipse cx="666" cy="145" rx="6" ry="11" transform="rotate(-30 666 145)"/><ellipse cx="680" cy="132" rx="6" ry="11" transform="rotate(25 680 132)"/><ellipse cx="686" cy="154" rx="6" ry="11" transform="rotate(30 686 154)"/><ellipse cx="716" cy="171" rx="6" ry="11" transform="rotate(-30 716 171)"/><ellipse cx="728" cy="159" rx="6" ry="11" transform="rotate(25 728 159)"/></g>
                            <path d="M535 300Q535 245 552 211M552 258Q522 239 516 220M552 273Q577 246 589 237" stroke="#9ebd5e" stroke-width="4" fill="none" stroke-linecap="round"/>
                        </svg>
                        @break
                    @case('seeds')
                        <svg class="category-banner-art-scene banner-scene-seeds" viewBox="0 0 760 300" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" role="presentation">
                            <path d="M400 300Q485 227 580 238T760 205V300Z" fill="#9dba70" opacity=".35"/>
                            <path d="M425 300Q520 263 620 266T760 244V300Z" fill="#745a3d" opacity=".55"/>
                            <ellipse cx="638" cy="266" rx="88" ry="18" fill="#b88b57" opacity=".5"/>
                            <g class="banner-seedling" stroke="#b5db83" stroke-width="5" stroke-linecap="round" fill="none"><path d="M640 264Q635 213 642 168"/><path d="M640 220Q589 213 579 174Q622 174 640 220Z" fill="#64ae5b" stroke="#9bcf75" stroke-width="2"/><path d="M642 198Q665 150 706 155Q692 192 642 198Z" fill="#8ccf70" stroke="#b5db83" stroke-width="2"/><path d="M641 168Q628 139 643 119Q663 143 641 168Z" fill="#a8d783" stroke="#c9e5a0" stroke-width="2"/></g>
                            <g class="banner-seed-drift"><ellipse cx="528" cy="245" rx="15" ry="8" fill="#d9b16e" transform="rotate(24 528 245)"/><ellipse cx="558" cy="265" rx="11" ry="6" fill="#b98b53" transform="rotate(-28 558 265)"/><ellipse cx="596" cy="245" rx="12" ry="7" fill="#e3c488" transform="rotate(12 596 245)"/><ellipse cx="684" cy="267" rx="14" ry="7" fill="#c69a5c" transform="rotate(-16 684 267)"/></g>
                            <path d="M470 300Q475 267 498 254M482 286l-16-17M497 272l16-17" stroke="#91bf69" stroke-width="4" fill="none" stroke-linecap="round"/>
                            <circle cx="640" cy="119" r="45" fill="#c6e7a0" opacity=".09"/><path d="M444 300Q500 283 550 294" stroke="#d5b786" stroke-width="3" fill="none"/>
                        </svg>
                        @break
                    @case('organic products')
                        <svg class="category-banner-art-scene banner-scene-organic" viewBox="0 0 760 300" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" role="presentation">
                            <circle cx="635" cy="128" r="112" fill="#b8d9a1" opacity=".12"/>
                            <g class="banner-organic-leaf" stroke="#b8d89a" stroke-width="2"><path d="M605 298Q500 215 542 101Q641 152 605 298Z" fill="#4f9b5c"/><path d="M605 298Q578 172 677 83Q722 197 605 298Z" fill="#77b968"/><path d="M605 298Q656 190 747 205Q720 278 605 298Z" fill="#39894f"/><path d="M605 298Q535 189 567 138Q625 191 605 298Z" fill="#9acb7a"/><path d="M605 298Q611 188 641 128" fill="none" stroke-width="4"/></g>
                            <g class="banner-organic-leaf leaf-left" stroke="#b8d89a" stroke-width="2"><path d="M510 299Q420 235 451 163Q533 192 510 299Z" fill="#68ae65"/><path d="M510 299Q499 216 552 184Q574 245 510 299Z" fill="#a4d183"/></g>
                            <path d="M450 300Q515 267 570 285T760 260V300Z" fill="#3f8c53" opacity=".55"/>
                            <g fill="#f0d98c" opacity=".8"><circle cx="692" cy="72" r="3"/><circle cx="715" cy="103" r="2"/><circle cx="567" cy="70" r="3"/><circle cx="735" cy="151" r="2"/></g>
                        </svg>
                        @break
                    @case('herbs & spices')
                        <svg class="category-banner-art-scene banner-scene-herbs" viewBox="0 0 760 300" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" role="presentation">
                            <path d="M440 300Q490 218 600 225T760 193V300Z" fill="#76985d" opacity=".35"/>
                            <g class="banner-herb-sprig" stroke="#b6d68b" stroke-width="2"><path d="M612 300Q602 210 650 92" stroke-width="4" fill="none"/><path d="M628 250Q575 244 565 210Q610 210 628 250Z" fill="#5aab65"/><path d="M631 225Q677 214 688 177Q646 181 631 225Z" fill="#87c96e"/><path d="M636 193Q588 180 590 147Q627 155 636 193Z" fill="#70b76a"/><path d="M644 163Q683 151 684 119Q650 129 644 163Z" fill="#a1d47c"/><path d="M647 130Q620 110 634 83Q656 102 647 130Z" fill="#77bd6b"/></g>
                            <g class="banner-spice-pods"><circle cx="540" cy="245" r="14" fill="#cf6d45"/><circle cx="562" cy="265" r="10" fill="#e1a34c"/><circle cx="585" cy="242" r="8" fill="#b85d3d"/><path d="M532 233l7-8m15 29 7-7" stroke="#8fbd68" stroke-width="3" stroke-linecap="round"/></g>
                            <g fill="#d8b779" opacity=".8"><ellipse cx="704" cy="238" rx="7" ry="14" transform="rotate(35 704 238)"/><ellipse cx="727" cy="256" rx="6" ry="12" transform="rotate(-24 727 256)"/><ellipse cx="684" cy="267" rx="6" ry="12" transform="rotate(15 684 267)"/></g>
                            <path d="M480 300Q495 264 520 251M493 282l-13-16" stroke="#9ecb77" stroke-width="4" fill="none"/>
                        </svg>
                        @break
                    @case('meat & poultry')
                        <svg class="category-banner-art-scene banner-scene-meat" viewBox="0 0 760 300" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" role="presentation">
                            <circle cx="644" cy="72" r="37" fill="#e9c878" opacity=".65"/><path d="M410 192Q490 125 570 174T760 145V300H410Z" fill="#8eae72" opacity=".55"/><path d="M410 229Q515 177 610 220T760 197V300H410Z" fill="#567e4e" opacity=".75"/>
                            <path d="M470 300V194l45-42 45 42v106Z" fill="#c67b50"/><path d="M458 198l57-53 57 53Z" fill="#8c4f3b"/><path d="M492 300V218h47v82Z" fill="#e5c58b"/><path d="M527 220h22v27h-22Z" fill="#6c8a58"/>
                            <g transform="translate(590 205)"><g class="banner-chicken"><ellipse cx="0" cy="18" rx="38" ry="25" fill="#f0e3c5"/><circle cx="29" cy="-2" r="18" fill="#f6ebd3"/><path d="M23-20q-9-18 0-20 8 2 9 13 9-16 16-8 4 8-8 17" fill="#cf6650"/><path d="M44-3l18 7-18 6Z" fill="#e7a84e"/><circle cx="33" cy="-5" r="2.7" fill="#3a332b"/><path d="M-10 40l-2 14m21-14 2 14" stroke="#e4aa50" stroke-width="4" stroke-linecap="round"/><path d="M-27 12q-17-14-14 7 8 13 22 9" fill="#e4d2ad"/></g></g>
                            <g class="banner-livestock-hill"><path d="M680 250q-18-35 9-45l25 7 14 24-6 27h-42Z" fill="#a7c57e"/><circle cx="711" cy="202" r="15" fill="#a7c57e"/><path d="M700 191l-11-9 4 16m29-7 11-9-5 16" stroke="#d5e1b3" stroke-width="4" fill="none" stroke-linecap="round"/><circle cx="716" cy="200" r="2" fill="#273d2e"/></g>
                            <path d="M460 300Q510 265 550 286T760 270" stroke="#c9d89a" stroke-width="3" fill="none" opacity=".7"/>
                        </svg>
                        @break
                    @case('fish & seafood')
                        <svg class="category-banner-art-scene banner-scene-fish" viewBox="0 0 760 300" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" role="presentation">
                            <path d="M360 170Q480 120 590 170T760 153V300H360Z" fill="#5ca8a3" opacity=".32"/><path d="M330 215Q470 164 600 213T760 194V300H330Z" fill="#2c7f82" opacity=".6"/><path d="M330 255Q475 205 610 251T760 232" stroke="#9bd7ca" stroke-width="4" fill="none" opacity=".7"/><path d="M360 282Q490 235 610 279T760 263" stroke="#9bd7ca" stroke-width="3" fill="none" opacity=".5"/>
                            <g class="banner-fish-swim"><path d="M518 157Q565 111 624 153Q565 198 518 157Z" fill="#e5c875" stroke="#f3e4a4" stroke-width="2"/><path d="M520 157l-28-22 1 43Z" fill="#e5c875" stroke="#f3e4a4" stroke-width="2"/><path d="M557 130q10 26 0 51" stroke="#b5a75c" stroke-width="2" fill="none"/><circle cx="600" cy="150" r="3.5" fill="#254d4e"/></g>
                            <g class="banner-fish-swim fish-two"><path d="M652 220Q681 190 721 218Q681 247 652 220Z" fill="#7cc6b6" stroke="#c0e8d7" stroke-width="2"/><path d="M654 220l-20-16 0 32Z" fill="#7cc6b6"/><circle cx="708" cy="216" r="2.5" fill="#204e50"/></g>
                            <g class="banner-water-bubble" fill="none" stroke="#b5e4d9" stroke-width="2"><circle cx="490" cy="110" r="7"/><circle cx="469" cy="91" r="4"/><circle cx="633" cy="122" r="5"/><circle cx="696" cy="169" r="7"/></g>
                            <g fill="#80bd8d"><path d="M440 300q-8-60 12-91 3 47 0 91Z"/><path d="M451 300q12-53 35-68-10 44-35 68Z"/><path d="M468 300q-1-38 17-53 0 31-17 53Z"/></g>
                            <path d="M400 300q14-58 2-92m0 42q-20-19-20-35m22 54q23-20 25-39" stroke="#b6d69a" stroke-width="4" fill="none" stroke-linecap="round"/>
                        </svg>
                        @break
                    @case('dairy & eggs')
                        <svg class="category-banner-art-scene banner-scene-dairy" viewBox="0 0 760 300" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" role="presentation">
                            <circle cx="655" cy="67" r="36" fill="#f3d58a" opacity=".75"/><path d="M385 194Q465 133 560 176T760 146V300H385Z" fill="#9fbe83" opacity=".6"/><path d="M360 238Q470 179 590 221T760 197V300H360Z" fill="#5d965d" opacity=".8"/><path d="M385 270Q500 226 610 257T760 238" stroke="#c6dca0" stroke-width="4" fill="none"/>
                            <path d="M565 300V167l45-36 45 36v133Z" fill="#f1e5c7"/><path d="M551 169l59-49 59 49Z" fill="#b76549"/><path d="M585 300V207h42v93Z" fill="#d5a878"/><path d="M619 184h24v31h-24Z" fill="#82a86a"/>
                            <g transform="translate(510 188)"><g class="banner-milk-bottle"><path d="M10 0h24v15l8 12v66q0 9-9 9H11q-9 0-9-9V27l8-12Z" fill="#f8f7eb" stroke="#d5e2d2" stroke-width="2"/><path d="M10 0h24v13H10Z" fill="#c4d9cb"/><rect x="4" y="43" width="34" height="28" rx="4" fill="#79ad8b"/><path d="M11 57q8-14 16 0-8 11-16 0Z" fill="#e8f0d8"/></g></g>
                            <g class="banner-eggs" transform="translate(-24 0)"><ellipse cx="685" cy="267" rx="16" ry="22" fill="#f7edd8"/><ellipse cx="715" cy="269" rx="16" ry="22" fill="#e8d7b8"/><ellipse cx="744" cy="267" rx="14" ry="20" fill="#f7edd8"/></g>
                            <path d="M420 300Q435 260 466 251" stroke="#c5dfa0" stroke-width="4" fill="none"/>
                        </svg>
                        @break
                    @case('processed foods')
                        <svg class="category-banner-art-scene banner-scene-processed" viewBox="0 0 760 300" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" role="presentation">
                            <circle cx="645" cy="90" r="94" fill="#e9bd73" opacity=".13"/><path d="M405 300Q470 230 580 246T760 218V300Z" fill="#9fbd7a" opacity=".35"/>
                            <g class="banner-package-float"><path d="M530 130h72l-7 132h-58Z" fill="#e8d2a0" stroke="#f6e6bd" stroke-width="2"/><path d="M530 145h72v28h-72Z" fill="#d36b48"/><circle cx="566" cy="203" r="23" fill="#88ae5d"/><path d="M552 204q14-25 28 0-14 22-28 0Z" fill="#eacb73"/><path d="M540 118h52v12h-52Z" fill="#f3e4c2"/></g>
                            <g class="banner-package-float package-two"><path d="M626 163l61-10 19 111-61 10Z" fill="#e9e5c9" stroke="#f4edda" stroke-width="2"/><path d="M630 177l60-9 5 25-60 9Z" fill="#6b9d61"/><path d="M649 221q12-26 29-3-9 23-29 3Z" fill="#d36b48"/></g>
                            <g class="banner-jar"><path d="M700 185h39v14l6 10v65q0 8-8 8h-35q-8 0-8-8v-65l6-10Z" fill="#f1dfad" stroke="#e8c983" stroke-width="2"/><rect x="699" y="176" width="41" height="12" rx="3" fill="#c77a4d"/><rect x="697" y="224" width="45" height="24" rx="3" fill="#e6a74f"/><path d="M707 236q12-17 24 0-12 13-24 0Z" fill="#6f9f55"/></g>
                            <g fill="#d7b86d"><ellipse cx="490" cy="272" rx="9" ry="17" transform="rotate(-25 490 272)"/><ellipse cx="508" cy="280" rx="8" ry="14" transform="rotate(25 508 280)"/><ellipse cx="475" cy="288" rx="7" ry="13"/></g>
                            <path d="M450 300Q470 270 489 262" stroke="#8cba70" stroke-width="4" fill="none"/>
                        </svg>
                        @break
                    @default
                        <svg class="category-banner-art-scene banner-scene-general" viewBox="0 0 760 300" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" role="presentation">
                            <circle cx="620" cy="68" r="48" fill="#f5d68a" opacity=".75"/><path d="M320 203Q430 112 535 174T760 145V300H320Z" fill="#80ae69" opacity=".5"/><path d="M300 250Q450 170 590 224T760 194V300H300Z" fill="#3d7c4c" opacity=".75"/><path d="M290 280Q440 205 610 257T760 230" fill="none" stroke="#d6d28b" stroke-width="5"/>
                            <g class="banner-general-leaf" stroke="#b6d68b" stroke-width="2"><path d="M628 299Q560 211 598 135Q671 193 628 299Z" fill="#5caa60"/><path d="M628 299Q639 196 716 153Q735 233 628 299Z" fill="#8bc86d"/><path d="M628 299Q680 237 750 248Q713 286 628 299Z" fill="#4b984f"/></g>
                            <path d="M480 300Q495 245 520 226M500 270l-17-18m37-2 18-20" stroke="#c6dc91" stroke-width="4" fill="none" stroke-linecap="round"/>
                        </svg>
                @endswitch
            </div>

            <div class="category-banner-content">
                <span class="category-banner-eyebrow">
                    <i class="fa-solid fa-layer-group"></i>
                    Category Collection
                </span>

                <h1 id="categoryName">
                    @php
                        $categoryIcons = [
                            'fruits' => 'fa-apple-whole',
                            'vegetables' => 'fa-carrot',
                            'grains & rice' => 'fa-wheat-awn',
                            'seeds' => 'fa-seedling',
                            'organic products' => 'fa-leaf',
                            'herbs & spices' => 'fa-mortar-pestle',
                            'meat & poultry' => 'fa-drumstick-bite',
                            'fish & seafood' => 'fa-fish',
                            'dairy & eggs' => 'fa-egg',
                            'processed foods' => 'fa-jar',
                            'new & fresh' => 'fa-star',
                            'best sellers' => 'fa-trophy',
                            'below 100' => 'fa-tags',
                            'all groceries' => 'fa-boxes-stacked',
                        ];

                        $categoryIcon = $categoryIcons[strtolower(trim($category))] ?? 'fa-boxes-stacked';
                    @endphp

                    <i class="fa-solid {{ $categoryIcon }}"></i>
                    {{ $category }}
                </h1>

                <p>
                    Explore products available in this
                    category from AgriMarket sellers.
                </p>
            </div>
        </section>

        <!-- SORT -->

        <section class="sort-section reveal">
            <span class="sort-label">Sort by:</span>

            <div class="sort-control">
                <select class="sort-select" id="sortSelect">
                    <option value="default">Default</option>
                    <option value="price-low">Price: Low to High</option>
                    <option value="price-high">Price: High to Low</option>
                </select>

                <i class="fa-solid fa-chevron-down"></i>
            </div>
        </section>

        <!-- ITEMS -->

        <section class="items-section reveal">
            <div class="items-heading">
                <span class="eyebrow">Item</span>
                <h2>Items</h2>
                <p>Products available in this category.</p>
            </div>

            <!-- PRODUCT GRID -->

            <div class="product-grid stagger" id="productGrid">
                @forelse($products as $index => $product)
                    <article
                        class="product-card"
                        data-product-id="{{ $product->product_id }}"
                        data-name="{{ strtolower($product->product_name) }}"
                        data-price="{{ is_numeric($product->price) ? (float) $product->price : '' }}"
                    >
                        @if($index === 0)
                            <span class="product-badge">FEATURED</span>
                        @endif

                        <div class="product-image">
                            @if (!empty($product->image))
                                <img
                                    src="{{ asset('image/product/' . $product->image) }}"
                                    alt="{{ $product->product_name }}"
                                    class="product-photo"
                                    loading="lazy"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='grid';"
                                >

                                <div class="placeholder" style="display: none;">
                                    <div class="placeholder-content">
                                        <i class="fa-regular fa-image"></i>
                                        <strong>PRODUCT IMAGE</strong>
                                        <small>{{ $product->product_name }}</small>
                                    </div>
                                </div>
                            @else
                                <div class="placeholder">
                                    <div class="placeholder-content">
                                        <i class="fa-regular fa-image"></i>
                                        <strong>PRODUCT IMAGE</strong>
                                        <small>{{ $product->product_name }}</small>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="product-info">
                            <div class="product-name">
                                {{ $product->product_name }}
                            </div>

                            <div class="product-price">
                                ₱{{ number_format($product->price, 2) }}
                            </div>

                            <div class="product-meta">
                                <span class="stock">
                                    {{ $product->quantity }} Available
                                </span>

                                <span class="uom">
                                    {{ $product->oum }}
                                </span>
                            </div>

                            <div class="card-actions">
                                <button
                                    class="card-btn cart-btn"
                                    type="button"
                                    data-product-id="{{ $product->product_id }}"
                                    data-product-name="{{ $product->product_name }}"
                                >
                                    <i class="fa-solid fa-cart-plus"></i>
                                    Add to Cart
                                </button>

                                <button
                                    class="card-btn buy-btn"
                                    type="button"
                                    onclick="buyNow({{ $product->product_id }})"
                                >
                                    Buy Now
                                </button>
                            </div>
                        </div>
                    </article>
                @empty
                    <div style="grid-column:1 / -1; padding:50px; text-align:center; color:var(--text-muted);">
                        No products available in this category.
                    </div>
                @endforelse
            </div>
        </section>

        <!-- PAGINATION -->

        <section class="pagination-wrapper reveal" id="paginationWrapper">
            <nav class="pagination" id="pagination" aria-label="Product pagination"></nav>
        </section>
    </main>

    <!-- =========================================
         FOOTER
    ========================================= -->

    <footer>
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="{{ url('/shop') }}" class="brand" style="color:#fff">
                    <i class="fa-solid fa-leaf"></i>
                    <span>agrimarket</span>
                </a>

                <p>
                    A modern agricultural marketplace
                    connecting buyers and sellers of farm
                    products, supplies and services.
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
                    <li><a href="{{ url('/category/All Products') }}">Categories</a></li>
                    <li><a href="{{ url('/category/New Arrivals') }}">New & Fresh</a></li>
                    <li><a href="{{ url('/category/Best Sellers') }}">Best Sellers</a></li>
                </ul>
            </div>
        </div>

        <div class="copyright">
            © 2026 AgriMarket. All rights reserved.
        </div>
    </footer>

    <!-- TOAST -->

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
        /* =========================================================
           LARAVEL SEARCHABLE PRODUCTS
        ========================================================= */

        const searchableProducts = [
            @foreach($allProducts->unique('product_name')->values() as $product)
                {
                    name: @json($product->product_name)
                }@if(!$loop->last),@endif
            @endforeach
        ];

        /* =========================================================
           CART AND BUY NOW - DATABASE INTEGRATION
        ========================================================= */

        const cartModal = document.getElementById("cartModal");
        const cartModalProduct = document.getElementById("cartModalProduct");
        const cancelCartButton = document.getElementById("cancelCartButton");
        const confirmCartButton = document.getElementById("confirmCartButton");

        let selectedCartProductId = null;
        let selectedCartProductName = "";

        function addToCart(productId, productName) {
            if (!Number.isInteger(productId) || productId <= 0) {
                showToast("This product cannot be added to your cart.");
                return;
            }

            selectedCartProductId = productId;
            selectedCartProductName = productName;
            cartModalProduct.textContent = productName;
            cartModal.classList.add("open");
            cartModal.setAttribute("aria-hidden", "false");
            document.body.style.overflow = "hidden";
        }

        function closeCartModal() {
            cartModal.classList.remove("open");
            cartModal.setAttribute("aria-hidden", "true");
            document.body.style.overflow = "";
            selectedCartProductId = null;
            selectedCartProductName = "";
            confirmCartButton.disabled = false;
            confirmCartButton.innerHTML = `
                <i class="fa-solid fa-cart-plus"></i>
                Yes, Add to Cart
            `;
        }

        document.addEventListener("click", function(event) {
            const button = event.target.closest(".cart-btn");
            if (!button) return;

            const productId = Number(button.dataset.productId);
            const productName = button.dataset.productName || "Product";

            if (!Number.isInteger(productId) || productId <= 0) {
                showToast("This product cannot be added to your cart.");
                return;
            }

            addToCart(productId, productName);
        });

        cancelCartButton.addEventListener("click", closeCartModal);

        cartModal.addEventListener("click", event => {
            if (event.target === cartModal) closeCartModal();
        });

        document.addEventListener("keydown", event => {
            if (event.key === "Escape" && cartModal.classList.contains("open")) {
                closeCartModal();
            }
        });

        confirmCartButton.addEventListener("click", async () => {
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
                const response = await fetch("{{ route('cart.add') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: JSON.stringify({ product_id: productId })
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

        function buyNow(productId) {
            if (!Number.isInteger(productId) || productId <= 0) {
                showToast("This product cannot be purchased. Please select an available product.");
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

        /* =========================================================
           TOAST
        ========================================================= */

        function showToast(message) {
            const container = document.getElementById("toastContainer");
            const toast = document.createElement("div");

            toast.className = "toast";

            toast.innerHTML = `
                <i class="fa-solid fa-circle-check"></i>
                <span>${message}</span>
            `;

            container.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = "0";
                toast.style.transform = "translateY(10px)";
                toast.style.transition = ".3s ease";

                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 2600);
        }

        /* =========================================================
           REPEATING SCROLL REVEAL
        ========================================================= */

        const observer = new IntersectionObserver(
            entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add("visible");

                        // Reveal once. Do not hide content again when it leaves
                        // the viewport, especially when a product grid is taller
                        // than the viewport and cannot meet a large ratio threshold.
                        observer.unobserve(entry.target);
                    }
                });
            },
            {
                threshold: 0,
                rootMargin: "0px 0px 0px 0px"
            }
        );

        function setupReveal() {
            document
                .querySelectorAll(".reveal, .stagger")
                .forEach(element => {
                    // Product content must not depend on a later scroll to become
                    // readable. Keep the existing reveal animation, but make the
                    // product section and grid visible immediately on page load.
                    if (
                        element.classList.contains("items-section") ||
                        element.classList.contains("product-grid")
                    ) {
                        element.classList.add("visible");
                        return;
                    }

                    observer.observe(element);
                });
        }

        /* =========================================================
           CATEGORY BANNER ART INTERACTION
           Lightweight pointer parallax; disabled for touch/reduced motion.
        ========================================================= */

        const categoryBanner = document.querySelector(".category-banner");
        const categoryBannerScene = document.querySelector(".category-banner-art-scene");
        const reducedMotionPreference = window.matchMedia("(prefers-reduced-motion: reduce)");
        const finePointerPreference = window.matchMedia("(hover: hover) and (pointer: fine)");
        const mobileBannerLayout = window.matchMedia("(max-width: 650px)");

        function updateBannerSceneAspectRatio() {
            if (!categoryBannerScene) return;
            categoryBannerScene.setAttribute(
                "preserveAspectRatio",
                mobileBannerLayout.matches ? "xMaxYMid slice" : "xMidYMid slice"
            );
        }

        updateBannerSceneAspectRatio();
        if (typeof mobileBannerLayout.addEventListener === "function") {
            mobileBannerLayout.addEventListener("change", updateBannerSceneAspectRatio);
        } else if (typeof mobileBannerLayout.addListener === "function") {
            mobileBannerLayout.addListener(updateBannerSceneAspectRatio);
        }

        if (
            categoryBanner &&
            categoryBannerScene &&
            finePointerPreference.matches &&
            !reducedMotionPreference.matches
        ) {
            categoryBanner.addEventListener("pointermove", event => {
                const bounds = categoryBanner.getBoundingClientRect();
                const offsetX = (event.clientX - bounds.left) / bounds.width - .5;
                const offsetY = (event.clientY - bounds.top) / bounds.height - .5;

                categoryBannerScene.style.setProperty("--banner-art-shift-x", `${offsetX * -5}px`);
                categoryBannerScene.style.setProperty("--banner-art-shift-y", `${offsetY * -3}px`);
            });

            categoryBanner.addEventListener("pointerleave", () => {
                categoryBannerScene.style.setProperty("--banner-art-shift-x", "0px");
                categoryBannerScene.style.setProperty("--banner-art-shift-y", "0px");
            });
        }

        /* =========================================================
           NAVBAR SCROLL
        ========================================================= */

        window.addEventListener(
            "scroll",
            () => {
                document
                    .getElementById("navbar")
                    .classList
                    .toggle("scrolled", window.scrollY > 25);
            },
            {
                passive: true
            }
        );

        /* =========================================================
           DROPDOWNS
        ========================================================= */

        const profileButton = document.getElementById("profileButton");
        const profileMenu = document.getElementById("profileMenu");
        const categoryButton = document.getElementById("categoryButton");
        const categoryMenu = document.getElementById("categoryMenu");
        const mobileCategoryButton = document.getElementById("mobileCategoryButton");

        profileButton.addEventListener("click", event => {
            event.stopPropagation();

            profileMenu.classList.toggle("open");
            categoryMenu?.classList.remove("open");
        });

        categoryButton?.addEventListener("click", event => {
            event.stopPropagation();

            categoryMenu.classList.toggle("open");
            profileMenu.classList.remove("open");
        });

        mobileCategoryButton?.addEventListener("click", event => {
            event.stopPropagation();

            categoryMenu.classList.toggle("open");
            profileMenu.classList.remove("open");
        });

        document.addEventListener("click", () => {
            profileMenu.classList.remove("open");
            categoryMenu?.classList.remove("open");
            closeSearchSuggestions();
        });

        /* =========================================================
           SEARCH SUGGESTIONS
        ========================================================= */

        const searchForm = document.getElementById("searchForm");
        const searchInput = document.getElementById("searchInput");
        const searchSuggestions = document.getElementById("searchSuggestions");

        function escapeHTML(value) {
            return String(value).replace(
                /[&<>"']/g,
                character => {
                    const entities = {
                        "&": "&amp;",
                        "<": "&lt;",
                        ">": "&gt;",
                        '"': "&quot;",
                        "'": "&#039;"
                    };

                    return entities[character];
                }
            );
        }

        function showSearchSuggestions(query) {
            const normalizedQuery = query.trim().toLowerCase();

            if (!normalizedQuery) {
                searchSuggestions.innerHTML = "";
                searchSuggestions.classList.remove("open");
                return;
            }

            const matches = searchableProducts
                .filter(product =>
                    String(product.name).toLowerCase().includes(normalizedQuery)
                )
                .slice(0, 8);

            if (!matches.length) {
                searchSuggestions.innerHTML = `
                    <div class="search-empty">
                        No products found for "${escapeHTML(query.trim())}".
                    </div>
                `;

                searchSuggestions.classList.add("open");
                return;
            }

            searchSuggestions.innerHTML = matches.map(product => {
                const name = String(product.name);
                const productUrl =
                    "{{ url('/search') }}/" +
                    encodeURIComponent(name);

                return `
                    <a
                        href="${productUrl}"
                        class="search-suggestion"
                        data-product-name="${escapeHTML(name)}"
                    >
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span class="search-suggestion-name">${escapeHTML(name)}</span>
                    </a>
                `;
            }).join("");

            searchSuggestions.classList.add("open");
        }

        function closeSearchSuggestions() {
            searchSuggestions.classList.remove("open");
        }

        searchInput.addEventListener("input", event => {
            event.stopPropagation();
            showSearchSuggestions(searchInput.value);
        });

        searchInput.addEventListener("focus", event => {
            event.stopPropagation();

            if (searchInput.value.trim()) {
                showSearchSuggestions(searchInput.value);
            }
        });

        searchSuggestions.addEventListener("click", event => {
            const suggestion = event.target.closest(".search-suggestion");

            if (suggestion) {
                closeSearchSuggestions();
            }

            event.stopPropagation();
        });

        searchForm.addEventListener("submit", event => {
            event.preventDefault();
            event.stopPropagation();

            const query = searchInput.value.trim();

            if (!query) {
                showToast("Enter a product or category to search.");
                return;
            }

            window.location.href =
                "{{ url('/search') }}/" + encodeURIComponent(query);
        });

        document.addEventListener("click", event => {
            if (!event.target.closest(".nav-search-wrap")) {
                closeSearchSuggestions();
            }
        });

        /* =========================================================
           SORT
        ========================================================= */

        const sortSelect = document.getElementById("sortSelect");

        // Original Laravel-rendered order, captured once before any sorting.
        const originalProductOrder = Array.from(
            document.querySelectorAll("#productGrid .product-card")
        );

        function getCardPrice(card) {
            const rawPrice = (card.dataset.price || "").trim();

            if (rawPrice === "") {
                return null;
            }

            const price = Number(rawPrice);

            return Number.isFinite(price) ? price : null;
        }

        function applyProductSort() {
            const grid = document.getElementById("productGrid");

            if (!grid || !sortSelect || !originalProductOrder.length) {
                return;
            }

            const sortValue = sortSelect.value;
            let orderedCards = originalProductOrder.slice();

            if (sortValue === "price-low" || sortValue === "price-high") {
                const direction = sortValue === "price-low" ? 1 : -1;

                orderedCards.sort((cardA, cardB) => {
                    const priceA = getCardPrice(cardA);
                    const priceB = getCardPrice(cardB);

                    // Missing or invalid prices always go to the end.
                    if (priceA === null && priceB === null) {
                        return originalProductOrder.indexOf(cardA) - originalProductOrder.indexOf(cardB);
                    }

                    if (priceA === null) {
                        return 1;
                    }

                    if (priceB === null) {
                        return -1;
                    }

                    if (priceA !== priceB) {
                        return (priceA - priceB) * direction;
                    }

                    // Equal prices keep their original relative order.
                    return originalProductOrder.indexOf(cardA) - originalProductOrder.indexOf(cardB);
                });
            }

            const fragment = document.createDocumentFragment();

            orderedCards.forEach(card => {
                fragment.appendChild(card);
            });

            grid.appendChild(fragment);
        }

        sortSelect.addEventListener("change", function () {
            const selected = this.options[this.selectedIndex].text;

            applyProductSort();

            // Sorting always returns to the first page.
            currentPage = 1;
            renderPagination();

            showToast(`Sort changed to ${selected}.`);
        });

        /* =========================================================
           PAGINATION
        ========================================================= */

        let currentPage = 1;

        function getProductsPerPage() {
            return window.matchMedia("(max-width: 650px)").matches ? 18 : 36;
        }

        function renderPagination() {
            const grid = document.getElementById("productGrid");
            const paginationWrapper = document.getElementById("paginationWrapper");
            const pagination = document.getElementById("pagination");

            if (!grid || !paginationWrapper || !pagination) {
                return;
            }

            const productCards = Array.from(grid.querySelectorAll(".product-card"));
            const productsPerPage = getProductsPerPage();
            const totalProducts = productCards.length;
            const totalPages = Math.ceil(totalProducts / productsPerPage);

            if (totalPages <= 1) {
                currentPage = 1;
                pagination.innerHTML = "";
                paginationWrapper.style.display = "none";

                productCards.forEach(card => {
                    card.style.display = "";
                });

                return;
            }

            currentPage = Math.min(currentPage, totalPages);
            paginationWrapper.style.display = "flex";

            const start = (currentPage - 1) * productsPerPage;
            const end = start + productsPerPage;

            productCards.forEach((card, index) => {
                card.style.display = index >= start && index < end ? "" : "none";
            });

            pagination.innerHTML = "";

            const addPageLink = (page, active = false) => {
                const link = document.createElement("a");

                link.href = "#";
                link.className = `page-link${active ? " active" : ""}`;
                link.textContent = page;

                if (active) {
                    link.setAttribute("aria-current", "page");
                }

                link.addEventListener("click", event => {
                    event.preventDefault();
                    currentPage = page;
                    renderPagination();
                });

                pagination.appendChild(link);
            };

            const addDots = () => {
                const dots = document.createElement("span");
                dots.className = "page-dots";
                dots.textContent = ".......";
                pagination.appendChild(dots);
            };

            if (totalPages <= 6) {
                for (let page = 1; page <= totalPages; page++) {
                    addPageLink(page, page === currentPage);
                }
            } else {
                addPageLink(1, currentPage === 1);
                addPageLink(2, currentPage === 2);
                addPageLink(3, currentPage === 3);
                addPageLink(4, currentPage === 4);

                if (currentPage > 4 && currentPage < totalPages) {
                    addDots();
                    addPageLink(currentPage, true);
                } else {
                    addDots();
                }

                addPageLink(totalPages, currentPage === totalPages);
            }

            if (currentPage < totalPages) {
                const nextLink = document.createElement("a");

                nextLink.href = "#";
                nextLink.className = "page-link";
                nextLink.setAttribute("aria-label", "Next page");
                nextLink.innerHTML = '<i class="fa-solid fa-chevron-right"></i>';

                nextLink.addEventListener("click", event => {
                    event.preventDefault();
                    currentPage++;
                    renderPagination();
                });

                pagination.appendChild(nextLink);
            }
        }

        window.addEventListener("resize", () => {
            renderPagination();
        });

        /* =========================================================
           CLICK POP
        ========================================================= */

        document.addEventListener("click", event => {
            const pop = document.createElement("span");

            pop.className = "click-pop";
            pop.style.left = `${event.clientX}px`;
            pop.style.top = `${event.clientY}px`;

            document.body.appendChild(pop);

            setTimeout(() => {
                pop.remove();
            }, 700);
        });

        /* =========================================================
           INITIAL SETUP
        ========================================================= */

        setupReveal();
        applyProductSort();
        renderPagination();
    </script>
</body>
</html>