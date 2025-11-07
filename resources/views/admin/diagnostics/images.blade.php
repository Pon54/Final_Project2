<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Diagnostics - Vehicle Images</title>
  <style>body{font-family:system-ui,Segoe UI,Roboto,Arial;margin:18px} table{border-collapse:collapse;width:100%} td,th{padding:6px;border:1px solid #ddd} th{background:#f3f4f6;text-align:left}</style>
</head>
<body>
  <h1>Vehicle Image Diagnostics</h1>
  <p>Checking first image field (Vimage1) existence across candidate public paths.</p>
  <p><a href="?export=csv">Export all as CSV</a></p>
  <table>
    <thead><tr><th>ID</th><th>Title</th><th>Vimage1</th><th>Found?</th></tr></thead>
    <tbody>
  @foreach($vehicles as $v)
      <?php
        $file = $v->Vimage1 ?? '';
        $found = false;
        $foundPath = '';
        foreach($candidates as $c) {
            $p = public_path($c . $file);
            if ($file && file_exists($p)) { $found = true; $foundPath = $c . $file; break; }
        }
        $color = $found ? '#065f46' : '#991b1b';
        $label = $found ? ('FOUND: ' . $foundPath) : 'MISSING';
      ?>
      <tr>
        <td>{{ $v->id }}</td>
        <td>{{ $v->VehiclesTitle ?? $v->VehiclesTitle ?? '' }}</td>
        <td>{{ $file }}</td>
  <td style="color:<?php echo $color; ?>"><?php echo htmlspecialchars($label); ?></td>
      </tr>
    @endforeach
    </tbody>
  </table>
  @if(method_exists($vehicles,'links'))
    <div style="margin-top:12px">{{ $vehicles->links() }}</div>
  @endif
</body>
</html>