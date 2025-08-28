<?php
$selectorFile = __DIR__ . "/selector.txt";
$themaDir = __DIR__ . "/thema";

$themes = array_filter(glob($themaDir . "/*"), 'is_dir');
$themes = array_map('basename', $themes);

if (!file_exists($selectorFile)) {
    file_put_contents($selectorFile, $themes[0] ?? "hotspotlogin1");
}
$default = trim(file_get_contents($selectorFile));

if (isset($_GET['choose'])) {
    $choose = $_GET['choose'];
    if (in_array($choose, $themes)) {
        $default = $choose;
        file_put_contents($selectorFile, $default);
    }
    header("Location: loginpage.php?updated=1");
    exit;
}

if (isset($_GET['uamip'])) {
    $query = $_SERVER['QUERY_STRING'] ?? '';
    header("Location: thema/$default/hotspotlogin.php?$query");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Pilih Tampilan Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<style>
  body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      width: 100%;
      font-family: Arial, sans-serif;
      background: #111;
      color: white;
      display: flex;
      flex-direction: column;
      align-items: center;
  }
  .header {
      width: 100%;
      padding: 10px;
      background: #222;
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 8px;
      z-index: 1000;
      box-shadow: 0 2px 5px rgba(0,0,0,0.5);
  }
  .btn {
      display: inline-block;
      padding: 8px 15px;
      font-size: 14px;
      color: white;
      background: #007BFF;
      border-radius: 6px;
      text-decoration: none;
      transition: 0.2s;
  }
  .btn:hover { background: #0056b3; }
  .active { background: #28a745 !important; }

  .phone-frame {
      margin-top: 20px;
      width: 375px;
      height: 667px;
      border: 10px solid #333;
      border-radius: 30px;
      box-shadow: 0 0 25px rgba(0,0,0,0.8);
      overflow: hidden;
      background: #000;
      position: relative;
  }
  iframe {
      width: 100%;
      height: 100%;
      border: 0;
  }

  /* Overlay lock */
  .overlay-lock {
      position: absolute;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.5);
      display: flex;
      justify-content: center;
      align-items: center;
      color: white;
      font-size: 48px;
      cursor: pointer;
      z-index: 10;
      transition: 0.3s;
  }
  .lock-btn {
      margin-top: 10px;
      padding: 6px 14px;
      font-size: 13px;
      background: #dc3545;
      border-radius: 5px;
      color: white;
      border: none;
      cursor: pointer;
  }
  .lock-btn.unlock { background: #28a745; }
</style>
</head>
<body>

<div class="header">
  <?php foreach ($themes as $t): ?>
    <a href="?choose=<?php echo urlencode($t); ?>" 
       class="btn <?php echo ($default==$t?"active":""); ?>">
       <?php echo ucfirst($t); ?>
    </a>
  <?php endforeach; ?>
  <a href="http://10.10.10.1:3990" target="_blank" class="btn" style="background:#6f42c1;">
    🚀 LoginPage
  </a>
</div>

<div class="phone-frame">
  <div class="overlay-lock" id="lockOverlay">🔒</div>
  <iframe id="previewFrame" src="thema/<?php echo urlencode($default); ?>/hotspotlogin.php?res=notyet"
          title="Preview <?php echo htmlspecialchars($default); ?>"></iframe>
</div>

<button class="lock-btn unlock" id="toggleLock">🔓 Unlock</button>

<script>
  const overlay = document.getElementById("lockOverlay");
  const toggleBtn = document.getElementById("toggleLock");
  let locked = true;

  toggleBtn.addEventListener("click", () => {
    locked = !locked;
    if (locked) {
      overlay.style.display = "flex";
      toggleBtn.textContent = "🔓 Unlock";
      toggleBtn.classList.add("unlock");
      toggleBtn.classList.remove("lock");
    } else {
      overlay.style.display = "none";
      toggleBtn.textContent = "🔒 Lock";
      toggleBtn.classList.add("lock");
      toggleBtn.classList.remove("unlock");
    }
  });
</script>

</body>
</html>