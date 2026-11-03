<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>AgriMarket - My Orders</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
:root{
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

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:"Plus Jakarta Sans",sans-serif;
}

html{scroll-behavior:smooth}

body{
    background:var(--bg-cream);
    color:var(--text-main);
    line-height:1.55;
    overflow-x:hidden;
}

button,input,select{font:inherit}
button,a{-webkit-tap-highlight-color:transparent}
button{cursor:pointer}
a{color:inherit}

/* =========================
   AMBIENT BACKGROUND
========================= */

.ambient-bg{
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

.ambient-bg::after{
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

.ambient-shape{
    position:absolute;
    width:34vw;
    height:34vw;
    min-width:250px;
    min-height:250px;
    border-radius:48% 52% 65% 35% / 38% 45% 55% 62%;
    filter:blur(3px);
    opacity:.3;
}

.shape-a{
    top:-14vw;
    left:-12vw;
    background:radial-gradient(circle at 40% 40%,rgba(82,145,104,.22),transparent 68%);
    animation:driftA 18s ease-in-out infinite alternate;
}

.shape-b{
    right:-13vw;
    top:28vh;
    background:radial-gradient(circle at 45% 45%,rgba(211,107,72,.18),transparent 68%);
    animation:driftB 23s ease-in-out infinite alternate;
}

@keyframes driftA{
    to{transform:translate(10vw,9vh) rotate(25deg) scale(1.12)}
}

@keyframes driftB{
    to{transform:translate(-8vw,-12vh) rotate(-30deg) scale(1.16)}
}

/* =========================
   NAVBAR
========================= */

.navbar{
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

.navbar.scrolled{
    padding-top:10px;
    padding-bottom:10px;
    background:rgba(249,248,243,.78);
    box-shadow:0 12px 35px rgba(30,58,43,.08);
}

.brand{
    display:flex;
    align-items:center;
    gap:9px;
    color:var(--primary-dark);
    text-decoration:none;
    font-size:1.45rem;
    font-weight:800;
    white-space:nowrap;
}

.brand i{color:var(--primary-green)}

.nav-actions{
    margin-left:auto;
    display:flex;
    align-items:center;
    gap:7px;
}

.icon-btn{
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

.icon-btn:hover{
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

.badge{
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

.dropdown-wrap{position:relative}

.dropdown{
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

.dropdown.open{
    opacity:1;
    visibility:visible;
    transform:none;
}

.dropdown a,
.dropdown button{
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
.dropdown button:hover{
    background:var(--soft-green);
    color:var(--primary-green);
}

/* =========================
   GENERAL
========================= */

main{
    width:min(1400px,90%);
    margin:0 auto;
    padding-top:96px;
    padding-bottom:20px;
}

.section{
    padding:24px 0;
}

.section-heading{
    display:flex;
    align-items:end;
    justify-content:space-between;
    gap:20px;
    margin-bottom:14px;
}

.heading-left .eyebrow{
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

.heading-left h2{
    margin-top:8px;
    color:var(--primary-dark);
    font-size:clamp(1.55rem,2.5vw,2.25rem);
    line-height:1.15;
    font-weight:800;
}

.heading-left p{
    margin-top:5px;
    color:var(--text-muted);
    font-size:.88rem;
}

/* =========================
   PAGE HEADER
========================= */

.orders-header{
    padding:20px 0 10px;
}

.orders-header-inner{
    display:flex;
    align-items:flex-end;
    justify-content:space-between;
    gap:20px;
}

.orders-header h1{
    margin-top:8px;
    color:var(--primary-dark);
    font-size:clamp(1.8rem,3vw,2.65rem);
    line-height:1.1;
    font-weight:800;
}

.orders-header p{
    margin-top:7px;
    color:var(--text-muted);
    font-size:.9rem;
}

.page-icon{
    width:56px;
    height:56px;
    display:grid;
    place-items:center;
    flex:0 0 56px;
    border-radius:16px;
    background:var(--soft-green);
    color:var(--primary-green);
    box-shadow:var(--shadow-sm);
    font-size:1.3rem;
}

/* =========================
   STATISTICS
========================= */

.stats-grid{
    display:grid;
    grid-template-columns:repeat(5,minmax(0,1fr));
    gap:13px;
}

.stat-card{
    position:relative;
    overflow:hidden;
    padding:17px;
    background:#fff;
    border:1px solid rgba(228,231,236,.85);
    border-radius:15px;
    box-shadow:var(--shadow-sm);
    transition:transform .35s var(--spring),box-shadow .35s ease,border-color .35s ease;
}

.stat-card::after{
    content:"";
    position:absolute;
    right:-35px;
    bottom:-45px;
    width:110px;
    height:110px;
    border-radius:50%;
    background:var(--soft-green);
    opacity:.7;
    transition:transform .5s var(--ease);
}

.stat-card:hover{
    transform:translateY(-6px);
    box-shadow:var(--shadow-lg);
    border-color:rgba(45,90,63,.15);
}

.stat-card:hover::after{
    transform:scale(1.4);
}

.stat-top{
    position:relative;
    z-index:1;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
}

.stat-icon{
    width:38px;
    height:38px;
    display:grid;
    place-items:center;
    border-radius:10px;
    background:var(--soft-green);
    color:var(--primary-green);
}

.stat-card.sales .stat-icon{
    background:var(--soft-terracotta);
    color:var(--accent-terracotta);
}

.stat-label{
    position:relative;
    z-index:1;
    margin-top:13px;
    color:var(--text-muted);
    font-size:.7rem;
    font-weight:700;
}

.stat-value{
    position:relative;
    z-index:1;
    margin-top:3px;
    color:var(--primary-dark);
    font-size:1.45rem;
    line-height:1.2;
    font-weight:800;
}

.stat-sub{
    position:relative;
    z-index:1;
    margin-top:4px;
    color:var(--text-muted);
    font-size:.62rem;
}

/* =========================
   CUSTOMER INFORMATION
========================= */

.customer-sticky{
    position:sticky;
    top:74px;
    z-index:80;
    margin-top:8px;
    padding:12px 0;
    background:rgba(249,248,243,.78);
    backdrop-filter:blur(12px);
}

.customer-card{
    display:grid;
    grid-template-columns:1.5fr 1fr 1fr;
    gap:10px;
    padding:13px;
    background:rgba(255,255,255,.94);
    border:1px solid var(--border-color);
    border-radius:15px;
    box-shadow:var(--shadow-md);
}

.customer-item{
    min-width:0;
    display:flex;
    align-items:center;
    gap:11px;
    padding:8px 11px;
    border-radius:10px;
    background:#fff;
}

.customer-icon{
    width:35px;
    height:35px;
    flex:0 0 35px;
    display:grid;
    place-items:center;
    border-radius:9px;
    background:var(--soft-green);
    color:var(--primary-green);
}

.customer-content{
    min-width:0;
}

.customer-label{
    color:var(--text-muted);
    font-size:.62rem;
    font-weight:700;
}

.customer-value{
    margin-top:1px;
    color:var(--primary-dark);
    font-size:.78rem;
    font-weight:800;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}

/* =========================
   CONTROLS
========================= */

.section-tools{
    display:flex;
    align-items:center;
    justify-content:flex-end;
    gap:8px;
    flex-wrap:wrap;
}

.search-box{
    width:min(330px,100%);
    display:flex;
    align-items:center;
    gap:8px;
    padding:5px 6px 5px 12px;
    background:#fff;
    border:1px solid var(--border-color);
    border-radius:11px;
    box-shadow:var(--shadow-sm);
}

.search-box i{
    color:var(--text-muted);
    font-size:.8rem;
}

.search-box input{
    width:100%;
    min-width:0;
    border:0;
    outline:0;
    background:transparent;
    color:var(--text-main);
    padding:8px 2px;
    font-size:.76rem;
}

.control-btn,
.filter-select{
    height:38px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:7px;
    padding:0 12px;
    border:1px solid var(--border-color);
    border-radius:10px;
    background:#fff;
    color:var(--primary-dark);
    font-size:.72rem;
    font-weight:800;
    transition:.3s var(--ease);
}

.control-btn:hover{
    background:var(--soft-green);
    border-color:rgba(45,90,63,.2);
    color:var(--primary-green);
    transform:translateY(-2px);
}

.filter-select{
    outline:0;
}

.stock-add-btn{
    background:var(--primary-dark);
    border-color:var(--primary-dark);
    color:#fff;
}

.stock-add-btn:hover{
    background:var(--primary-green);
    border-color:var(--primary-green);
    color:#fff;
}

.stock-section{
    opacity:1;
    visibility:visible;
    transform:none;
    filter:none;
}

.stock-section .stock-grid > .product-card{
    opacity:1;
    transform:none;
    transition:transform .35s var(--spring),box-shadow .35s ease,border-color .35s ease;
}

.qty-btn:disabled{
    opacity:.45;
    cursor:not-allowed;
    transform:none;
}

.qty-btn:disabled:hover{
    background:#fff;
    color:var(--primary-green);
}

.stock-form{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:13px;
}

.stock-form-group{
    min-width:0;
    display:flex;
    flex-direction:column;
    gap:6px;
}

.stock-form-group.full{
    grid-column:1 / -1;
}

.stock-form-group label{
    color:var(--primary-dark);
    font-size:.7rem;
    font-weight:800;
}

.stock-form-group input,
.stock-form-group select{
    width:100%;
    min-height:42px;
    padding:9px 11px;
    border:1px solid var(--border-color);
    border-radius:9px;
    outline:0;
    background:#fff;
    color:var(--text-main);
    font-size:.76rem;
}

.stock-form-group input:focus,
.stock-form-group select:focus{
    border-color:var(--primary-green);
    box-shadow:0 0 0 3px rgba(45,90,63,.09);
}

.stock-form-help{
    color:var(--text-muted);
    font-size:.62rem;
}

.stock-form-error{
    display:none;
    grid-column:1 / -1;
    padding:10px 12px;
    border-radius:9px;
    background:var(--soft-terracotta);
    color:#a33d2c;
    font-size:.72rem;
    font-weight:700;
}

.stock-form-error.show{
    display:block;
}

.stock-form-submit{
    display:flex;
    justify-content:flex-end;
    gap:8px;
    grid-column:1 / -1;
    margin-top:4px;
}

.stock-form-submit button{
    min-height:39px;
    padding:0 15px;
    border:0;
    border-radius:9px;
    font-size:.7rem;
    font-weight:800;
}

.stock-cancel-btn{
    background:var(--soft-green);
    color:var(--primary-dark);
}

.stock-save-btn{
    background:var(--primary-dark);
    color:#fff;
}

.stock-save-btn:hover{
    background:var(--primary-green);
}

.stock-save-btn:disabled{
    opacity:.6;
    cursor:wait;
}

@media(max-width:650px){
    .stock-form{grid-template-columns:1fr;}
    .stock-form-group.full{grid-column:auto;}
    .stock-form-submit{grid-column:auto;}
}

/* =========================
   MY STOCKS
========================= */

.stocks-container{
    max-height:690px;
    overflow-y:auto;
    overflow-x:hidden;
    padding:3px 5px 10px 2px;
    scrollbar-width:thin;
    scrollbar-color:rgba(45,90,63,.35) transparent;
}

.stocks-container::-webkit-scrollbar{
    width:7px;
}

.stocks-container::-webkit-scrollbar-track{
    background:transparent;
}

.stocks-container::-webkit-scrollbar-thumb{
    background:rgba(45,90,63,.3);
    border-radius:20px;
}

.stock-grid{
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:13px;
}

.product-card{
    position:relative;
    min-width:0;
    overflow:hidden;
    background:#fff;
    border:1px solid rgba(228,231,236,.85);
    border-radius:15px;
    box-shadow:var(--shadow-sm);
    transition:transform .35s var(--spring),box-shadow .35s ease,border-color .35s ease;
}

.product-card:hover{
    transform:translateY(-7px);
    box-shadow:var(--shadow-lg);
    border-color:rgba(45,90,63,.15);
}

.product-card.stock-highlight{
    border:3px solid var(--accent-terracotta);
    box-shadow:0 0 0 4px rgba(211,107,72,.12),var(--shadow-lg);
    animation:highlightCard 2.8s ease;
}

@keyframes highlightCard{
    0%,100%{box-shadow:0 0 0 4px rgba(211,107,72,.12),var(--shadow-lg)}
    30%{box-shadow:0 0 0 9px rgba(211,107,72,.18),var(--shadow-lg)}
    60%{box-shadow:0 0 0 4px rgba(211,107,72,.12),var(--shadow-lg)}
}

.product-image{
    position:relative;
    height:155px;
    overflow:hidden;
    background:#e9ecef;
}

.placeholder{
    position:absolute;
    inset:0;
    display:grid;
    place-items:center;
    text-align:center;
    padding:20px;
    color:#6c757d;
    background:
        linear-gradient(135deg,rgba(255,255,255,.38),transparent 50%),
        #e9ecef;
}

.placeholder::before{
    content:"";
    position:absolute;
    width:180%;
    height:50%;
    background:rgba(255,255,255,.34);
    transform:rotate(-18deg) translateX(-80%);
    transition:transform .9s var(--ease);
}

.product-card:hover .placeholder::before{
    transform:rotate(-18deg) translateX(80%);
}

.placeholder-content{
    position:relative;
    z-index:1;
}

.placeholder i{
    font-size:2rem;
    color:#a8b0b5;
    margin-bottom:7px;
}

.placeholder strong{
    display:block;
    font-size:.72rem;
}

.placeholder small{
    display:block;
    margin-top:3px;
    font-size:.62rem;
}

.stock-badge{
    position:absolute;
    top:9px;
    left:9px;
    z-index:2;
    padding:4px 8px;
    border-radius:7px;
    background:var(--primary-green);
    color:#fff;
    font-size:.58rem;
    font-weight:800;
}

.stock-info{
    padding:12px;
}

.product-name{
    min-height:36px;
    color:var(--primary-dark);
    font-size:.8rem;
    font-weight:800;
    line-height:1.35;
}

.product-price{
    margin-top:5px;
    color:var(--accent-terracotta);
    font-size:.95rem;
    font-weight:800;
}

.product-meta{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:5px;
    margin-top:4px;
    color:var(--text-muted);
    font-size:.65rem;
}

.quantity-control{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:6px;
    margin-top:11px;
    padding:5px;
    border-radius:9px;
    background:var(--soft-green);
}

.qty-btn{
    width:30px;
    height:30px;
    display:grid;
    place-items:center;
    border:0;
    border-radius:7px;
    background:#fff;
    color:var(--primary-green);
    box-shadow:0 2px 8px rgba(0,0,0,.05);
    transition:.25s var(--spring);
}

.qty-btn:hover{
    background:var(--primary-green);
    color:#fff;
    transform:scale(1.08);
}

.qty-value{
    flex:1;
    text-align:center;
    color:var(--primary-dark);
    font-size:.75rem;
    font-weight:800;
}

.stock-actions{
    display:grid;
    grid-template-columns:1fr;
    gap:6px;
    margin-top:7px;
}

.remove-btn{
    border:0;
    border-radius:8px;
    padding:8px 5px;
    background:var(--soft-terracotta);
    color:var(--accent-terracotta);
    font-size:.65rem;
    font-weight:800;
    transition:.3s var(--ease);
}

.remove-btn:hover{
    background:var(--accent-terracotta);
    color:#fff;
    transform:translateY(-2px);
}

.empty-state{
    padding:45px 20px;
    text-align:center;
    border:1px dashed #cbd4cd;
    border-radius:15px;
    background:rgba(255,255,255,.65);
}

.empty-state i{
    font-size:2rem;
    color:#a8b0b5;
}

.empty-state h3{
    margin-top:9px;
    color:var(--primary-dark);
    font-size:1rem;
}

.empty-state p{
    margin-top:4px;
    color:var(--text-muted);
    font-size:.75rem;
}

/* =========================
   TRANSACTION TABLE
========================= */

.transaction-wrapper{
    overflow:hidden;
    background:#fff;
    border:1px solid var(--border-color);
    border-radius:15px;
    box-shadow:var(--shadow-sm);
}

.transaction-scroll{
    max-height:470px;
    overflow-y:auto;
    overflow-x:auto;
    scrollbar-width:thin;
    scrollbar-color:rgba(45,90,63,.35) transparent;
}

.transaction-scroll::-webkit-scrollbar{
    width:7px;
    height:7px;
}

.transaction-scroll::-webkit-scrollbar-thumb{
    background:rgba(45,90,63,.3);
    border-radius:20px;
}

.transaction-table{
    width:100%;
    min-width:760px;
    border-collapse:collapse;
}

.transaction-table thead{
    position:sticky;
    top:0;
    z-index:3;
}

.transaction-table th{
    padding:13px 15px;
    background:var(--primary-dark);
    color:#fff;
    text-align:left;
    font-size:.68rem;
    font-weight:800;
    white-space:nowrap;
}

.transaction-table td{
    padding:13px 15px;
    border-bottom:1px solid #edf0f1;
    color:var(--text-main);
    font-size:.72rem;
    vertical-align:middle;
}

.transaction-row{
    cursor:pointer;
    transition:background .25s ease,transform .25s ease;
}

.transaction-row:hover{
    background:var(--soft-green);
}

.transaction-row:last-child td{
    border-bottom:0;
}

.order-id{
    color:var(--primary-green);
    font-weight:800;
}

.amount{
    color:var(--accent-terracotta);
    font-weight:800;
}

.status{
    display:inline-flex;
    align-items:center;
    gap:5px;
    padding:5px 9px;
    border-radius:20px;
    font-size:.6rem;
    font-weight:800;
}

.status.shipping{
    background:var(--soft-terracotta);
    color:var(--accent-terracotta);
}

.status.completed{
    background:var(--soft-green);
    color:var(--primary-green);
}

.status::before{
    content:"";
    width:6px;
    height:6px;
    border-radius:50%;
    background:currentColor;
}

.no-results{
    padding:35px 15px!important;
    text-align:center;
    color:var(--text-muted)!important;
}

/* =========================
   ORDER REQUESTS
========================= */

.requests-container{
    overflow-x:auto;
    overflow-y:hidden;
    padding:3px 3px 13px;
    scrollbar-width:thin;
    scrollbar-color:rgba(45,90,63,.35) transparent;
}

.requests-container::-webkit-scrollbar{
    height:7px;
}

.requests-container::-webkit-scrollbar-thumb{
    background:rgba(45,90,63,.3);
    border-radius:20px;
}

.requests-grid{
    display:flex;
    gap:13px;
    width:max-content;
}

.request-card{
    position:relative;
    width:280px;
    flex:0 0 280px;
    padding:16px;
    background:#fff;
    border:1px solid rgba(228,231,236,.85);
    border-radius:15px;
    box-shadow:var(--shadow-sm);
    cursor:pointer;
    transition:transform .35s var(--spring),box-shadow .35s ease,border-color .35s ease;
}

.request-card:hover{
    transform:translateY(-7px);
    box-shadow:var(--shadow-lg);
    border-color:rgba(45,90,63,.2);
}

.request-top{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:10px;
}

.customer-avatar{
    width:40px;
    height:40px;
    display:grid;
    place-items:center;
    flex:0 0 40px;
    border-radius:50%;
    background:var(--soft-green);
    color:var(--primary-green);
    font-weight:800;
}

.request-customer{
    flex:1;
    min-width:0;
}

.request-customer strong{
    display:block;
    color:var(--primary-dark);
    font-size:.76rem;
    white-space:nowrap;
    overflow:hidden;
    text-overflow:ellipsis;
}

.request-customer small{
    display:block;
    margin-top:2px;
    color:var(--text-muted);
    font-size:.6rem;
}

.request-details{
    margin-top:14px;
    padding-top:12px;
    border-top:1px solid #edf0f1;
}

.request-line{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    margin-bottom:7px;
    font-size:.68rem;
}

.request-line span:first-child{
    color:var(--text-muted);
}

.request-line span:last-child{
    color:var(--primary-dark);
    font-weight:800;
    text-align:right;
}

.request-total{
    color:var(--accent-terracotta)!important;
    font-size:.82rem;
}

.request-actions{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:7px;
    margin-top:13px;
}

.request-btn{
    border:0;
    border-radius:8px;
    padding:9px 6px;
    font-size:.65rem;
    font-weight:800;
    transition:.3s var(--ease);
}

.accept-btn{
    background:var(--primary-dark);
    color:#fff;
}

.accept-btn:hover{
    background:var(--primary-green);
    transform:translateY(-2px);
}

.decline-btn{
    background:var(--soft-terracotta);
    color:var(--accent-terracotta);
}

.decline-btn:hover{
    background:var(--accent-terracotta);
    color:#fff;
    transform:translateY(-2px);
}

/* =========================
   MODAL
========================= */

.modal-overlay{
    position:fixed;
    inset:0;
    z-index:5000;
    display:grid;
    place-items:center;
    padding:20px;
    background:rgba(30,58,43,.35);
    backdrop-filter:blur(7px);
    opacity:0;
    visibility:hidden;
    transition:.3s ease;
}

.modal-overlay.open{
    opacity:1;
    visibility:visible;
}

.modal{
    width:min(620px,100%);
    max-height:min(760px,90vh);
    overflow-y:auto;
    background:#fff;
    border:1px solid var(--border-color);
    border-radius:18px;
    box-shadow:0 30px 70px rgba(30,58,43,.2);
    transform:translateY(20px) scale(.97);
    transition:.4s var(--spring);
}

.modal-overlay.open .modal{
    transform:none;
}

.modal-header{
    position:sticky;
    top:0;
    z-index:2;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:15px;
    padding:17px 19px;
    background:rgba(255,255,255,.95);
    backdrop-filter:blur(10px);
    border-bottom:1px solid #edf0f1;
}

.modal-title{
    color:var(--primary-dark);
    font-size:1rem;
    font-weight:800;
}

.modal-subtitle{
    margin-top:2px;
    color:var(--text-muted);
    font-size:.65rem;
}

.modal-close{
    width:35px;
    height:35px;
    display:grid;
    place-items:center;
    border:0;
    border-radius:9px;
    background:var(--soft-green);
    color:var(--primary-dark);
    transition:.3s var(--ease);
}

.modal-close:hover{
    background:var(--primary-dark);
    color:#fff;
    transform:rotate(5deg);
}

.modal-body{
    padding:19px;
}

.detail-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:10px;
}

.detail-item{
    padding:11px 12px;
    border:1px solid #edf0f1;
    border-radius:10px;
    background:#fcfcfa;
}

.detail-item.full{
    grid-column:1 / -1;
}

.detail-label{
    color:var(--text-muted);
    font-size:.6rem;
    font-weight:700;
}

.detail-value{
    margin-top:3px;
    color:var(--primary-dark);
    font-size:.76rem;
    font-weight:800;
}

.detail-products{
    margin-top:16px;
}

.detail-products h4{
    margin-bottom:8px;
    color:var(--primary-dark);
    font-size:.8rem;
}

.detail-product{
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:12px;
    padding:10px 0;
    border-bottom:1px solid #edf0f1;
    font-size:.7rem;
}

.detail-product:last-child{
    border-bottom:0;
}

.detail-product-name{
    color:var(--primary-dark);
    font-weight:800;
}

.detail-product-qty{
    color:var(--text-muted);
}

.modal-footer{
    display:flex;
    align-items:center;
    justify-content:flex-end;
    gap:8px;
    padding:14px 19px 18px;
    border-top:1px solid #edf0f1;
}

.modal-action{
    border:0;
    border-radius:9px;
    padding:9px 14px;
    font-size:.68rem;
    font-weight:800;
    transition:.3s var(--ease);
}

.modal-action.primary{
    background:var(--primary-dark);
    color:#fff;
}

.modal-action.primary:hover{
    background:var(--primary-green);
    transform:translateY(-2px);
}

.modal-action.decline{
    background:var(--soft-terracotta);
    color:var(--accent-terracotta);
}

.modal-action.decline:hover{
    background:var(--accent-terracotta);
    color:#fff;
}

/* =========================
   REVEAL ANIMATIONS
========================= */

.reveal{
    opacity:0;
    transform:translateY(48px) scale(.98);
    filter:blur(5px);
    transition:opacity .75s var(--ease),transform .85s var(--ease),filter .75s var(--ease);
}

.reveal.from-left{transform:translateX(-55px)}
.reveal.from-right{transform:translateX(55px)}

.reveal.visible{
    opacity:1;
    transform:none;
    filter:blur(0);
}

.stagger>*{
    opacity:0;
    transform:translateY(25px);
    transition:opacity .6s var(--ease),transform .65s var(--ease);
}

.stagger.visible>*{
    opacity:1;
    transform:none;
}

.stagger.visible>*:nth-child(1){transition-delay:.03s}
.stagger.visible>*:nth-child(2){transition-delay:.08s}
.stagger.visible>*:nth-child(3){transition-delay:.13s}
.stagger.visible>*:nth-child(4){transition-delay:.18s}
.stagger.visible>*:nth-child(5){transition-delay:.23s}
.stagger.visible>*:nth-child(6){transition-delay:.28s}

/* =========================
   TOAST
========================= */

.toast-container{
    position:fixed;
    right:22px;
    bottom:22px;
    z-index:6000;
    display:flex;
    flex-direction:column;
    gap:8px;
}

.toast{
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

.toast i{color:#b9d7c0}

@keyframes toastIn{
    from{opacity:0;transform:translateY(20px) scale(.92)}
    to{opacity:1;transform:none}
}

/* =========================
   CLICK POP
========================= */

.click-pop{
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

@keyframes pop{
    0%{opacity:.85;transform:translate(-50%,-50%) scale(1)}
    100%{opacity:0;transform:translate(-50%,-50%) scale(8)}
}

/* =========================
   FOOTER
========================= */

footer{
    margin-top:18px;
    padding:38px 5% 18px;
    background:var(--primary-dark);
    color:#fff;
}

.footer-grid{
    width:min(1400px,100%);
    margin:0 auto;
    display:grid;
    grid-template-columns:2fr 1fr 1fr 1.3fr;
    gap:35px;
    padding-bottom:24px;
    border-bottom:1px solid rgba(255,255,255,.1);
}

.footer-brand p{
    max-width:430px;
    margin-top:8px;
    color:#a0aec0;
    font-size:.8rem;
}

.footer-links h4{
    margin-bottom:9px;
    font-size:.9rem;
}

.footer-links ul{
    list-style:none;
}

.footer-links li{
    margin-bottom:5px;
}

.footer-links a{
    color:#a0aec0;
    text-decoration:none;
    font-size:.76rem;
    transition:.25s ease;
}

.footer-links a:hover{color:#fff}

.copyright{
    width:min(1400px,100%);
    margin:0 auto;
    padding-top:15px;
    text-align:center;
    color:#a0aec0;
    font-size:.72rem;
}

/* =========================
   RESPONSIVE
========================= */

@media(max-width:1200px){
    .stats-grid{
        grid-template-columns:repeat(3,minmax(0,1fr));
    }

    .stock-grid{
        grid-template-columns:repeat(3,minmax(0,1fr));
    }
}

@media(max-width:900px){
    .navbar{
        gap:10px;
    }

    .stats-grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }

    .customer-card{
        grid-template-columns:1fr 1fr;
    }

    .customer-item:first-child{
        grid-column:1 / -1;
    }

    .stock-grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }

    .footer-grid{
        grid-template-columns:1fr 1fr;
    }
}

@media(max-width:650px){
    .navbar{
        padding:13px 4%;
    }

    .brand{
        font-size:1.2rem;
    }

    .nav-actions{
        gap:2px;
    }

    .icon-btn{
        width:37px;
        height:37px;
    }

    main{
        width:92%;
        padding-top:82px;
    }

    .section{
        padding:20px 0;
    }

    .orders-header{
        padding-top:16px;
    }

    .orders-header-inner{
        align-items:flex-start;
    }

    .page-icon{
        width:48px;
        height:48px;
        flex-basis:48px;
    }

    .stats-grid{
        grid-template-columns:1fr 1fr;
        gap:9px;
    }

    .stat-card{
        padding:13px;
    }

    .stat-value{
        font-size:1.2rem;
    }

    .customer-sticky{
        top:60px;
        padding:8px 0;
    }

    .customer-card{
        grid-template-columns:1fr;
        padding:9px;
    }

    .customer-item:first-child{
        grid-column:auto;
    }

    .customer-value{
        white-space:normal;
    }

    .section-heading{
        align-items:flex-start;
        flex-direction:column;
        gap:10px;
    }

    .section-tools{
        width:100%;
        justify-content:stretch;
    }

    .search-box{
        flex:1;
        width:auto;
    }

    .stock-grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
        gap:9px;
    }

    .product-image{
        height:135px;
    }

    .stock-info{
        padding:10px;
    }

    .product-name{
        font-size:.73rem;
    }

    .product-price{
        font-size:.9rem;
    }

    .stocks-container{
        max-height:570px;
    }

    .transaction-scroll{
        max-height:420px;
    }

    .modal-overlay{
        padding:10px;
    }

    .modal{
        max-height:92vh;
    }

    .detail-grid{
        grid-template-columns:1fr;
    }

    .detail-item.full{
        grid-column:auto;
    }

    .footer-grid{
        grid-template-columns:1fr 1fr;
        gap:22px;
    }

    .footer-brand{
        grid-column:1 / -1;
    }
}

@media(max-width:430px){
    .stats-grid{
        grid-template-columns:1fr;
    }

    .stock-grid{
        grid-template-columns:1fr 1fr;
    }

    .product-image{
        height:120px;
    }

    .product-meta{
        flex-direction:column;
        align-items:flex-start;
    }

    .footer-grid{
        grid-template-columns:1fr;
    }
}

@media(prefers-reduced-motion:reduce){
    *,*::before,*::after{
        animation-duration:.001ms!important;
        animation-iteration-count:1!important;
        transition-duration:.001ms!important;
        scroll-behavior:auto!important;
    }

    .reveal,
    .stagger>*{
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

<!-- =========================
     TOP NAVIGATION
========================= -->

<nav class="navbar" id="navbar">

    <a href="{{ url('/') }}" class="brand">
        <i class="fa-solid fa-leaf"></i>
        <span>agrimarket</span>
    </a>

    <!--
        Intentionally no:
        - Category button
        - Category menu
        - Search bar
        - Search button
    -->

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
                <!-- Laravel routes can be placed here -->
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
                    <i class="fa-solid fa-right-from-bracket"></i>Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                    @csrf
                </form>
            </div>
        </div>

    </div>
</nav>

<main>

<!-- =========================
     PAGE HEADER
========================= -->

<section class="orders-header reveal">
    <div class="orders-header-inner">

        <div>
            <span class="eyebrow heading-left" style="display:inline-block;padding:4px 11px;border-radius:20px;background:var(--soft-green);color:var(--primary-green);font-size:.68rem;font-weight:800;letter-spacing:1px;text-transform:uppercase;">
                Marketplace
            </span>

            <h1>My Orders</h1>

            <p>
                Manage your orders, transactions, stocks and incoming order requests.
            </p>
        </div>

        <div class="page-icon">
            <i class="fa-solid fa-boxes-stacked"></i>
        </div>

    </div>
</section>

<!-- =========================
     1. ORDER STATISTICS
========================= -->

<section class="section reveal">
    <div class="stats-grid stagger">

        <article class="stat-card">
            <div class="stat-top">
                <div class="stat-icon">
                    <i class="fa-solid fa-box"></i>
                </div>
            </div>

            <div class="stat-label">Total Products</div>
            <div class="stat-value" id="totalProducts">{{ $totalProducts }}</div>
            <div class="stat-sub">All products available</div>
        </article>

        <article class="stat-card">
            <div class="stat-top">
                <div class="stat-icon">
                    <i class="fa-regular fa-clock"></i>
                </div>
            </div>

            <div class="stat-label">Pending Requests</div>
            <div class="stat-value" id="pendingRequests"></div>
            <div class="stat-sub">Waiting for your action</div>
        </article>

        <article class="stat-card">
            <div class="stat-top">
                <div class="stat-icon">
                    <i class="fa-solid fa-truck"></i>
                </div>
            </div>

            <div class="stat-label">Shipping</div>
            <div class="stat-value" id="shippingOrders"></div>
            <div class="stat-sub">Orders currently shipping</div>
        </article>

        <article class="stat-card">
            <div class="stat-top">
                <div class="stat-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>

            <div class="stat-label">Completed</div>
            <div class="stat-value" id="completedOrders"></div>
            <div class="stat-sub">Successfully completed</div>
        </article>

        <article class="stat-card sales">
            <div class="stat-top">
                <div class="stat-icon">
                    <i class="fa-solid fa-peso-sign"></i>
                </div>
            </div>

            <div class="stat-label">Total Sales</div>
            <div class="stat-value" id="totalSales"></div>
            <div class="stat-sub">Current recorded sales</div>
        </article>

    </div>
</section>

<!-- =========================
     2. CUSTOMER INFORMATION
========================= -->

<div class="customer-sticky reveal">

    <div class="customer-card">

        <div class="customer-item">
            <div class="customer-icon">
                <i class="fa-solid fa-location-dot"></i>
            </div>

            <div class="customer-content">
                <div class="customer-label">Address</div>
                <div class="customer-value" id="customerAddress">
                    {{ $deliveryAddress ?: 'Not provided' }}
                </div>
            </div>
        </div>

        <div class="customer-item">
            <div class="customer-icon">
                <i class="fa-regular fa-user"></i>
            </div>

            <div class="customer-content">
                <div class="customer-label">Name</div>
                <div class="customer-value" id="customerName">
                    {{ $customerName ?: 'Not provided' }}
                </div>
            </div>
        </div>

        <div class="customer-item">
            <div class="customer-icon">
                <i class="fa-solid fa-phone"></i>
            </div>

            <div class="customer-content">
                <div class="customer-label">Contact Number</div>
                <div class="customer-value" id="customerContact">
                    {{ $mobileNumber ?: 'Not provided' }}
                </div>
            </div>
        </div>

    </div>

</div>

<!-- =========================
     3. MY STOCKS
========================= -->

<section class="section stock-section" id="myStockSection">

    <div class="section-heading">

        <div class="heading-left">
            <span class="eyebrow">Inventory</span>
            <h2>My Stocks</h2>
            <p>Manage the products and quantities currently available.</p>
        </div>

        <div class="section-tools">
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" id="stockSearch" placeholder="Search My Stocks..." aria-label="Search My Stocks">
            </div>

            <button type="button" class="control-btn stock-add-btn" id="addStockButton">
                <i class="fa-solid fa-plus"></i>
                Add Item
            </button>
        </div>

    </div>

    <div class="stocks-container" id="stocksContainer">
        <div class="stock-grid" id="stockGrid">
            @forelse($products as $product)
                <article class="product-card" data-product-id="{{ $product->product_id }}" data-name="{{ strtolower($product->product_name) }}">
                    @if((int) $product->quantity === 0)
                        <span class="stock-badge" style="background:#b42318;">OUT OF STOCK</span>
                    @elseif((int) $product->quantity <= 10)
                        <span class="stock-badge" style="background:var(--accent-terracotta);">LOW STOCK</span>
                    @else
                        <span class="stock-badge">IN STOCK</span>
                    @endif

                    <div class="product-image">
                        @if(!empty($product->image))
                            @php
                                $imageInfo = @getimagesizefromstring($product->image);
                                $imageMime = $imageInfo['mime'] ?? 'image/jpeg';
                            @endphp
                            <img
                                src="data:{{ $imageMime }};base64,{{ base64_encode($product->image) }}"
                                alt="{{ $product->product_name }}"
                                style="width:100%;height:100%;object-fit:cover;display:block;"
                            >
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

                    <div class="stock-info">
                        <div class="product-name">{{ $product->product_name }}</div>
                        <div class="product-price">₱{{ number_format((float) $product->price, 2) }}</div>
                        <div class="product-meta">
                            <span>{{ $product->oum }}</span>
                            <span class="stock-status-text">{{ (int) $product->quantity === 0 ? 'Out of Stock' : ((int) $product->quantity <= 10 ? 'Low Stock' : 'In Stock') }}</span>
                        </div>

                        <div class="quantity-control">
                            <button type="button" class="qty-btn" data-quantity-action="less" data-product-id="{{ $product->product_id }}" aria-label="Decrease {{ $product->product_name }} quantity" {{ (int) $product->quantity <= 0 ? 'disabled' : '' }}>
                                <i class="fa-solid fa-minus"></i>
                            </button>

                            <span class="qty-value" data-quantity-value>Quantity: {{ $product->quantity }}</span>

                            <button type="button" class="qty-btn" data-quantity-action="add" data-product-id="{{ $product->product_id }}" aria-label="Increase {{ $product->product_name }} quantity">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>

                        <div class="stock-actions">
                            <button type="button" class="remove-btn" data-remove-product="{{ $product->product_id }}">
                                <i class="fa-regular fa-trash-can"></i>
                                Remove
                            </button>
                        </div>
                    </div>
                </article>
            @empty
                <div class="empty-state stock-empty-state" style="grid-column:1/-1">
                    <i class="fa-solid fa-box-open"></i>
                    <h3>No products found</h3>
                    <p>Your listed products will appear here.</p>
                </div>
            @endforelse
        </div>
    </div>

</section>

<!-- =========================
     4. TRANSACTION TABLE
========================= -->

<section class="section reveal">

    <div class="section-heading">

        <div class="heading-left">
            <span class="eyebrow">Transactions</span>
            <h2>Transaction Table</h2>
            <p>View and manage your ongoing and completed transactions.</p>
        </div>

        <div class="section-tools">

            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>

                <input
                    type="search"
                    id="transactionSearch"
                    placeholder="Order ID, customer or product..."
                    aria-label="Search transactions"
                >
            </div>

            <select class="filter-select" id="transactionFilter" aria-label="Filter transactions">
                <option value="All">All</option>
                <option value="Shipping">Shipping</option>
                <option value="Completed">Completed</option>
            </select>

        </div>

    </div>

    <div class="transaction-wrapper">

        <div class="transaction-scroll">

            <table class="transaction-table">

                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Product</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody id="transactionBody"></tbody>

            </table>

        </div>

    </div>

</section>

<!-- =========================
     5. ORDER REQUESTS
========================= -->

<section class="section reveal">

    <div class="section-heading">

        <div class="heading-left">
            <span class="eyebrow">Incoming</span>
            <h2>Order Requests</h2>
            <p>Review orders waiting for acceptance or decline.</p>
        </div>

    </div>

    <div class="requests-container">

        <div class="requests-grid stagger" id="requestsGrid"></div>

    </div>

</section>

</main>

<!-- =========================
     FOOTER
     KEPT IN REFERENCE STYLE
========================= -->

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
                <li><a href="">My Orders</a></li>
                <li><a href="">My Stocks</a></li>
                <li><a href="">Products</a></li>
            </ul>

        </div>

    </div>

    <div class="copyright">
        © 2026 AgriMarket. All rights reserved.
    </div>

</footer>

<!-- =========================
     TRANSACTION MODAL
========================= -->

<div class="modal-overlay" id="transactionModal">

    <div class="modal">

        <div class="modal-header">

            <div>
                <div class="modal-title">Transaction Details</div>
                <div class="modal-subtitle" id="transactionModalSubtitle">
                    Complete transaction information
                </div>
            </div>

            <button class="modal-close" onclick="closeModal('transactionModal')">
                <i class="fa-solid fa-xmark"></i>
            </button>

        </div>

        <div class="modal-body" id="transactionModalBody"></div>

    </div>

</div>

<!-- =========================
     ORDER REQUEST MODAL
========================= -->

<div class="modal-overlay" id="requestModal">

    <div class="modal">

        <div class="modal-header">

            <div>
                <div class="modal-title">Order Request</div>
                <div class="modal-subtitle" id="requestModalSubtitle">
                    Review order request
                </div>
            </div>

            <button class="modal-close" onclick="closeModal('requestModal')">
                <i class="fa-solid fa-xmark"></i>
            </button>

        </div>

        <div class="modal-body" id="requestModalBody"></div>

        <div class="modal-footer">

            <button class="modal-action decline" id="modalDeclineButton">
                <i class="fa-solid fa-xmark"></i>
                Decline
            </button>

            <button class="modal-action primary" id="modalAcceptButton">
                <i class="fa-solid fa-check"></i>
                Accept
            </button>

        </div>

    </div>

</div>

<!-- =========================
     ADD STOCK ITEM MODAL
========================= -->

<div class="modal-overlay" id="addStockModal">
    <div class="modal">
        <div class="modal-header">
            <div>
                <div class="modal-title">Add Item to My Stock</div>
                <div class="modal-subtitle">Enter the product details below.</div>
            </div>
            <button type="button" class="modal-close" onclick="closeModal('addStockModal')" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="addStockForm" class="modal-body stock-form" enctype="multipart/form-data">
            @csrf
            <div class="stock-form-error" id="stockFormError" role="alert"></div>

            <div class="stock-form-group full">
                <label for="stockProductName">Product Name</label>
                <input type="text" id="stockProductName" name="product_name" maxlength="255" pattern="[A-Za-z]+( [A-Za-z]+)*" title="Use alphabetic letters only. Numbers, spaces, and special symbols are not allowed." autocomplete="off" required>
            </div>

            <div class="stock-form-group">
                <label for="stockCategory">Category</label>
                <select id="stockCategory" name="category" required>
                    <option value="" selected disabled>Select a category</option>
                    <option value="Fruits">Fruits</option>
                    <option value="Vegetables">Vegetables</option>
                    <option value="Grains &amp; Rice">Grains &amp; Rice</option>
                    <option value="Seeds">Seeds</option>
                    <option value="Organic Products">Organic Products</option>
                    <option value="Herbs &amp; Spices">Herbs &amp; Spices</option>
                    <option value="Meat &amp; Poultry">Meat &amp; Poultry</option>
                    <option value="Fish &amp; Seafood">Fish &amp; Seafood</option>
                    <option value="Dairy &amp; Eggs">Dairy &amp; Eggs</option>
                    <option value="Processed Foods">Processed Foods</option>
                </select>
            </div>

            <div class="stock-form-group">
                <label for="stockPrice">Price (₱)</label>
                <input type="number" id="stockPrice" name="price" min="0" step="0.01" required>
            </div>

            <div class="stock-form-group">
                <label for="stockQuantity">Quantity</label>
                <input type="number" id="stockQuantity" name="quantity" min="0" step="1" required>
            </div>

            <div class="stock-form-group">
                <label for="stockOum">Unit of Measurement</label>
                <input type="text" id="stockOum" name="oum" maxlength="50" pattern="[A-Za-z]+( [A-Za-z]+)*" title="Use alphabetic letters only. Numbers, spaces, and special symbols are not allowed." placeholder="e.g. kg, piece, sack" autocomplete="off" required>
            </div>

            <div class="stock-form-group full">
                <label for="stockImage">Product Image <span aria-hidden="true">*</span></label>
                <input type="file" id="stockImage" name="image" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp" required>
                <span class="stock-form-help">Required. JPG, JPEG, PNG, or WEBP. Maximum file size: 5 MB.</span>
            </div>

            <div class="stock-form-submit">
                <button type="button" class="stock-cancel-btn" onclick="closeModal('addStockModal')">Cancel</button>
                <button type="submit" class="stock-save-btn" id="saveStockButton">
                    <i class="fa-solid fa-plus"></i>
                    Add Product
                </button>
            </div>
        </form>
    </div>
</div>

<div class="toast-container" id="toastContainer"></div>


@php
    $transactionRows = collect($transactions ?? [])->map(function ($transaction) {
        $transactionId = data_get($transaction, 'order_id')
            ?: data_get($transaction, 'transaction_id')
            ?: data_get($transaction, 'id');

        $createdAt = data_get($transaction, 'created_at');

        return [
            'id' => (string) ($transactionId ?? ''),
            'customer' => (string) data_get($transaction, 'customer_name', ''),
            'address' => (string) data_get($transaction, 'address', ''),
            'mobile' => (string) data_get($transaction, 'mobile_number', ''),
            'date' => $createdAt
                ? \Carbon\Carbon::parse($createdAt)->format('F d, Y')
                : '—',
            'products' => [[
                'name' => (string) data_get($transaction, 'product_name', ''),
                'quantity' => (int) data_get($transaction, 'quantity', 0),
                'price' => data_get($transaction, 'product_price'),
            ]],
            'total' => (float) data_get($transaction, 'total_amount', 0),
            'status' => ucfirst(strtolower((string) data_get($transaction, 'status', 'Shipping'))),
        ];
    })->values();

    $requestRows = collect($orderRequests ?? [])->map(function ($request) {
        $createdAt = data_get($request, 'created_at');

        return [
            'id' => (string) (data_get($request, 'request_id') ?? data_get($request, 'id', '')),
            'orderId' => data_get($request, 'order_id'),
            'customer' => (string) data_get($request, 'customer_name', ''),
            'address' => (string) data_get($request, 'address', ''),
            'mobile' => (string) data_get($request, 'mobile_number', ''),
            'date' => $createdAt
                ? \Carbon\Carbon::parse($createdAt)->format('F d, Y')
                : '—',
            'products' => [[
                'name' => (string) data_get($request, 'product_name', ''),
                'quantity' => (int) data_get($request, 'quantity', 0),
                'price' => data_get($request, 'product_price'),
            ]],
            'total' => (float) data_get($request, 'total_amount', 0),
        ];
    })->values();
@endphp

<script>

let transactionData = @json($transactionRows);

let requestData = @json($requestRows);

/*
 * Order request actions use the authenticated PATCH routes in web.php.
 * The backend performs the database insert/delete operations.
 */
const API_CONFIG = {
    acceptRequest: @json(url('/orders/requests')),
    declineRequest: @json(url('/orders/requests')),
    csrf: @json(csrf_token())
};

const requestBusy = new Set();

/* Removed hardcoded sample transaction and request arrays. */

const STOCK_API = {
    add: @json(route('orders.products.add')),
    quantity: @json(url('/orders/products')),
    remove: @json(url('/orders/products')),
    csrf: @json(csrf_token())
};

const stockBusyProducts = new Set();

/* =========================
   HELPERS
========================= */

function peso(value){
    return "₱" + Number(value).toLocaleString("en-PH",{
        minimumFractionDigits:2,
        maximumFractionDigits:2
    });
}

function escapeHTML(value){
    return String(value)
        .replace(/&/g,"&amp;")
        .replace(/</g,"&lt;")
        .replace(/>/g,"&gt;")
        .replace(/"/g,"&quot;")
        .replace(/'/g,"&#039;");
}

function getInitials(name){
    return String(name)
        .split(" ")
        .map(word => word[0])
        .slice(0,2)
        .join("")
        .toUpperCase();
}

/* =========================
   TOAST
========================= */

function showToast(message){
    const container=document.getElementById("toastContainer");
    const toast=document.createElement("div");

    toast.className="toast";

    toast.innerHTML=`
        <i class="fa-solid fa-circle-check"></i>
        <span>${escapeHTML(message)}</span>
    `;

    container.appendChild(toast);

    setTimeout(()=>{
        toast.style.opacity="0";
        toast.style.transform="translateY(10px)";
        toast.style.transition=".3s ease";

        setTimeout(()=>toast.remove(),300);
    },2600);
}

/* =========================
   STATISTICS
========================= */

function updateStatistics(){
    const pending = requestData.length;
    const shipping = transactionData.filter(item => item.status === "Shipping").length;
    const completed = transactionData.filter(item => item.status === "Completed").length;
    const sales = transactionData
        .filter(item => item.status === "Completed")
        .reduce((total, item) => total + Number(item.total || 0), 0);

    document.getElementById("pendingRequests").textContent = pending;
    document.getElementById("shippingOrders").textContent = shipping;
    document.getElementById("completedOrders").textContent = completed;
    document.getElementById("totalSales").textContent = peso(sales);
}

/* =========================
   TRANSACTIONS
========================= */

function renderTransactions(){

    const tbody=document.getElementById("transactionBody");

    const query=document
        .getElementById("transactionSearch")
        .value
        .trim()
        .toLowerCase();

    const filter=document
        .getElementById("transactionFilter")
        .value;

    const filtered=transactionData.filter(transaction=>{

        const statusMatch=
            filter==="All" ||
            transaction.status===filter;

        const productMatch=transaction.products.some(product=>
            product.name.toLowerCase().includes(query)
        );

        const searchMatch=
            !query ||
            transaction.id.toLowerCase().includes(query) ||
            transaction.customer.toLowerCase().includes(query) ||
            productMatch;

        return statusMatch && searchMatch;
    });

    if(!filtered.length){

        tbody.innerHTML=`
            <tr>
                <td colspan="5" class="no-results">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    No transactions found.
                </td>
            </tr>
        `;

        return;
    }

    tbody.innerHTML=filtered.map(transaction=>{

        const products=transaction.products
            .map(product=>`${escapeHTML(product.name)} × ${product.quantity}`)
            .join(", ");

        return `
            <tr
                class="transaction-row"
                onclick="openTransaction('${transaction.id}')"
            >

                <td>
                    <span class="order-id">
                        ${escapeHTML(transaction.id)}
                    </span>
                </td>

                <td>
                    ${escapeHTML(transaction.customer)}
                </td>

                <td>
                    ${products}
                </td>

                <td>
                    <span class="amount">
                        ${peso(transaction.total)}
                    </span>
                </td>

                <td>
                    <span class="status ${transaction.status.toLowerCase()}">
                        ${escapeHTML(transaction.status)}
                    </span>
                </td>

            </tr>
        `;

    }).join("");
}

function transactionProductsHTML(products){

    return products.map(product=>`

        <div class="detail-product">

            <span class="detail-product-name">
                ${escapeHTML(product.name)}
            </span>

            <span class="detail-product-qty">
                ${product.price !== null && product.price !== undefined
                    ? `${product.quantity} × ${peso(product.price)}`
                    : `Quantity: ${product.quantity}`}
            </span>

        </div>

    `).join("");
}

function openTransaction(id){

    const transaction=transactionData.find(
        item=>item.id===id
    );

    if(!transaction)return;

    document.getElementById("transactionModalSubtitle").textContent=
        transaction.id;

    document.getElementById("transactionModalBody").innerHTML=`

        <div class="detail-grid">

            <div class="detail-item">
                <div class="detail-label">Order ID</div>
                <div class="detail-value">
                    ${escapeHTML(transaction.id)}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Order Status</div>
                <div class="detail-value">
                    <span class="status ${transaction.status.toLowerCase()}">
                        ${escapeHTML(transaction.status)}
                    </span>
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Customer Name</div>
                <div class="detail-value">
                    ${escapeHTML(transaction.customer)}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Mobile Number</div>
                <div class="detail-value">
                    ${escapeHTML(transaction.mobile)}
                </div>
            </div>

            <div class="detail-item full">
                <div class="detail-label">Address</div>
                <div class="detail-value">
                    ${escapeHTML(transaction.address)}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Order Date</div>
                <div class="detail-value">
                    ${escapeHTML(transaction.date)}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Total Amount</div>
                <div class="detail-value" style="color:var(--accent-terracotta)">
                    ${peso(transaction.total)}
                </div>
            </div>

        </div>

        <div class="detail-products">

            <h4>
                <i class="fa-solid fa-basket-shopping"></i>
                Products Ordered
            </h4>

            ${transactionProductsHTML(transaction.products)}

        </div>
    `;

    openModal("transactionModal");
}

/* =========================
   ORDER REQUESTS
========================= */

function renderRequests(){

    const grid=document.getElementById("requestsGrid");

    if(!requestData.length){

        grid.innerHTML=`
            <div class="empty-state" style="width:100%">
                <i class="fa-solid fa-inbox"></i>
                <h3>No pending order requests</h3>
                <p>New customer requests will appear here.</p>
            </div>
        `;

        return;
    }

    grid.innerHTML=requestData.map(request=>{

        const firstProduct=request.products[0];

        return `
            <article
                class="request-card"
                onclick="openRequest('${request.id}')"
            >

                <div class="request-top">

                    <div class="customer-avatar">
                        ${getInitials(request.customer)}
                    </div>

                    <div class="request-customer">
                        <strong>
                            ${escapeHTML(request.customer)}
                        </strong>

                        <small>
                            ${escapeHTML(request.id)}
                        </small>
                    </div>

                </div>

                <div class="request-details">

                    <div class="request-line">
                        <span>Product</span>
                        <span>
                            ${escapeHTML(firstProduct.name)}
                        </span>
                    </div>

                    <div class="request-line">
                        <span>Quantity</span>
                        <span>
                            ${firstProduct.quantity}
                        </span>
                    </div>

                    <div class="request-line">
                        <span>Total</span>
                        <span class="request-total">
                            ${peso(request.total)}
                        </span>
                    </div>

                </div>

                <div
                    class="request-actions"
                    onclick="event.stopPropagation()"
                >

                    <button
                        class="request-btn accept-btn"
                        onclick="acceptRequest('${request.id}')"
                    >
                        <i class="fa-solid fa-check"></i>
                        Accept
                    </button>

                    <button
                        class="request-btn decline-btn"
                        onclick="declineRequest('${request.id}')"
                    >
                        <i class="fa-solid fa-xmark"></i>
                        Decline
                    </button>

                </div>

            </article>
        `;

    }).join("");

    observeNewElements();
}

function openRequest(id){

    const request=requestData.find(
        item=>item.id===id
    );

    if(!request)return;

    document.getElementById("requestModalSubtitle").textContent=
        request.id;

    document.getElementById("requestModalBody").innerHTML=`

        <div class="detail-grid">

            <div class="detail-item">
                <div class="detail-label">Order ID</div>
                <div class="detail-value">
                    ${escapeHTML(request.id)}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Customer Name</div>
                <div class="detail-value">
                    ${escapeHTML(request.customer)}
                </div>
            </div>

            <div class="detail-item full">
                <div class="detail-label">Address</div>
                <div class="detail-value">
                    ${escapeHTML(request.address)}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Mobile Number</div>
                <div class="detail-value">
                    ${escapeHTML(request.mobile)}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Order Date</div>
                <div class="detail-value">
                    ${escapeHTML(request.date)}
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Total Amount</div>
                <div class="detail-value" style="color:var(--accent-terracotta)">
                    ${peso(request.total)}
                </div>
            </div>

        </div>

        <div class="detail-products">

            <h4>
                <i class="fa-solid fa-basket-shopping"></i>
                Products
            </h4>

            ${transactionProductsHTML(request.products)}

        </div>
    `;

    document.getElementById("modalAcceptButton").onclick=()=>{
        acceptRequest(request.id);
    };

    document.getElementById("modalDeclineButton").onclick=()=>{
        declineRequest(request.id);
    };

    openModal("requestModal");
}

async function acceptRequest(id){

    const request = requestData.find(item => String(item.id) === String(id));

    if(!request || requestBusy.has(String(id))) return;

    requestBusy.add(String(id));

    try{
        const response = await fetch(
            `${API_CONFIG.acceptRequest}/${encodeURIComponent(id)}/accept`,
            {
                method:"PATCH",
                headers:{
                    "Accept":"application/json",
                    "X-CSRF-TOKEN":API_CONFIG.csrf,
                    "X-Requested-With":"XMLHttpRequest"
                }
            }
        );

        const result = await response.json();

        if(!response.ok || !result.success){
            throw new Error(result.message || "Unable to accept this order request.");
        }

        // The server has inserted the transaction and deleted the request.
        requestData = requestData.filter(item => String(item.id) !== String(id));

        transactionData.unshift({
            id: request.orderId || request.id,
            customer: request.customer,
            address: request.address,
            mobile: request.mobile,
            date: request.date,
            products: request.products,
            total: request.total,
            status: "Shipping"
        });

        renderRequests();
        renderTransactions();
        updateStatistics();

        closeModal("requestModal");
        showToast(result.message || "Order request accepted and added to transactions.");

    }catch(error){
        showToast(error.message || "An error occurred while accepting the request.");
    }finally{
        requestBusy.delete(String(id));
    }
}

async function declineRequest(id){

    const request = requestData.find(item => String(item.id) === String(id));

    if(!request || requestBusy.has(String(id))) return;

    requestBusy.add(String(id));

    try{
        const response = await fetch(
            `${API_CONFIG.declineRequest}/${encodeURIComponent(id)}/decline`,
            {
                method:"PATCH",
                headers:{
                    "Accept":"application/json",
                    "X-CSRF-TOKEN":API_CONFIG.csrf,
                    "X-Requested-With":"XMLHttpRequest"
                }
            }
        );  

        const result = await response.json();

        if(!response.ok || !result.success){
            throw new Error(result.message || "Unable to decline this order request.");
        }

        // The server has deleted the request. No transaction is created.
        requestData = requestData.filter(item => String(item.id) !== String(id));

        renderRequests();
        updateStatistics();

        closeModal("requestModal");
        showToast(result.message || "Order request declined and removed.");

    }catch(error){
        showToast(error.message || "An error occurred while declining the request.");
    }finally{
        requestBusy.delete(String(id));
    }
}


/* =========================
   MODALS
========================= */

function openModal(id){
    document
        .getElementById(id)
        .classList
        .add("open");

    document.body.style.overflow="hidden";
}

function closeModal(id){
    document
        .getElementById(id)
        .classList
        .remove("open");

    if(!document.querySelector(".modal-overlay.open")){
        document.body.style.overflow="";
    }
}

document.querySelectorAll(".modal-overlay").forEach(overlay=>{

    overlay.addEventListener("click",event=>{

        if(event.target===overlay){
            closeModal(overlay.id);
        }

    });

});

/* =========================
   SEARCH / FILTER
========================= */

/* =========================
   MY STOCK DATABASE ACTIONS
========================= */

function stockStatus(quantity){
    const qty = Number(quantity);
    if(qty <= 0) return {label:"Out of Stock", badge:"OUT OF STOCK", color:"#b42318"};
    if(qty <= 10) return {label:"Low Stock", badge:"LOW STOCK", color:"var(--accent-terracotta)"};
    return {label:"In Stock", badge:"IN STOCK", color:"var(--primary-green)"};
}

function stockCardHTML(product, uploadedImageDataUrl = null){
    const id = Number(product.product_id);
    const quantity = Number(product.quantity);
    const status = stockStatus(quantity);
    const name = escapeHTML(product.product_name);
    const imageSource = uploadedImageDataUrl
        || product.image_data_url
        || product.image_base64
        || "";

    const normalizedImageSource = imageSource
        ? (imageSource.startsWith("data:")
            ? imageSource
            : `data:${product.image_mime || "image/jpeg"};base64,${imageSource}`)
        : "";

    const image = normalizedImageSource
        ? `<img src="${escapeHTML(normalizedImageSource)}" alt="${name}" style="width:100%;height:100%;object-fit:cover;display:block;">`
        : `<div class="placeholder"><div class="placeholder-content"><i class="fa-regular fa-image"></i><strong>PRODUCT IMAGE</strong><small>${name}</small></div></div>`;

    return `
        <article class="product-card" data-product-id="${id}" data-name="${name.toLowerCase()}">
            <span class="stock-badge" style="background:${status.color};">${status.badge}</span>
            <div class="product-image">${image}</div>
            <div class="stock-info">
                <div class="product-name">${name}</div>
                <div class="product-price">${peso(product.price)}</div>
                <div class="product-meta">
                    <span>${escapeHTML(product.oum)}</span>
                    <span class="stock-status-text">${status.label}</span>
                </div>
                <div class="quantity-control">
                    <button type="button" class="qty-btn" data-quantity-action="less" data-product-id="${id}" aria-label="Decrease ${name} quantity" ${quantity <= 0 ? "disabled" : ""}>
                        <i class="fa-solid fa-minus"></i>
                    </button>
                    <span class="qty-value" data-quantity-value>Quantity: ${quantity}</span>
                    <button type="button" class="qty-btn" data-quantity-action="add" data-product-id="${id}" aria-label="Increase ${name} quantity">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
                <div class="stock-actions">
                    <button type="button" class="remove-btn" data-remove-product="${id}">
                        <i class="fa-regular fa-trash-can"></i> Remove
                    </button>
                </div>
            </div>
        </article>
    `;
}

function refreshStockEmptyState(){
    const grid = document.getElementById("stockGrid");
    const cards = grid.querySelectorAll(".product-card");
    const empty = grid.querySelector(".stock-empty-state");

    if(cards.length === 0 && !empty){
        grid.innerHTML = `
            <div class="empty-state stock-empty-state" style="grid-column:1/-1">
                <i class="fa-solid fa-box-open"></i>
                <h3>No products found</h3>
                <p>Your listed products will appear here.</p>
            </div>
        `;
    }else if(cards.length > 0 && empty){
        empty.remove();
    }
}

function updateStockCard(card, quantity){
    const status = stockStatus(quantity);
    card.querySelector(".stock-badge").textContent = status.badge;
    card.querySelector(".stock-badge").style.background = status.color;
    card.querySelector("[data-quantity-value]").textContent = `Quantity: ${Number(quantity)}`;
    card.querySelector(".stock-status-text").textContent = status.label;
    card.querySelector('[data-quantity-action="less"]').disabled = Number(quantity) <= 0;
}

async function changeStockQuantity(productId, action){
    if(stockBusyProducts.has(productId)) return;

    const card = document.querySelector(`.product-card[data-product-id="${productId}"]`);
    if(!card) return;

    const buttons = card.querySelectorAll(".qty-btn");
    stockBusyProducts.add(productId);
    buttons.forEach(button => button.disabled = true);

    try{
        const response = await fetch(`${STOCK_API.quantity}/${encodeURIComponent(productId)}/quantity`, {
            method:"PATCH",
            headers:{
                "Accept":"application/json",
                "Content-Type":"application/json",
                "X-CSRF-TOKEN":STOCK_API.csrf,
                "X-Requested-With":"XMLHttpRequest"
            },
            body:JSON.stringify({action})
        });

        const result = await response.json();
        if(!response.ok || !result.success){
            throw new Error(result.message || "Unable to update product quantity.");
        }

        updateStockCard(card, result.quantity);
        showToast(action === "add" ? "Product quantity increased." : "Product quantity decreased.");
    }catch(error){
        showToast(error.message || "An error occurred while updating quantity.");
    }finally{
        stockBusyProducts.delete(productId);
        const currentQuantity = Number(card.querySelector("[data-quantity-value]")?.textContent.match(/\d+/)?.[0] || 0);
        buttons.forEach(button => {
            button.disabled = button.dataset.quantityAction === "less" && currentQuantity <= 0;
        });
    }
}

async function removeStockProduct(productId, button){
    if(stockBusyProducts.has(productId)) return;
    if(!confirm("Are you sure you want to remove this product from your stock?")) return;

    const card = document.querySelector(`.product-card[data-product-id="${productId}"]`);
    if(!card) return;

    stockBusyProducts.add(productId);
    if(button) button.disabled = true;

    try{
        const response = await fetch(`${STOCK_API.remove}/${encodeURIComponent(productId)}`, {
            method:"DELETE",
            headers:{
                "Accept":"application/json",
                "X-CSRF-TOKEN":STOCK_API.csrf,
                "X-Requested-With":"XMLHttpRequest"
            }
        });

        const result = await response.json();
        if(!response.ok || !result.success){
            throw new Error(result.message || "Unable to remove this product.");
        }

        card.remove();
        refreshStockEmptyState();

        const totalProductsElement = document.getElementById("totalProducts");
        if(totalProductsElement){
            totalProductsElement.textContent = Math.max(0, Number(totalProductsElement.textContent || 0) - 1);
        }

        showToast("Product removed successfully.");
    }catch(error){
        if(button) button.disabled = false;
        showToast(error.message || "An error occurred while removing the product.");
    }finally{
        stockBusyProducts.delete(productId);
    }
}

function showStockFormError(message){
    const errorBox = document.getElementById("stockFormError");
    errorBox.textContent = message;
    errorBox.classList.add("show");
}

const stockProductNameInput = document.getElementById("stockProductName");
const stockOumInput = document.getElementById("stockOum");

// Product names and units are alphabetic only. Normalize product-name casing as the user types.
function keepAlphabeticOnly(value){
    return value.replace(/[^A-Za-z]/g, "");
}

function formatStockProductName(value){
    const words = value.replace(/[^A-Za-z ]/g, "");

    return words
        .replace(/\s+/g, " ")
        .replace(/\b[a-z]/g, letter => letter.toUpperCase());
}

stockProductNameInput.addEventListener("input", function(){
    const formatted = formatStockProductName(this.value);
    if(this.value !== formatted) this.value = formatted;
});

stockOumInput.addEventListener("input", function(){
    const letters = keepAlphabeticOnly(this.value);
    if(this.value !== letters) this.value = letters;
});

document.getElementById("addStockButton").addEventListener("click", () => {
    document.getElementById("addStockForm").reset();
    document.getElementById("stockFormError").classList.remove("show");
    openModal("addStockModal");
});

document.getElementById("addStockForm").addEventListener("submit", async function(event){
    event.preventDefault();

    const form = this;
    const submitButton = document.getElementById("saveStockButton");
    const errorBox = document.getElementById("stockFormError");
    errorBox.classList.remove("show");

    // Require all product details, including the product image.
    const requiredFields = [
        { element: document.getElementById("stockProductName"), label: "Product Name" },
        { element: document.getElementById("stockCategory"), label: "Category" },
        { element: document.getElementById("stockPrice"), label: "Price" },
        { element: document.getElementById("stockQuantity"), label: "Quantity" },
        { element: document.getElementById("stockOum"), label: "Unit of Measurement" }
    ];

    const firstEmptyField = requiredFields.find(field => {
        return field.element.value.trim() === "";
    });

    const imageInput = document.getElementById("stockImage");

    // Normalize again immediately before submission so the submitted value is always formatted.
    stockProductNameInput.value = formatStockProductName(stockProductNameInput.value);
    stockOumInput.value = keepAlphabeticOnly(stockOumInput.value);

    if(firstEmptyField){
        showStockFormError("Please fill in all required fields first.");
        firstEmptyField.element.focus();
        return;
    }

    if(!imageInput.files || imageInput.files.length === 0){
        showStockFormError("Please upload a product image before adding the product.");
        imageInput.focus();
        return;
    }

    if(!/^[A-Za-z]+(?: [A-Za-z]+)*$/.test(stockProductNameInput.value)){
        showStockFormError("Product Name must contain letters and spaces only.");
        stockProductNameInput.focus();
        return;
    }

    if(!/^[A-Za-z]+$/.test(stockOumInput.value)){
        showStockFormError("Unit of Measurement must contain alphabetic letters only. Numbers, spaces, and special symbols are not allowed.");
        stockOumInput.focus();
        return;
    }

    if(!form.reportValidity()) return;

    submitButton.disabled = true;
    submitButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';

    try{
        const response = await fetch(STOCK_API.add, {
            method:"POST",
            headers:{
                "Accept":"application/json",
                "X-CSRF-TOKEN":STOCK_API.csrf,
                "X-Requested-With":"XMLHttpRequest"
            },
            body:new FormData(form)
        });

        const result = await response.json();
        if(!response.ok || !result.success){
            const validationMessage = result.errors ? Object.values(result.errors).flat()[0] : result.message;
            throw new Error(validationMessage || "Unable to add product.");
        }

        const empty = document.querySelector("#stockGrid .stock-empty-state");
        if(empty) empty.remove();

        // Use the selected file for the new card's immediate image preview.
        // The database stores the image as a BLOB, not as a public-folder filename.
        const uploadedImageFile = imageInput.files[0];
        const uploadedImageDataUrl = await new Promise((resolve, reject) => {
            const reader = new FileReader();

            reader.onload = () => resolve(reader.result);
            reader.onerror = () => reject(new Error("Unable to preview the uploaded product image."));

            reader.readAsDataURL(uploadedImageFile);
        });

        document.getElementById("stockGrid").insertAdjacentHTML(
            "afterbegin",
            stockCardHTML(result.product, uploadedImageDataUrl)
        );

        const totalProductsElement = document.getElementById("totalProducts");
        if(totalProductsElement){
            totalProductsElement.textContent = Number(totalProductsElement.textContent || 0) + 1;
        }

        document.getElementById("stockSearch").value = "";
        document.querySelectorAll("#stockGrid .product-card").forEach(card => card.style.display = "");

        closeModal("addStockModal");
        form.reset();
        showToast("Product added successfully.");
    }catch(error){
        showStockFormError(error.message || "An error occurred while adding the product.");
    }finally{
        submitButton.disabled = false;
        submitButton.innerHTML = '<i class="fa-solid fa-plus"></i> Add Product';
    }
});

document.getElementById("stockGrid").addEventListener("click", event => {
    const quantityButton = event.target.closest("[data-quantity-action]");
    if(quantityButton){
        changeStockQuantity(Number(quantityButton.dataset.productId), quantityButton.dataset.quantityAction);
        return;
    }

    const removeButton = event.target.closest("[data-remove-product]");
    if(removeButton){
        removeStockProduct(Number(removeButton.dataset.removeProduct), removeButton);
    }
});

/* =========================
   STOCK SEARCH
========================= */

document.getElementById("stockSearch").addEventListener("input", function(){
    const query = this.value.trim().toLowerCase();
    const cards = Array.from(document.querySelectorAll("#stockGrid .product-card"));
    let firstMatch = null;

    cards.forEach(card => {
        const matches = card.dataset.name.includes(query);
        card.style.display = matches ? "" : "none";
        if (matches && !firstMatch) firstMatch = card;
    });

    const emptyMessage = document.getElementById("stockSearchEmpty");
    if (emptyMessage) emptyMessage.remove();

    if (query && !firstMatch) {
        const message = document.createElement("div");
        message.id = "stockSearchEmpty";
        message.className = "empty-state";
        message.style.gridColumn = "1/-1";
        message.innerHTML = '<i class="fa-solid fa-magnifying-glass"></i><h3>No stock items found</h3><p>Try another product name.</p>';
        document.getElementById("stockGrid").appendChild(message);
    }
});

document
    .getElementById("transactionSearch")
    .addEventListener("input",renderTransactions);

document
    .getElementById("transactionFilter")
    .addEventListener("change",renderTransactions);

/* =========================
   PROFILE DROPDOWN
========================= */

const profileButton=
    document.getElementById("profileButton");

const profileMenu=
    document.getElementById("profileMenu");

profileButton.addEventListener("click",event=>{

    event.stopPropagation();

    profileMenu.classList.toggle("open");

});

document.addEventListener("click",()=>{
    profileMenu.classList.remove("open");
});

/* =========================
   NAVBAR SCROLL
========================= */

window.addEventListener("scroll",()=>{

    document
        .getElementById("navbar")
        .classList
        .toggle(
            "scrolled",
            window.scrollY>25
        );

},{
    passive:true
});

/* =========================
   REVEAL ANIMATION
========================= */

const observer=new IntersectionObserver(
    entries=>{

        entries.forEach(entry=>{

            if(entry.isIntersecting){
                entry.target.classList.add("visible");
            }else{
                entry.target.classList.remove("visible");
            }

        });

    },
    {
        threshold:.12,
        rootMargin:"0px 0px -45px 0px"
    }
);

function observeNewElements(){

    document
        .querySelectorAll(".reveal,.stagger")
        .forEach(element=>{

            if(element.closest("#myStockSection")) return;

            if(!element.dataset.observed){
                observer.observe(element);
                element.dataset.observed="true";
            }

        });
}

/* =========================
   CLICK POP
========================= */

document.addEventListener("click",event=>{

    const pop=document.createElement("span");

    pop.className="click-pop";

    pop.style.left=`${event.clientX}px`;
    pop.style.top=`${event.clientY}px`;

    document.body.appendChild(pop);

    setTimeout(()=>{
        pop.remove();
    },700);

});

/* =========================
   ESCAPE KEY
========================= */

document.addEventListener("keydown",event=>{

    if(event.key==="Escape"){

        document
            .querySelectorAll(".modal-overlay.open")
            .forEach(modal=>{
                closeModal(modal.id);
            });

        profileMenu.classList.remove("open");
    }

});

/* =========================
   INITIALIZE
========================= */

renderTransactions();
renderRequests();
updateStatistics();
observeNewElements();

</script>

</body>
</html>