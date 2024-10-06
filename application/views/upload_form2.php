<!DOCTYPE html>
<html>
<head>
  <title>Upload File Excel </title>
</head>
<body>
  <?php if (isset($error)) : ?>
    <div class="alert alert-danger">
      <?php echo $error; ?>
    </div>
  <?php endif; ?>

  <?php if (isset($success)) : ?>
    <div class="alert alert-success">
      <?php echo $success; ?>
    </div>
  <?php endif; ?>

  <?php if (isset($excel_data)) : ?>
    <table border="1">
      <?php foreach ($excel_data as $row) : ?>
        <tr>
          <td><?= $row['method'] ?></td>
          <td><?= $row['nama'] ?></td>
          <td><?= $row['nik'] ?></td>
          <td><?= $row['item'] ?></td>
          <td><?= $row['barcode'] ?></td>
          <td><?= $row['qty'] ?></td>
          <td><?= $row['harga'] ?></td>
          <td><?= $row['tgl2'] ?></td>
          <td><?= $row['ket'] ?></td>
        </tr>
      <?php endforeach; ?>
    </table>
  <?php endif; ?>
  <h3>upload data pitang toko januari 2023</h3>      
  <form action="<?php echo site_url('upload/PiutangToko1'); ?>" method="post" enctype="multipart/form-data">
    <input type="file" name="excel_file"><br>
    <input type="submit" value="Upload">
  </form>
</body>
</html>
