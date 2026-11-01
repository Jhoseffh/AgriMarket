
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AgriMarket - Search</title>

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
input {
    font: inherit;
}

button,
a {
    -webkit-tap-highlight-color: transparent;
}

a {
    color: inherit;
}

/* AMBIENT BACKGROUND */

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

/* NAVIGATION */

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
    transition:
        padding .45s var(--ease),
        box-shadow .45s ease,
        background .45s ease;
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

/* SEARCH BAR */

.nav-search-wrap {
    position: relative;
    flex: 1;
    max-width: 600px;
    min-width: 0;
    margin: 0 auto;
}

.nav-search {
    width: 100%;
    max-width: none;
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

.nav-search button {
    flex: 0 0 38px;
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

/* DATABASE SEARCH SUGGESTIONS */

.search-suggestions {
    position: absolute;
    top: calc(100% + 8px);
    left: 0;
    width: 100%;
    max-height: 330px;
    padding: 7px;
    background: #fff;
    border: 1px solid var(--border-color);
    border-radius: 12px;
    box-shadow: var(--shadow-lg);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-7px);
    transition:
        opacity .25s var(--ease),
        transform .25s var(--ease),
        visibility .25s ease;
    z-index: 2500;
}

.search-suggestions.open {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.search-suggestion {
    display: flex;
    align-items: center;
    gap: 10px;
    width: 100%;
    padding: 10px 11px;
    border: 0;
    border-radius: 9px;
    color: var(--text-main);
    background: transparent;
    text-decoration: none;
    font-size: .82rem;
    text-align: left;
    cursor: pointer;
    transition: background .2s ease, color .2s ease;
}

.search-suggestion:hover {
    background: var(--soft-green);
    color: var(--primary-green);
}

.search-suggestion i {
    flex: 0 0 auto;
    color: var(--primary-green);
    font-size: .78rem;
}

.search-suggestion-name {
    min-width: 0;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.search-empty {
    padding: 11px 12px;
    color: var(--text-muted);
    font-size: .78rem;
}

/* NAV ACTIONS */

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

/* CATEGORY */

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

/* BADGE */

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

/* DROPDOWNS */

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
    z-index: 2100;
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

/* CATEGORY DROPDOWN */

.category-dropdown {
    left: 50%;
    right: auto;
    top: calc(100% + 10px);
    width: 590px;
    max-width: min(590px, 90vw);
    padding: 10px;
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 5px;
    border-radius: 14px;
    opacity: 0;
    visibility: hidden;
    transform: translateX(-52%) translateY(-8px) scale(.97);
    transition:
        opacity .3s var(--ease),
        transform .3s var(--ease),
        visibility .3s ease;
    z-index: 2500;
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
    color: var(--primary-green);
    font-size: .82rem;
    text-align: center;
}

.mobile-menu-btn {
    display: none;
}

/* SEARCH PAGE */

.search-page {
    width: min(1400px, 90%);
    margin: 0 auto;
    padding: 135px 0 45px;
}

.search-header {
    margin-bottom: 25px;
}

.search-count {
    color: var(--text-muted);
    font-size: .72rem;
    font-weight: 600;
    margin-bottom: 7px;
}

.search-count strong {
    color: var(--primary-dark);
    font-weight: 800;
}

.search-title {
    color: var(--primary-dark);
    font-size: clamp(1.45rem, 2.7vw, 2.15rem);
    line-height: 1.2;
    font-weight: 800;
    letter-spacing: -.5px;
}

.search-keyword {
    color: var(--accent-terracotta);
    overflow-wrap: anywhere;
}

/* SORT BY */

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
    transition:
        border-color .3s ease,
        box-shadow .3s ease,
        transform .3s var(--spring);
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

/* ITEM LABEL */

.item-label {
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

.item-label::after {
    content: "";
    flex: 1;
    height: 1px;
    background: var(--border-color);
}

/* PRODUCT GRID */

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
    transition:
        transform .35s var(--spring),
        box-shadow .35s ease,
        border-color .35s ease;
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

.product-photo {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .45s var(--ease);
}

.product-card:hover .product-photo {
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
    background:
        linear-gradient(135deg, rgba(255,255,255,.38), transparent 50%),
        #e9ecef;
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

/* FEATURED */

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

/* PRODUCT INFO */

.product-info {
    padding: 12px;
}

.product-name {
    min-height: 38px;
    color: var(--primary-dark);
    font-size: .8rem;
    font-weight: 800;
    line-height: 1.35;
    overflow-wrap: anywhere;
}

.product-price {
    margin-top: 5px;
    color: var(--accent-terracotta);
    font-size: 1rem;
    font-weight: 800;
}

.product-meta {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 5px;
    margin-top: 3px;
    color: var(--text-muted);
    font-size: .65rem;
}

.product-meta span {
    min-width: 0;
    overflow-wrap: anywhere;
}

.rating {
    color: #d68b23;
}

/* CARD BUTTONS */

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

/* NO RESULTS */

.no-results {
    display: none;
    padding: 60px 20px;
    text-align: center;
    background: rgba(255,255,255,.7);
    border: 1px solid var(--border-color);
    border-radius: 16px;
    box-shadow: var(--shadow-sm);
}

.no-results i {
    font-size: 2.2rem;
    color: #a8b0b5;
    margin-bottom: 10px;
}

.no-results h3 {
    color: var(--primary-dark);
    font-size: 1rem;
}

.no-results p {
    margin-top: 5px;
    color: var(--text-muted);
    font-size: .75rem;
}

/* PAGINATION */

.pagination-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 40px;
}

.pagination-wrapper[hidden] {
    display: none !important;
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

.page-link.disabled {
    opacity: .4;
    pointer-events: none;
}

.page-dots {
    color: var(--text-muted);
    font-size: .75rem;
    padding: 0 3px;
}

/* REVEAL ANIMATIONS */

.reveal {
    opacity: 0;
    transform: translateY(48px) scale(.98);
    filter: blur(5px);
    transition:
        opacity .75s var(--ease),
        transform .85s var(--ease),
        filter .75s var(--ease);
}

.reveal.visible {
    opacity: 1;
    transform: none;
    filter: blur(0);
}

.product-card.reveal-card {
    opacity: 0;
    transform: translateY(25px);
    transition:
        opacity .6s var(--ease),
        transform .65s var(--ease);
}

.product-card.reveal-card.visible {
    opacity: 1;
    transform: none;
}

/* TOAST */

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

/* CLICK POP */

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

/* FOOTER */

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

/* RESPONSIVE */

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
        max-width: 90vw;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        transform: translateY(-8px) scale(.97);
    }

    .category-dropdown.open {
        transform: none;
    }

    .footer-grid {
        grid-template-columns: 1fr 1fr;
    }
}

@media (max-width: 650px) {
    .search-page {
        width: 92%;
        padding-top: 145px;
    }

    .search-title {
        font-size: 1.5rem;
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
        max-width: 92%;
    }

    .category-dropdown a {
        padding: 9px 8px;
        font-size: .73rem;
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

    .category-dropdown a i {
        width: 15px;
        flex: 0 0 15px;
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
    .product-card.reveal-card {
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
    <a href="{{ url('/shop') }}" class="brand">
        <i class="fa-solid fa-leaf"></i>
        <span>agrimarket</span>
    </a>

    <!-- SEARCH BAR AND SUGGESTIONS -->

    <div class="nav-search-wrap">
        <form class="nav-search" id="searchForm" autocomplete="off">
            <i class="fa-solid fa-magnifying-glass"></i>

            <input
                id="searchInput"
                type="search"
                placeholder="Search products, categories..."
                aria-label="Search products"
                autocomplete="off"
                value="{{ $product_name }}"
            >

            <button type="submit" title="Search">
                <i class="fa-solid fa-arrow-right"></i>
            </button>
        </form>

        <div
            class="search-suggestions"
            id="searchSuggestions"
            role="listbox"
            aria-label="Search suggestions"
        ></div>
    </div>

    <!-- CATEGORY -->

    <div class="dropdown-wrap category-desktop">
        <button class="icon-btn" id="categoryButton" title="Category" type="button">
            <i class="fa-solid fa-grip"></i>
            <span>Category</span>
        </button>

        <div class="dropdown category-dropdown" id="categoryMenu">
            <a href="{{ url('/category/Fruits') }}">
                <i class="fa-solid fa-apple-whole"></i>
                Fruits
            </a>

            <a href="{{ url('/category/Vegetables') }}">
                <i class="fa-solid fa-carrot"></i>
                Vegetables
            </a>

            <a href="{{ url('/category/Grains%20%26%20Rice') }}">
                <i class="fa-solid fa-wheat-awn"></i>
                Grains &amp; Rice
            </a>

            <a href="{{ url('/category/Seeds') }}">
                <i class="fa-solid fa-seedling"></i>
                Seeds
            </a>

            <a href="{{ url('/category/Organic%20Products') }}">
                <i class="fa-solid fa-leaf"></i>
                Organic Products
            </a>

            <a href="{{ url('/category/Herbs%20%26%20Spices') }}">
                <i class="fa-solid fa-mortar-pestle"></i>
                Herbs &amp; Spices
            </a>

            <a href="{{ url('/category/Meat%20%26%20Poultry') }}">
                <i class="fa-solid fa-drumstick-bite"></i>
                Meat &amp; Poultry
            </a>

            <a href="{{ url('/category/Fish%20%26%20Seafood') }}">
                <i class="fa-solid fa-fish"></i>
                Fish &amp; Seafood
            </a>

            <a href="{{ url('/category/Dairy%20%26%20Eggs') }}">
                <i class="fa-solid fa-egg"></i>
                Dairy &amp; Eggs
            </a>

            <a href="{{ url('/category/Processed%20Foods') }}">
                <i class="fa-solid fa-jar"></i>
                Processed Foods
            </a>

            <a href="{{ url('/category/New%20Arrivals') }}">
                <i class="fa-solid fa-star"></i>
                New Arrivals
            </a>

            <a href="{{ url('/category/Best%20Sellers') }}">
                <i class="fa-solid fa-trophy"></i>
                Best Sellers
            </a>

            <a href="{{ url('/category/Below%20100') }}">
                <i class="fa-solid fa-tags"></i>
                Below 100
            </a>

            <a href="{{ url('/category/All%20Products') }}">
                <i class="fa-solid fa-boxes-stacked"></i>
                All Products
            </a>
        </div>
    </div>

    <!-- NAV ACTIONS -->

    <div class="nav-actions">
        <button
            class="icon-btn"
            title="Notifications"
            type="button"
            onclick="showToast('You have no new notifications.')"
        >
            <i class="fa-regular fa-bell"></i>
            <span class="badge">2</span>
        </button>

        <button
            class="icon-btn"
            title="Shopping Cart"
            type="button"
            onclick="showToast('Your cart is ready.')"
        >
            <i class="fa-solid fa-cart-shopping"></i>
            <span class="badge" id="cartCount">0</span>
        </button>

        <!-- PROFILE -->

        <div class="dropdown-wrap">
            <button class="icon-btn" id="profileButton" title="Profile" type="button">
                <i class="fa-regular fa-user"></i>
            </button>

            <div class="dropdown" id="profileMenu">
                <a href="{{ url('/profile') }}">
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

                <a href="{{ url('/logout') }}">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    Logout
                </a>
            </div>
        </div>

        <!-- MOBILE CATEGORY -->

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

<!-- SEARCH PAGE -->

<main>
    <section class="search-page">

        <!-- SEARCH INFORMATION -->

        <div class="search-header reveal">
            <div class="search-count">
                Search:
                <strong id="resultCount">{{ $products->count() }}</strong>
                results found for
                "<strong id="productNameSmall">{{ $product_name }}</strong>"
            </div>

            <h1 class="search-title">
                Search results:
                <span class="search-keyword" id="productName">{{ $product_name }}</span>
            </h1>
        </div>

        <!-- SORT BY -->

        <div class="sort-section">
            <span class="sort-label">Sort by:</span>

            <div class="sort-control">
                <select class="sort-select" id="sortSelect">
                    <option value="default">Default</option>
                    <option value="price_low">Price: Low to High</option>
                    <option value="price_high">Price: High to Low</option>
                </select>

                <i class="fa-solid fa-chevron-down"></i>
            </div>
        </div>

        <!-- ITEM -->

        <div class="item-label reveal">
            <span>Item</span>
        </div>

        <!-- DATABASE PRODUCT RESULTS -->

        <div class="product-grid" id="productGrid">

            @forelse ($products as $product)
                <article
                    class="product-card reveal-card"
                    data-name="{{ $product->product_name }}"
                    data-price="{{ $product->price }}"
                    data-id="{{ $product->product_id }}"
                >

                <div class="product-image">
                    @if (!empty($product->image))
                        <img
                            src="{{ asset('image/product' . $product->image) }}"
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
                            ₱{{ number_format((float) $product->price, 2) }}
                        </div>

                        <div class="product-meta">
                            <span>
                                Stock: {{ $product->quantity }}
                                {{ $product->oum }}
                            </span>

                            <span>
                                {{ $product->category }}
                            </span>
                        </div>

                        <div class="card-actions">
                            <button
                                class="card-btn cart-btn"
                                type="button"
                                onclick='addToCart(@json($product->product_name))'
                            >
                                <i class="fa-solid fa-cart-plus"></i>
                                Add to Cart
                            </button>

                            <button
                                class="card-btn buy-btn"
                                type="button"
                                onclick='buyNow(@json($product->product_name))'
                            >
                                Buy Now
                            </button>
                        </div>
                    </div>
                </article>
            @empty
                <!-- The no-results panel below will be displayed. -->
            @endforelse

        </div>

        <!-- NO RESULTS -->

        <div
            class="no-results"
            id="noResults"
            style="{{ $products->isEmpty() ? 'display:block;' : 'display:none;' }}"
        >
            <i class="fa-solid fa-magnifying-glass"></i>

            <h3>No products found</h3>

            <p>
                Try searching for another product or category.
            </p>
        </div>

        <!-- PAGINATION -->

        <div class="pagination-wrapper reveal" id="paginationWrapper" hidden>
            <nav
                class="pagination"
                id="pagination"
                aria-label="Search results pagination"
            ></nav>
        </div>

    </section>
</main>

<!-- FOOTER -->

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
                <li><a href="#">Help &amp; Support</a></li>
            </ul>
        </div>

        <div class="footer-links">
            <h4>Legal</h4>

            <ul>
                <li><a href="#">Terms &amp; Conditions</a></li>
                <li><a href="#">Privacy Policy</a></li>
            </ul>
        </div>

        <div class="footer-links">
            <h4>Marketplace</h4>

            <ul>
                <li><a href="{{ url('/category/New%20Arrivals') }}">New &amp; Fresh</a></li>
                <li><a href="{{ url('/category/Best%20Sellers') }}">Best Sellers</a></li>
                <li><a href="{{ url('/category/All%20Products') }}">Groceries</a></li>
            </ul>
        </div>

    </div>

    <div class="copyright">
        © 2026 AgriMarket.
        All rights reserved.
    </div>
</footer>

<!-- TOAST -->

<div class="toast-container" id="toastContainer"></div>

<script>
/* SEARCH DATA FROM LARAVEL — MATCHES CATEGORY PAGE */

const productName = @json($product_name);
const searchResultsUrl = @json(url('/search'));

/*
 * Product names are rendered by Blade from the database.
 * This works like the searchableProducts array in the Category page.
 */
const searchableProducts = [
    @foreach ($allProducts->unique('product_name')->values() as $product)
        {
            name: @json($product->product_name)
        }@if (!$loop->last),@endif
    @endforeach
];

/* UPDATE SEARCH INFORMATION */

function updateSearchInformation() {
    document.getElementById("productName").textContent = productName;
    document.getElementById("productNameSmall").textContent = productName;
    document.getElementById("searchInput").value = productName;
}

updateSearchInformation();

/* CART */

let cartCount = 0;

function addToCart(name) {
    cartCount++;

    document.getElementById("cartCount").textContent = cartCount;

    showToast(`${name} was added to your cart.`);
}

/* BUY NOW */

function buyNow(name) {
    showToast(
        `Buy Now selected for ${name}. Connect this to your checkout route.`
    );
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

        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 2600);
}

/* REPEATING SCROLL REVEAL */

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
        threshold: .12,
        rootMargin: "0px 0px -45px 0px"
    }
);

document
    .querySelectorAll(".reveal, .reveal-card")
    .forEach(element => {
        observer.observe(element);
    });

/* NAVBAR SCROLL */

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

/* DROPDOWNS */

const profileButton = document.getElementById("profileButton");
const profileMenu = document.getElementById("profileMenu");
const categoryButton = document.getElementById("categoryButton");
const categoryMenu = document.getElementById("categoryMenu");
const mobileCategoryButton = document.getElementById("mobileCategoryButton");

const searchForm = document.getElementById("searchForm");
const searchInput = document.getElementById("searchInput");
const searchSuggestions = document.getElementById("searchSuggestions");

function closeSearchSuggestions() {
    searchSuggestions.classList.remove("open");
}

function closeMenus() {
    profileMenu.classList.remove("open");
    categoryMenu.classList.remove("open");
    closeSearchSuggestions();
}

profileButton.addEventListener("click", event => {
    event.stopPropagation();

    const shouldOpen = !profileMenu.classList.contains("open");

    closeMenus();

    if (shouldOpen) {
        profileMenu.classList.add("open");
    }
});

function toggleCategoryMenu(event) {
    event.stopPropagation();

    const shouldOpen = !categoryMenu.classList.contains("open");

    closeMenus();

    if (shouldOpen) {
        categoryMenu.classList.add("open");
    }
}

categoryButton.addEventListener("click", toggleCategoryMenu);
mobileCategoryButton.addEventListener("click", toggleCategoryMenu);

categoryMenu.addEventListener("click", event => {
    event.stopPropagation();
});

profileMenu.addEventListener("click", event => {
    event.stopPropagation();
});

searchForm.addEventListener("click", event => {
    event.stopPropagation();
});

searchSuggestions.addEventListener("click", event => {
    event.stopPropagation();
});

document.addEventListener("click", () => {
    closeMenus();
});

/* DATABASE-DRIVEN SEARCH SUGGESTIONS */
/* Same local filtering approach used by the Category page. */

function escapeHTML(value) {
    return String(value).replace(/[&<>"']/g, character => {
        const entities = {
            "&": "&amp;",
            "<": "&lt;",
            ">": "&gt;",
            '"': "&quot;",
            "'": "&#39;"
        };

        return entities[character];
    });
}

function renderSearchSuggestions() {
    const query = searchInput.value.trim();
    const normalizedQuery = query.toLowerCase();

    if (!normalizedQuery) {
        closeSearchSuggestions();
        searchSuggestions.innerHTML = "";
        return;
    }

    const matches = searchableProducts
        .filter(product =>
            String(product.name)
                .toLowerCase()
                .includes(normalizedQuery)
        )
        .slice(0, 8);

    if (matches.length === 0) {
        searchSuggestions.innerHTML = `
            <div class="search-empty">
                No products found for "${escapeHTML(query)}".
            </div>
        `;

        searchSuggestions.classList.add("open");
        return;
    }

    searchSuggestions.innerHTML = matches.map(product => `
        <a
            href="${searchResultsUrl}/${encodeURIComponent(product.name)}"
            class="search-suggestion"
            role="option"
        >
            <i class="fa-solid fa-magnifying-glass"></i>
            <span class="search-suggestion-name">
                ${escapeHTML(product.name)}
            </span>
        </a>
    `).join("");

    searchSuggestions.classList.add("open");
}

searchInput.addEventListener("input", renderSearchSuggestions);

searchInput.addEventListener("focus", () => {
    if (searchInput.value.trim()) {
        renderSearchSuggestions();
    }
});

/* SEARCH FORM SUBMISSION */

searchForm.addEventListener("submit", event => {
    event.preventDefault();

    const query = searchInput.value.trim();

    if (!query) {
        closeSearchSuggestions();
        showToast("Enter a product or category to search.");
        return;
    }

    window.location.href =
        `${searchResultsUrl}/${encodeURIComponent(query)}`;
});

/* PAGINATION: 36 DESKTOP / 18 MOBILE */

const productGrid = document.getElementById("productGrid");
const paginationWrapper = document.getElementById("paginationWrapper");
const pagination = document.getElementById("pagination");
const noResults = document.getElementById("noResults");
const sortSelect = document.getElementById("sortSelect");

let currentPage = 1;
let currentPageSize = 0;
let paginationResizeTimer;

function getPageSize() {
    return window.matchMedia("(max-width: 768px)").matches ? 18 : 36;
}

function getSortedCards() {
    const cards = Array.from(
        productGrid.querySelectorAll(".product-card")
    );

    const sortValue = sortSelect.value;

    if (sortValue === "latest") {
        cards.sort((a, b) =>
            Number(b.dataset.id) - Number(a.dataset.id)
        );
    } else if (sortValue === "price_low") {
        cards.sort((a, b) =>
            Number(a.dataset.price) - Number(b.dataset.price)
        );
    } else if (sortValue === "price_high") {
        cards.sort((a, b) =>
            Number(b.dataset.price) - Number(a.dataset.price)
        );
    }

    return cards;
}

function renderPagination() {
    const cards = getSortedCards();

    const previousPageSize = currentPageSize;
    currentPageSize = getPageSize();

    if (
        previousPageSize !== 0 &&
        previousPageSize !== currentPageSize
    ) {
        currentPage = 1;
    }

    const totalProducts = cards.length;
    const totalPages = Math.ceil(totalProducts / currentPageSize);

    document.getElementById("resultCount").textContent = totalProducts;

    noResults.style.display = totalProducts === 0 ? "block" : "none";

    if (totalPages <= 1) {
        currentPage = 1;

        cards.forEach(card => {
            card.style.display = "";
            productGrid.appendChild(card);
        });

        pagination.innerHTML = "";
        paginationWrapper.hidden = true;
        return;
    }

    paginationWrapper.hidden = false;
    currentPage = Math.min(Math.max(currentPage, 1), totalPages);

    const startIndex = (currentPage - 1) * currentPageSize;
    const endIndex = startIndex + currentPageSize;

    cards.forEach((card, index) => {
        productGrid.appendChild(card);

        card.style.display =
            index >= startIndex && index < endIndex ? "" : "none";
    });

    const makePageLink = (page, label, options = {}) => {
        const link = document.createElement("a");

        link.href = "#";
        link.className = "page-link";
        link.textContent = label;

        link.setAttribute(
            "aria-label",
            options.ariaLabel || `Page ${page}`
        );

        if (page === currentPage && !options.disabled) {
            link.classList.add("active");
            link.setAttribute("aria-current", "page");
        }

        if (options.disabled) {
            link.classList.add("disabled");
            link.setAttribute("aria-disabled", "true");
        } else {
            link.addEventListener("click", event => {
                event.preventDefault();

                currentPage = page;
                renderPagination();

                productGrid.scrollIntoView({
                    behavior: "smooth",
                    block: "start"
                });
            });
        }

        return link;
    };

    pagination.innerHTML = "";

    pagination.appendChild(
        makePageLink(
            Math.max(1, currentPage - 1),
            "‹",
            {
                disabled: currentPage === 1,
                ariaLabel: "Previous page"
            }
        )
    );

    let pages = [];

    if (totalPages <= 7) {
        pages = Array.from(
            { length: totalPages },
            (_, index) => index + 1
        );
    } else if (currentPage <= 4) {
        pages = [1, 2, 3, 4, 5, "...", totalPages];
    } else if (currentPage >= totalPages - 3) {
        pages = [
            1,
            "...",
            totalPages - 4,
            totalPages - 3,
            totalPages - 2,
            totalPages - 1,
            totalPages
        ];
    } else {
        pages = [
            1,
            "...",
            currentPage - 1,
            currentPage,
            currentPage + 1,
            "...",
            totalPages
        ];
    }

    pages.forEach(page => {
        if (page === "...") {
            const dots = document.createElement("span");

            dots.className = "page-dots";
            dots.textContent = "...";
            pagination.appendChild(dots);
            return;
        }

        pagination.appendChild(
            makePageLink(page, String(page))
        );
    });

    pagination.appendChild(
        makePageLink(
            Math.min(totalPages, currentPage + 1),
            "›",
            {
                disabled: currentPage === totalPages,
                ariaLabel: "Next page"
            }
        )
    );
}

sortSelect.addEventListener("change", () => {
    currentPage = 1;
    renderPagination();
});

window.addEventListener("resize", () => {
    clearTimeout(paginationResizeTimer);

    paginationResizeTimer = setTimeout(() => {
        renderPagination();
    }, 120);
});

renderPagination();

/* CLICK POP */

document.addEventListener("click", event => {
    const pop = document.createElement("span");

    pop.className = "click-pop";
    pop.style.left = `${event.clientX}px`;
    pop.style.top = `${event.clientY}px`;

    document.body.appendChild(pop);

    setTimeout(() => pop.remove(), 700);
});
</script>

</body>
</html>
