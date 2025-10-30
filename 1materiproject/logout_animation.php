<?php
session_start();
session_destroy(); // Hapus sesi pengguna
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Keluar dari Sistem Surat</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      height: 100vh;
      background: linear-gradient(135deg, #0f2027, #203a43, #2c5364);
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      font-family: 'Poppins', sans-serif;
      color: white;
    }

    .logout-container {
      text-align: center;
      position: relative;
      z-index: 2;
    }

    h2 {
      font-weight: 600;
      font-size: 1.8rem;
      margin-bottom: 15px;
    }

    p {
      font-size: 1rem;
      opacity: 0.8;
    }

    .envelope {
      width: 120px;
      height: 80px;
      background: #2196f3;
      position: relative;
      margin: 30px auto;
      border-radius: 5px;
      overflow: hidden;
      animation: float 3s ease-in-out infinite;
    }

    .envelope::before, .envelope::after {
      content: '';
      position: absolute;
      width: 0;
      height: 0;
      border-style: solid;
    }

    .envelope::before {
      top: 0;
      left: 0;
      border-width: 0 60px 40px 60px;
      border-color: transparent transparent #1976d2 transparent;
    }

    .envelope::after {
      bottom: 0;
      left: 0;
      border-width: 40px 60px 0 60px;
      border-color: #1976d2 transparent transparent transparent;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px); }
      50% { transform: translateY(-10px); }
    }

    .paper {
      width: 80px;
      height: 60px;
      background: #fff;
      position: absolute;
      top: 10px;
      left: 20px;
      border-radius: 4px;
      animation: slideUp 2.5s ease-in-out infinite;
    }

    @keyframes slideUp {
      0% { transform: translateY(20px); opacity: 0; }
      40% { transform: translateY(-20px); opacity: 1; }
      80% { transform: translateY(-40px); opacity: 0; }
      100% { transform: translateY(20px); opacity: 0; }
    }

    .fadeout {
      animation: fadeout 1s ease forwards;
    }

    @keyframes fadeout {
      to { opacity: 0; transform: scale(1.1); }
    }
  </style>
</head>
<body>

  <div class="logout-container animate__animated animate__fadeIn">
    <div class="envelope">
      <div class="paper"></div>
    </div>
    <h2>Anda Telah Logout</h2>
    <p>Surat telah dikirim ke sistem. Terima kasih telah menggunakan Sistem Surat Modern.</p>
  </div>

  <script>
    // Setelah animasi selesai, arahkan ke login.php
    setTimeout(() => {
      document.querySelector('.logout-container').classList.add('fadeout');
      setTimeout(() => {
        window.location.href = "login.php";
      }, 1000);
    }, 3000);
  </script>

</body>
</html>
