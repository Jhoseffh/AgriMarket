<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AgriMarket - Settings</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    >
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
        button,
        input,
        textarea {
            font: inherit;
        }
        button,
        a {
            -webkit-tap-highlight-color: transparent;
        }
        a {
            color: inherit;
        }
        /* =========================================================
           AMBIENT BACKGROUND
        ========================================================= */
        .ambient-bg {
            position: fixed;
            inset: 0;
            z-index: -5;
            pointer-events: none;
            overflow: hidden;
            background:radial-gradient( circle at 10% 10%, rgba(45,90,63,.09), transparent 28% ), radial-gradient( circle at 90% 72%, rgba(211,107,72,.08), transparent 26% ), linear-gradient( 180deg, #fbfaf6 0%, #f4f6ef 48%, #faf8f2 100% );
        }
        .ambient-bg::after {
            content: "";
            position: absolute;
            inset: 0;
            opacity: .2;
            background-image:linear-gradient( rgba(30,58,43,.035) 1px, transparent 1px ), linear-gradient( 90deg, rgba(30,58,43,.035) 1px, transparent 1px );
            background-size: 60px 60px;
            mask-image:linear-gradient( to bottom, black, transparent 80% );
        }
        .ambient-shape {
            position: absolute;
            width: 34vw;
            height: 34vw;
            min-width: 250px;
            min-height: 250px;
            border-radius:48% 52% 65% 35% / 38% 45% 55% 62%;
            filter: blur(3px);
            opacity: .3;
        }
        .shape-a {
            top: -14vw;
            left: -12vw;
            background:radial-gradient( circle at 40% 40%, rgba(82,145,104,.22), transparent 68% );
            animation:driftA 18s ease-in-out infinite alternate;
        }
        .shape-b {
            right: -13vw;
            top: 28vh;
            background:radial-gradient( circle at 45% 45%, rgba(211,107,72,.18), transparent 68% );
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
        /* =========================================================
           NAVIGATION
        ========================================================= */
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
            border-bottom:1px solid rgba(0,0,0,.05);
            transition:padding .45s var(--ease), box-shadow .45s ease, background .45s ease;
        }
        .navbar.scrolled {
            padding-top: 10px;
            padding-bottom: 10px;
            background:rgba(249,248,243,.78);
            box-shadow:0 12px 35px rgba(30,58,43,.08);
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
        .nav-spacer {
            flex: 1;
        }
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
            border-color:var(--border-color);
            transform:translateY(-2px);
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
            background:var(--accent-terracotta);
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
            border:1px solid var(--border-color);
            border-radius: 14px;
            box-shadow:var(--shadow-lg);
            opacity: 0;
            visibility: hidden;
            transform:translateY(-8px) scale(.97);
            transition:.3s var(--ease);
        }
        .dropdown.open {
            opacity: 1;
            visibility: visible;
            transform: none;
        }
        .dropdown a {
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
        .dropdown a:hover {
            background:var(--soft-green);
            color:var(--primary-green);
        }
        /* =========================================================
           SETTINGS PAGE
        ========================================================= */
        .settings-page {
            width: min(1100px, 90%);
            margin: 0 auto;
            padding:120px 0 45px;
        }
        .page-heading {
            margin-bottom: 28px;
        }
        .page-eyebrow {
            display: inline-block;
            padding: 4px 11px;
            border-radius: 20px;
            background:var(--soft-green);
            color:var(--primary-green);
            font-size: .68rem;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform:uppercase;
        }
        .page-heading h1 {
            margin-top: 9px;
            color:var(--primary-dark);
            font-size:clamp(1.7rem,3vw,2.45rem);
            line-height: 1.15;
            font-weight: 800;
        }
        .page-heading p {
            margin-top: 7px;
            color:var(--text-muted);
            font-size: .88rem;
            max-width: 650px;
        }
        /* =========================================================
           SETTINGS GROUP
        ========================================================= */
        .settings-group {
            margin-bottom: 30px;
        }
        .group-heading {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 13px;
        }
        .group-icon {
            width: 39px;
            height: 39px;
            display: grid;
            place-items: center;
            border-radius: 11px;
            background:var(--soft-green);
            color:var(--primary-green);
        }
        .group-heading h2 {
            color:var(--primary-dark);
            font-size: 1.2rem;
            font-weight: 800;
        }
        .group-heading p {
            margin-top: 2px;
            color:var(--text-muted);
            font-size: .72rem;
        }
        .settings-card {
            overflow: hidden;
            background:rgba(255,255,255,.92);
            border:1px solid rgba(228,231,236,.9);
            border-radius: 17px;
            box-shadow:var(--shadow-sm);
        }
        .setting-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 25px;
            padding: 19px 21px;
            border-bottom:1px solid var(--border-color);
            transition:background .3s ease;
        }
        .setting-row:last-child {
            border-bottom: 0;
        }
        .setting-row:hover {
            background:rgba(238,244,240,.38);
        }
        .setting-information {
            min-width: 0;
        }
        .setting-title {
            display: flex;
            align-items: center;
            gap: 8px;
            color:var(--primary-dark);
            font-size: .88rem;
            font-weight: 800;
        }
        .setting-title i {
            color:var(--primary-green);
            font-size: .8rem;
        }
        .setting-description {
            margin-top: 3px;
            color:var(--text-muted);
            font-size: .7rem;
        }
        .setting-current {
            margin-top: 5px;
            color:var(--text-main);
            font-size: .73rem;
            font-weight: 600;
            word-break: break-word;
        }
        .setting-action {
            flex: 0 0 auto;
        }
        /* =========================================================
           BUTTONS
        ========================================================= */
        .btn {
            border: 0;
            border-radius: 9px;
            padding:10px 15px;
            cursor: pointer;
            font-size: .72rem;
            font-weight: 800;
            transition:.3s var(--ease);
        }
        .btn-primary {
            background:var(--primary-dark);
            color: #fff;
        }
        .btn-primary:hover {
            background:var(--primary-green);
            transform:translateY(-2px);
        }
        .btn-green {
            background:var(--soft-green);
            color:var(--primary-green);
        }
        .btn-green:hover {
            background:var(--primary-green);
            color: #fff;
            transform:translateY(-2px);
        }
        .btn-danger {
            background:var(--soft-terracotta);
            color:var(--accent-terracotta);
        }
        .btn-danger:hover {
            background:var(--accent-terracotta);
            color: #fff;
            transform:translateY(-2px);
        }
        .btn-secondary {
            background:#f1f2f4;
            color:var(--text-muted);
        }
        .btn-secondary:hover {
            background:#e5e7eb;
            color:var(--text-main);
        }
        .button-row {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 16px;
        }
        /* =========================================================
           MODAL
        ========================================================= */
        .modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 5000;
            display: grid;
            place-items: center;
            padding: 20px;
            background:rgba(20,35,27,.48);
            backdrop-filter:blur(7px);
            opacity: 0;
            visibility: hidden;
            transition:opacity .3s ease, visibility .3s ease;
        }
        .modal-overlay.open {
            opacity: 1;
            visibility: visible;
        }
        .modal {
            width: min(510px,100%);
            max-height:min(88vh,760px);
            overflow-y: auto;
            background:#fff;
            border:1px solid var(--border-color);
            border-radius: 18px;
            box-shadow:0 25px 70px rgba(30,58,43,.22);
            transform:translateY(20px) scale(.96);
            transition:transform .4s var(--spring);
        }
        .modal-overlay.open .modal {
            transform:translateY(0) scale(1);
        }
        .modal-header {
            position: sticky;
            top: 0;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            padding: 17px 19px;
            background:rgba(255,255,255,.95);
            backdrop-filter:blur(10px);
            border-bottom:1px solid var(--border-color);
        }
        .modal-title-wrap h3 {
            color:var(--primary-dark);
            font-size: 1rem;
            font-weight: 800;
        }
        .modal-title-wrap p {
            margin-top: 2px;
            color:var(--text-muted);
            font-size: .68rem;
        }
        .modal-close {
            width: 34px;
            height: 34px;
            display: grid;
            place-items: center;
            flex: 0 0 auto;
            border: 0;
            border-radius: 9px;
            background:#f5f5f3;
            color:var(--text-muted);
            cursor: pointer;
            transition:.25s ease;
        }
        .modal-close:hover {
            background:var(--soft-terracotta);
            color:var(--accent-terracotta);
        }
        .modal-body {
            padding: 19px;
        }
        /* =========================================================
           FORM
        ========================================================= */
        .form-group {
            margin-bottom: 14px;
        }
        .form-label {
            display: block;
            margin-bottom: 6px;
            color:var(--primary-dark);
            font-size: .73rem;
            font-weight: 800;
        }
        .required {
            color:var(--accent-terracotta);
        }
        .form-control {
            width: 100%;
            min-height: 42px;
            padding:9px 12px;
            border:1px solid var(--border-color);
            border-radius: 10px;
            outline: none;
            background:#fff;
            color:var(--text-main);
            font-size: .76rem;
            transition:border-color .25s ease, box-shadow .25s ease;
        }
        .form-control:focus {
            border-color:rgba(45,90,63,.45);
            box-shadow:0 0 0 3px rgba(45,90,63,.08);
        }
        .form-control:disabled {
            background:#f3f4f3;
            color:#98a19b;
            cursor:not-allowed;
        }
        textarea.form-control {
            min-height: 90px;
            resize: vertical;
        }
        .password-wrap {
            position: relative;
        }
        .password-wrap .form-control {
            padding-right: 43px;
        }
        .password-toggle {
            position: absolute;
            right: 5px;
            top: 5px;
            width: 33px;
            height: 33px;
            border: 0;
            background: transparent;
            color:var(--text-muted);
            cursor: pointer;
            border-radius: 7px;
        }
        .password-toggle:hover {
            background:var(--soft-green);
            color:var(--primary-green);
        }
        .form-help {
            margin-top: 5px;
            color:var(--text-muted);
            font-size: .65rem;
        }
        .character-counter {
            display: flex;
            justify-content: space-between;
            margin-top: 4px;
            color:var(--text-muted);
            font-size: .62rem;
        }
        /* =========================================================
           CONFIRMATION MODAL
        ========================================================= */
        .confirmation-icon {
            width: 55px;
            height: 55px;
            margin: 0 auto 13px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background:var(--soft-terracotta);
            color:var(--accent-terracotta);
            font-size: 1.15rem;
        }
        .confirmation-content {
            text-align: center;
        }
        .confirmation-content h3 {
            color:var(--primary-dark);
            font-size: 1.05rem;
            font-weight: 800;
        }
        .confirmation-content p {
            margin-top: 6px;
            color:var(--text-muted);
            font-size: .75rem;
            line-height: 1.6;
        }
        .confirmation-actions {
            display: grid;
            grid-template-columns:1fr 1fr;
            gap: 8px;
            margin-top: 19px;
        }
        /* =========================================================
           ADDRESS LIST
        ========================================================= */
        .address-list {
            display: flex;
            flex-direction: column;
            gap: 9px;
        }
        .address-item {
            position: relative;
            padding: 14px;
            border:1px solid var(--border-color);
            border-radius: 12px;
            background:#fff;
            transition:.3s var(--ease);
        }
        .address-item:hover {
            border-color:rgba(45,90,63,.25);
            transform:translateY(-2px);
            box-shadow:var(--shadow-sm);
        }
        .address-item.active {
            border-color:rgba(45,90,63,.35);
            background:var(--soft-green);
        }
        .address-item-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }
        .address-name {
            color:var(--primary-dark);
            font-size: .77rem;
            font-weight: 800;
        }
        .active-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            margin-left: 5px;
            padding: 3px 6px;
            border-radius: 20px;
            background:var(--primary-green);
            color: #fff;
            font-size: .55rem;
            font-weight: 800;
        }
        .address-text {
            margin-top: 5px;
            color:var(--text-muted);
            font-size: .68rem;
            line-height: 1.55;
        }
        .address-actions {
            display: flex;
            gap: 6px;
            margin-top: 10px;
        }
        .address-actions button {
            border: 0;
            border-radius: 7px;
            padding: 6px 9px;
            cursor: pointer;
            font-size: .62rem;
            font-weight: 800;
            transition: .25s ease;
        }
        .address-use {
            background:var(--soft-green);
            color:var(--primary-green);
        }
        .address-use:hover {
            background:var(--primary-green);
            color: #fff;
        }
        .address-delete {
            background:var(--soft-terracotta);
            color:var(--accent-terracotta);
        }
        .address-delete:hover {
            background:var(--accent-terracotta);
            color: #fff;
        }
        .empty-address {
            padding: 28px 15px;
            text-align: center;
            color:var(--text-muted);
            font-size: .73rem;
        }
        .empty-address i {
            display: block;
            margin-bottom: 8px;
            font-size: 1.5rem;
            color:#b7c0ba;
        }
        /* =========================================================
           SEARCHABLE SELECT
        ========================================================= */
        .search-select {
            position: relative;
        }
        .search-select-input {
            padding-right: 38px;
        }
        .search-select-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform:translateY(-50%);
            color:var(--text-muted);
            pointer-events: none;
            font-size: .7rem;
        }
        .options-list {
            position: absolute;
            left: 0;
            right: 0;
            top: calc(100% + 5px);
            z-index: 20;
            max-height: 190px;
            overflow-y: auto;
            padding: 5px;
            background:#fff;
            border:1px solid var(--border-color);
            border-radius: 10px;
            box-shadow:var(--shadow-lg);
            opacity: 0;
            visibility: hidden;
            transform:translateY(-5px) scale(.98);
            transition:.22s var(--ease);
        }
        .search-select.open .options-list {
            opacity: 1;
            visibility: visible;
            transform:none;
        }
        .option-item {
            padding:9px 10px;
            border-radius: 7px;
            color:var(--text-main);
            cursor: pointer;
            font-size: .7rem;
        }
        .option-item:hover,
        .option-item.highlighted {
            background:var(--soft-green);
            color:var(--primary-green);
        }
        .no-options {
            padding: 10px;
            color:var(--text-muted);
            text-align: center;
            font-size: .68rem;
        }
        /* =========================================================
           ADDRESS GRID
        ========================================================= */
        .address-grid {
            display: grid;
            grid-template-columns:1fr 1fr;
            gap: 12px;
        }
        .address-grid .full {
            grid-column:1 / -1;
        }
        .loading-text {
            color:var(--text-muted);
            font-size: .62rem;
            margin-top: 4px;
        }
        /* =========================================================
           TOAST
        ========================================================= */
        .toast-container {
            position: fixed;
            right: 22px;
            bottom: 22px;
            z-index: 7000;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        .toast {
            min-width: 250px;
            max-width: 340px;
            padding:13px 15px;
            display: flex;
            align-items: center;
            gap: 10px;
            border-radius: 12px;
            background:var(--primary-dark);
            color: #fff;
            box-shadow:var(--shadow-lg);
            animation:toastIn .45s var(--spring);
            font-size: .78rem;
        }
        .toast i {
            color:#b9d7c0;
        }
        @keyframes toastIn {
            from {
                opacity: 0;
                transform:translateY(20px) scale(.92);
            }
            to {
                opacity: 1;
                transform:none;
            }
        }
        /* =========================================================
           REVEAL ANIMATION
        ========================================================= */
        .reveal {
            opacity: 0;
            transform:translateY(48px) scale(.98);
            filter:blur(5px);
            transition:opacity .75s var(--ease), transform .85s var(--ease), filter .75s var(--ease);
        }
        .reveal.visible {
            opacity: 1;
            transform:none;
            filter:blur(0);
        }
        .stagger > * {
            opacity: 0;
            transform:translateY(25px);
            transition:opacity .6s var(--ease), transform .65s var(--ease);
        }
        .stagger.visible > * {
            opacity: 1;
            transform:none;
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
        /* =========================================================
           CLICK POP
        ========================================================= */
        .click-pop {
            position: fixed;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            pointer-events: none;
            z-index: 9000;
            background:rgba(45,90,63,.45);
            transform:translate(-50%,-50%);
            animation:pop .7s ease-out forwards;
        }
        @keyframes pop {
            0% {
                opacity: .85;
                transform:translate(-50%,-50%) scale(1);
            }
            100% {
                opacity: 0;
                transform:translate(-50%,-50%) scale(8);
            }
        }
        /* =========================================================
           FOOTER
        ========================================================= */
        footer {
            margin-top: 18px;
            padding:38px 5% 18px;
            background:var(--primary-dark);
            color: #fff;
        }
        .footer-grid {
            width:min(1400px,100%);
            margin:0 auto;
            display: grid;
            grid-template-columns:2fr 1fr 1fr 1.3fr;
            gap: 35px;
            padding-bottom: 24px;
            border-bottom:1px solid rgba(255,255,255,.1);
        }
        .footer-brand p {
            max-width: 430px;
            margin-top: 8px;
            color:#a0aec0;
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
            color:#a0aec0;
            text-decoration: none;
            font-size: .76rem;
            transition:.25s ease;
        }
        .footer-links a:hover {
            color: #fff;
        }
        .copyright {
            width:min(1400px,100%);
            margin:0 auto;
            padding-top: 15px;
            text-align: center;
            color:#a0aec0;
            font-size: .72rem;
        }
        /* =========================================================
           RESPONSIVE
        ========================================================= */
        @media (max-width: 900px) {
            .navbar {
                gap: 10px;
            }
            .nav-spacer {
                flex: 1;
            }
            .settings-page {
                width: 92%;
            }
            .footer-grid {
                grid-template-columns:1fr 1fr;
            }
        }
        @media (max-width: 650px) {
            .navbar {
                padding:13px 4%;
            }
            .brand {
                font-size:1.2rem;
            }
            .icon-btn {
                width: 37px;
                height: 37px;
            }
            .settings-page {
                width: 92%;
                padding-top:100px;
            }
            .page-heading {
                margin-bottom:22px;
            }
            .setting-row {
                align-items:flex-start;
                flex-direction:column;
                gap: 12px;
                padding:16px;
            }
            .setting-action {
                width: 100%;
            }
            .setting-action .btn {
                width: 100%;
            }
            .address-grid {
                grid-template-columns:1fr;
            }
            .address-grid .full {
                grid-column:auto;
            }
            .modal-overlay {
                padding:12px;
            }
            .modal {
                max-height:92vh;
                border-radius:15px;
            }
            .modal-body {
                padding:15px;
            }
            .confirmation-actions {
                grid-template-columns:1fr;
                }
            .footer-grid {
                grid-template-columns:1fr 1fr;
                gap:22px;
            }
            .footer-brand {
                grid-column:1 / -1;
            }
            .toast-container {
                left: 14px;
                right: 14px;
                bottom: 14px;
            }
            .toast {
                min-width:0;
                width:100%;
            }
        }
        @media (max-width: 430px) {
            .footer-grid {
                grid-template-columns:1fr;
            }
            .footer-brand {
                grid-column:auto;
            }
            .page-heading h1 {
                font-size:1.65rem;
            }
        }
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration:.001ms !important;
                animation-iteration-count:1 !important;
                transition-duration:.001ms !important;
                scroll-behavior:auto !important;
            }
            .reveal,
            .stagger > * {
                opacity: 1;
                transform:none;
                filter:none;
            }
        }
    
        .status-alert {
            margin: 0 0 20px;
            padding: 13px 16px;
            border: 1px solid rgba(45,90,63,.18);
            border-radius: 11px;
            background: var(--soft-green);
            color: var(--primary-green);
            font-size: .78rem;
            font-weight: 700;
        }
        .validation-alert {
            margin: 0 0 20px;
            padding: 13px 16px;
            border: 1px solid rgba(211,107,72,.25);
            border-radius: 11px;
            background: var(--soft-terracotta);
            color: var(--accent-terracotta);
            font-size: .76rem;
        }
        .field-error {
            display: block;
            margin-top: 5px;
            color: var(--accent-terracotta);
            font-size: .67rem;
            font-weight: 700;
        }
        .modal-form { margin: 0; }

    
        .dropdown form { margin: 0; }
        .dropdown-logout {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 12px;
            border: 0;
            background: transparent;
            color: var(--text-main);
            border-radius: 9px;
            cursor: pointer;
            text-align: left;
            font-size: .88rem;
        }
        .dropdown-logout:hover {
            background: var(--soft-green);
            color: var(--primary-green);
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

        <div class="nav-spacer"></div>

        <div class="nav-actions">
            <button type="button" class="icon-btn" title="Notifications"
                onclick="showToast('You have no new notifications.')">
                <i class="fa-regular fa-bell"></i>
                <span class="badge">2</span>
            </button>

            <button type="button" class="icon-btn" title="Shopping Cart"
                onclick="showToast('Your cart is ready.')">
                <i class="fa-solid fa-cart-shopping"></i>
                <span class="badge">0</span>
            </button>

            <div class="dropdown-wrap">
                <button type="button" class="icon-btn" id="profileButton" title="Profile">
                    <i class="fa-regular fa-user"></i>
                </button>

                <div class="dropdown" id="profileMenu">
                    <a href="#"><i class="fa-regular fa-user"></i>Profile</a>
                    <a href="{{ route('orders') }}"><i class="fa-solid fa-box"></i>My Orders</a>
                    <a href="{{ route('settings') }}"><i class="fa-solid fa-gear"></i>Settings</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-logout">
                            <i class="fa-solid fa-right-from-bracket"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="settings-page">
        <header class="page-heading reveal">
            <span class="page-eyebrow">Account & Marketplace</span>
            <h1>Settings</h1>
            <p>
                Manage your account information and the details displayed
                on your AgriMarket marketplace profile.
            </p>
        </header>

        @if (session('status'))
            <div class="status-alert reveal" role="status">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="validation-alert reveal" role="alert">
                <strong>Please correct the following:</strong>
                <ul style="margin:7px 0 0 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- ACCOUNT SETTINGS -->
        <section class="settings-group reveal">
            <div class="group-heading">
                <div class="group-icon"><i class="fa-solid fa-shield-halved"></i></div>
                <div>
                    <h2>Account Settings</h2>
                    <p>Manage the email address associated with your account.</p>
                </div>
            </div>

            <div class="settings-card stagger">
                <div class="setting-row">
                    <div class="setting-information">
                        <div class="setting-title"><i class="fa-solid fa-envelope"></i>Email</div>
                        <div class="setting-description">Change the email address associated with your account.</div>
                        <div class="setting-current">{{ $user->email }}</div>
                    </div>
                    <div class="setting-action">
                        <button type="button" class="btn btn-primary" onclick="openModal('emailModal')">
                            Change Email
                        </button>
                    </div>
                </div>

                <div class="setting-row">
                    <div class="setting-information">
                        <div class="setting-title"><i class="fa-solid fa-lock"></i>Password</div>
                        <div class="setting-description">Update your account password.</div>
                    </div>
                    <div class="setting-action">
                        <button type="button" class="btn btn-primary" onclick="openModal('passwordModal')">
                            Change Password
                        </button>
                    </div>
                </div>

                <div class="setting-row">
                    <div class="setting-information">
                        <div class="setting-title"><i class="fa-solid fa-at"></i>Username</div>
                        <div class="setting-description">Change the username used for your account.</div>
                        <div class="setting-current" id="nameDisplay">{{ $user->name }}</div>
                    </div>
                    <div class="setting-action">
                        <button type="button" class="btn btn-primary" onclick="openModal('nameModal')">
                            Change Username
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- MARKETPLACE / PROFILE SETTINGS -->
        <section class="settings-group reveal">
            <div class="group-heading">
                <div class="group-icon"><i class="fa-solid fa-store"></i></div>
                <div>
                    <h2>Marketplace / Profile Information</h2>
                    <p>Manage information that may appear on your marketplace profile.</p>
                </div>
            </div>

            <div class="settings-card stagger">

                <div class="setting-row">
                    <div class="setting-information">
                        <div class="setting-title"><i class="fa-solid fa-id-card"></i>Real Name</div>
                        <div class="setting-description">Manage your real name for your account information.</div>
                        <div class="setting-current" id="realNameDisplay">
                            {{ $user->real_name ?: 'No real name added.' }}
                        </div>
                    </div>
                    <div class="setting-action">
                        <button type="button" class="btn btn-primary" onclick="openModal('realNameModal')">
                            Edit Real Name
                        </button>
                    </div>
                </div>

                <div class="setting-row">
                    <div class="setting-information">
                        <div class="setting-title"><i class="fa-regular fa-pen-to-square"></i>Bio</div>
                        <div class="setting-description">Add a short description about yourself or your marketplace activity.</div>
                        <div class="setting-current" id="bioDisplay">
                            {{ $user->bio ?: 'No bio added yet.' }}
                        </div>
                    </div>
                    <div class="setting-action">
                        <button type="button" class="btn btn-green" onclick="openModal('bioModal')">
                            Edit Bio
                        </button>
                    </div>
                </div>

                <div class="setting-row">
                    <div class="setting-information">
                        <div class="setting-title"><i class="fa-solid fa-phone"></i>Contact Number</div>
                        <div class="setting-description">Manage the contact number used for marketplace communication.</div>
                        <div class="setting-current" id="contactDisplay">
                            {{ $user->phone ?: 'No contact number added.' }}
                        </div>
                    </div>
                    <div class="setting-action">
                        <button type="button" class="btn btn-primary" onclick="openModal('phoneModal')">
                            Change Contact
                        </button>
                    </div>
                </div>

                <!-- ADDRESS -->
                <div class="setting-row">
                    <div class="setting-information">
                        <div class="setting-title">
                            <i class="fa-solid fa-location-dot"></i>
                            Address
                        </div>
                        <div class="setting-description">
                            Manage your saved marketplace addresses.
                        </div>
                        <div
                            class="setting-current"
                            id="addressDisplay"
                        >
                            No active address selected.
                        </div>
                    </div>
                    <div class="setting-action">
                        <button
                            class="btn btn-green"
                            onclick="openAddressModal()"
                        >
                            Manage Addresses
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <div class="setting-action" style="display:flex;justify-content:flex-end;margin-top:8px;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger">
                    <i class="fa-solid fa-right-from-bracket"></i> Sign Out
                </button>
            </form>
        </div>
    </main>

    <!-- FOOTER -->
    <footer>
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="{{ route('shop') }}" class="brand" style="color:#fff">
                    <i class="fa-solid fa-leaf"></i><span>agrimarket</span>
                </a>
                <p>
                    A modern agricultural marketplace connecting buyers and sellers
                    of farm products, supplies and services.
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
                    <li><a href="{{ route('shop') }}">Shop</a></li>
                    <li><a href="{{ route('orders') }}">My Orders</a></li>
                </ul>
            </div>
        </div>

        <div class="copyright">© 2026 AgriMarket. All rights reserved.</div>
    </footer>

    <!-- EMAIL MODAL -->
    <div class="modal-overlay" id="emailModal">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title-wrap">
                    <h3>Change Email</h3>
                    <p>Update the email address associated with your account.</p>
                </div>
                <button type="button" class="modal-close" onclick="closeModal('emailModal')">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="modal-form" id="emailForm" method="POST" action="{{ route('settings.update-email') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="email">Email Address <span class="required">*</span></label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email', $user->email) }}" maxlength="255" required>
                        @error('email')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="email_current_password">Current Password <span class="required">*</span></label>
                        <input type="password" class="form-control" id="email_current_password"
                            name="email_current_password" autocomplete="current-password" required>
                        @error('email_current_password')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="button-row">
                        <button type="button" class="btn btn-secondary" onclick="closeModal('emailModal')">Cancel</button>
                        <button type="button" class="btn btn-primary"
                            onclick="confirmForm('emailForm', 'Confirm Email Change', 'Are you sure you want to update your email address?')">
                            Save Email
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- PASSWORD MODAL -->
    <div class="modal-overlay" id="passwordModal">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title-wrap">
                    <h3>Change Password</h3>
                    <p>Enter your current password and choose a new password.</p>
                </div>
                <button type="button" class="modal-close" onclick="closeModal('passwordModal')">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="modal-form" id="passwordForm" method="POST" action="{{ route('settings.update-password') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="current_password">Current / Old Password <span class="required">*</span></label>
                        <input type="password" class="form-control" id="current_password" name="current_password"
                            autocomplete="current-password" required>
                        @error('current_password')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password">New Password <span class="required">*</span></label>
                        <input type="password" class="form-control" id="password" name="password"
                            autocomplete="new-password" minlength="8" required>
                        @error('password')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">Confirm New Password <span class="required">*</span></label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                            autocomplete="new-password" minlength="8" required>
                    </div>
                    <div class="button-row">
                        <button type="button" class="btn btn-secondary" onclick="closeModal('passwordModal')">Cancel</button>
                        <button type="button" class="btn btn-primary"
                            onclick="confirmForm('passwordForm', 'Confirm Password Change', 'Are you sure you want to change your account password?')">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- USERNAME MODAL (users.name) -->
    <div class="modal-overlay" id="nameModal">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title-wrap">
                    <h3>Change Username</h3>
                    <p>Update the username used for your account.</p>
                </div>
                <button type="button" class="modal-close" onclick="closeModal('nameModal')">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="modal-form" id="nameForm" method="POST" action="{{ route('settings.update-name') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="name">Username <span class="required">*</span></label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="{{ old('name', $user->name) }}" maxlength="20" minlength="5" required>
                        @error('name')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="button-row">
                        <button type="button" class="btn btn-secondary" onclick="closeModal('nameModal')">Cancel</button>
                        <button type="button" class="btn btn-primary"
                            onclick="confirmForm('nameForm', 'Confirm Username Change', 'Your username will also be synchronized with your buyer records in transactions and order requests. Continue?')">
                            Save Username
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- REAL NAME MODAL -->
    <div class="modal-overlay" id="realNameModal">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title-wrap">
                    <h3>Edit Real Name</h3>
                    <p>Update your real name saved in your account.</p>
                </div>
                <button type="button" class="modal-close" onclick="closeModal('realNameModal')">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="modal-form" id="realNameForm" method="POST" action="{{ route('settings.update-real-name') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="real_name">Real Name</label>
                        <input type="text" class="form-control" id="real_name" name="real_name"
                            oninput="this.value = this.value.replace(/[0-9]/g, '')"
                            value="{{ old('real_name', $user->real_name) }}" maxlength="100">
                        @error('real_name')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="button-row">
                        <button type="button" class="btn btn-secondary" onclick="closeModal('realNameModal')">Cancel</button>
                        <button type="button" class="btn btn-primary"
                            onclick="confirmForm('realNameForm', 'Confirm Real Name Change', 'Save the updated real name to your account?')">
                            Save Real Name
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- BIO MODAL -->
    <div class="modal-overlay" id="bioModal">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title-wrap">
                    <h3>Edit Bio</h3>
                    <p>Add a short description to your marketplace profile.</p>
                </div>
                <button type="button" class="modal-close" onclick="closeModal('bioModal')">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="modal-form" id="bioForm" method="POST" action="{{ route('settings.update-bio') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="bio">Bio</label>
                        <textarea class="form-control" id="bio" name="bio" maxlength="300"
                            placeholder="Tell buyers and sellers a little about yourself..."
                            oninput="updateBioCounter()">{{ old('bio', $user->bio) }}</textarea>
                        <div class="character-counter">
                            <span>Maximum 300 characters</span>
                            <span id="bioCounter">0 / 300</span>
                        </div>
                        @error('bio')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="button-row">
                        <button type="button" class="btn btn-secondary" onclick="closeModal('bioModal')">Cancel</button>
                        <button type="button" class="btn btn-green"
                            onclick="confirmForm('bioForm', 'Save Bio', 'Save the updated bio to your profile?')">
                            Save Bio
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- PHONE MODAL -->
    <div class="modal-overlay" id="phoneModal">
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title-wrap">
                    <h3>Change Contact Number</h3>
                    <p>Update the contact number used on your profile.</p>
                </div>
                <button type="button" class="modal-close" onclick="closeModal('phoneModal')">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <form class="modal-form" id="phoneForm" method="POST" action="{{ route('settings.update-phone') }}">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="phone">Contact Number</label>
                        <input type="tel" class="form-control" id="phone" name="phone"
                            value="{{ old('phone', $user->phone) }}" maxlength="11" minlength="11"
                            pattern="09[0-9]{9}" inputmode="numeric" 
                            title="Contact number must start with 09 and contain exactly 11 digits."
                            placeholder="09XX XXX XXXX">
                            
                        @error('phone')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="button-row">
                        <button type="button" class="btn btn-secondary" onclick="closeModal('phoneModal')">Cancel</button>
                        <button type="button" class="btn btn-primary"
                            onclick="confirmForm('phoneForm', 'Confirm Contact Number Change', 'Save the updated contact number to your account?')">
                            Save Contact
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- =========================================================
         ADDRESS LIST MODAL
    ========================================================= -->
    <div
        class="modal-overlay"
        id="addressModal"
    >
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title-wrap">
                    <h3>
                        Saved Addresses
                    </h3>
                    <p>
                        Select, add, or delete your marketplace addresses.
                    </p>
                </div>
                <button
                    class="modal-close"
                    onclick="closeModal('addressModal')"
                >
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="character-counter" style="margin:0 0 12px;">
                    <span>Saved addresses</span>
                    <strong id="savedAddressCount">0/3</strong>
                </div>
                <div
                    class="address-list"
                    id="addressList"
                ></div>
                <div class="button-row">
                    <button
                        type="button"
                        class="btn btn-green"
                        id="addAddressButton"
                        onclick="openNewAddressModal()"
                    >
                        <i class="fa-solid fa-plus"></i>
                        Add New Address
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- =========================================================
         ADD ADDRESS MODAL
    ========================================================= -->
    <div
        class="modal-overlay"
        id="newAddressModal"
    >
        <div class="modal">
            <div class="modal-header">
                <div class="modal-title-wrap">
                    <h3>
                        Add New Address
                    </h3>
                    <p>
                        Select your Philippine location in order.
                    </p>
                </div>
                <button
                    class="modal-close"
                    onclick="closeModal('newAddressModal')"
                >
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="address-grid">
                    <!-- REGION -->
                    <div class="form-group full">
                        <label class="form-label">
                            Region
                            <span class="required">*</span>
                        </label>
                        <div
                            class="search-select"
                            id="regionSelect"
                        >
                            <input
                                type="text"
                                class="form-control search-select-input"
                                id="regionInput"
                                placeholder="Search or select region"
                                autocomplete="off"
                            >
                            <i
                                class="fa-solid fa-chevron-down search-select-icon"
                            ></i>
                            <div
                                class="options-list"
                                id="regionOptions"
                            ></div>
                        </div>
                    </div>
                    <!-- PROVINCE -->
                    <div class="form-group full">
                        <label class="form-label">
                            Province
                            <span class="required">*</span>
                        </label>
                        <div
                            class="search-select"
                            id="provinceSelect"
                        >
                            <input
                                type="text"
                                class="form-control search-select-input"
                                id="provinceInput"
                                placeholder="Select a region first"
                                autocomplete="off"
                                disabled
                            >
                            <i
                                class="fa-solid fa-chevron-down search-select-icon"
                            ></i>
                            <div
                                class="options-list"
                                id="provinceOptions"
                            ></div>
                        </div>
                    </div>
                    <!-- CITY / MUNICIPALITY -->
                    <div class="form-group full">
                        <label class="form-label">
                            City / Municipality
                            <span class="required">*</span>
                        </label>
                        <div
                            class="search-select"
                            id="citySelect"
                        >
                            <input
                                type="text"
                                class="form-control search-select-input"
                                id="cityInput"
                                placeholder="Select a province first"
                                autocomplete="off"
                                disabled
                            >
                            <i
                                class="fa-solid fa-chevron-down search-select-icon"
                            ></i>
                            <div
                                class="options-list"
                                id="cityOptions"
                            ></div>
                        </div>
                    </div>
                    <!-- BARANGAY -->
                    <div class="form-group full">
                        <label class="form-label">
                            Barangay
                            <span class="required">*</span>
                        </label>
                        <div
                            class="search-select"
                            id="barangaySelect"
                        >
                            <input
                                type="text"
                                class="form-control search-select-input"
                                id="barangayInput"
                                placeholder="Select a city/municipality first"
                                autocomplete="off"
                                disabled
                            >
                            <i
                                class="fa-solid fa-chevron-down search-select-icon"
                            ></i>
                            <div
                                class="options-list"
                                id="barangayOptions"
                            ></div>
                        </div>
                    </div>
                    <!-- ADDITIONAL ADDRESS -->
                    <div class="form-group full">
                        <label class="form-label">
                            Additional Address Information
                        </label>
                        <textarea
                            class="form-control"
                            id="additionalAddress"
                            maxlength="100"
                            placeholder="e.g. Near the barangay hall, beside the small store."
                            oninput="updateAddressCounter()"
                        ></textarea>
                        <div class="character-counter">
                            <span>
                                Maximum 100 characters
                            </span>
                            <span id="addressCounter">
                                0 / 100
                            </span>
                        </div>
                    </div>
                </div>
                <div class="button-row">
                    <button
                        class="btn btn-secondary"
                        onclick="closeModal('newAddressModal')"
                    >
                        Cancel
                    </button>
                    <button
                        class="btn btn-green"
                        onclick="saveNewAddress()"
                    >
                        Save Address
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- CONFIRMATION MODAL -->
    <div class="modal-overlay" id="confirmationModal">
        <div class="modal">
            <div class="modal-body">
                <div class="confirmation-icon"><i class="fa-solid fa-circle-exclamation"></i></div>
                <div class="confirmation-content">
                    <h3 id="confirmationTitle">Are you sure?</h3>
                    <p id="confirmationMessage">Please confirm this change.</p>
                </div>
                <div class="confirmation-actions">
                    <button type="button" class="btn btn-secondary" onclick="cancelConfirmation()">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="executeConfirmation()">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <div class="toast-container" id="toastContainer"></div>

    <script>
        const profileButton = document.getElementById("profileButton");
        const profileMenu = document.getElementById("profileMenu");

        profileButton.addEventListener("click", event => {
            event.stopPropagation();
            profileMenu.classList.toggle("open");
        });

        document.addEventListener("click", () => profileMenu.classList.remove("open"));

        window.addEventListener("scroll", () => {
            document.getElementById("navbar").classList.toggle("scrolled", window.scrollY > 25);
        }, { passive: true });

        function openModal(id) {
            const modal = document.getElementById(id);
            if (!modal) return;
            modal.classList.add("open");
            document.body.style.overflow = "hidden";
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            if (!modal) return;
            modal.classList.remove("open");
            if (!document.querySelector(".modal-overlay.open")) {
                document.body.style.overflow = "";
            }
        }

        document.querySelectorAll(".modal-overlay").forEach(overlay => {
            overlay.addEventListener("click", event => {
                if (event.target === overlay) closeModal(overlay.id);
            });
        });

        let confirmationCallback = null;

        function askConfirmation(title, message, callback) {
            document.getElementById("confirmationTitle").textContent = title;
            document.getElementById("confirmationMessage").textContent = message;
            confirmationCallback = callback;
            openModal("confirmationModal");
        }

        function cancelConfirmation() {
            confirmationCallback = null;
            closeModal("confirmationModal");
        }

        function executeConfirmation() {
            if (typeof confirmationCallback !== "function") return;
            const callback = confirmationCallback;
            confirmationCallback = null;
            closeModal("confirmationModal");
            callback();
        }

        function confirmForm(formId, title, message) {
            askConfirmation(title, message, () => {
                const form = document.getElementById(formId);
                if (form) form.submit();
            });
        }

        function escapeHTML(value) {
            return String(value)
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }

        const PSGC_MODULE_URL = "https://cdn.jsdelivr.net/npm/@ianlabicani/geoph-lite@2.0.0/+esm";
        let psgcModulePromise = null;
        let selectedRegion = null;
        let selectedProvince = null;
        let selectedCity = null;
        let selectedBarangay = null;
        let regionData = [];
        let provinceData = [];
        let cityData = [];
        let barangayData = [];
        let addressLoadToken = 0;
        let addresses = @json($savedAddresses);
        const addressRoutes = {
            store: @json(route('settings.addresses.store')),
            select: @json(route('settings.addresses.select', ['slot' => '__SLOT__'])),
            delete: @json(route('settings.addresses.delete', ['slot' => '__SLOT__']))
        };
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        async function getPSGC() {
            if (!psgcModulePromise) {
                psgcModulePromise = import(PSGC_MODULE_URL);
            }
            return psgcModulePromise;
        }
        /* =========================================================
           ADDRESS MODAL
        ========================================================= */
        function openAddressModal() {
            renderAddresses();
            openModal("addressModal");
        }

        function updateSavedAddressCount() {
            const count = addresses.length;
            document.getElementById("savedAddressCount").textContent = `${count}/3`;

            const addButton = document.getElementById("addAddressButton");
            addButton.disabled = count >= 3;
            addButton.style.opacity = count >= 3 ? ".55" : "1";
            addButton.style.cursor = count >= 3 ? "not-allowed" : "pointer";
            addButton.title = count >= 3 ? "You can save a maximum of 3 addresses." : "";
        }

        function renderAddresses() {
            const container = document.getElementById("addressList");

            if (!addresses.length) {
                container.innerHTML = `
                    <div class="empty-address">
                        <i class="fa-solid fa-location-dot"></i>
                        No saved addresses yet.
                    </div>
                `;
                updateActiveAddressDisplay();
                updateSavedAddressCount();
                return;
            }

            container.innerHTML = addresses.map(address => {
                const active = address.active;
                const title = address.address.split(",")[0];

                return `
                    <div class="address-item ${active ? "active" : ""}">
                        <div class="address-item-header">
                            <div>
                                <div class="address-name">
                                    <i class="fa-solid fa-location-dot"></i>
                                    ${escapeHTML(title)}
                                    ${active ? `
                                        <span class="active-badge">
                                            <i class="fa-solid fa-check"></i>
                                            Active
                                        </span>
                                    ` : ""}
                                </div>
                                <div class="address-text">
                                    ${escapeHTML(address.address)}
                                </div>
                            </div>
                        </div>
                        <div class="address-actions">
                            ${!active ? `
                                <button class="address-use" onclick="selectAddress('${address.slot}')">
                                    <i class="fa-solid fa-check"></i>
                                    Use
                                </button>
                            ` : `
                                <button class="address-use" disabled style="opacity:.55;cursor:default">
                                    <i class="fa-solid fa-check"></i>
                                    Current
                                </button>
                            `}
                            <button
                                class="address-delete"
                                onclick="deleteAddress('${address.slot}')"
                                ${active ? 'disabled title="Switch to another address before deleting this one." style="opacity:.45;cursor:not-allowed"' : ""}
                            >
                                <i class="fa-solid fa-trash"></i>
                                Delete
                            </button>
                        </div>
                    </div>
                `;
            }).join("");

            updateActiveAddressDisplay();
            updateSavedAddressCount();
        }

        async function sendAddressRequest(url, method, body = null) {
            const options = {
                method,
                headers: {
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    "X-Requested-With": "XMLHttpRequest"
                }
            };

            if (body) {
                options.headers["Content-Type"] = "application/json";
                options.body = JSON.stringify(body);
            }

            const response = await fetch(url, options);
            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || "Unable to update your saved addresses.");
            }

            return data;
        }

        async function selectAddress(slot) {
            try {
                const url = addressRoutes.select.replace("__SLOT__", encodeURIComponent(slot));
                const result = await sendAddressRequest(url, "PATCH");

                addresses = addresses.map(address => ({
                    ...address,
                    active: address.slot === slot
                }));

                renderAddresses();
                showToast(result.message);
            } catch (error) {
                showToast(error.message);
            }
        }

        function deleteAddress(slot) {
            const address = addresses.find(item => item.slot === slot);
            if (!address) return;

            if (address.active) {
                showToast("Switch to another address before deleting this one.");
                return;
            }

            if (addresses.length <= 1) {
                showToast("At least one saved address must remain.");
                return;
            }

            askConfirmation(
                "Delete Saved Address",
                "Are you sure you want to delete this saved address?",
                async () => {
                    try {
                        const url = addressRoutes.delete.replace("__SLOT__", encodeURIComponent(slot));
                        const result = await sendAddressRequest(url, "DELETE");

                        addresses = addresses.filter(item => item.slot !== slot);
                        renderAddresses();
                        showToast(result.message);
                    } catch (error) {
                        showToast(error.message);
                    }
                }
            );
        }

        function updateActiveAddressDisplay() {
            const active = addresses.find(address => address.active);
            const display = document.getElementById("addressDisplay");

            display.textContent = active
                ? active.address
                : "No active address selected.";
        }

        /* =========================================================
           NEW ADDRESS MODAL
        ========================================================= */
        function openNewAddressModal() {
            if (addresses.length >= 3) {
                showToast("You can save a maximum of 3 addresses.");
                return;
            }

            closeModal("addressModal");
            resetAddressForm();
            openModal("newAddressModal");
            loadRegions();
        }
        function resetAddressForm() {
            addressLoadToken++;
            selectedRegion = null;
            selectedProvince = null;
            selectedCity = null;
            selectedBarangay = null;
            regionData = [];
            provinceData = [];
            cityData = [];
            barangayData = [];
            const region = document.getElementById("regionInput");
            const province = document.getElementById("provinceInput");
            const city = document.getElementById("cityInput");
            const barangay = document.getElementById("barangayInput");
            region.value = "";
            province.value = "";
            city.value = "";
            barangay.value = "";
            document.getElementById("additionalAddress").value = "";
            region.disabled = false;
            province.disabled = true;
            city.disabled = true;
            barangay.disabled = true;
            region.placeholder = "Search or select region";
            province.placeholder = "Select a region first";
            city.placeholder = "Select a province first";
            barangay.placeholder = "Select a city/municipality first";
            ["regionSelect","provinceSelect","citySelect","barangaySelect"]
                .forEach(id => document.getElementById(id).classList.remove("open"));
            updateAddressCounter();
        }
        /* =========================================================
           COMPLETE PSGC DATA LOADERS
        ========================================================= */
        function normalizeLocation(item) {
            return {
                code: String(item.psgc_code ?? item.code ?? ""),
                name: String(item.name ?? item.regionName ?? item.provinceName ??
                    item.cityName ?? item.municipalityName ?? item.barangayName ?? "")
            };
        }
        async function loadRegions() {
            const options = document.getElementById("regionOptions");
            options.innerHTML = `<div class="no-options">Loading regions...</div>`;
            try {
                const { philippines } = await getPSGC();
                regionData = philippines.regions()
                    .map(normalizeLocation)
                    .filter(item => item.code && item.name);
                renderRegionOptions(regionData);
            } catch (error) {
                regionData = [];
                options.innerHTML = `
                    <div class="no-options">
                        Unable to load Philippine location data.
                    </div>
                `;
            }
        }
        async function loadProvinces(regionCode) {
            const input = document.getElementById("provinceInput");
            const token = ++addressLoadToken;
            input.disabled = true;
            input.placeholder = "Loading provinces...";
            try {
                const { philippines } = await getPSGC();
                const data = await philippines.provinces(String(regionCode));
                if (token !== addressLoadToken) return;
                provinceData = data
                    .map(normalizeLocation)
                    .filter(item => item.code && item.name);
                input.disabled = false;
                input.placeholder = "Search or select province";
                renderSearchOptions(
                    provinceData,
                    input.value,
                    document.getElementById("provinceOptions"),
                    selectProvince
                );
            } catch (error) {
                if (token !== addressLoadToken) return;
                provinceData = [];
                input.disabled = false;
                input.placeholder = "Search or select province";
                document.getElementById("provinceOptions").innerHTML = `
                    <div class="no-options">
                        No provinces found for this region.
                    </div>
                `;
            }
        }
        async function loadCities(parentCode) {
            const input = document.getElementById("cityInput");
            const token = ++addressLoadToken;
            input.disabled = true;
            input.placeholder = "Loading cities/municipalities...";
            try {
                const { philippines } = await getPSGC();
                const data = await philippines.localities(String(parentCode));
                if (token !== addressLoadToken) return;
                cityData = data
                    .map(item => ({
                        code: String(item.psgc_code ?? item.code ?? ""),
                        name: String(item.name ?? "")
                    }))
                    .filter(item => item.code && item.name);
                input.disabled = false;
                input.placeholder = "Search or select city/municipality";
                renderSearchOptions(
                    cityData,
                    input.value,
                    document.getElementById("cityOptions"),
                    selectCity
                );
            } catch (error) {
                if (token !== addressLoadToken) return;
                cityData = [];
                input.disabled = false;
                input.placeholder = "Search or select city/municipality";
                document.getElementById("cityOptions").innerHTML = `
                    <div class="no-options">
                        No cities/municipalities found for this province.
                    </div>
                `;
            }
        }
        async function loadBarangays(cityCode) {
            const input = document.getElementById("barangayInput");
            const token = ++addressLoadToken;
            input.disabled = true;
            input.placeholder = "Loading barangays...";
            try {
                const { philippines } = await getPSGC();
                const data = await philippines.barangays(String(cityCode));
                if (token !== addressLoadToken) return;
                barangayData = data
                    .map(normalizeLocation)
                    .filter(item => item.code && item.name);
                input.disabled = false;
                input.placeholder = "Search or select barangay";
                renderSearchOptions(
                    barangayData,
                    input.value,
                    document.getElementById("barangayOptions"),
                    selectBarangay
                );
            } catch (error) {
                if (token !== addressLoadToken) return;
                barangayData = [];
                input.disabled = false;
                input.placeholder = "Search or select barangay";
                document.getElementById("barangayOptions").innerHTML = `
                    <div class="no-options">
                        No barangays found for this city/municipality.
                    </div>
                `;
            }
        }
        /* =========================================================
           SEARCHABLE DROPDOWN
        ========================================================= */
        function setupSearchSelect(inputId, selectId, optionsId, getData, onSelect) {
            const input = document.getElementById(inputId);
            const select = document.getElementById(selectId);
            const options = document.getElementById(optionsId);
            input.addEventListener("focus", () => {
                if (input.disabled) return;
                renderSearchOptions(getData(), input.value, options, onSelect);
                select.classList.add("open");
            });
            input.addEventListener("input", () => {
                if (input.disabled) return;
                renderSearchOptions(getData(), input.value, options, onSelect);
                select.classList.add("open");
            });
            input.addEventListener("keydown", event => {
                if (event.key === "Escape") {
                    select.classList.remove("open");
                }
            });
        }
        function renderSearchOptions(data, search, container, onSelect) {
            const query = search.trim().toLowerCase();
            const filtered = data
                .filter(item => item.name.toLowerCase().includes(query))
                .slice(0, 100);
            if (!filtered.length) {
                container.innerHTML = `
                    <div class="no-options">
                        ${data.length ? "No matching options found." : "No options available."}
                    </div>
                `;
                return;
            }
            container.innerHTML = filtered.map(item => `
                <div class="option-item" data-code="${escapeHTML(item.code)}">
                    ${escapeHTML(item.name)}
                </div>
            `).join("");
            container.querySelectorAll(".option-item").forEach(option => {
                option.addEventListener("click", () => {
                    const item = filtered.find(record =>
                        String(record.code) === option.dataset.code
                    );
                    if (item) onSelect(item);
                });
            });
        }
        function renderRegionOptions(data) {
            renderSearchOptions(
                data,
                document.getElementById("regionInput").value,
                document.getElementById("regionOptions"),
                selectRegion
            );
        }
        /* =========================================================
           CASCADING SELECTIONS
        ========================================================= */
        function selectRegion(region) {
            addressLoadToken++;
            selectedRegion = region;
            selectedProvince = null;
            selectedCity = null;
            selectedBarangay = null;
            document.getElementById("regionInput").value = region.name;
            document.getElementById("regionSelect").classList.remove("open");
            resetDependentFields("province");
            loadProvinces(region.code);
        }
        function selectProvince(province) {
            addressLoadToken++;
            selectedProvince = province;
            selectedCity = null;
            selectedBarangay = null;
            document.getElementById("provinceInput").value = province.name;
            document.getElementById("provinceSelect").classList.remove("open");
            resetDependentFields("city");
            loadCities(province.code);
        }
        function selectCity(city) {
            addressLoadToken++;
            selectedCity = city;
            selectedBarangay = null;
            document.getElementById("cityInput").value = city.name;
            document.getElementById("citySelect").classList.remove("open");
            resetDependentFields("barangay");
            loadBarangays(city.code);
        }
        function selectBarangay(barangay) {
            selectedBarangay = barangay;
            document.getElementById("barangayInput").value = barangay.name;
            document.getElementById("barangaySelect").classList.remove("open");
        }
        /* =========================================================
           RESET DEPENDENT FIELDS
        ========================================================= */
        function resetDependentFields(level) {
            if (level === "province") {
                provinceData = [];
                cityData = [];
                barangayData = [];
                document.getElementById("provinceInput").value = "";
                document.getElementById("cityInput").value = "";
                document.getElementById("barangayInput").value = "";
                document.getElementById("provinceInput").disabled = true;
                document.getElementById("cityInput").disabled = true;
                document.getElementById("barangayInput").disabled = true;
                document.getElementById("provinceInput").placeholder = "Loading provinces...";
                document.getElementById("cityInput").placeholder = "Select a province first";
                document.getElementById("barangayInput").placeholder = "Select a city/municipality first";
            }
            if (level === "city") {
                cityData = [];
                barangayData = [];
                document.getElementById("cityInput").value = "";
                document.getElementById("barangayInput").value = "";
                document.getElementById("cityInput").disabled = true;
                document.getElementById("barangayInput").disabled = true;
                document.getElementById("cityInput").placeholder = "Loading cities/municipalities...";
                document.getElementById("barangayInput").placeholder = "Select a city/municipality first";
            }
            if (level === "barangay") {
                barangayData = [];
                document.getElementById("barangayInput").value = "";
                document.getElementById("barangayInput").disabled = true;
                document.getElementById("barangayInput").placeholder = "Loading barangays...";
            }
        }
        setupSearchSelect(
            "regionInput",
            "regionSelect",
            "regionOptions",
            () => regionData,
            selectRegion
        );
        setupSearchSelect(
            "provinceInput",
            "provinceSelect",
            "provinceOptions",
            () => provinceData,
            selectProvince
        );
        setupSearchSelect(
            "cityInput",
            "citySelect",
            "cityOptions",
            () => cityData,
            selectCity
        );
        setupSearchSelect(
            "barangayInput",
            "barangaySelect",
            "barangayOptions",
            () => barangayData,
            selectBarangay
        );
        document.addEventListener("click", event => {
            ["regionSelect","provinceSelect","citySelect","barangaySelect"].forEach(id => {
                const element = document.getElementById(id);
                if (!element.contains(event.target)) element.classList.remove("open");
            });
        });
        /* =========================================================
           ADDITIONAL ADDRESS COUNTER
        ========================================================= */
        function updateAddressCounter() {
            const input = document.getElementById("additionalAddress");
            document.getElementById("addressCounter").textContent =
                `${input.value.length} / 100`;
        }
        /* =========================================================
           SAVE NEW ADDRESS
        ========================================================= */
        async function saveNewAddress() {
            if (addresses.length >= 3) {
                showToast("You can save a maximum of 3 addresses.");
                return;
            }

            if (!selectedRegion) {
                showToast("Please select a region.");
                return;
            }
            if (!selectedProvince) {
                showToast("Please select a province.");
                return;
            }
            if (!selectedCity) {
                showToast("Please select a city or municipality.");
                return;
            }
            if (!selectedBarangay) {
                showToast("Please select a barangay.");
                return;
            }

            const additional = document
                .getElementById("additionalAddress")
                .value
                .trim();

            try {
                const result = await sendAddressRequest(
                    addressRoutes.store,
                    "POST",
                    {
                        region: selectedRegion.name,
                        province: selectedProvince.name,
                        city: selectedCity.name,
                        barangay: selectedBarangay.name,
                        additional
                    }
                );

                addresses = addresses.map(address => ({
                    ...address,
                    active: false
                }));

                addresses.push({
                    slot: result.address.slot,
                    address: result.address.address,
                    active: true
                });

                closeModal("newAddressModal");
                renderAddresses();
                showToast(result.message);
                setTimeout(() => openModal("addressModal"), 250);
            } catch (error) {
                showToast(error.message);
            }
        }

        updateAddressCounter();
        renderAddresses();

        function updateBioCounter() {
            const bio = document.getElementById("bio");
            document.getElementById("bioCounter").textContent = `${bio.value.length} / 300`;
        }

        function showToast(message) {
            const container = document.getElementById("toastContainer");
            const toast = document.createElement("div");
            toast.className = "toast";
            const icon = document.createElement("i");
            icon.className = "fa-solid fa-circle-check";
            const text = document.createElement("span");
            text.textContent = message;
            toast.append(icon, text);
            container.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = "0";
                toast.style.transform = "translateY(10px)";
                toast.style.transition = ".3s ease";
                setTimeout(() => toast.remove(), 300);
            }, 2600);
        }

        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("visible");
                } else {
                    entry.target.classList.remove("visible");
                }
            });
        }, { threshold: .12, rootMargin: "0px 0px -45px 0px" });

        document.querySelectorAll(".reveal, .stagger").forEach(element => observer.observe(element));

        document.addEventListener("click", event => {
            if (event.target.closest("input, textarea")) return;
            const pop = document.createElement("span");
            pop.className = "click-pop";
            pop.style.left = `${event.clientX}px`;
            pop.style.top = `${event.clientY}px`;
            document.body.appendChild(pop);
            setTimeout(() => pop.remove(), 700);
        });

        document.addEventListener("keydown", event => {
            if (event.key !== "Escape") return;
            document.querySelectorAll(".modal-overlay.open").forEach(modal => closeModal(modal.id));
        });

        updateBioCounter();

        @if ($errors->has('email') || $errors->has('email_current_password'))
            openModal('emailModal');
        @elseif ($errors->has('current_password') || $errors->has('password'))
            openModal('passwordModal');
        @elseif ($errors->has('name'))
            openModal('nameModal');
        @elseif ($errors->has('real_name'))
            openModal('realNameModal');
        @elseif ($errors->has('bio'))
            openModal('bioModal');
        @elseif ($errors->has('phone'))
            openModal('phoneModal');
        @endif
    </script>
</body>
</html>
