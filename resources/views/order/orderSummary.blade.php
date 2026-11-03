
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>AgriMarket - Order Summary</title>

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
    to { transform:translate(10vw,9vh) rotate(25deg) scale(1.12); }
}

@keyframes driftB {
    to { transform:translate(-8vw,-12vh) rotate(-30deg) scale(1.16); }
}

/* TOP BAR */
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
    background:rgba(249,248,243,.82);
    box-shadow:0 12px 35px rgba(30,58,43,.08);
}

/* BRAND */
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

/* BACK BUTTON */
.back-button {
    margin-left:auto;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:8px;
    min-width:92px;
    height:40px;
    padding:0 13px;
    border:1px solid var(--border-color);
    border-radius:10px;
    background:#fff;
    color:var(--primary-dark);
    cursor:pointer;
    font-size:.72rem;
    font-weight:800;
    box-shadow:var(--shadow-sm);
    transition:.3s var(--ease);
}

.back-button:hover {
    background:var(--soft-green);
    border-color:rgba(45,90,63,.2);
    color:var(--primary-green);
    transform:translateY(-2px);
}

/* MAIN PAGE */
main {
    position:relative;
}

/* BODY SIDE DECORATIONS */
main::before,
main::after {
    content:"";
    position:fixed;
    top:32vh;
    width:260px;
    height:260px;
    pointer-events:none;
    z-index:0;
    border-radius:50%;
    filter:blur(2px);
    will-change:transform,opacity;
}

main::before {
    left:-115px;
    background:
        radial-gradient(
            circle at center,
            rgba(45,90,63,.22) 0%,
            rgba(82,145,104,.16) 25%,
            rgba(82,145,104,.09) 48%,
            rgba(82,145,104,.035) 66%,
            transparent 76%
        );
    box-shadow:
        0 0 70px rgba(82,145,104,.13),
        0 0 120px rgba(82,145,104,.08);
    animation:
        bodyCircleLeft 8s ease-in-out infinite,
        bodyPulse 5s ease-in-out infinite;
}

main::after {
    right:-115px;
    top:42vh;
    background:
        radial-gradient(
            circle at center,
            rgba(45,90,63,.22) 0%,
            rgba(82,145,104,.16) 25%,
            rgba(82,145,104,.09) 48%,
            rgba(82,145,104,.035) 66%,
            transparent 76%
        );
    box-shadow:
        0 0 70px rgba(82,145,104,.13),
        0 0 120px rgba(82,145,104,.08);
    animation:
        bodyCircleRight 9s ease-in-out infinite,
        bodyPulse 5.8s ease-in-out infinite;
}

/* VISIBLE FLOATING BODY CIRCLES */
.body-side-decoration {
    position:fixed;
    pointer-events:none;
    z-index:0;
    border-radius:50%;
    will-change:transform,opacity;
}

.body-side-decoration.left {
    top:62vh;
    left:-62px;
    width:145px;
    height:145px;
    background:
        radial-gradient(
            circle at 42% 38%,
            rgba(45,90,63,.23) 0%,
            rgba(82,145,104,.16) 30%,
            rgba(82,145,104,.08) 55%,
            rgba(82,145,104,.025) 72%,
            transparent 78%
        );
    box-shadow:
        0 0 35px rgba(45,90,63,.14),
        0 0 75px rgba(82,145,104,.12);
    animation:floatCircleLeft 7s ease-in-out infinite;
}

.body-side-decoration.right {
    top:62vh;
    right:-62px;
    width:145px;
    height:145px;
    background:
        radial-gradient(
            circle at 58% 38%,
            rgba(45,90,63,.23) 0%,
            rgba(82,145,104,.16) 30%,
            rgba(82,145,104,.08) 55%,
            rgba(82,145,104,.025) 72%,
            transparent 78%
        );
    box-shadow:
        0 0 35px rgba(45,90,63,.14),
        0 0 75px rgba(82,145,104,.12);
    animation:floatCircleRight 8s ease-in-out infinite;
}

/* INNER CIRCLES */
.body-side-decoration::before,
.body-side-decoration::after {
    content:"";
    position:absolute;
    border-radius:50%;
    pointer-events:none;
}

.body-side-decoration.left::before {
    width:72px;
    height:72px;
    top:-25px;
    left:72px;
    background:
        radial-gradient(
            circle,
            rgba(82,145,104,.22) 0%,
            rgba(82,145,104,.10) 48%,
            transparent 72%
        );
    box-shadow:0 0 35px rgba(82,145,104,.13);
    animation:smallCircleLeft 5.5s ease-in-out infinite;
}

.body-side-decoration.left::after {
    width:48px;
    height:48px;
    bottom:-18px;
    left:24px;
    background:
        radial-gradient(
            circle,
            rgba(45,90,63,.19) 0%,
            rgba(82,145,104,.08) 52%,
            transparent 75%
        );
    box-shadow:0 0 28px rgba(45,90,63,.11);
    animation:smallCircleLeft2 6.5s ease-in-out infinite;
}

.body-side-decoration.right::before {
    width:72px;
    height:72px;
    top:-25px;
    right:72px;
    background:
        radial-gradient(
            circle,
            rgba(82,145,104,.22) 0%,
            rgba(82,145,104,.10) 48%,
            transparent 72%
        );
    box-shadow:0 0 35px rgba(82,145,104,.13);
    animation:smallCircleRight 6s ease-in-out infinite;
}

.body-side-decoration.right::after {
    width:48px;
    height:48px;
    bottom:-18px;
    right:24px;
    background:
        radial-gradient(
            circle,
            rgba(45,90,63,.19) 0%,
            rgba(82,145,104,.08) 52%,
            transparent 75%
        );
    box-shadow:0 0 28px rgba(45,90,63,.11);
    animation:smallCircleRight2 7s ease-in-out infinite;
}

/* LARGE CIRCLE FLOATING ANIMATION */
@keyframes bodyCircleLeft {
    0%,100% { transform:translate(0,0) scale(1); }
    50% { transform:translate(28px,20px) scale(1.08); }
}

@keyframes bodyCircleRight {
    0%,100% { transform:translate(0,0) scale(1); }
    50% { transform:translate(-28px,25px) scale(1.09); }
}

/* MAIN CIRCLE PULSE */
@keyframes bodyPulse {
    0%,100% { opacity:.78; }
    50% { opacity:1; }
}

/* SIDE CIRCLE FLOATING */
@keyframes floatCircleLeft {
    0%,100% { transform:translate(0,0) scale(1); }
    25% { transform:translate(15px,-18px) scale(1.04); }
    50% { transform:translate(27px,8px) scale(1.09); }
    75% { transform:translate(10px,22px) scale(1.03); }
}

@keyframes floatCircleRight {
    0%,100% { transform:translate(0,0) scale(1); }
    25% { transform:translate(-15px,-20px) scale(1.04); }
    50% { transform:translate(-30px,10px) scale(1.09); }
    75% { transform:translate(-12px,23px) scale(1.03); }
}

/* SMALL CIRCLE ANIMATIONS */
@keyframes smallCircleLeft {
    0%,100% { transform:translate(0,0) scale(1); opacity:.7; }
    50% { transform:translate(18px,14px) scale(1.18); opacity:1; }
}

@keyframes smallCircleLeft2 {
    0%,100% { transform:translate(0,0) scale(1); opacity:.55; }
    50% { transform:translate(-8px,-14px) scale(1.16); opacity:.9; }
}

@keyframes smallCircleRight {
    0%,100% { transform:translate(0,0) scale(1); opacity:.7; }
    50% { transform:translate(-18px,15px) scale(1.18); opacity:1; }
}

@keyframes smallCircleRight2 {
    0%,100% { transform:translate(0,0) scale(1); opacity:.55; }
    50% { transform:translate(8px,-14px) scale(1.16); opacity:.9; }
}

.order-page {
    position:relative;
    z-index:1;
    width:min(1100px,90%);
    margin:0 auto;
    padding:118px 0 45px;
}

/* PAGE INTRO */
.page-intro { margin-bottom:18px; }

.eyebrow {
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

.page-intro h1 {
    margin-top:8px;
    color:var(--primary-dark);
    font-size:clamp(1.65rem,3vw,2.3rem);
    line-height:1.15;
    font-weight:800;
}

.page-intro p {
    margin-top:6px;
    color:var(--text-muted);
    font-size:.8rem;
}

/* DELIVERY INFORMATION */
.delivery-card {
    position:sticky;
    top:74px;
    z-index:100;
    padding:15px 18px;
    margin-bottom:18px;
    background:rgba(255,255,255,.96);
    backdrop-filter:blur(14px);
    border:1px solid rgba(228,231,236,.9);
    border-radius:14px;
    box-shadow:var(--shadow-md);
}

.delivery-top {
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:15px;
}

.delivery-label {
    display:flex;
    align-items:center;
    gap:7px;
    color:var(--primary-green);
    font-size:.67rem;
    font-weight:800;
    letter-spacing:.6px;
    text-transform:uppercase;
}

.delivery-label i { font-size:.72rem; }

.customer-line {
    margin-top:6px;
    color:var(--primary-dark);
    font-size:.83rem;
    line-height:1.4;
}

.customer-line strong { font-weight:800; }

.customer-address {
    display:flex;
    align-items:center;
    gap:7px;
    margin-top:3px;
    min-width:0;
    color:var(--text-muted);
    font-size:.7rem;
}

.customer-address i {
    flex:0 0 auto;
    color:var(--primary-green);
    font-size:.68rem;
}

.address-text {
    overflow:hidden;
    white-space:nowrap;
    text-overflow:ellipsis;
}

/* SEPARATOR */
.section-separator {
    display:flex;
    align-items:center;
    gap:12px;
    margin:20px 0 15px;
    color:var(--text-muted);
    font-size:.65rem;
    font-weight:800;
    letter-spacing:.7px;
    text-transform:uppercase;
}

.section-separator::before,
.section-separator::after {
    content:"";
    flex:1;
    height:1px;
    background:var(--border-color);
}

/* PRODUCTS SECTION */
.products-section {
    display:flex;
    flex-direction:column;
    gap:13px;
}

.seller-card {
    background:#fff;
    border:1px solid var(--border-color);
    border-radius:15px;
    box-shadow:var(--shadow-sm);
    overflow:hidden;
    transition:transform .3s var(--ease),box-shadow .3s ease;
}

.seller-card:hover {
    transform:translateY(-2px);
    box-shadow:var(--shadow-md);
}

.seller-header {
    display:flex;
    align-items:center;
    justify-content:space-between;
    padding:12px 17px;
    background:#fbfcfa;
    border-bottom:1px solid var(--border-color);
}

.seller-name {
    display:flex;
    align-items:center;
    gap:7px;
    color:var(--primary-dark);
    font-size:.75rem;
    font-weight:800;
}

.seller-name i {
    color:var(--primary-green);
    font-size:.72rem;
}

.seller-label {
    color:var(--text-muted);
    font-size:.61rem;
    font-weight:600;
}

/* PRODUCT ITEM */
.product-item {
    display:grid;
    grid-template-columns:78px minmax(0,1fr) auto;
    align-items:center;
    gap:14px;
    padding:15px 17px;
}

.product-image {
    width:78px;
    height:78px;
    display:grid;
    place-items:center;
    overflow:hidden;
    border-radius:12px;
    background:
        linear-gradient(135deg,rgba(255,255,255,.38),transparent 50%),
        #e9ecef;
    border:1px solid #cbd4cd;
}

.product-image img {
    width:100%;
    height:100%;
    object-fit:cover;
    border-radius:inherit;
}

.product-image i {
    color:#a8b0b5;
    font-size:1.35rem;
}

.product-details { min-width:0; }

.product-name {
    color:var(--primary-dark);
    font-size:.85rem;
    font-weight:800;
    line-height:1.35;
    overflow:hidden;
    text-overflow:ellipsis;
    white-space:nowrap;
}

.product-unit {
    display:flex;
    align-items:center;
    gap:5px;
    margin-top:4px;
    color:var(--text-muted);
    font-size:.65rem;
    font-weight:600;
}

.product-unit i {
    color:var(--primary-green);
    font-size:.62rem;
}

.product-price {
    margin-top:7px;
    color:var(--accent-terracotta);
    font-size:.83rem;
    font-weight:800;
}

/* QUANTITY */
.quantity-control {
    display:flex;
    align-items:center;
    border:1px solid var(--border-color);
    border-radius:9px;
    background:#fff;
    overflow:hidden;
}

.quantity-btn {
    width:31px;
    height:31px;
    display:grid;
    place-items:center;
    border:0;
    background:transparent;
    color:var(--primary-dark);
    cursor:pointer;
    font-size:.72rem;
    font-weight:800;
    transition:.25s ease;
}

.quantity-btn:hover {
    background:var(--soft-green);
    color:var(--primary-green);
}

.quantity-btn:disabled {
    opacity:.4;
    cursor:not-allowed;
}

.quantity-btn:disabled:hover {
    background:transparent;
    color:var(--primary-dark);
}

.quantity-value {
    min-width:27px;
    text-align:center;
    color:var(--primary-dark);
    font-size:.7rem;
    font-weight:800;
}

/* ORDER SUMMARY */
.summary-card {
    margin-top:18px;
    padding:19px 20px;
    background:#fff;
    border:1px solid var(--border-color);
    border-radius:15px;
    box-shadow:var(--shadow-sm);
}

.summary-title {
    display:flex;
    align-items:center;
    gap:8px;
    color:var(--primary-dark);
    font-size:.95rem;
    font-weight:800;
}

.summary-title i {
    color:var(--primary-green);
    font-size:.85rem;
}

.summary-rows { margin-top:15px; }

.summary-row {
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
    min-height:30px;
    color:var(--text-muted);
    font-size:.73rem;
}

.summary-row strong {
    color:var(--primary-dark);
    font-size:.8rem;
    font-weight:800;
}

.summary-row .price {
    color:var(--text-main);
    font-weight:600;
    white-space:nowrap;
}

.summary-row.subtotal { min-height:34px; }
.summary-row.subtotal strong { font-size:.82rem; }
.summary-row.shipping-subtotal { margin-top:5px; }

.summary-divider {
    height:1px;
    margin:10px 0;
    background:var(--border-color);
}

.summary-row.total { min-height:38px; }
.summary-row.total strong { font-size:.9rem; }

.summary-row.total .price {
    color:var(--accent-terracotta);
    font-size:1.02rem;
    font-weight:800;
}

/* PAYMENT METHOD */
.payment-card {
    margin-top:14px;
    padding:17px 20px;
    background:#fff;
    border:1px solid var(--border-color);
    border-radius:15px;
    box-shadow:var(--shadow-sm);
}

.payment-title {
    color:var(--primary-dark);
    font-size:.88rem;
    font-weight:800;
}

.payment-option {
    margin-top:12px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:15px;
    padding:11px 12px;
    border:1px solid var(--border-color);
    border-radius:11px;
    background:#fbfcfa;
}

.payment-option-left {
    display:flex;
    align-items:center;
    gap:10px;
}

.payment-icon {
    width:32px;
    height:32px;
    display:grid;
    place-items:center;
    border-radius:9px;
    background:var(--soft-green);
    color:var(--primary-green);
    font-size:.78rem;
}

.payment-name {
    color:var(--primary-dark);
    font-size:.73rem;
    font-weight:800;
}

.payment-description {
    margin-top:1px;
    color:var(--text-muted);
    font-size:.59rem;
}

/* CIRCULAR PAYMENT SELECTION */
.radio-button {
    position:relative;
    flex:0 0 auto;
    width:22px;
    height:22px;
    border:2px solid var(--primary-green);
    border-radius:50%;
    background:#fff;
    cursor:pointer;
    transition:.3s var(--ease);
}

.radio-button:hover { transform:scale(1.08); }
.radio-button.selected { background:var(--primary-green); }

.radio-button.selected::after {
    content:"";
    position:absolute;
    top:50%;
    left:50%;
    width:7px;
    height:7px;
    border-radius:50%;
    background:#fff;
    transform:translate(-50%,-50%);
}

/* FINAL PAYMENT SECTION */
.final-payment {
    margin-top:14px;
    padding:19px 20px;
    background:var(--primary-dark);
    border:1px solid var(--primary-dark);
    border-radius:15px;
    box-shadow:var(--shadow-md);
}

.final-payment-top {
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:20px;
}

.final-label {
    color:rgba(255,255,255,.72);
    font-size:.7rem;
    font-weight:600;
}

.final-total {
    color:#fff;
    font-size:1.1rem;
    font-weight:800;
    white-space:nowrap;
}

.pay-button {
    width:100%;
    margin-top:14px;
    padding:13px 18px;
    border:0;
    border-radius:10px;
    background:var(--accent-terracotta);
    color:#fff;
    cursor:pointer;
    font-size:.78rem;
    font-weight:800;
    box-shadow:0 8px 20px rgba(0,0,0,.12);
    transition:transform .3s var(--spring),background .3s ease,box-shadow .3s ease;
}

.pay-button:hover {
    background:var(--accent-terracotta-hover);
    transform:translateY(-3px);
    box-shadow:0 12px 25px rgba(0,0,0,.2);
}

.pay-button:disabled {
    opacity:.7;
    cursor:not-allowed;
    transform:none;
}

/* MODAL OVERLAY */
.modal-overlay {
    position:fixed;
    inset:0;
    z-index:5000;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:20px;
    background:rgba(30,58,43,.38);
    backdrop-filter:blur(6px);
    opacity:0;
    visibility:hidden;
    transition:opacity .3s ease,visibility .3s ease;
}

.modal-overlay.open {
    opacity:1;
    visibility:visible;
}

/* CONFIRMATION MODAL */
.confirm-modal {
    width:min(420px,100%);
    padding:24px;
    background:#fff;
    border:1px solid var(--border-color);
    border-radius:18px;
    box-shadow:var(--shadow-lg);
    transform:translateY(18px) scale(.96);
    transition:transform .4s var(--spring);
}

.modal-overlay.open .confirm-modal { transform:none; }

.modal-icon {
    width:50px;
    height:50px;
    display:grid;
    place-items:center;
    margin-bottom:14px;
    border-radius:14px;
    background:var(--soft-terracotta);
    color:var(--accent-terracotta);
    font-size:1.15rem;
}

.modal-title {
    color:var(--primary-dark);
    font-size:1rem;
    font-weight:800;
}

.modal-message {
    margin-top:7px;
    color:var(--text-muted);
    font-size:.74rem;
    line-height:1.6;
}

.modal-actions {
    display:flex;
    justify-content:flex-end;
    gap:9px;
    margin-top:20px;
}

.modal-btn {
    min-width:115px;
    padding:10px 14px;
    border:1px solid var(--border-color);
    border-radius:9px;
    cursor:pointer;
    font-size:.68rem;
    font-weight:800;
    transition:.3s var(--ease);
}

.modal-btn:disabled {
    opacity:.6;
    cursor:not-allowed;
}

.modal-btn.cancel {
    background:#fff;
    color:var(--primary-dark);
}

.modal-btn.cancel:hover {
    background:var(--soft-green);
    border-color:rgba(45,90,63,.2);
}

.modal-btn.primary {
    border-color:var(--primary-dark);
    background:var(--primary-dark);
    color:#fff;
}

.modal-btn.primary:hover {
    background:var(--primary-green);
    transform:translateY(-2px);
}

.modal-btn.danger {
    border-color:var(--accent-terracotta);
    background:var(--accent-terracotta);
    color:#fff;
}

.modal-btn.danger:hover {
    background:var(--accent-terracotta-hover);
    transform:translateY(-2px);
}

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
    z-index:7000;
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

/* REVEAL ANIMATION */
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
    main::before,
    main::after,
    .body-side-decoration {
        display:none;
    }

    .navbar {
        padding-left:4%;
        padding-right:4%;
    }

    .order-page {
        width:92%;
        padding-top:108px;
    }

    .delivery-card { top:62px; }

    .footer-grid {
        grid-template-columns:1fr 1fr;
    }
}

/* MOBILE */
@media (max-width:650px) {
    .navbar { padding:13px 4%; }

    .navbar.scrolled {
        padding-top:9px;
        padding-bottom:9px;
    }

    .brand { font-size:1.2rem; }

    .back-button {
        min-width:38px;
        width:38px;
        height:36px;
        padding:0;
    }

    .back-button span { display:none; }

    .order-page {
        width:92%;
        padding:100px 0 30px;
    }

    .page-intro { margin-bottom:14px; }

    .page-intro h1 { font-size:1.5rem; }
    .page-intro p { font-size:.7rem; }

    /* DELIVERY */
    .delivery-card {
        top:58px;
        padding:12px 13px;
        border-radius:12px;
    }

    .delivery-top { gap:8px; }
    .delivery-label { font-size:.6rem; }
    .customer-line { font-size:.72rem; }
    .customer-address { font-size:.62rem; }

    /* PRODUCTS */
    .seller-header { padding:10px 12px; }
    .seller-name { font-size:.67rem; }
    .seller-label { font-size:.56rem; }

    .product-item {
        grid-template-columns:61px minmax(0,1fr) auto;
        gap:10px;
        padding:12px;
    }

    .product-image {
        width:61px;
        height:61px;
        border-radius:10px;
    }

    .product-image i { font-size:1.05rem; }
    .product-name { font-size:.71rem; }
    .product-unit { font-size:.58rem; }
    .product-price { font-size:.72rem; }

    .quantity-btn {
        width:27px;
        height:27px;
    }

    .quantity-value {
        min-width:23px;
        font-size:.64rem;
    }

    /* SUMMARY */
    .summary-card,
    .payment-card,
    .final-payment {
        padding:15px;
    }

    .summary-title { font-size:.85rem; }
    .summary-row { font-size:.65rem; }
    .summary-row strong { font-size:.72rem; }
    .summary-row.total .price { font-size:.92rem; }
    .payment-title { font-size:.8rem; }

    .payment-option { padding:9px 10px; }
    .payment-name { font-size:.67rem; }
    .payment-description { font-size:.55rem; }

    /* FINAL */
    .final-label { font-size:.64rem; }
    .final-total { font-size:.95rem; }

    .pay-button {
        padding:12px;
        font-size:.7rem;
    }

    /* MODAL */
    .confirm-modal {
        padding:20px;
        border-radius:15px;
    }

    .modal-title { font-size:.9rem; }
    .modal-message { font-size:.68rem; }

    .modal-actions {
        flex-direction:column-reverse;
    }

    .modal-btn { width:100%; }

    /* FOOTER */
    .footer-grid {
        grid-template-columns:1fr 1fr;
        gap:22px;
    }

    .footer-brand { grid-column:1 / -1; }

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
    .brand { font-size:1.05rem; }

    .order-page { padding-top:94px; }
    .delivery-card { top:53px; }
    .customer-line { font-size:.68rem; }
    .customer-address { max-width:100%; }

    .product-item {
        grid-template-columns:55px minmax(0,1fr) auto;
        gap:8px;
    }

    .product-image {
        width:55px;
        height:55px;
    }

    .quantity-btn {
        width:25px;
        height:25px;
    }

    .quantity-value { min-width:21px; }

    .footer-grid { grid-template-columns:1fr; }
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

<div class="ambient-bg">
    <div class="ambient-shape shape-a"></div>
    <div class="ambient-shape shape-b"></div>
</div>

<nav class="navbar" id="navbar">
    <a href="{{ route('shop') }}" class="brand">
        <i class="fa-solid fa-leaf"></i>
        <span>agrimarket</span>
    </a>

    <button type="button" class="back-button" id="backButton">
        <i class="fa-solid fa-arrow-left"></i>
        <span>Back</span>
    </button>
</nav>

<main>
    <div class="body-side-decoration left"></div>
    <div class="body-side-decoration right"></div>

    <section class="order-page reveal" id="orderPage">

        <div class="page-intro">
            <span class="eyebrow">Final Step</span>
            <h1>Order Summary</h1>
            <p>Review your delivery details and order before payment.</p>
        </div>

        <!-- DELIVERY INFORMATION -->
        <section class="delivery-card" id="deliveryCard">
            <div class="delivery-top">
                <div class="delivery-label">
                    <i class="fa-solid fa-location-dot"></i>
                    <span>Delivery Information</span>
                </div>
            </div>

            <div class="customer-line">
                <strong>{{ $customerName }}</strong>
                <strong>{{ $mobileNumber }}</strong>
            </div>

            <div class="customer-address" title="{{ $deliveryAddress }}">
                <i class="fa-solid fa-location-dot"></i>
                <span class="address-text">{{ $deliveryAddress }}</span>
            </div>
        </section>

        <div class="section-separator">
            <span>Products to Order</span>
        </div>

        <!-- MULTIPLE PRODUCTS -->
        <section class="products-section" id="productsSection">

            @foreach($items as $index => $item)

                <div class="seller-card">

                    <div class="seller-header">
                        <div class="seller-name">
                            <i class="fa-solid fa-store"></i>
                            <span>
                                {{ $item->seller_name ?? ('Seller #' . $item->seller_id) }}
                            </span>
                        </div>

                        <span class="seller-label">
                            Available Stock: {{ number_format($item->quantity) }}
                        </span>
                    </div>

                    <div
                        class="product-item"
                        data-product-id="{{ $item->product_id }}"
                        data-cart-id="{{ $item->cart_id ?? '' }}"
                        data-price="{{ $item->price }}"
                        data-stock="{{ $item->quantity }}"
                        data-shipping="{{ $item->shipping_fee }}"
                    >

                        <div class="product-image">
                            <img
                                src="{{ asset('image/product/' . $item->image) }}"
                                alt="{{ $item->product_name }}"
                                onerror="this.style.display='none';"
                            >
                        </div>

                        <div class="product-details">
                            <div class="product-name">
                                {{ $item->product_name }}
                            </div>

                            <div class="product-unit">
                                <i class="fa-solid fa-scale-balanced"></i>
                                {{ $item->oum }}
                            </div>

                            <div class="product-price">
                                ₱{{ number_format((float) $item->price, 2) }}
                            </div>
                        </div>

                        <div class="quantity-control">
                            <button
                                type="button"
                                class="quantity-btn decrease"
                                aria-label="Decrease quantity"
                                onclick="changeQuantity({{ $index }}, -1)"
                            >−</button>

                            <span class="quantity-value" aria-live="polite">1</span>

                            <button
                                type="button"
                                class="quantity-btn increase"
                                aria-label="Increase quantity"
                                onclick="changeQuantity({{ $index }}, 1)"
                            >+</button>
                        </div>

                    </div>
                </div>

            @endforeach

        </section>

        <!-- ORDER SUMMARY -->
        <section class="summary-card" id="summaryCard">

            <div class="summary-title">
                <i class="fa-solid fa-file-invoice-dollar"></i>
                <span>Order Summary</span>
            </div>

            <div class="summary-rows">

                <div class="summary-row subtotal">
                    <strong>Product Subtotal</strong>
                    <strong class="price" id="productSubtotal">₱0.00</strong>
                </div>

                <div class="summary-row">
                    <span>Total Quantity</span>
                    <span class="price" id="summaryQuantity">0</span>
                </div>

                <div class="summary-row shipping-subtotal">
                    <strong>Shipping Fees</strong>
                    <strong class="price" id="shippingFee">₱0.00</strong>
                </div>

                <div class="summary-divider"></div>

                <div class="summary-row total">
                    <strong>Total</strong>
                    <strong class="price" id="summaryTotal">₱0.00</strong>
                </div>

            </div>
        </section>

        <!-- PAYMENT METHOD -->
        <section class="payment-card" id="paymentCard">
            <div class="payment-title">Payment Method</div>

            <div class="payment-option">
                <div class="payment-option-left">
                    <div class="payment-icon">
                        <i class="fa-solid fa-money-bill-wave"></i>
                    </div>

                    <div>
                        <div class="payment-name">Cash on Delivery</div>
                        <div class="payment-description">Pay when your order arrives.</div>
                    </div>
                </div>

                <button
                    type="button"
                    class="radio-button selected"
                    id="codRadio"
                    aria-label="Cash on Delivery selected"
                    aria-pressed="true"
                    onclick="toggleCOD()"
                ></button>
            </div>
        </section>

        <!-- FINAL PAYMENT -->
        <section class="final-payment" id="finalPayment">

            <div class="final-payment-top">
                <div class="final-label">
                    Total <strong id="finalItemCount">(0 items)</strong>
                </div>

                <div class="final-total" id="finalTotal">₱0.00</div>
            </div>

            <button type="button" class="pay-button" id="payButton">
                Buy Now
                <i class="fa-solid fa-arrow-right"></i>
            </button>

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
                <li><a href="#">New & Fresh</a></li>
                <li><a href="#">Best Sellers</a></li>
                <li><a href="#">Groceries</a></li>
            </ul>
        </div>

    </div>

    <div class="copyright">© 2026 AgriMarket. All rights reserved.</div>
</footer>

<!-- LEAVE PAGE CONFIRMATION -->
<div class="modal-overlay" id="leaveModal">
    <div class="confirm-modal">
        <div class="modal-icon">
            <i class="fa-solid fa-arrow-left"></i>
        </div>

        <div class="modal-title">Leave Order Summary?</div>

        <div class="modal-message">
            Are you sure you want to leave? Your current order has not been saved yet. Leaving this page will cancel the current ordering process.
        </div>

        <div class="modal-actions">
            <button type="button" class="modal-btn cancel" id="continueOrderingButton">
                Continue Ordering
            </button>

            <button type="button" class="modal-btn danger" id="leaveButton">
                Leave
            </button>
        </div>
    </div>
</div>

<!-- PAYMENT CONFIRMATION -->
<div class="modal-overlay" id="paymentModal">
    <div class="confirm-modal">
        <div class="modal-icon" style="background:var(--soft-green);color:var(--primary-green);">
            <i class="fa-solid fa-circle-check"></i>
        </div>

        <div class="modal-title">Confirm Your Order</div>

        <div class="modal-message">
            Are you sure you want to continue with this order? Your order will proceed using Cash on Delivery.
        </div>

        <div class="modal-actions">
            <button type="button" class="modal-btn cancel" id="cancelPaymentButton">
                Cancel
            </button>

            <button type="button" class="modal-btn primary" id="continuePaymentButton">
                Continue
            </button>
        </div>
    </div>
</div>

<!-- TOAST -->
<div class="toast-container" id="toastContainer"></div>

<script>
/* =========================================
   MULTIPLE PRODUCT INFORMATION
========================================= */

const productElements = document.querySelectorAll(".product-item");

const orderItems = Array.from(productElements).map(element => ({
    element: element,
    id: Number(element.dataset.productId),
    cartId: element.dataset.cartId
        ? Number(element.dataset.cartId)
        : null,
    price: Number(element.dataset.price),
    stock: Number(element.dataset.stock),
    shipping: Number(element.dataset.shipping),
    quantity: 1
}));

let codSelected = true;
let orderSubmitting = false;
let orderPlaced = false;


/* =========================================
   FORMAT PRICE
========================================= */

function formatPrice(price) {
    return Number(price).toLocaleString("en-PH", {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}


/* =========================================
   CALCULATE ORDER
========================================= */

function calculateOrder() {

    let productSubtotal = 0;
    let totalQuantity = 0;
    let totalShipping = 0;

    orderItems.forEach(item => {

        productSubtotal += item.price * item.quantity;

        totalQuantity += item.quantity;

        totalShipping += item.shipping;

    });

    return {
        productSubtotal,
        totalQuantity,
        shippingFee: totalShipping,
        total: productSubtotal + totalShipping
    };
}


/* =========================================
   UPDATE ORDER SUMMARY
========================================= */

function updateOrderSummary() {

    const order = calculateOrder();

    document.getElementById("productSubtotal").textContent =
        `₱${formatPrice(order.productSubtotal)}`;

    document.getElementById("summaryQuantity").textContent =
        order.totalQuantity;

    document.getElementById("shippingFee").textContent =
        `₱${formatPrice(order.shippingFee)}`;

    document.getElementById("summaryTotal").textContent =
        `₱${formatPrice(order.total)}`;

    document.getElementById("finalItemCount").textContent =
        `(${order.totalQuantity} ${
            order.totalQuantity === 1 ? "item" : "items"
        })`;

    document.getElementById("finalTotal").textContent =
        `₱${formatPrice(order.total)}`;

    updateQuantityButtons();
}


/* =========================================
   UPDATE QUANTITY BUTTON STATES
========================================= */

function updateQuantityButtons() {

    orderItems.forEach(item => {

        const decreaseButton =
            item.element.querySelector(".decrease");

        const increaseButton =
            item.element.querySelector(".increase");

        const quantityValue =
            item.element.querySelector(".quantity-value");

        quantityValue.textContent = item.quantity;

        decreaseButton.disabled =
            item.quantity <= 1 || orderPlaced || orderSubmitting;

        increaseButton.disabled =
            item.quantity >= item.stock || orderPlaced || orderSubmitting;

    });
}


/* =========================================
   CHANGE INDIVIDUAL PRODUCT QUANTITY
========================================= */

function changeQuantity(index, amount) {

    if (orderPlaced || orderSubmitting) {
        return;
    }

    const item = orderItems[index];

    if (!item) {
        return;
    }

    const newQuantity = item.quantity + amount;

    if (newQuantity < 1) {
        showToast("Quantity cannot be less than 1.");
        return;
    }

    if (newQuantity > item.stock) {
        showToast(`Only ${item.stock} available in stock.`);
        return;
    }

    item.quantity = newQuantity;

    updateOrderSummary();
}


/* =========================================
   CASH ON DELIVERY
========================================= */

function toggleCOD() {

    if (orderPlaced || orderSubmitting) {
        return;
    }

    codSelected = !codSelected;

    const radio = document.getElementById("codRadio");

    radio.classList.toggle("selected", codSelected);

    radio.setAttribute("aria-pressed", String(codSelected));

    radio.setAttribute(
        "aria-label",
        codSelected
            ? "Cash on Delivery selected"
            : "Cash on Delivery not selected"
    );

    if (codSelected) {
        showToast("Cash on Delivery selected.");
    } else {
        showToast("Please select Cash on Delivery before continuing.");
    }
}


/* =========================================
   BACK BUTTON
========================================= */

document.getElementById("backButton").addEventListener("click", () => {

    if (orderSubmitting || orderPlaced) {
        return;
    }

    openModal("leaveModal");

});


/* =========================================
   CONTINUE ORDERING
========================================= */

document.getElementById("continueOrderingButton")
    .addEventListener("click", () => {

        closeModal("leaveModal");

    });


/* =========================================
   LEAVE PAGE
========================================= */

document.getElementById("leaveButton").addEventListener("click", () => {

    if (orderSubmitting) {
        return;
    }

    window.location.href = @json(route('cart'));

});


/* =========================================
   ACTIVATE TO PAY
========================================= */

document.getElementById("payButton").addEventListener("click", () => {

    if (orderSubmitting || orderPlaced) {
        return;
    }

    if (!codSelected) {
        showToast("Please select Cash on Delivery.");
        return;
    }

    if (orderItems.length === 0) {
        showToast("There are no products to order.");
        return;
    }

    const unavailableItem = orderItems.find(item => item.stock < 1);

    if (unavailableItem) {
        showToast("One of your products is out of stock.");
        return;
    }

    openModal("paymentModal");

});


/* =========================================
   CANCEL PAYMENT
========================================= */

document.getElementById("cancelPaymentButton")
    .addEventListener("click", () => {

        if (orderSubmitting) {
            return;
        }

        closeModal("paymentModal");

    });


/* =========================================
   CONTINUE PAYMENT
   SAVE ALL PRODUCTS TO DATABASE
========================================= */

document.getElementById("continuePaymentButton")
    .addEventListener("click", async () => {

        if (orderSubmitting || orderPlaced) {
            return;
        }

        if (!codSelected) {
            showToast("Please select Cash on Delivery.");
            closeModal("paymentModal");
            return;
        }

        if (orderItems.length === 0) {
            showToast("There are no products to order.");
            closeModal("paymentModal");
            return;
        }

        const invalidItem = orderItems.find(item =>
            item.quantity < 1 ||
            item.quantity > item.stock
        );

        if (invalidItem) {
            showToast("One of your product quantities is invalid.");
            closeModal("paymentModal");
            return;
        }

        const continueButton =
            document.getElementById("continuePaymentButton");

        const payButton =
            document.getElementById("payButton");

        const originalButtonText = continueButton.textContent;

        try {

            orderSubmitting = true;

            continueButton.disabled = true;
            payButton.disabled = true;

            continueButton.textContent = "Processing...";

            payButton.innerHTML = `
                <i class="fa-solid fa-spinner fa-spin"></i>
                Processing Order...
            `;

            updateQuantityButtons();

            const payload = {

                items: orderItems.map(item => ({
                    product_id: item.id,
                    quantity: item.quantity,
                    cart_id: item.cartId
                })),

                cart_ids: orderItems
                    .filter(item => item.cartId !== null)
                    .map(item => item.cartId)

            };

            const response = await fetch(
                @json(route('orders.store')),
                {
                    method: "POST",

                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json",

                        "X-CSRF-TOKEN": document.querySelector(
                            'meta[name="csrf-token"]'
                        ).getAttribute("content")
                    },

                    body: JSON.stringify(payload)
                }
            );

            const result = await response.json();

            if (!response.ok || !result.success) {

                throw new Error(
                    result.message || "Unable to process your order."
                );

            }

            orderPlaced = true;

            closeModal("paymentModal");

            showToast(
                result.message || "Your orders have been placed successfully."
            );

            payButton.innerHTML = `
                <i class="fa-solid fa-circle-check"></i>
                Order Placed
            `;

            payButton.disabled = true;

            updateQuantityButtons();

            // Return to the cart after successful checkout.
            setTimeout(() => {
                window.location.href = @json(route('cart'));
            }, 1800);

        } catch (error) {

            console.error("Order submission error:", error);

            closeModal("paymentModal");

            showToast(
                error.message || "Something went wrong. Please try again."
            );

            payButton.disabled = false;

            payButton.innerHTML = `
                Buy Now
                <i class="fa-solid fa-arrow-right"></i>
            `;

            updateQuantityButtons();

        } finally {

            orderSubmitting = false;

            continueButton.disabled = false;

            continueButton.textContent = originalButtonText;

            if (!orderPlaced) {
                updateQuantityButtons();
            }

        }

    });


/* =========================================
   OPEN MODAL
========================================= */

function openModal(id) {

    document.getElementById(id).classList.add("open");

}


/* =========================================
   CLOSE MODAL
========================================= */

function closeModal(id) {

    document.getElementById(id).classList.remove("open");

}


/* =========================================
   CLOSE MODAL BY CLICKING OUTSIDE
========================================= */

document.querySelectorAll(".modal-overlay").forEach(modal => {

    modal.addEventListener("click", event => {

        if (event.target === modal && !orderSubmitting) {
            closeModal(modal.id);
        }

    });

});


/* =========================================
   ESCAPE KEY
========================================= */

document.addEventListener("keydown", event => {

    if (event.key === "Escape" && !orderSubmitting) {

        document.querySelectorAll(".modal-overlay.open").forEach(modal => {
            closeModal(modal.id);
        });

    }

});


/* =========================================
   TOAST
========================================= */

function showToast(message) {

    const container =
        document.getElementById("toastContainer");

    const toast =
        document.createElement("div");

    toast.className = "toast";

    const icon = document.createElement("i");
    icon.className = "fa-solid fa-circle-check";

    const messageElement = document.createElement("span");
    messageElement.textContent = message;

    toast.appendChild(icon);
    toast.appendChild(messageElement);

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


/* =========================================
   NAVBAR SCROLL EFFECT
========================================= */

window.addEventListener("scroll", () => {

    document.getElementById("navbar").classList.toggle(
        "scrolled",
        window.scrollY > 25
    );

}, { passive: true });


/* =========================================
   CLICK POP
========================================= */

document.addEventListener("click", event => {

    if (event.clientX === 0 && event.clientY === 0) return;

    const pop = document.createElement("span");

    pop.className = "click-pop";
    pop.style.left = `${event.clientX}px`;
    pop.style.top = `${event.clientY}px`;

    document.body.appendChild(pop);

    setTimeout(() => pop.remove(), 700);

});


/* =========================================
   REVEAL ANIMATION
========================================= */

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
        threshold: .08,
        rootMargin: "0px 0px -35px 0px"
    }
);

document.querySelectorAll(".reveal").forEach(element => {
    observer.observe(element);
});


/* =========================================
   INITIAL SETUP
========================================= */

updateOrderSummary();

</script>

</body>
</html>
