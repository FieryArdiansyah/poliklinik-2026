<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PoliQueue — Sistem Informasi Antrian Poliklinik</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
  :root{
    --blue-50:#eef3ff;
    --blue-100:#dbe6ff;
    --blue-500:#3b5bfd;
    --blue-600:#2f4de0;
    --blue-700:#1e3ab8;
    --navy-900:#0f172a;
    --navy-700:#334155;
    --navy-500:#64748b;
    --bg:#eef1f7;
    --surface:#ffffff;
    --border:#e6e9f2;
    --green-500:#16a34a;
    --green-50:#ecfdf3;
    --amber-500:#d97706;
    --amber-50:#fffaeb;
    --shadow-sm: 0 1px 2px rgba(15,23,42,.04);
    --shadow-md: 0 8px 24px rgba(15,23,42,.08);
    --shadow-lg: 0 24px 48px -12px rgba(30,58,138,.25);
    --radius:16px;
  }

  *{box-sizing:border-box;}
  html{scroll-behavior:smooth;}
  body{
    margin:0;
    font-family:'Inter',system-ui,sans-serif;
    background:var(--bg);
    color:var(--navy-900);
    -webkit-font-smoothing:antialiased;
  }
  h1,h2,h3,.brand,.nav-link,.btn,.chip{
    font-family:'Plus Jakarta Sans',sans-serif;
  }

  a{text-decoration:none;color:inherit;}
  button{font-family:inherit;cursor:pointer;}

  /* ===== Top accent bar ===== */
  .top-accent{
    height:4px;
    background:linear-gradient(90deg,var(--blue-500),var(--blue-700));
  }

  /* ===== Navbar ===== */
  header{
    position:sticky;
    top:0;
    z-index:50;
    background:rgba(255,255,255,.85);
    backdrop-filter:blur(10px);
    border-bottom:1px solid var(--border);
  }
  .nav-wrap{
    max-width:1200px;
    margin:0 auto;
    padding:16px 32px;
    display:flex;
    align-items:center;
    justify-content:space-between;
  }
  .brand{
    display:flex;
    align-items:center;
    gap:10px;
    font-weight:800;
    font-size:20px;
    color:var(--blue-600);
    letter-spacing:-0.02em;
  }
  .brand-mark{
    width:34px;height:34px;
    border-radius:9px;
    background:linear-gradient(135deg,var(--blue-500),var(--blue-700));
    display:flex;align-items:center;justify-content:center;
    box-shadow:var(--shadow-sm);
    flex-shrink:0;
  }
  .brand-mark svg{width:18px;height:18px;}

  nav{display:flex;align-items:center;gap:4px;}
  .nav-link{
    font-weight:600;
    font-size:14.5px;
    color:var(--navy-700);
    padding:9px 16px;
    border-radius:10px;
    transition:background .15s ease, color .15s ease;
    position:relative;
  }
  .nav-link:hover{background:var(--blue-50);color:var(--blue-700);}
  .nav-link.active{color:var(--blue-700);background:var(--blue-50);}
  .nav-link.admin{
    margin-left:8px;
    color:#fff;
    background:var(--navy-900);
  }
  .nav-link.admin:hover{background:#1e293b;}

  .nav-toggle{display:none;}

  /* ===== Layout helpers ===== */
  .container{max-width:1200px;margin:0 auto;padding:0 32px;}

  /* ===== Hero ===== */
  .hero{padding:72px 0 88px;}
  .hero-grid{
    display:grid;
    grid-template-columns:1.15fr 0.85fr;
    gap:32px;
    align-items:stretch;
  }

  .hero-card{
    background:var(--surface);
    border:1px solid var(--border);
    border-radius:24px;
    padding:52px 48px;
    box-shadow:var(--shadow-md);
    display:flex;
    flex-direction:column;
    justify-content:center;
  }

  .chip{
    display:inline-flex;
    align-items:center;
    gap:7px;
    width:fit-content;
    background:var(--blue-50);
    color:var(--blue-700);
    font-weight:700;
    font-size:13px;
    padding:8px 16px;
    border-radius:999px;
    margin-bottom:22px;
    letter-spacing:.01em;
  }
  .chip .dot{
    width:7px;height:7px;border-radius:50%;
    background:var(--green-500);
    box-shadow:0 0 0 3px var(--green-50);
    animation:pulse-dot 2s infinite;
  }
  @keyframes pulse-dot{
    0%,100%{opacity:1;}
    50%{opacity:.4;}
  }

  .hero h1{
    font-size:46px;
    line-height:1.12;
    font-weight:800;
    letter-spacing:-0.03em;
    margin:0 0 18px;
    color:var(--navy-900);
  }
  .hero h1 span{color:var(--blue-600);}

  .hero p{
    font-size:16.5px;
    line-height:1.65;
    color:var(--navy-500);
    max-width:480px;
    margin:0 0 32px;
  }

  .hero-actions{display:flex;gap:12px;flex-wrap:wrap;}

  .btn{
    display:inline-flex;
    align-items:center;
    gap:8px;
    font-weight:700;
    font-size:15px;
    padding:14px 24px;
    border-radius:12px;
    border:none;
    transition:transform .15s ease, box-shadow .15s ease, background .15s ease;
  }
  .btn:active{transform:scale(.98);}
  .btn-primary{
    background:linear-gradient(135deg,var(--blue-500),var(--blue-700));
    color:#fff;
    box-shadow:0 10px 20px -6px rgba(47,77,224,.45);
  }
  .btn-primary:hover{box-shadow:0 14px 26px -6px rgba(47,77,224,.55);transform:translateY(-1px);}
  .btn-secondary{
    background:var(--blue-50);
    color:var(--blue-700);
  }
  .btn-secondary:hover{background:var(--blue-100);}

  .hero-stats{
    display:flex;
    gap:28px;
    margin-top:36px;
    padding-top:28px;
    border-top:1px solid var(--border);
  }
  .hero-stat b{
    display:block;
    font-size:22px;
    font-weight:800;
    color:var(--navy-900);
  }
  .hero-stat span{
    font-size:12.5px;
    color:var(--navy-500);
    font-weight:600;
  }

  /* ===== Queue preview card ===== */
  .queue-card{
    background:linear-gradient(160deg,var(--blue-500) 0%, var(--blue-700) 100%);
    border-radius:24px;
    padding:36px;
    color:#fff;
    box-shadow:var(--shadow-lg);
    display:flex;
    flex-direction:column;
    position:relative;
    overflow:hidden;
  }
  .queue-card::before{
    content:"";
    position:absolute;
    width:260px;height:260px;
    background:radial-gradient(circle,rgba(255,255,255,.16),transparent 70%);
    top:-90px;right:-70px;
    border-radius:50%;
  }
  .queue-card::after{
    content:"";
    position:absolute;
    width:200px;height:200px;
    background:radial-gradient(circle,rgba(255,255,255,.10),transparent 70%);
    bottom:-80px;left:-60px;
    border-radius:50%;
  }

  .queue-card-top{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    position:relative;
    z-index:1;
  }
  .queue-label{
    font-size:12.5px;
    font-weight:700;
    letter-spacing:.09em;
    text-transform:uppercase;
    color:rgba(255,255,255,.75);
  }
  .live-pill{
    display:flex;align-items:center;gap:6px;
    font-size:11.5px;font-weight:700;
    background:rgba(255,255,255,.14);
    padding:5px 10px;border-radius:999px;
    color:#fff;
  }
  .live-pill .dot{
    width:6px;height:6px;border-radius:50%;background:#4ade80;
    animation:pulse-dot 2s infinite;
  }

  .queue-number{
    font-size:64px;
    font-weight:800;
    letter-spacing:-0.02em;
    margin:26px 0 6px;
    position:relative;z-index:1;
    line-height:1;
  }
  .queue-meta{
    display:flex;
    align-items:center;
    gap:8px;
    font-size:14.5px;
    color:rgba(255,255,255,.85);
    font-weight:600;
    margin-bottom:26px;
    position:relative;z-index:1;
  }
  .status-badge{
    display:inline-flex;align-items:center;gap:6px;
    background:rgba(255,255,255,.16);
    padding:4px 10px;
    border-radius:999px;
    font-size:12.5px;
  }

  .queue-progress{
    position:relative;z-index:1;
    background:rgba(255,255,255,.14);
    border-radius:14px;
    padding:16px 18px;
    margin-top:auto;
  }
  .queue-progress-row{
    display:flex;justify-content:space-between;
    font-size:13px;font-weight:600;
    color:rgba(255,255,255,.85);
    margin-bottom:10px;
  }
  .queue-progress-row b{color:#fff;font-size:14px;}
  .progress-track{
    height:6px;
    background:rgba(255,255,255,.2);
    border-radius:999px;
    overflow:hidden;
  }
  .progress-fill{
    height:100%;
    width:35%;
    border-radius:999px;
    background:#fff;
  }

  /* ===== Section shared ===== */
  .section{padding:24px 0 88px;}
  .section-head{
    text-align:center;
    max-width:600px;
    margin:0 auto 44px;
  }
  .section-eyebrow{
    font-size:13px;
    font-weight:700;
    color:var(--blue-600);
    letter-spacing:.08em;
    text-transform:uppercase;
    margin-bottom:10px;
  }
  .section-head h2{
    font-size:32px;
    font-weight:800;
    letter-spacing:-0.02em;
    margin:0 0 12px;
    color:var(--navy-900);
  }
  .section-head p{
    font-size:15.5px;
    color:var(--navy-500);
    line-height:1.6;
    margin:0;
  }

  /* ===== Steps ===== */
  .steps-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:24px;
    position:relative;
  }
  .step-card{
    background:var(--surface);
    border:1px solid var(--border);
    border-radius:18px;
    padding:32px 28px;
    box-shadow:var(--shadow-sm);
    transition:transform .18s ease, box-shadow .18s ease, border-color .18s ease;
  }
  .step-card:hover{
    transform:translateY(-4px);
    box-shadow:var(--shadow-md);
    border-color:var(--blue-100);
  }
  .step-num{
    width:40px;height:40px;
    border-radius:11px;
    background:var(--blue-50);
    color:var(--blue-700);
    display:flex;align-items:center;justify-content:center;
    font-weight:800;
    font-size:15px;
    margin-bottom:20px;
  }
  .step-card h3{
    font-size:17.5px;
    font-weight:700;
    margin:0 0 8px;
    color:var(--navy-900);
  }
  .step-card p{
    font-size:14.5px;
    color:var(--navy-500);
    line-height:1.6;
    margin:0;
  }

  /* ===== Poli overview ===== */
  .poli-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:20px;
  }
  .poli-card{
    background:var(--surface);
    border:1px solid var(--border);
    border-radius:16px;
    padding:24px;
    box-shadow:var(--shadow-sm);
    transition:transform .18s ease, box-shadow .18s ease;
  }
  .poli-card:hover{transform:translateY(-3px);box-shadow:var(--shadow-md);}
  .poli-card-top{
    display:flex;align-items:center;
    margin-bottom:18px;
  }
  .poli-icon{
    width:42px;height:42px;
    border-radius:11px;
    display:flex;align-items:center;justify-content:center;
  }
  .poli-icon svg{width:20px;height:20px;}
  .poli-tag{
    font-size:11px;font-weight:700;
    padding:4px 9px;border-radius:999px;
  }
  .poli-tag.normal{background:var(--green-50);color:var(--green-500);}
  .poli-tag.busy{background:var(--amber-50);color:var(--amber-500);}
  .poli-card h4{
    font-size:15.5px;font-weight:700;margin:0 0 4px;color:var(--navy-900);
  }
  .poli-card .waiting{
    font-size:13px;color:var(--navy-500);margin-bottom:14px;
  }
  .poli-card .waiting b{color:var(--navy-900);font-weight:700;}
  .poli-wait-time{
    display:flex;align-items:center;gap:6px;
    font-size:12.5px;font-weight:600;color:var(--navy-500);
    padding-top:14px;border-top:1px dashed var(--border);
  }

  /* ===== View switching ===== */
  .view{display:none;}
  .view.active{display:block;}

  /* ===== Form (Ambil Antrian) ===== */
  .form-shell{
    max-width:560px;
    margin:0 auto;
    background:var(--surface);
    border:1px solid var(--border);
    border-radius:24px;
    padding:44px 40px;
    box-shadow:var(--shadow-md);
  }
  .field{margin-bottom:20px;}
  .field label{
    display:block;
    font-size:13.5px;
    font-weight:700;
    color:var(--navy-700);
    margin-bottom:8px;
  }
  .field input,.field select{
    width:100%;
    padding:13px 14px;
    border-radius:11px;
    border:1.5px solid var(--border);
    font-size:15px;
    font-family:inherit;
    color:var(--navy-900);
    background:#fbfcfe;
    transition:border-color .15s ease, box-shadow .15s ease;
  }
  .field input:focus,.field select:focus{
    outline:none;
    border-color:var(--blue-500);
    box-shadow:0 0 0 3px var(--blue-100);
    background:#fff;
  }
  .field-hint{font-size:12.5px;color:var(--navy-500);margin-top:6px;}
  .btn-block{width:100%;justify-content:center;margin-top:6px;}

  .ticket-result{
    max-width:560px;
    margin:0 auto;
    text-align:center;
  }
  .ticket-result .queue-card{margin-bottom:20px;}
  .ticket-actions{display:flex;gap:10px;justify-content:center;flex-wrap:wrap;}

  /* ===== Monitoring ===== */
  .mon-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;}
  .mon-card{
    background:var(--surface);
    border:1px solid var(--border);
    border-radius:18px;
    padding:26px;
    box-shadow:var(--shadow-sm);
  }
  .mon-card h4{margin:0 0 4px;font-size:16px;font-weight:700;}
  .mon-serving{
    background:var(--blue-50);
    border-radius:12px;
    padding:16px;
    margin:16px 0;
    text-align:center;
  }
  .mon-serving span{font-size:11.5px;font-weight:700;color:var(--blue-700);text-transform:uppercase;letter-spacing:.06em;}
  .mon-serving b{display:block;font-size:26px;font-weight:800;color:var(--navy-900);margin-top:4px;}
  .mon-list{list-style:none;margin:0;padding:0;display:flex;flex-direction:column;gap:8px;max-height:220px;overflow-y:auto;}
  .mon-list li{
    display:flex;justify-content:space-between;align-items:center;
    padding:10px 12px;border-radius:9px;
    background:#fbfcfe;border:1px solid var(--border);
    font-size:13.5px;font-weight:600;color:var(--navy-700);
  }
  .mon-list li.mine{background:var(--blue-50);border-color:var(--blue-100);color:var(--blue-700);}
  .mon-empty{font-size:13px;color:var(--navy-500);text-align:center;padding:14px 0;}
  .refresh-row{display:flex;justify-content:flex-end;margin-bottom:16px;}
  .btn-ghost{background:transparent;border:1.5px solid var(--border);color:var(--navy-700);}
  .btn-ghost:hover{border-color:var(--blue-500);color:var(--blue-700);}

  /* ===== Admin ===== */
  .admin-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-bottom:32px;}
  .admin-card{
    background:var(--surface);border:1px solid var(--border);
    border-radius:18px;padding:24px;box-shadow:var(--shadow-sm);
  }
  .admin-card h4{margin:0 0 14px;font-size:16px;font-weight:700;}
  .admin-row{display:flex;justify-content:space-between;font-size:13.5px;color:var(--navy-500);margin-bottom:8px;}
  .admin-row b{color:var(--navy-900);}
  .admin-actions{display:flex;gap:8px;margin-top:16px;}
  .admin-actions .btn{flex:1;padding:11px;font-size:13.5px;}

  .admin-table{width:100%;border-collapse:collapse;background:var(--surface);border:1px solid var(--border);border-radius:16px;overflow:hidden;}
  .admin-table th,.admin-table td{text-align:left;padding:12px 16px;font-size:13.5px;border-bottom:1px solid var(--border);}
  .admin-table th{background:#fbfcfe;color:var(--navy-500);font-weight:700;text-transform:uppercase;font-size:11.5px;letter-spacing:.05em;}
  .status-pill{display:inline-block;padding:3px 10px;border-radius:999px;font-size:11.5px;font-weight:700;}
  .status-pill.waiting{background:var(--amber-50);color:var(--amber-500);}
  .status-pill.called{background:var(--blue-50);color:var(--blue-700);}
  .status-pill.done{background:var(--green-50);color:var(--green-500);}

  /* ===== Footer ===== */
  footer{
    border-top:1px solid var(--border);
    background:var(--surface);
    padding:36px 0;
  }
  .footer-wrap{
    display:flex;justify-content:space-between;align-items:center;
    flex-wrap:wrap;gap:16px;
  }
  .footer-brand{
    display:flex;align-items:center;gap:9px;
    font-weight:800;color:var(--blue-600);font-size:16px;
  }
  .footer-note{font-size:13px;color:var(--navy-500);}

  /* ===== Responsive ===== */
  @media (max-width:980px){
    .hero-grid{grid-template-columns:1fr;}
    .poli-grid{grid-template-columns:repeat(2,1fr);}
    .steps-grid{grid-template-columns:1fr;}
    .hero h1{font-size:36px;}
  }
  @media (max-width:720px){
    .nav-wrap{padding:14px 20px;}
    nav{display:none;}
    .container{padding:0 20px;}
    .hero-card{padding:32px 24px;}
    .hero h1{font-size:30px;}
    .hero-stats{gap:18px;flex-wrap:wrap;}
    .poli-grid{grid-template-columns:1fr;}
    .queue-number{font-size:50px;}
  }
</style>
</head>
<body>

<div class="top-accent"></div>

<header>
  <div class="nav-wrap">
    <a href="#" class="brand">
      <span class="brand-mark">
        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M4 12h4l2-6 4 12 2-6h4" stroke="white" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </span>
      PoliQueue
    </a>
    <nav>
      <a href="#home" class="nav-link active" data-view="home" onclick="showView('home');return false;">Beranda</a>
      <a href="#ambil" class="nav-link" data-view="ambil" onclick="showView('ambil');return false;">Ambil Antrian</a>
      <a href="#monitoring" class="nav-link" data-view="monitoring" onclick="showView('monitoring');return false;">Monitoring</a>
      <a href="#admin" class="nav-link admin" data-view="admin" onclick="showView('admin');return false;">Admin</a>
    </nav>
  </div>
</header>

<main>
<section id="view-home" class="view active">
  <section class="hero">
    <div class="container">
      <div class="hero-grid">

        <div class="hero-card">
          <span class="chip"><span class="dot"></span> Antrian Poliklinik Real-Time</span>
          <h1>Sistem Informasi<br><span>Antrian Poliklinik</span></h1>
          <p>Ambil nomor antrian secara online, lihat estimasi waktu tunggu, dan pantau status panggilan pasien melalui halaman monitoring — tanpa perlu mengantre di loket.</p>
          <div class="hero-actions">
            <button class="btn btn-primary" onclick="showView('ambil')">
              Ambil Nomor Antrian
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
            <button class="btn btn-secondary" onclick="showView('monitoring')">
              Lihat Monitoring
            </button>
          </div>

          <div class="hero-stats">
            <div class="hero-stat">
              <b>3</b>
              <span>Poliklinik Aktif</span>
            </div>
            <div class="hero-stat">
              <b>128</b>
              <span>Antrian Hari Ini</span>
            </div>
            <div class="hero-stat">
              <b>~12 mnt</b>
              <span>Rata-rata Tunggu</span>
            </div>
          </div>
        </div>

        <div class="queue-card">
          <div class="queue-card-top">
            <span class="queue-label">Contoh Nomor</span>
            <span class="live-pill"><span class="dot"></span> Live</span>
          </div>
          <div class="queue-number" id="home-queue-number">UMU&#8209;001</div>
          <div class="queue-meta">
            <span id="home-queue-poli">Poli Umum</span>
            <span class="status-badge">
              <svg width="12" height="12" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/><path d="M12 7v5l3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
              Menunggu
            </span>
          </div>

          <div class="queue-progress">
            <div class="queue-progress-row">
              <span>Antrian menunggu</span>
              <b id="home-queue-waiting">9 pasien</b>
            </div>
            <div class="progress-track"><div class="progress-fill" id="home-queue-fill"></div></div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="section-head">
        <div class="section-eyebrow">Cara Kerja</div>
        <h2>Tiga langkah, tanpa antre di loket</h2>
        <p>Alur sederhana dari mengambil nomor sampai dipanggil ke ruang periksa.</p>
      </div>
      <div class="steps-grid">
        <div class="step-card">
          <div class="step-num">01</div>
          <h3>Ambil Antrian</h3>
          <p>Pasien mengisi data dan memilih poliklinik tujuan langsung dari perangkat masing-masing.</p>
        </div>
        <div class="step-card">
          <div class="step-num">02</div>
          <h3>Dapat Nomor</h3>
          <p>Sistem membuat nomor antrian otomatis berdasarkan kode poli, lengkap dengan estimasi waktu tunggu.</p>
        </div>
        <div class="step-card">
          <div class="step-num">03</div>
          <h3>Monitoring</h3>
          <p>Pasien bisa melihat status antrian dan posisi terkini secara real-time dari halaman monitoring.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="section" style="padding-top:0;">
    <div class="container">
      <div class="section-head">
        <div class="section-eyebrow">Status Poliklinik</div>
        <h2>Pantau antrian tiap poli saat ini</h2>
        <p>Lihat jumlah antrian yang sedang menunggu di setiap poliklinik sebelum kamu datang.</p>
      </div>
      <div class="poli-grid">

        <div class="poli-card">
          <div class="poli-card-top">
            <span class="poli-icon" style="background:var(--blue-50);">
              <svg viewBox="0 0 24 24" fill="none"><path d="M12 21c-4.4-2.7-8-6.2-8-10.5A5.5 5.5 0 0 1 9.5 5c1 0 2 .4 2.5 1.2C12.5 5.4 13.5 5 14.5 5A5.5 5.5 0 0 1 20 10.5c0 4.3-3.6 7.8-8 10.5Z" stroke="#2f4de0" stroke-width="1.8" stroke-linejoin="round"/></svg>
            </span>
          </div>
          <h4>Poli Umum</h4>
          <div class="waiting"><b id="poli-UMU-waiting">9</b> pasien menunggu</div>
          <div class="poli-wait-time">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8"/><path d="M12 7v5l3 3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            Estimasi ~<span id="poli-UMU-time">12</span> menit
          </div>
        </div>

        <div class="poli-card">
          <div class="poli-card-top">
            <span class="poli-icon" style="background:#fdf2f8;">
              <svg viewBox="0 0 24 24" fill="none"><path d="M12 3v6M9 6h6M6 13h12l-1.2 6.4a2 2 0 0 1-2 1.6H9.2a2 2 0 0 1-2-1.6L6 13Z" stroke="#db2777" stroke-width="1.8" stroke-linejoin="round"/></svg>
            </span>
          </div>
          <h4>Poli Gigi</h4>
          <div class="waiting"><b id="poli-GIG-waiting">14</b> pasien menunggu</div>
          <div class="poli-wait-time">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8"/><path d="M12 7v5l3 3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            Estimasi ~<span id="poli-GIG-time">24</span> menit
          </div>
        </div>

        <div class="poli-card">
          <div class="poli-card-top">
            <span class="poli-icon" style="background:#f0fdf4;">
              <svg viewBox="0 0 24 24" fill="none"><path d="M9 12h6M12 9v6M12 21c-4.4-2.7-8-6.2-8-10.5A5.5 5.5 0 0 1 9.5 5c1 0 2 .4 2.5 1.2C12.5 5.4 13.5 5 14.5 5A5.5 5.5 0 0 1 20 10.5c0 4.3-3.6 7.8-8 10.5Z" stroke="#16a34a" stroke-width="1.8" stroke-linejoin="round"/></svg>
            </span>
          </div>
          <h4>Poli Anak</h4>
          <div class="waiting"><b id="poli-ANA-waiting">6</b> pasien menunggu</div>
          <div class="poli-wait-time">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8"/><path d="M12 7v5l3 3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            Estimasi ~<span id="poli-ANA-time">9</span> menit
          </div>
        </div>

      </div>
    </div>
  </section>
</section>
<!-- /view-home -->

<section id="view-ambil" class="view">
  <div class="section" style="padding-top:56px;">
    <div class="container">
      <div class="section-head">
        <div class="section-eyebrow">Ambil Antrian</div>
        <h2>Isi data untuk dapat nomor antrian</h2>
        <p>Nomor antrianmu akan dibuat otomatis sesuai poliklinik yang dipilih.</p>
      </div>

      <div id="ambil-form-wrap" class="form-shell">
        <div class="field">
          <label for="input-nama">Nama Pasien</label>
          <input type="text" id="input-nama" placeholder="Contoh: Siti Rahma">
        </div>
        <div class="field">
          <label for="input-poli">Pilih Poliklinik</label>
          <select id="input-poli">
            <option value="UMU">Poli Umum</option>
            <option value="GIG">Poli Gigi</option>
            <option value="ANA">Poli Anak</option>
          </select>
          <div class="field-hint">Nomor antrian akan mengikuti kode poliklinik, contoh: UMU-001.</div>
        </div>
        <button class="btn btn-primary btn-block" onclick="ambilAntrian()">
          Dapatkan Nomor Antrian
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none"><path d="M5 12h14M13 6l6 6-6 6" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
        </button>
      </div>

      <div id="ambil-result-wrap" class="ticket-result" style="display:none;"></div>
    </div>
  </div>
</section>

<section id="view-monitoring" class="view">
  <div class="section" style="padding-top:56px;">
    <div class="container">
      <div class="section-head">
        <div class="section-eyebrow">Monitoring</div>
        <h2>Status antrian saat ini</h2>
        <p>Pantau nomor yang sedang dilayani dan daftar tunggu di tiap poliklinik.</p>
      </div>
      <div class="refresh-row">
        <button class="btn btn-ghost" onclick="renderMonitoring()">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none"><path d="M4 4v6h6M20 20v-6h-6M4.5 15a8 8 0 0 0 13.9 3M19.5 9A8 8 0 0 0 5.6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
          Segarkan
        </button>
      </div>
      <div id="monitoring-grid" class="mon-grid"></div>
    </div>
  </div>
</section>

<section id="view-admin" class="view">
  <div class="section" style="padding-top:56px;">
    <div class="container">
      <div class="section-head">
        <div class="section-eyebrow">Panel Admin</div>
        <h2>Kelola panggilan antrian</h2>
        <p>Panggil nomor berikutnya atau reset antrian per poliklinik. Halaman ini untuk petugas loket.</p>
      </div>
      <div id="admin-grid" class="admin-grid"></div>
      <div class="section-head" style="margin-bottom:20px;">
        <h2 style="font-size:22px;">Riwayat Antrian Hari Ini</h2>
      </div>
      <table class="admin-table">
        <thead>
          <tr><th>Nomor</th><th>Nama</th><th>Poli</th><th>Status</th></tr>
        </thead>
        <tbody id="admin-table-body"></tbody>
      </table>
    </div>
  </div>
</section>
</main>

<footer>
  <div class="container footer-wrap">
    <div class="footer-brand">
      <span class="brand-mark" style="width:28px;height:28px;">
        <svg viewBox="0 0 24 24" fill="none" width="14" height="14"><path d="M4 12h4l2-6 4 12 2-6h4" stroke="white" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
      </span>
      PoliQueue
    </div>
    <div class="footer-note">© 2026 PoliQueue — Sistem Informasi Antrian Poliklinik</div>
  </div>
</footer>

<script>
  // ===== Konfigurasi poliklinik =====
  var POLI_INFO = {
    UMU: { name: 'Poli Umum', avgMinutes: 4 },
    GIG: { name: 'Poli Gigi', avgMinutes: 5 },
    ANA: { name: 'Poli Anak', avgMinutes: 4 }
  };
  var STORAGE_KEY = 'poliqueue_state_v1';
  var MY_TICKET_KEY = 'poliqueue_my_ticket';

  // ===== State: load / save dari localStorage browser =====
  function loadState(){
    try{
      var raw = localStorage.getItem(STORAGE_KEY);
      if(raw) return JSON.parse(raw);
    }catch(e){}
    return seedState();
  }
  function saveState(state){
    localStorage.setItem(STORAGE_KEY, JSON.stringify(state));
  }
  function seedState(){
    // data contoh awal supaya tampilan tidak kosong saat pertama dibuka
    var state = { polis:{} };
    var seed = { UMU:5, GIG:8, ANA:3 };
    Object.keys(POLI_INFO).forEach(function(code){
      var tickets = [];
      for(var i=1;i<=seed[code];i++){
        tickets.push({ no: code + '-' + pad(i), name:'Pasien '+i, status: i===1?'called':'waiting', createdAt: Date.now() });
      }
      state.polis[code] = { counter: seed[code]+1, tickets: tickets };
    });
    saveState(state);
    return state;
  }
  function pad(n){ return String(n).padStart(3,'0'); }

  var state = loadState();

  // ===== Navigasi antar halaman =====
  function showView(view){
    document.querySelectorAll('.view').forEach(function(el){ el.classList.remove('active'); });
    document.getElementById('view-'+view).classList.add('active');
    document.querySelectorAll('.nav-link').forEach(function(el){
      el.classList.toggle('active', el.dataset.view === view && view !== 'admin');
    });
    window.location.hash = view;
    window.scrollTo({top:0, behavior:'smooth'});

    if(view === 'home') renderHome();
    if(view === 'monitoring') renderMonitoring();
    if(view === 'admin') renderAdmin();
  }

  // ===== Beranda: kartu contoh nomor + status poli =====
  function renderHome(){
    var codes = Object.keys(POLI_INFO);
    var busiest = codes.reduce(function(a,b){
      return waitingCount(b) > waitingCount(a) ? b : a;
    });
    var w = waitingCount(busiest);
    document.getElementById('home-queue-poli').textContent = POLI_INFO[busiest].name;
    document.getElementById('home-queue-number').textContent = nextPreviewNumber(busiest);
    document.getElementById('home-queue-waiting').textContent = w + ' pasien';
    document.getElementById('home-queue-fill').style.width = Math.min(100, w*8) + '%';

    codes.forEach(function(code){
      var wc = waitingCount(code);
      var elW = document.getElementById('poli-'+code+'-waiting');
      var elT = document.getElementById('poli-'+code+'-time');
      if(elW) elW.textContent = wc;
      if(elT) elT.textContent = wc * POLI_INFO[code].avgMinutes;
    });
  }
  function waitingCount(code){
    return state.polis[code].tickets.filter(function(t){ return t.status === 'waiting'; }).length;
  }
  function nextPreviewNumber(code){
    var p = state.polis[code];
    return code + '-' + pad(p.counter);
  }

  // ===== Ambil Antrian =====
  function ambilAntrian(){
    var name = document.getElementById('input-nama').value.trim() || 'Pasien';
    var code = document.getElementById('input-poli').value;
    var p = state.polis[code];
    var no = code + '-' + pad(p.counter);
    p.counter++;
    p.tickets.push({ no:no, name:name, status:'waiting', createdAt: Date.now() });
    saveState(state);
    localStorage.setItem(MY_TICKET_KEY, no);

    var position = waitingCount(code); // posisi ticket baru = jumlah yg menunggu skrg
    var estMinutes = position * POLI_INFO[code].avgMinutes;

    document.getElementById('ambil-form-wrap').style.display = 'none';
    var resultWrap = document.getElementById('ambil-result-wrap');
    resultWrap.style.display = 'block';
    resultWrap.innerHTML =
      '<div class="queue-card" style="max-width:420px;margin:0 auto;">' +
        '<div class="queue-card-top">' +
          '<span class="queue-label">Nomor Antrian Kamu</span>' +
          '<span class="live-pill"><span class="dot"></span> Baru</span>' +
        '</div>' +
        '<div class="queue-number">'+no+'</div>' +
        '<div class="queue-meta">'+POLI_INFO[code].name+
          '<span class="status-badge"><svg width="12" height="12" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/><path d="M12 7v5l3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg> Menunggu</span>' +
        '</div>' +
        '<div class="queue-progress">' +
          '<div class="queue-progress-row"><span>Posisi antrian</span><b>'+position+'</b></div>' +
          '<div class="queue-progress-row"><span>Estimasi tunggu</span><b>~'+estMinutes+' menit</b></div>' +
        '</div>' +
      '</div>' +
      '<div class="ticket-actions">' +
        '<button class="btn btn-primary" onclick="showView(\'monitoring\')">Pantau di Monitoring</button>' +
        '<button class="btn btn-secondary" onclick="resetAmbilForm()">Ambil Nomor Lain</button>' +
      '</div>';
  }
  function resetAmbilForm(){
    document.getElementById('input-nama').value = '';
    document.getElementById('ambil-form-wrap').style.display = 'block';
    document.getElementById('ambil-result-wrap').style.display = 'none';
  }

  // ===== Monitoring =====
  function renderMonitoring(){
    var myTicket = localStorage.getItem(MY_TICKET_KEY);
    var grid = document.getElementById('monitoring-grid');
    grid.innerHTML = '';
    Object.keys(POLI_INFO).forEach(function(code){
      var p = state.polis[code];
      var called = p.tickets.filter(function(t){return t.status==='called';}).slice(-1)[0];
      var waiting = p.tickets.filter(function(t){return t.status==='waiting';});

      var listHtml = waiting.length
        ? waiting.map(function(t){
            var mine = t.no === myTicket ? ' mine' : '';
            return '<li class="'+mine.trim()+'"><span>'+t.no+'</span><span>'+t.name+'</span></li>';
          }).join('')
        : '<div class="mon-empty">Tidak ada antrian menunggu.</div>';

      var card = document.createElement('div');
      card.className = 'mon-card';
      card.innerHTML =
        '<h4>'+p_name(code)+'</h4>' +
        '<div class="mon-serving">' +
          '<span>Sedang Dilayani</span>' +
          '<b>'+ (called ? called.no : '—') +'</b>' +
        '</div>' +
        '<ul class="mon-list">'+listHtml+'</ul>';
      grid.appendChild(card);
    });
  }
  function p_name(code){ return POLI_INFO[code].name; }

  // ===== Admin =====
  function renderAdmin(){
    var grid = document.getElementById('admin-grid');
    grid.innerHTML = '';
    Object.keys(POLI_INFO).forEach(function(code){
      var p = state.polis[code];
      var called = p.tickets.filter(function(t){return t.status==='called';}).slice(-1)[0];
      var waiting = p.tickets.filter(function(t){return t.status==='waiting';});

      var card = document.createElement('div');
      card.className = 'admin-card';
      card.innerHTML =
        '<h4>'+p_name(code)+'</h4>' +
        '<div class="admin-row"><span>Sedang dilayani</span><b>'+(called?called.no:'—')+'</b></div>' +
        '<div class="admin-row"><span>Menunggu</span><b>'+waiting.length+' pasien</b></div>' +
        '<div class="admin-actions">' +
          '<button class="btn btn-primary" onclick="panggilBerikutnya(\''+code+'\')">Panggil Berikutnya</button>' +
          '<button class="btn btn-ghost" onclick="resetPoli(\''+code+'\')">Reset</button>' +
        '</div>';
      grid.appendChild(card);
    });
    renderAdminTable();
  }
  function panggilBerikutnya(code){
    var p = state.polis[code];
    // selesaikan yang sedang dipanggil
    p.tickets.forEach(function(t){ if(t.status==='called') t.status='done'; });
    // panggil antrian berikutnya
    var next = p.tickets.filter(function(t){return t.status==='waiting';})[0];
    if(next) next.status = 'called';
    saveState(state);
    renderAdmin();
  }
  function resetPoli(code){
    if(!confirm('Reset seluruh antrian '+p_name(code)+'?')) return;
    state.polis[code] = { counter:1, tickets:[] };
    saveState(state);
    renderAdmin();
  }
  function renderAdminTable(){
    var body = document.getElementById('admin-table-body');
    var rows = [];
    Object.keys(POLI_INFO).forEach(function(code){
      state.polis[code].tickets.forEach(function(t){
        rows.push({ t:t, poli:p_name(code) });
      });
    });
    rows.sort(function(a,b){ return b.t.createdAt - a.t.createdAt; });
    body.innerHTML = rows.length ? rows.map(function(r){
      return '<tr><td>'+r.t.no+'</td><td>'+r.t.name+'</td><td>'+r.poli+'</td>' +
        '<td><span class="status-pill '+r.t.status+'">'+labelStatus(r.t.status)+'</span></td></tr>';
    }).join('') : '<tr><td colspan="4" style="text-align:center;color:var(--navy-500);">Belum ada data antrian.</td></tr>';
  }
  function labelStatus(s){
    return s==='waiting' ? 'Menunggu' : s==='called' ? 'Dipanggil' : 'Selesai';
  }

  // ===== Inisialisasi halaman =====
  renderHome();
  var startView = (window.location.hash || '#home').replace('#','');
  if(!document.getElementById('view-'+startView)) startView = 'home';
  showView(startView);
</script>
</body>
</html>