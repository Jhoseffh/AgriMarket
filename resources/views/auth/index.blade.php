<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>agrimarket - Modern Agricultural Platform</title>

    <!-- Google Fonts & FontAwesome Icons -->
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
        --bg-card: #ffffff;
        --text-main: #1a1a1a;
        --text-muted: #667085;
        --border-color: #e4e7ec;
        --shadow-sm: 0 4px 20px rgba(0,0,0,0.03);
        --shadow-lg: 0 20px 40px rgba(0,0,0,0.08);
        --transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);

        --ease-expo: cubic-bezier(.16, 1, .3, 1);
        --ease-spring: cubic-bezier(.22, 1.2, .36, 1);
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    html {
        scroll-behavior: smooth;
    }

    body {
        background-color: var(--bg-cream);
        color: var(--text-main);
        line-height: 1.6;
        overflow-x: hidden;
        position: relative;
        isolation: isolate;
    }

    /* =========================================================
       PAGE CONTAINER
       ========================================================= */

    .page-section {
        min-height: auto;
        padding: 3.5rem 5%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        max-width: 1400px;
        margin: 0 auto;
        position: relative;
    }

    /* =========================================================
       BASIC ANIMATIONS
       ========================================================= */

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes float {
        0%, 100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-10px);
        }
    }

    @keyframes modalPop {
        from {
            opacity: 0;
            transform: scale(0.92);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .animated {
        animation: fadeIn 0.8s ease-out forwards;
    }

    /* =========================================================
       NAVIGATION
       ========================================================= */

    .navbar {
        display: flex;
        align-items: center;
        justify-content: space-between;

        padding: 1.25rem 5%;

        background: rgba(249, 248, 243, 0.92);
        backdrop-filter: blur(12px);

        position: fixed;
        top: 0;
        left: 0;
        right: 0;

        z-index: 1000;

        border-bottom: 1px solid rgba(0,0,0,0.05);

        transition:
            padding .45s var(--ease-expo),
            background .45s ease,
            box-shadow .45s ease;
    }

    .navbar.scrolled {
        padding-top: .78rem;
        padding-bottom: .78rem;
        background: rgba(249,248,243,.76);
        box-shadow: 0 12px 35px rgba(30,58,43,.07);
    }

    .brand-logo {
        display: flex;
        align-items: center;
        gap: 8px;

        font-size: 1.5rem;
        font-weight: 800;

        color: var(--primary-dark);
        text-decoration: none;
    }

    .brand-logo i {
        color: var(--primary-green);
    }

    .nav-links {
        display: flex;
        gap: 2rem;
        list-style: none;
    }

    .nav-links a {
        text-decoration: none;
        color: var(--text-main);
        font-weight: 600;
        font-size: 0.95rem;
        transition: var(--transition);
    }

    .nav-links a:hover {
        color: var(--accent-terracotta);
    }

    .btn-auth {
        background: var(--primary-dark);
        color: #fff;

        padding: 0.65rem 1.5rem;

        border-radius: 8px;
        font-weight: 700;

        border: none;
        cursor: pointer;

        transition: var(--transition);
    }

    .btn-auth:hover {
        background: var(--primary-green);
        transform: translateY(-2px);
    }

    /* =========================================================
       IMAGE PLACEHOLDER
       ========================================================= */

    .img-placeholder {
        width: 100%;
        height: 100%;
        min-height: 220px;

        background: #e9ecef;
        border-radius: 16px;

        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;

        color: #6c757d;
        font-weight: 600;
        text-align: center;

        padding: 1rem;

        transition: var(--transition);

        position: relative;
        overflow: hidden;
    }

    .img-placeholder::before {
        content: "";

        position: absolute;
        inset: -80%;

        background: linear-gradient(
            110deg,
            transparent 35%,
            rgba(255,255,255,.42) 48%,
            rgba(255,255,255,.08) 53%,
            transparent 65%
        );

        transform: translateX(-55%) rotate(12deg);

        transition: transform 1.1s var(--ease-expo);
    }

    .img-placeholder::after {
        content: "";

        position: absolute;
        inset: 0;

        background:
            radial-gradient(
                circle at 50% 50%,
                rgba(45,90,63,.06),
                transparent 45%
            );

        opacity: .6;

        animation: imageBreath 4s ease-in-out infinite;
    }

    .img-placeholder:hover {
        transform: scale(1.015);

        border-color: rgba(45,90,63,.38);

        box-shadow:
            inset 0 0 0 1px rgba(45,90,63,.08),
            0 20px 50px rgba(30,58,43,.10);
    }

    .img-placeholder:hover::before {
        transform: translateX(55%) rotate(12deg);
    }

    .img-placeholder i,
    .img-placeholder span,
    .img-placeholder small {
        position: relative;
        z-index: 2;
    }

    .img-placeholder i {
        font-size: 2rem;
        margin-bottom: .5rem;
        color: #adb5bd;

        animation: placeholderIcon 3s ease-in-out infinite;
    }

    @keyframes imageBreath {
        0%, 100% {
            transform: scale(.94);
            opacity: .3;
        }

        50% {
            transform: scale(1.05);
            opacity: .7;
        }
    }

    @keyframes placeholderIcon {
        0%, 100% {
            transform: translateY(0) rotate(0deg);
        }

        50% {
            transform: translateY(-7px) rotate(3deg);
        }
    }

    /* =========================================================
       PAGE 1
       ========================================================= */

    #page1 {
        padding-top: 6rem;

        display: grid;

        grid-template-columns: 1fr 1fr;

        gap: 4rem;

        align-items: center;
    }

    .hero-subtitle {
        text-transform: uppercase;

        font-size: 0.75rem;

        letter-spacing: 1.5px;

        font-weight: 800;

        color: var(--text-muted);

        margin-bottom: 1rem;
    }

    .hero-title {
        font-size: 3.2rem;

        line-height: 1.15;

        color: var(--primary-dark);

        font-weight: 800;

        margin-bottom: 1.5rem;
    }

    .hero-description {
        color: var(--text-muted);

        font-size: 1.05rem;

        margin-bottom: 2rem;
    }

    .search-bar {
        display: flex;

        background: #fff;

        padding: 6px;

        border-radius: 12px;

        box-shadow: var(--shadow-sm);

        border: 1px solid var(--border-color);

        margin-bottom: 2.5rem;
    }

    .search-bar input {
        border: none;
        outline: none;

        padding: 0.8rem 1rem;

        flex: 1;

        font-size: 0.95rem;
    }

    .btn-accent {
        background: var(--accent-terracotta);

        color: #fff;

        padding: 0.8rem 1.75rem;

        border-radius: 8px;

        font-weight: 700;

        border: none;

        cursor: pointer;

        transition: var(--transition);

        text-transform: uppercase;

        font-size: 0.85rem;
    }

    .btn-accent:hover {
        background: var(--accent-terracotta-hover);
    }

    /* =========================================================
       HERO STATS + NUMBER COUNTER
       ========================================================= */

    .hero-stats {
        display: flex;

        gap: 3rem;

        border-top: 1px solid var(--border-color);

        padding-top: 1.5rem;
    }

    .stat-item {
        min-width: 100px;
    }

    .stat-item h3 {
        font-size: 1.8rem;

        color: var(--primary-dark);

        font-weight: 800;

        font-variant-numeric: tabular-nums;

        min-width: 100px;
    }

    .stat-item p {
        font-size: 0.85rem;

        color: var(--text-muted);
    }

    /* =========================================================
       HERO VISUAL
       ========================================================= */

    .hero-visual {
        will-change: transform;

        transition: transform .18s linear;
    }

    .floating-badge {
        position: absolute;

        bottom: 20px;
        left: 20px;

        background: rgba(255, 255, 255, 0.95);

        backdrop-filter: blur(12px);

        padding: 1rem 1.25rem;

        border-radius: 12px;

        display: flex;

        align-items: center;

        gap: 12px;

        box-shadow: var(--shadow-lg);

        border: 1px solid rgba(255,255,255,0.4);
    }

    /* =========================================================
       SECTION HEADERS
       ========================================================= */

    .section-header {
        text-align: center;

        max-width: 700px;

        margin: 0 auto 2rem;
    }

    .section-header .tag {
        background: #eef4f0;

        color: var(--primary-green);

        padding: 4px 12px;

        border-radius: 20px;

        font-size: 0.75rem;

        font-weight: 700;

        text-transform: uppercase;

        letter-spacing: 1px;
    }

    .section-header h2 {
        font-size: 2.4rem;

        color: var(--primary-dark);

        margin: 0.75rem 0;

        font-weight: 800;
    }

    /* =========================================================
       PAGE 2
       ========================================================= */

    .grid-4 {
        display: grid;

        grid-template-columns:
            repeat(auto-fit, minmax(250px, 1fr));

        gap: 1.5rem;
    }

    .category-card {
        background: var(--bg-card);

        border-radius: 16px;

        overflow: hidden;

        box-shadow: var(--shadow-sm);

        transition: var(--transition);

        position: relative;

        height: 320px;
    }

    .category-card:hover {
        transform: translateY(-8px);

        box-shadow: var(--shadow-lg);
    }

    .category-card .card-info {
        position: absolute;

        bottom: 0;
        left: 0;
        right: 0;

        padding: 1.25rem;

        background:
            linear-gradient(
                to top,
                rgba(0,0,0,0.85),
                transparent
            );

        color: #fff;
    }

    /* =========================================================
       PAGE 3
       ========================================================= */

    .grid-3 {
        display: grid;

        grid-template-columns:
            repeat(auto-fit, minmax(300px, 1fr));

        gap: 2rem;
    }

    .step-card {
        background: #fff;

        padding: 2.5rem 2rem;

        border-radius: 16px;

        box-shadow: var(--shadow-sm);

        position: relative;

        transition: var(--transition);

        border: 1px solid var(--border-color);
    }

    .step-card:hover {
        border-color: var(--primary-green);

        transform: translateY(-5px);
    }

    .step-num {
        position: absolute;

        top: 20px;
        right: 20px;

        font-size: 2.5rem;

        font-weight: 800;

        color: #e9ecef;
    }

    .icon-box {
        width: 48px;
        height: 48px;

        background: #eef4f0;

        color: var(--primary-green);

        border-radius: 10px;

        display: flex;

        align-items: center;
        justify-content: center;

        font-size: 1.25rem;

        margin-bottom: 1.5rem;
    }

    /* =========================================================
       PAGE 4
       ========================================================= */

    .banner {
        background: var(--accent-terracotta);

        color: #fff;

        border-radius: 20px;

        padding: 4rem;

        display: grid;

        grid-template-columns: 1fr 1fr;

        gap: 3rem;

        align-items: center;

        box-shadow: var(--shadow-lg);
    }

    .banner-content h2 {
        font-size: 2.4rem;

        margin-bottom: 1rem;

        font-weight: 800;
    }

    .banner-actions {
        display: flex;

        gap: 1rem;

        margin-top: 2rem;
    }

    .btn-dark {
        background: var(--primary-dark);

        color: #fff;

        padding: 0.8rem 1.5rem;

        border-radius: 8px;

        font-weight: 700;

        border: none;

        cursor: pointer;
    }

    .btn-outline {
        border: 1px solid #fff;

        color: #fff;

        background: transparent;

        padding: 0.8rem 1.5rem;

        border-radius: 8px;

        font-weight: 700;

        cursor: pointer;
    }

    /* =========================================================
       PAGE 5
       ========================================================= */

    .testimonial-card {
        background: #fff;

        padding: 2rem;

        border-radius: 16px;

        box-shadow: var(--shadow-sm);

        border: 1px solid var(--border-color);

        display: flex;

        flex-direction: column;

        justify-content: space-between;
    }

    .rating {
        color: #f59e0b;

        margin-bottom: 1rem;
    }

    .user-profile {
        display: flex;

        align-items: center;

        gap: 12px;

        margin-top: 1.5rem;

        padding-top: 1rem;

        border-top: 1px solid var(--border-color);
    }

    .user-avatar-slot {
        width: 45px;
        height: 45px;

        border-radius: 50%;

        background: #e9ecef;
        display: flex;

        align-items: center;
        justify-content: center;

        font-size: 0.75rem;

        color: #6c757d;
    }

    /* =========================================================
       FOOTER — AGRIMARKET REFERENCE
       ========================================================= */

    footer {
        margin-top: 18px;

        padding: 38px 5% 18px;

        background:
            var(--primary-dark);

        color: #fff;
    }

    .footer-grid {
        width: min(1400px,100%);

        margin: 0 auto;

        display: grid;

        grid-template-columns:
            2fr 1fr 1fr 1.3fr;

        gap: 35px;

        padding-bottom: 24px;

        border-bottom:
            1px solid rgba(255,255,255,.1);
    }

    .footer-brand p {
        max-width: 430px;

        margin-top: 8px;

        color:
            #a0aec0;

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
        color:
            #a0aec0;

        text-decoration: none;

        font-size: .76rem;

        transition:
            .25s ease;
    }

    .footer-links a:hover {
        color: #fff;
    }

    .copyright {
        width: min(1400px,100%);

        margin: 0 auto;

        padding-top: 15px;

        text-align: center;

        color:
            #a0aec0;

        font-size: .72rem;
    }

    @media (max-width: 1000px) {

        .footer-grid {
            grid-template-columns:
                1fr 1fr;
        }
    }

    @media (max-width: 750px) {

        .footer-grid {
            grid-template-columns:
                1fr 1fr;

            gap: 22px;
        }
    }

    @media (max-width: 520px) {

        .footer-grid {
            grid-template-columns:
                1fr;
        }

        .footer-brand {
            grid-column:
                1 / -1;
        }
    }

    /* =========================================================
       AMBIENT BACKGROUND
       ========================================================= */

    .ambient-bg {
        position: fixed;

        inset: 0;

        z-index: -3;

        overflow: hidden;

        pointer-events: none;

        background:
            radial-gradient(
                circle at 15% 15%,
                rgba(45,90,63,.09),
                transparent 30%
            ),

            radial-gradient(
                circle at 85% 75%,
                rgba(211,107,72,.08),
                transparent 28%
            ),

            linear-gradient(
                180deg,
                #fbfaf6 0%,
                #f4f6ef 48%,
                #faf8f2 100%
            );
    }

    .ambient-shape {
        position: absolute;

        width: 32vw;
        height: 32vw;

        min-width: 260px;
        min-height: 260px;

        border-radius:
            48% 52% 65% 35% /
            38% 45% 55% 62%;

        filter: blur(3px);

        opacity: .32;

        will-change: transform;
    }

    .shape-a {
        top: -12vw;
        left: -10vw;

        background:
            radial-gradient(
                circle at 40% 40%,
                rgba(82,145,104,.22),
                transparent 68%
            );

        animation:
            ambientDriftA 18s ease-in-out infinite alternate;
    }

    .shape-b {
        right: -12vw;
        top: 28vh;

        background:
            radial-gradient(
                circle at 45% 45%,
                rgba(211,107,72,.18),
                transparent 68%
            );

        animation:
            ambientDriftB 23s ease-in-out infinite alternate;
    }

    .shape-c {
        left: 35vw;
        bottom: -22vw;

        background:
            radial-gradient(
                circle at 50% 40%,
                rgba(45,90,63,.12),
                transparent 70%
            );

        animation:
            ambientDriftC 20s ease-in-out infinite alternate;
    }

    .ambient-grid {
        position: absolute;

        inset: 0;

        opacity: .22;

        background-image:
            linear-gradient(
                rgba(30,58,43,.035) 1px,
                transparent 1px
            ),

            linear-gradient(
                90deg,
                rgba(30,58,43,.035) 1px,
                transparent 1px
            );

        background-size: 60px 60px;

        mask-image:
            linear-gradient(
                to bottom,
                black,
                transparent 80%
            );
    }

    @keyframes ambientDriftA {
        to {
            transform:
                translate3d(10vw, 9vh, 0)
                rotate(25deg)
                scale(1.12);
        }
    }

    @keyframes ambientDriftB {
        to {
            transform:
                translate3d(-8vw, -12vh, 0)
                rotate(-30deg)
                scale(1.16);
        }
    }

    @keyframes ambientDriftC {
        to {
            transform:
                translate3d(8vw, -10vh, 0)
                rotate(18deg)
                scale(1.08);
        }
    }

    /* =========================================================
       SCROLL PROGRESS
       ========================================================= */

    .scroll-progress {
        position: fixed;

        top: 0;
        left: 0;

        width: 0%;
        height: 3px;

        z-index: 3000;

        background:
            linear-gradient(
                90deg,
                var(--primary-green),
                var(--accent-terracotta)
            );

        box-shadow:
            0 0 16px rgba(45,90,63,.35);

        transform-origin: left;
    }

    /* =========================================================
       CURSOR GLOW
       ========================================================= */

    .cursor-glow {
        position: fixed;

        width: 260px;
        height: 260px;

        border-radius: 50%;

        pointer-events: none;

        z-index: -1;

        opacity: 0;

        background:
            radial-gradient(
                circle,
                rgba(45,90,63,.08),
                transparent 68%
            );

        transform:
            translate(-50%, -50%);

        transition: opacity .35s ease;
    }

    /* =========================================================
       INTRO SCREEN
       ========================================================= */

    .intro-screen {
        position: fixed;

        inset: 0;

        z-index: 5000;

        display: grid;

        place-items: center;

        overflow: hidden;

        background:
            radial-gradient(
                circle at 50% 42%,
                rgba(78,131,93,.18),
                transparent 30%
            ),

            #10291e;

        color: white;

        transition:
            opacity 1s var(--ease-expo),
            visibility 1s;
    }

    .intro-screen::before {
        content: "";

        position: absolute;

        inset: -20%;

        background:
            repeating-linear-gradient(
                115deg,
                transparent 0 70px,
                rgba(255,255,255,.018) 71px 72px
            );

        transform: rotate(-8deg);

        animation:
            introSweep 8s linear infinite;
    }

    .intro-screen.hide {
        opacity: 0;

        visibility: hidden;

        pointer-events: none;
    }

    .intro-content {
        position: relative;

        text-align: center;

        z-index: 2;

        animation:
            introContentIn 1.2s var(--ease-expo) both;
    }

    .intro-logo {
        width: 76px;
        height: 76px;

        margin: 0 auto 1.25rem;

        display: grid;

        place-items: center;

        border:
            1px solid rgba(255,255,255,.18);

        border-radius: 24px;

        background:
            rgba(255,255,255,.07);

        backdrop-filter: blur(16px);

        font-size: 2rem;

        animation:
            logoPulse 2.4s ease-in-out infinite;
    }

    .intro-kicker {
        text-transform: uppercase;

        letter-spacing: 3px;

        font-size: .68rem;

        opacity: .58;

        margin-bottom: .65rem;
    }

    .intro-content h1 {
        font-size:
            clamp(3rem, 8vw, 6rem);

        letter-spacing: -4px;

        line-height: .95;

        font-weight: 800;
    }

    .intro-content h1 span {
        color: #d9e7d9;
    }

    .intro-line {
        width: 170px;
        height: 2px;

        margin: 1.7rem auto 1rem;

        overflow: hidden;

        background:
            rgba(255,255,255,.12);
    }

    .intro-line span {
        display: block;

        width: 55%;
        height: 100%;

        background: #fff;

        animation:
            introLoading 1.8s var(--ease-expo) infinite;
    }

    .intro-status {
        font-size: .76rem;

        opacity: .55;

        letter-spacing: .4px;
    }

    .intro-orb {
        position: absolute;

        border-radius: 50%;

        filter: blur(1px);

        opacity: .5;
    }

    .orb-one {
        width: 28vw;
        height: 28vw;

        left: -10vw;
        bottom: -15vw;

        background:
            radial-gradient(
                circle,
                rgba(99,171,115,.22),
                transparent 65%
            );

        animation:
            orbFloat 8s ease-in-out infinite alternate;
    }

    .orb-two {
        width: 24vw;
        height: 24vw;

        right: -8vw;
        top: -12vw;

        background:
            radial-gradient(
                circle,
                rgba(211,107,72,.2),
                transparent 65%
            );

        animation:
            orbFloat 10s ease-in-out infinite alternate-reverse;
    }

    @keyframes introContentIn {
        from {
            opacity: 0;

            transform:
                translateY(35px)
                scale(.96);

            filter: blur(8px);
        }

        to {
            opacity: 1;

            transform: none;

            filter: blur(0);
        }
    }

    @keyframes introLoading {
        0% {
            transform: translateX(-150%);
        }

        55%, 100% {
            transform: translateX(310%);
        }
    }

    @keyframes introSweep {
        to {
            transform:
                rotate(-8deg)
                translateX(100px);
        }
    }

    @keyframes logoPulse {
        50% {
            transform:
                translateY(-6px)
                scale(1.04);

            box-shadow:
                0 18px 60px
                rgba(110,180,120,.16);
        }
    }

    @keyframes orbFloat {
        to {
            transform:
                translate(8vw, -6vh)
                scale(1.18);
        }
    }

    /* =========================================================
       SCROLL REVEAL
       ========================================================= */

    .reveal {
        opacity: 0;

        transform:
            translateY(70px)
            scale(.97);

        filter: blur(7px);

        transition:
            opacity 1s var(--ease-expo),
            transform 1.05s var(--ease-expo),
            filter 1.05s var(--ease-expo);

        will-change:
            opacity,
            transform,
            filter;
    }

    .reveal.is-visible {
        opacity: 1;

        transform: none;

        filter: blur(0);
    }

    .reveal.reveal-left {
        transform:
            translateX(-80px)
            rotate(-1.5deg);
    }

    .reveal.reveal-right {
        transform:
            translateX(80px)
            rotate(1.5deg);
    }

    .reveal.reveal-scale {
        transform: scale(.82);
    }

    /* =========================================================
       STAGGER
       ========================================================= */

    .stagger > * {
        opacity: 0;

        transform:
            translateY(35px)
            scale(.98);

        transition:
            opacity .8s var(--ease-expo),
            transform .8s var(--ease-expo);
    }

    .stagger.is-visible > * {
        opacity: 1;

        transform: none;
    }

    .stagger.is-visible > *:nth-child(1) {
        transition-delay: .04s;
    }

    .stagger.is-visible > *:nth-child(2) {
        transition-delay: .12s;
    }

    .stagger.is-visible > *:nth-child(3) {
        transition-delay: .20s;
    }

    .stagger.is-visible > *:nth-child(4) {
        transition-delay: .28s;
    }

    /* =========================================================
       BUTTON EFFECTS
       ========================================================= */

    button,
    .nav-links a,
    .category-card,
    .step-card,
    .testimonial-card {
        -webkit-tap-highlight-color: transparent;
    }

    button:active {
        transform: scale(.97) !important;
    }

    .btn-auth,
    .btn-accent,
    .btn-dark,
    .btn-outline,
    .btn-submit {
        position: relative;

        overflow: hidden;
    }

    .btn-auth::after,
    .btn-accent::after,
    .btn-dark::after,
    .btn-outline::after,
    .btn-submit::after {
        content: "";

        position: absolute;

        top: -80%;
        left: -30%;

        width: 30%;
        height: 260%;

        background:
            rgba(255,255,255,.18);

        transform:
            rotate(20deg)
            translateX(-250%);

        transition:
            transform .7s var(--ease-expo);
    }

    .btn-auth:hover::after,
    .btn-accent:hover::after,
    .btn-dark:hover::after,
    .btn-outline:hover::after,
    .btn-submit:hover::after {
        transform:
            rotate(20deg)
            translateX(650%);
    }

    /* =========================================================
       AUTH MODAL
       ========================================================= */

    .modal-overlay {
        position: fixed;

        top: 0;
        left: 0;

        width: 100vw;
        height: 100vh;

        display: flex;

        align-items: center;
        justify-content: center;

        z-index: 2000;

        opacity: 1;

        visibility: visible;

        pointer-events: auto;

        backdrop-filter: blur(0);

        background:
            rgba(8,24,16,0);

        transition:
            opacity .65s var(--ease-expo),
            visibility .65s,
            background .65s ease,
            backdrop-filter .65s ease;
    }

    .modal-overlay.hidden {
        opacity: 0;

        visibility: hidden;

        pointer-events: none;
    }

    .modal-overlay:not(.hidden) {
        background:
            rgba(8,24,16,.62);

        backdrop-filter:
            blur(14px)
            saturate(120%);
    }

    .auth-container {
        background: #fff;

        width: 90%;

        max-width: 440px;

        border-radius: 20px;

        padding: 2.5rem;

        box-shadow: var(--shadow-lg);

        position: relative;

        opacity: 0;

        transform:
            translateY(55px)
            scale(.88)
            rotateX(8deg);

        filter: blur(10px);

        transition:
            opacity .65s var(--ease-expo),
            transform .8s var(--ease-spring),
            filter .65s var(--ease-expo);

        transform-origin: 50% 80%;
    }

    .modal-overlay:not(.hidden) .auth-container {
        opacity: 1;

        transform: none;

        filter: blur(0);
    }

    .auth-container::before {
        content: "";

        position: absolute;

        inset: -1px;

        border-radius: 21px;

        padding: 1px;

        background:
            linear-gradient(
                135deg,
                rgba(45,90,63,.3),
                transparent 35%,
                rgba(211,107,72,.22)
            );

        -webkit-mask:
            linear-gradient(#000 0 0) content-box,
            linear-gradient(#000 0 0);

        -webkit-mask-composite: xor;

        mask:
            linear-gradient(#000 0 0) content-box,
            linear-gradient(#000 0 0);

        mask-composite: exclude;

        pointer-events: none;
    }

    .modal-close {
        position: absolute;

        top: 20px;
        right: 20px;

        background: transparent;

        border: none;

        font-size: 1.25rem;

        cursor: pointer;

        color: var(--text-muted);
    }

    .auth-tabs {
        display: flex;

        background: #f1f3f5;

        padding: 4px;

        border-radius: 10px;

        margin-bottom: 2rem;
    }

    .tab-btn {
        flex: 1;

        padding: 0.6rem;

        border: none;

        background: transparent;

        font-weight: 700;

        color: var(--text-muted);

        border-radius: 8px;

        cursor: pointer;

        transition: var(--transition);
    }

    .tab-btn.active {
        background: #fff;

        color: var(--primary-dark);

        box-shadow:
            0 2px 8px
            rgba(0,0,0,0.05);
    }

    .form-group {
        margin-bottom: 1.25rem;

        transition:
            transform .3s var(--ease-expo);
    }

    .form-group:focus-within {
        transform:
            translateX(4px);
    }

    .form-group label {
        display: block;

        font-size: 0.85rem;

        font-weight: 700;

        margin-bottom: 0.4rem;

        color: var(--text-main);
    }

    .form-group input {
        width: 100%;

        padding: 0.75rem 1rem;

        border:
            1px solid
            var(--border-color);

        border-radius: 8px;

        outline: none;

        font-size: 0.95rem;

        transition:
            border-color .3s ease,
            box-shadow .3s ease,
            transform .3s var(--ease-expo);
    }

    .form-group input:focus {
        border-color:
            var(--primary-green);

        box-shadow:
            0 0 0 4px
            rgba(45,90,63,.08);

        transform:
            translateY(-1px);
    }

    .btn-submit {
        width: 100%;

        background:
            var(--primary-dark);

        color: #fff;

        padding: 0.85rem;

        border-radius: 8px;

        font-weight: 700;

        border: none;

        cursor: pointer;

        margin-top: 0.5rem;

        transition:
            var(--transition);
    }

    .btn-submit:hover {
        background:
            var(--primary-green);
    }

    .auth-form-anim {
        animation:
            formSwap .48s var(--ease-expo) both;
    }

    @keyframes formSwap {
        from {
            opacity: 0;

            transform:
                translateX(20px);

            filter: blur(5px);
        }

        to {
            opacity: 1;

            transform: none;

            filter: blur(0);
        }
    }

    /* =========================================================
       CLICK WATER RIPPLE
       ========================================================= */

    .click-pop {
        position: fixed;

        width: 7px;
        height: 7px;

        border-radius: 50%;

        pointer-events: none;

        z-index: 6001;

        background:
            rgba(45,90,63,.45);

        transform:
            translate(-50%, -50%);

        animation:
            waterDrop .7s ease-out forwards;
    }

    @keyframes waterDrop {
        0% {
            opacity: .9;

            transform:
                translate(-50%,-50%)
                scale(1);
        }

        100% {
            opacity: 0;

            transform:
                translate(-50%,-50%)
                scale(.1)
                translateY(24px);
        }
    }

    /* =========================================================
       CURSOR TRAIL
       ========================================================= */

    .cursor-trail {
        position: fixed;

        width: 6px;
        height: 6px;

        border-radius: 50%;

        pointer-events: none;

        z-index: 5999;

        background:
            rgba(45,90,63,.22);

        transform:
            translate(-50%,-50%);

        animation:
            trailFade .65s ease-out forwards;
    }

    @keyframes trailFade {
        to {
            opacity: 0;

            transform:
                translate(-50%,-50%)
                scale(0);
        }
    }

    .cursor-bubble {
        position: fixed;

        pointer-events: none;

        z-index: 5998;

        width: 10px;
        height: 10px;

        border:
            1px solid
            rgba(45,90,63,.25);

        border-radius: 50%;

        animation:
            bubbleFloat .85s ease-out forwards;
    }

    @keyframes bubbleFloat {
        to {
            opacity: 0;

            transform:
                translate(var(--dx), var(--dy))
                scale(.2);
        }
    }

    /* =========================================================
       ACCESSIBILITY
       ========================================================= */

    @media (prefers-reduced-motion: reduce) {

        html {
            scroll-behavior: auto;
        }

        *,
        *::before,
        *::after {
            animation-duration: .001ms !important;

            animation-iteration-count: 1 !important;

            transition-duration: .001ms !important;
        }

        .reveal,
        .stagger > * {
            opacity: 1;

            transform: none;

            filter: none;
        }
    }

    /* =========================================================
       RESPONSIVE
       ========================================================= */

    @media (max-width: 992px) {

        #page1,
        .banner {
            grid-template-columns: 1fr;
        }

        .nav-links {
            display: none;
        }
    }

    @media (max-width: 768px) {

        .cursor-glow {
            display: none;
        }

        .ambient-grid {
            background-size: 38px 38px;
        }

        .intro-content h1 {
            letter-spacing: -2px;
        }

        .hero-stats {
            gap: 1.5rem;
        }

        .stat-item h3 {
            font-size: 1.45rem;
        }
    }

    @media (max-width: 576px) {

        .banner {
            padding: 2rem;
        }

        .hero-title {
            font-size: 2.2rem;
        }

        .hero-stats {
            flex-wrap: wrap;
        }

        .search-bar {
            flex-direction: column;
            gap: 6px;
        }

        .search-bar button {
            width: 100%;
        }
    }

    /* =========================================================
       BUTTON RIPPLE ANIMATION
       ========================================================= */

    @keyframes ripple {
        to {
            transform:
                translate(-50%,-50%)
                scale(28);

            opacity: 0;
        }
    }
</style>
</head>

<body>

    <!-- =========================================================
         INTRO
         ========================================================= -->

    <div class="intro-screen" id="introScreen">

        <div class="intro-orb orb-one"></div>
        <div class="intro-orb orb-two"></div>

        <div class="intro-content">

            <div class="intro-logo">
                <i class="fa-solid fa-leaf"></i>
            </div>

            <p class="intro-kicker">
                A new way to connect agriculture
            </p>

            <h1>
                agri<span>market</span>
            </h1>

            <div class="intro-line">
                <span></span>
            </div>

            <p class="intro-status">
                Preparing your marketplace...
            </p>

        </div>

    </div>

    <!-- =========================================================
         AMBIENT BACKGROUND
         ========================================================= -->

    <div class="ambient-bg" aria-hidden="true">

        <span class="ambient-shape shape-a"></span>
        <span class="ambient-shape shape-b"></span>
        <span class="ambient-shape shape-c"></span>

        <span class="ambient-grid"></span>

    </div>

    <div class="scroll-progress" id="scrollProgress"></div>

    <div class="cursor-glow" id="cursorGlow"></div>

    <!-- =========================================================
         NAVBAR
         ========================================================= -->

    <nav class="navbar">

        <a href="#page1" class="brand-logo">
            <i class="fa-solid fa-leaf"></i>
            agrimarket
        </a>

        <ul class="nav-links">

            <li>
                <a href="#page1">
                    Marketplace
                </a>
            </li>

            <li>
                <a href="#page2">
                    Categories
                </a>
            </li>

            <li>
                <a href="#page3">
                    How It Works
                </a>
            </li>

            <li>
                <a href="#page4">
                    Seasonal Offers
                </a>
            </li>

            <li>
                <a href="#page5">
                    Grower Network
                </a>
            </li>

        </ul>

        <button
            class="btn-auth"
            onclick="toggleModal(true)"
        >
            LOG IN
        </button>

    </nav>

    <!-- =========================================================
         PAGE 1
         ========================================================= -->

    <section
        class="page-section animated reveal"
        id="page1"
    >

        <div class="hero-content">

            <p class="hero-subtitle">
                Direct from Farm Gate to Market
            </p>

            <h1 class="hero-title">
                Earthy Goods. Trusted Supplies. Handled Wisely.
                @if (Auth::check())
                    {{ Auth::user()->name }}
                @else
                    no user
                @endif
            </h1>

            <p class="hero-description">
                Connecting growers directly with commercial buyers.
                Sourcing organic seeds, vetted premium equipment,
                natural fertilizers, and fresh farm produce with
                transactional integrity.
            </p>

            <!-- ANIMATED STATS -->

            <div class="hero-stats">

                <div class="stat-item">

                    <h3
                        class="count-number"
                        data-target="12000"
                        data-suffix="+"
                    >
                        0+
                    </h3>

                    <p>
                        Verified Growers
                    </p>

                </div>

                <div class="stat-item">

                    <h3
                        class="count-number"
                        data-target="24"
                        data-suffix=" hr"
                    >
                        0 hr
                    </h3>

                    <p>
                        Harvest-to-Ship
                    </p>

                </div>

                <div class="stat-item">

                    <h3
                        class="count-number"
                        data-target="100"
                        data-suffix="%"
                    >
                        0%
                    </h3>

                    <p>
                        Direct Sourced Proof
                    </p>

                </div>

            </div>

        </div>

        <div class="hero-visual"
            style="
                position: relative;
                animation: float 6s ease-in-out infinite;
            ">
            <img
                src="https://images.unsplash.com/photo-1495107334309-fcf20504a5ab?auto=format&fit=crop&w=1000&q=80"
                alt="Modern Greenhouse"
                style="
                    width: 100%;
                    height: 420px;
                    object-fit: cover;
                    border-radius: 24px;
                    display: block;
                ">

            <div class="floating-badge">

                <i
                    class="fa-solid fa-shield-halved"
                    style="
                        color: var(--primary-green);
                        font-size: 1.5rem;
                    "
                ></i>

                <div>

                    <strong
                        style="
                            display: block;
                            font-size: 0.85rem;
                        "
                    >
                        Quality Vetted List
                    </strong>

                    <span
                        style="
                            font-size: 0.75rem;
                            color: var(--text-muted);
                        "
                    >
                        Every grower certified organic or lab graded
                    </span>

                </div>

            </div>

        </div>



    </section>

    <!-- =========================================================
         PAGE 2
         ========================================================= -->

    <section
        class="page-section reveal"
        id="page2"
    >

        <div class="section-header">

            <span class="tag">
                Comprehensive Catalog
            </span>

            <h2>
                Everything Needed for Modern Sustainable Agriculture
            </h2>

            <p
                style="
                    color: var(--text-muted);
                    margin-top: 0.5rem;
                "
            >
                Direct procurement streams built to maximize farm
                productivity and secure high yields for conscious
                retail channels.
            </p>

        </div>

        <div class="grid-4 stagger">

    <div class="category-card">

        <div class="img-placeholder">

            <img
                src="https://images.unsplash.com/photo-1542838132-92c53300491e?auto=format&fit=crop&w=800&q=80"
                alt="Fresh Produce"
            >

        </div>

        <div class="card-info">

            <h3>
                Fresh Produce
            </h3>

        </div>

    </div>


    <div class="category-card">

        <div class="img-placeholder">

            <img
            src="https://plus.unsplash.com/premium_photo-1757479571654-43479f81aad1?auto=format&fit=crop&w=500&q=80"
            alt="Processed & Packaged Goods"
            >

        </div>

        <div class="card-info">

            <h3>
                Processed & Packaged Goods
            </h3>

        </div>

    </div>


    <div class="category-card">

        <div class="img-placeholder">

            <img
                src="https://commons.wikimedia.org/wiki/Special:FilePath/Rice%20grains%20(IRRI).jpg?width=1600"
                alt="Organic Fertilizers"
            >

        </div>

        <div class="card-info">

            <h3>
                Rice & Grains
            </h3>

        </div>

    </div>


    <div class="category-card">

        <div class="img-placeholder">

            <img
            src="https://images.unsplash.com/photo-1636998980792-63f27ddea4e3?auto=format&fit=crop&w=400&q=80"
            alt="Livestock Supplies"
            >

        </div>

        <div class="card-info">

            <h3>
                Livestock Supplies
            </h3>
        </div>

    </div>

</div>

    </section>
    <!-- =========================================================
         PAGE 3
         ========================================================= -->

    <section
        class="page-section reveal"
        id="page3"
    >

        <div class="section-header">

            <span class="tag">
                Streamlined Logistics
            </span>

            <h2>
                Empowering Farmers, Assuring Buyers
            </h2>

            <p
                style="
                    color: var(--text-muted);
                    margin-top: 0.5rem;
                "
            >
                A three-step loop designed to simplify the heavy
                lifting of agricultural procurement, payments, and
                temperature-controlled freight.
            </p>

        </div>

        <div class="grid-3 stagger">

            <div class="step-card">

                <span class="step-num">
                    01
                </span>

                <div class="icon-box">
                    <i class="fa-solid fa-store"></i>
                </div>

                <h3>
                    Direct Listing
                </h3>

                <p>
                    Farmers list their organic yield, seed batches,
                    and state-of-the-art agricultural tools straight
                    from source.
                </p>

            </div>

            <div class="step-card">

                <span class="step-num">
                    02
                </span>

                <div class="icon-box">
                    <i class="fa-solid fa-boxes-packing"></i>
                </div>

                <h3>
                    Seamless Ordering
                </h3>

                <p>
                    Browse vetted agricultural supplies and fresh
                    goods. Pay securely with modern transparent
                    pricing and tracking.
                </p>

            </div>

            <div class="step-card">

                <span class="step-num">
                    03
                </span>

                <div class="icon-box">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>

                <h3>
                    Harvest-Fresh Delivery
                </h3>

                <p>
                    Fast specialized cargo fleet delivers directly
                    to processing facilities, retail nodes, or farm
                    gates.
                </p>

            </div>

        </div>

    </section>

    <!-- =========================================================
         PAGE 4
         ========================================================= -->

    <section
        class="page-section reveal"
        id="page4"
    >

        <div class="banner">

            <div class="banner-content">

                <span
                    style="
                        font-size:0.75rem;
                        text-transform:uppercase;
                        font-weight:800;
                        letter-spacing:1px;
                        background:rgba(255,255,255,0.2);
                        padding:4px 10px;
                        border-radius:12px;
                    "
                >
                    Limited Harvest Window
                </span>

                <h2 style="margin-top:1rem;">
                    Pre-Order Spring Supplies:
                    Get up to 30% Off Bulk Shipments
                </h2>

                <p>
                    Secure early-season organic seeds and automated
                    irrigation systems before our seasonal freight
                    routes book out completely. Guarantee pricing
                    levels and safe shipping lanes today.
                </p>

                <div class="banner-actions">

                </div>

            </div>

                <div>

                    <div
                        class="img-placeholder"
                        style="
                            height:300px;
                            overflow:hidden;
                            border:none;
                            padding:0;
                        "
                    >

                        <img
                            src="https://images.unsplash.com/photo-1464226184884-fa280b87c399?auto=format&fit=crop&w=1000&q=80"
                            alt="Farmers in Field"
                            style="
                                width:100%;
                                height:100%;
                                object-fit:cover;
                                display:block;
                            "
                        >

                    </div>

                </div>

            </div>

    </section>

    <!-- =========================================================
         PAGE 5
         ========================================================= -->

    <section
        class="page-section reveal"
        id="page5"
    >

        <div class="section-header">

            <span class="tag">
                Verified Grower & Buyer Stories
            </span>

            <h2>
                Loved by Producers, Sourced by Experts
            </h2>

        </div>

        <div
            class="grid-3 stagger"
            style="margin-bottom:2rem;"
        >

            <div class="testimonial-card">

                <div>

                    <div class="rating">

                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>

                    </div>

                    <p>
                        "Agrimarket transformed how we distribute
                        our organic carrot crop. No middlemen,
                        better yields on pricing, and excellent
                        logistics."
                    </p>

                </div>

                <div class="user-profile">

                    <div class="user-avatar-slot">
                        <i class="fa-solid fa-user"></i>
                    </div>

                    <div>

                        <strong
                            style="
                                display:block;
                                font-size:0.9rem;
                            "
                        >
                            Ajay Q. Mendaros
                        </strong>

                    </div>

                </div>

            </div>

            <div class="testimonial-card">

                <div>

                    <div class="rating">

                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>

                    </div>

                    <p>
                        "Our restaurants depend on freshness.
                        With daily deliveries from local growers
                        on Agrimarket, we receive greens at peak
                        flavor."
                    </p>

                </div>

                <div class="user-profile">

                    <div class="user-avatar-slot">
                        <i class="fa-solid fa-user"></i>
                    </div>

                    <div>

                        <strong
                            style="
                                display:block;
                                font-size:0.9rem;
                            "
                        >
                            Eduard Mendoza
                        </strong>

                    </div>

                </div>

            </div>

            <div class="testimonial-card">

                <div>

                    <div class="rating">

                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i>

                    </div>

                    <p>
                        "As a smallholder, finding verified quality
                        fertilizers was tough. Agrimarket makes
                        bulk ordering transparent and incredibly
                        easy."
                    </p>

                </div>

                <div class="user-profile">

                    <div class="user-avatar-slot">
                        <i class="fa-solid fa-user"></i>
                    </div>

                    <div>

                        <strong
                            style="
                                display:block;
                                font-size:0.9rem;
                            "
                        >
                            Ivan Jay Elago
                        </strong>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- =========================================================
         FOOTER
         SAME AGRIMARKET REFERENCE FOOTER
    ========================================================== -->

    <footer>
    <div class="footer-grid">

        <div class="footer-brand">
            <a href="" class="brand-logo" style="color:#fff">
                <i class="fa-solid fa-leaf"></i>
                agrimarket
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
                <li>
                    <a href="">About Us</a>
                </li>

                <li>
                    <a href="">Contact</a>
                </li>

                <li>
                    <a href="">Help &amp; Support</a>
                </li>
            </ul>
        </div>

        <div class="footer-links">
            <h4>Legal</h4>

            <ul>
                <li>
                    <a href="">Terms &amp; Conditions</a>
                </li>

                <li>
                    <a href="">Privacy Policy</a>
                </li>
            </ul>
        </div>

        <div class="footer-links">
            <h4>Marketplace</h4>

            <ul>
                <li>
                    <a href="#page2">New &amp; Fresh</a>
                </li>

                <li>
                    <a href="#page3">Best Sellers</a>
                </li>

                <li>
                    <a href="">Groceries</a>
                </li>
            </ul>
        </div>

    </div>

    <div class="copyright">
        © 2026 AgriMarket. All rights reserved.
    </div>
</footer>

    <!-- =========================================================
         AUTHENTICATION MODAL
         ========================================================= -->

    <div
        class="modal-overlay hidden"
        id="authModal"
    >

        <div class="auth-container">

            <button
                class="modal-close"
                onclick="toggleModal(false)"
            >
                <i class="fa-solid fa-xmark"></i>
            </button>

            <div class="auth-tabs">

                <button
                    class="tab-btn active"
                    id="loginTabBtn"
                    onclick="switchTab('login')"
                >
                    Log In
                </button>

                <button
                    class="tab-btn"
                    id="signupTabBtn"
                    onclick="switchTab('signup')"
                >
                    Sign Up
                </button>

            </div>

            <!-- LOGIN -->

            <form id="loginForm" action="{{ route('login.process') }}" method="POST">
                @csrf
                @if(session('login_error'))
                    <div style="
                        margin-bottom: 1rem;
                        padding: 0.75rem 1rem;
                        background: var(--soft-terracotta, #f8e9e3);
                        color: var(--accent-terracotta, #d36b48);
                        border: 1px solid rgba(211,107,72,.25);
                        border-radius: 8px;
                        font-size: 0.85rem;
                        font-weight: 600;
                    ">
                        {{ session('login_error') }}
                    </div>
                @endif
                <div class="form-group">
                    <label> Email Address </label>
                    <input type="email" placeholder="name@farmdomain.com" required value="{{ old('email') }}" name="email">
                </div>

                <div class="form-group">
                    <label> Password </label>
                    <input type="password" placeholder="••••••••" required value="{{ old('password') }}" name="password">
                </div>
                <button type="submit" class="btn-submit">Log In to Dashboard</button>
            </form>

            <!-- SIGN UP -->

            <form id="signupForm" style="display:none;" action="{{ route('register') }}" method="POST">
                @csrf
                @if ($errors->any() && old('name') !== null)
                    <div style="
                        margin-bottom: 1rem;
                        padding: 0.75rem 1rem;
                        background: var(--soft-terracotta, #f8e9e3);
                        color: var(--accent-terracotta, #d36b48);
                        border: 1px solid rgba(211,107,72,.25);
                        border-radius: 8px;
                        font-size: 0.85rem;
                        font-weight: 600;
                    ">
                        {{ $errors->first() }}
                    </div>
                @endif
                <div class="form-group">
                    <label> Username / Business Name </label>
                    <input type="text" placeholder="GreenValley Farms" required value="{{ old('name') }}" name="name">
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" placeholder="name@farmdomain.com" required value="{{ old('email') }}" name="email">
                </div>

                <div class="form-group">
                    <label> Create Password </label>
                    <input type="password" placeholder="••••••••" required value="{{ old('password') }}" name="password">
                </div> 
                
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" placeholder="••••••••" required value="{{ old('password_confirmation') }}" name="password_confirmation">
                </div>

                <button type="submit" class="btn-submit"> Create Account </button>
            </form>

        </div>

    </div>

    <!-- =========================================================
         JAVASCRIPT
         ========================================================= -->

    <script>

        const prefersReducedMotion =
            window.matchMedia(
                '(prefers-reduced-motion: reduce)'
            ).matches;

        /* =========================================================
           AUTH MODAL
           ========================================================= */

        function toggleModal(show) {

            const modal =
                document.getElementById('authModal');

            if (show) {

                modal.classList.remove('hidden');

                document.body.style.overflow = 'hidden';

                requestAnimationFrame(() => {

                    document
                        .getElementById('loginTabBtn')
                        .focus({
                            preventScroll: true
                        });

                });

            } else {

                modal.classList.add('hidden');

                document.body.style.overflow = '';

            }

        }

        /* =========================================================
           AUTH TABS
           ========================================================= */

        function switchTab(tab) {

            const loginForm =
                document.getElementById('loginForm');

            const signupForm =
                document.getElementById('signupForm');

            const loginBtn =
                document.getElementById('loginTabBtn');

            const signupBtn =
                document.getElementById('signupTabBtn');

            const nextForm =
                tab === 'login'
                    ? loginForm
                    : signupForm;

            const oldForm =
                tab === 'login'
                    ? signupForm
                    : loginForm;

            oldForm.style.display = 'none';

            nextForm.style.display = 'block';

            nextForm.classList.remove(
                'auth-form-anim'
            );

            void nextForm.offsetWidth;

            nextForm.classList.add(
                'auth-form-anim'
            );

            loginBtn.classList.toggle(
                'active',
                tab === 'login'
            );

            signupBtn.classList.toggle(
                'active',
                tab === 'signup'
            );

        }

        /* =========================================================
           NUMBER COUNTER
           ========================================================= */

        function animateCounter(element) {

            const target =
                Number(element.dataset.target);

            const suffix =
                element.dataset.suffix || '';

            const duration = 1000;

            const startTime =
                performance.now();

            element.textContent =
                `0${suffix}`;

            function updateCounter(currentTime) {

                const elapsed =
                    currentTime - startTime;

                const progress =
                    Math.min(
                        elapsed / duration,
                        1
                    );

                const easedProgress =
                    1 -
                    Math.pow(
                        1 - progress,
                        3
                    );

                const currentValue =
                    Math.floor(
                        target *
                        easedProgress
                    );

                element.textContent =
                    currentValue.toLocaleString() +
                    suffix;

                if (progress < 1) {

                    requestAnimationFrame(
                        updateCounter
                    );

                } else {

                    element.textContent =
                        target.toLocaleString() +
                        suffix;

                }

            }

            requestAnimationFrame(
                updateCounter
            );

        }

        /* =========================================================
           RESET COUNTERS
           ========================================================= */

        function resetCounters() {

            document
                .querySelectorAll('.count-number')
                .forEach(number => {

                    const suffix =
                        number.dataset.suffix || '';

                    number.textContent =
                        `0${suffix}`;

                });

        }

        /* =========================================================
           MAIN
           ========================================================= */

        document.addEventListener(
            'DOMContentLoaded',
            () => {

                const intro =
                    document.getElementById(
                        'introScreen'
                    );

                const progress =
                    document.getElementById(
                        'scrollProgress'
                    );

                const navbar =
                    document.querySelector(
                        '.navbar'
                    );

                const cursorGlow =
                    document.getElementById(
                        'cursorGlow'
                    );

                const heroVisual =
                    document.querySelector(
                        '.hero-visual'
                    );

                /* =================================================
                   INTRO
                   ================================================= */

                if (!prefersReducedMotion) {

                    document.body.style.overflow =
                        'hidden';

                    setTimeout(() => {

                        intro.classList.add(
                            'hide'
                        );

                        document.body.style.overflow =
                            '';

                    }, 2600);

                } else {

                    intro.classList.add(
                        'hide'
                    );

                }

                /* =================================================
                   REPEATABLE SCROLL REVEALS
                   ================================================= */

                if (!prefersReducedMotion) {

                    const observer =
                        new IntersectionObserver(
                            (entries) => {

                                entries.forEach(
                                    entry => {

                                        const el =
                                            entry.target;

                                        if (
                                            entry.isIntersecting
                                        ) {

                                            el.classList.remove(
                                                'is-visible'
                                            );

                                            void el.offsetWidth;

                                            el.classList.add(
                                                'is-visible'
                                            );

                                        } else {

                                            el.classList.remove(
                                                'is-visible'
                                            );

                                        }

                                    }
                                );

                            },
                            {
                                threshold: 0.18,

                                rootMargin:
                                    '0px 0px -80px 0px'
                            }
                        );

                    document
                        .querySelectorAll(
                            '.reveal, .stagger'
                        )
                        .forEach(el => {

                            observer.observe(el);

                        });

                } else {

                    document
                        .querySelectorAll(
                            '.reveal, .stagger'
                        )
                        .forEach(el => {

                            el.classList.add(
                                'is-visible'
                            );

                        });

                }

                /* =================================================
                   REPEATABLE NUMBER COUNTER OBSERVER
                   ================================================= */

                const heroStats =
                    document.querySelector(
                        '.hero-stats'
                    );

                if (heroStats) {

                    const statsObserver =
                        new IntersectionObserver(
                            (entries) => {

                                entries.forEach(
                                    entry => {

                                        if (
                                            entry.isIntersecting
                                        ) {

                                            if (
                                                !prefersReducedMotion
                                            ) {

                                                document
                                                    .querySelectorAll(
                                                        '.count-number'
                                                    )
                                                    .forEach(
                                                        number => {

                                                            animateCounter(
                                                                number
                                                            );

                                                        }
                                                    );

                                            } else {

                                                document
                                                    .querySelectorAll(
                                                        '.count-number'
                                                    )
                                                    .forEach(
                                                        number => {

                                                            const target =
                                                                Number(
                                                                    number.dataset.target
                                                                );

                                                            const suffix =
                                                                number.dataset.suffix ||
                                                                '';

                                                            number.textContent =
                                                                target.toLocaleString() +
                                                                suffix;

                                                        }
                                                    );

                                            }

                                        } else {

                                            if (
                                                !prefersReducedMotion
                                            ) {

                                                resetCounters();

                                            }

                                        }

                                    }
                                );

                            },
                            {
                                threshold: 0.35,

                                rootMargin:
                                    '0px 0px -50px 0px'
                            }
                        );

                    statsObserver.observe(
                        heroStats
                    );

                }

                /* =================================================
                   SCROLL EFFECTS
                   ================================================= */

                function updateScrollEffects() {

                    const scrollTop =
                        window.scrollY;

                    const maxScroll =
                        document.documentElement
                            .scrollHeight -
                        window.innerHeight;

                    const percent =
                        maxScroll > 0
                            ? (scrollTop / maxScroll) * 100
                            : 0;

                    progress.style.width =
                        `${percent}%`;

                    navbar.classList.toggle(
                        'scrolled',
                        scrollTop > 20
                    );

                    if (
                        heroVisual &&
                        !prefersReducedMotion &&
                        scrollTop <
                        window.innerHeight * 1.1
                    ) {

                        const y =
                            scrollTop * 0.075;

                        const rotate =
                            scrollTop * 0.008;

                        heroVisual.style.transform =
                            `translate3d(0, ${y}px, 0) rotate(${rotate}deg)`;

                    }

                }

                let ticking = false;

                window.addEventListener(
                    'scroll',
                    () => {

                        if (!ticking) {

                            requestAnimationFrame(
                                () => {

                                    updateScrollEffects();

                                    ticking = false;

                                }
                            );

                            ticking = true;

                        }

                    },
                    {
                        passive: true
                    }
                );

                updateScrollEffects();

                /* =================================================
                   CURSOR GLOW
                   ================================================= */

                if (
                    cursorGlow &&
                    !prefersReducedMotion
                ) {

                    window.addEventListener(
                        'pointermove',
                        e => {

                            cursorGlow.style.left =
                                `${e.clientX}px`;

                            cursorGlow.style.top =
                                `${e.clientY}px`;

                            cursorGlow.style.opacity =
                                '1';

                        },
                        {
                            passive: true
                        }
                    );

                    window.addEventListener(
                        'pointerleave',
                        () => {

                            cursorGlow.style.opacity =
                                '0';

                        }
                    );

                }

                /* =================================================
                   CARD TILT
                   ================================================= */

                if (!prefersReducedMotion) {

                    document
                        .querySelectorAll(
                            '.category-card, .step-card, .testimonial-card'
                        )
                        .forEach(card => {

                            card.addEventListener(
                                'pointermove',
                                e => {

                                    const r =
                                        card.getBoundingClientRect();

                                    const x =
                                        (e.clientX - r.left) /
                                        r.width -
                                        0.5;

                                    const y =
                                        (e.clientY - r.top) /
                                        r.height -
                                        0.5;

                                    card.style.transform =
                                        `perspective(900px)
                                         rotateX(${-y * 3}deg)
                                         rotateY(${x * 4}deg)
                                         translateY(-5px)`;

                                }
                            );

                            card.addEventListener(
                                'pointerleave',
                                () => {

                                    card.style.transform =
                                        '';

                                }
                            );

                        });

                }

                /* =================================================
                   MODAL CLOSE
                   ================================================= */

                document
                    .getElementById('authModal')
                    .addEventListener(
                        'click',
                        e => {

                            if (
                                e.target.id ===
                                'authModal'
                            ) {

                                toggleModal(false);

                            }

                        }
                    );

                document.addEventListener(
                    'keydown',
                    e => {

                        if (
                            e.key === 'Escape'
                        ) {

                            toggleModal(false);

                        }

                    }
                );

                /* =================================================
                   BUTTON RIPPLE
                   ================================================= */

                document
                    .querySelectorAll('button')
                    .forEach(button => {

                        button.addEventListener(
                            'click',
                            e => {

                                const rect =
                                    button.getBoundingClientRect();

                                const ripple =
                                    document.createElement(
                                        'span'
                                    );

                                ripple.style.cssText = `
                                    position:absolute;
                                    left:${e.clientX - rect.left}px;
                                    top:${e.clientY - rect.top}px;
                                    width:8px;
                                    height:8px;
                                    border-radius:50%;
                                    background:rgba(255,255,255,.3);
                                    transform:translate(-50%,-50%) scale(0);
                                    pointer-events:none;
                                    animation:ripple .65s ease-out forwards;
                                `;

                                button.appendChild(
                                    ripple
                                );

                                setTimeout(
                                    () => {
                                        ripple.remove();
                                    },
                                    700
                                );

                            }
                        );

                    });

                /* =================================================
                   WATER CLICK EFFECT
                   ================================================= */

                function createWaterClick(
                    x,
                    y
                ) {

                    const drop =
                        document.createElement(
                            'span'
                        );

                    drop.className =
                        'click-pop';

                    drop.style.left =
                        `${x}px`;

                    drop.style.top =
                        `${y}px`;

                    drop.animate(
                        [
                            {
                                transform:
                                    'translate(-50%, -50%) scale(.2)',

                                opacity: 1
                            },

                            {
                                transform:
                                    'translate(-50%, -50%) scale(2.4)',

                                opacity: .7
                            },

                            {
                                transform:
                                    'translate(-50%, -50%) scale(3.2)',

                                opacity: 0
                            }
                        ],
                        {
                            duration:
                                650 +
                                Math.random() * 250,

                            easing:
                                'cubic-bezier(.16,1,.3,1)',

                            fill:
                                'forwards'
                        }
                    );

                    document.body.appendChild(
                        drop
                    );

                    setTimeout(
                        () => {
                            drop.remove();
                        },
                        950
                    );

                }

                document.addEventListener(
                    'click',
                    e => {

                        createWaterClick(
                            e.clientX,
                            e.clientY
                        );

                    },
                    {
                        passive: true
                    }
                );

                /* =================================================
                   CURSOR TRAIL
                   ================================================= */

                let lastTrailTime = 0;

                document.addEventListener(
                    'pointermove',
                    e => {

                        if (
                            prefersReducedMotion
                        ) {
                            return;
                        }

                        const now =
                            performance.now();

                        if (
                            now -
                            lastTrailTime <
                            55
                        ) {
                            return;
                        }

                        lastTrailTime =
                            now;

                        const trail =
                            document.createElement(
                                'span'
                            );

                        trail.className =
                            'cursor-trail';

                        trail.style.left =
                            `${e.clientX}px`;

                        trail.style.top =
                            `${e.clientY}px`;

                        document.body.appendChild(
                            trail
                        );

                        setTimeout(
                            () => {
                                trail.remove();
                            },
                            700
                        );

                        if (
                            Math.random() <
                            .12
                        ) {

                            const bubble =
                                document.createElement(
                                    'span'
                                );

                            bubble.className =
                                'cursor-bubble';

                            bubble.style.left =
                                `${e.clientX}px`;

                            bubble.style.top =
                                `${e.clientY}px`;

                            bubble.style.setProperty(
                                '--dx',
                                `${(Math.random() - .5) * 35}px`
                            );

                            bubble.style.setProperty(
                                '--dy',
                                `${-10 - Math.random() * 25}px`
                            );

                            document.body.appendChild(
                                bubble
                            );

                            setTimeout(
                                () => {
                                    bubble.remove();
                                },
                                900
                            );

                        }

                    },
                    {
                        passive: true
                    }
                );

                /* =================================================
                   INITIAL AUTH FORM ANIMATION
                   ================================================= */

                document
                    .getElementById('loginForm')
                    .classList.add(
                        'auth-form-anim'
                    );

            }
        );

        @if ($errors->any() && old('name') !== null)
            document.addEventListener('DOMContentLoaded', function () {
                toggleModal(true);
                switchTab('signup');
            });
        @endif

        @if(session('login_error'))
            document.addEventListener('DOMContentLoaded', function () {
                toggleModal(true);
                switchTab('login');
            });
        @endif

    </script>

</body>
</html>