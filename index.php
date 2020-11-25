<?php
    // Koneksi Database
    $server = "localhost";
    $user = "id15497667_vadillahnurhikmah";
    $pass = "3mOVn&*=NKy5W)t{";
    $database = "id15497667_webdatasiswa";
    $koneksi = mysqli_connect($server, $user, $pass, $database)or die(mysqli_error($koneksi));

    // jika tombol simpan diklik
    if(isset($_POST['bsimpan']))
    {
        //Pengujian apakah data akan diedit atau disimpan baru
        if($_GET['hal'] == "edit")
        {
            //Data Akan Diedit
            $edit = mysqli_query($koneksi, " UPDATE ts set
                                            nis = '$_POST[tnis]', 
                                            nama = '$_POST[tnama]', 
                                            alamat = '$_POST[talamat]', 
                                            jurusan = '$_POST[tjurusan]'
                                        WHERE id = '$_GET[id]' 
                                            ") ;

         if ($edit) //jika edit sukses
         {
            echo"<script>
            alert('Edit Data Suksess!');
            document.location = 'index.php';
            </script>";
         }
         else //jika edit gagal
         {
            echo"<script>
            alert('Edit Data Gagall!');
            document.location = 'index.php';
            </script>";   
         }

         
        }else
        {
            //Data Akan Disimpan Baru
            $simpan = mysqli_query($koneksi, "INSERT INTO ts (nis, nama, alamat, jurusan)
            VALUES ('$_POST[tnis]', 
                   '$_POST[tnama]',
                   '$_POST[talamat]',
                   '$_POST[tjurusan]')
              ") ;

         if ($simpan) //jika simpan sukses
         {
            echo"<script>
                alert('Simpan Data Suksess!');
                document.location = 'index.php';
            </script>";
         }
         else //jika simpan gagal
         {
            echo"<script>
                alert('Simpan Data Gagall!');
                document.location = 'index.php';
            </script>";   
         }

         }
                            

}

//Pengujian jika tombol edit atau hapus diklik 
if(isset($_GET['hal']))
{
    //Pengujian jika edit data
    if($_GET['hal'] == "edit")
    {

    //Tampilkan data yang akan diedit
    $tampil = mysqli_query($koneksi, "SELECT * FROM ts WHERE id= '$_GET[id]' ");
    $data = mysqli_fetch_array($tampil);
    if($data)
       {
            //Jika data ditemukan, maka data ditampung dulu kedalam variable
            $vnis = $data['nis'];
            $vnama = $data['nama'];
            $valamat = $data['alamat'];
            $vjurusan = $data['jurusan'];
       }
    }
    else if ($_GET['hal'] == "hapus")
    {
        //Persiapan Hapus Data
        $hapus = mysqli_query($koneksi, "DELETE  FROM ts WHERE id = '$_GET[id]' ");
        if($hapus){
            echo"<script>
                alert('Hapus Data Suksess!');
                document.location = 'index.php';
            </script>";
        }
    }
 }

?>





<!DOCTYPE html>
<html>
<head>
    <title>CRUD DATA SISWA</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
<div class="container">
<h1 class="text-center">CRUD DATA SISWA </h1>
<h2 class="text-center">@Vadillah Nur Hikmah</h2>

<!--- AWAL CARD FORM--->
<div class="card mt-4">
  <div class="card-header bg-primary text-white">
    Form Input Data Siswa
  </div>
  <div class="card-body">
   <form method="post" action="">
        <div class="form-group">
            <label>NIS</label>
            <input type="text" name="tnis" value="<?=@$vnis?>" class="form-control" placeholder="Inputkan Nis Anda Disini" required>
        </div>
        <div class="form-group">
            <label>NAMA</label>
            <input type="text" name="tnama" value="<?=@$vnama?>" class="form-control" placeholder="Inputkan Nama Anda Disini" required>
        </div>
        <div class="form-group">
            <label>ALAMAT</label>
            <textarea class="form-control" name="talamat" placeholder="Inputkan Alamat Anda Disini"><?=@$valamat?></textarea>
        </div>
        <div class="form-group">
            <label>JURUSAN</label>
            <select class="form-control" name="tjurusan">
                <option value="<?=@$vjurusan?>"><?=@$vjurusan?></option>
                <option value="Rekayasa Perangkat Lunak (Rpl)">Rekayasa Perangkat Lunak (Rpl)</option>
                <option value="Teknik Jaringan Akses (Tja)">Teknik Jaringan Akses (Tja)</option>
                <option value="Teknik Komputer dan Jaringan (Tkj)">Teknik Komputer dan Jaringan (Tkj)</option>
                <option value="Akuntansi dan Keuangan Lembaga">Akuntansi dan Keuangan Lembaga</option>
                <option value="IPA">IPA</option>
                <option value="IPS">IPS</option>
                <option value="Tata Boga">Tata Boga</Opatin>

            </select>
        </div>

        <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
        <button type="reset" class="btn btn-danger" name="breset">Kosongkan</button>
   </form>
  </div>
</div>
<!--- AKHIR CARD FORM--->

<!--- AWAL CARD TABLE--->
<div class="card mt-4">
  <div class="card-header bg-success text-white">
    Daftar Siswa
  </div>
  <div class="card-body">
    <table class="table table-bordered table-striped">
        <tr>
            <th>NO.</th>
            <th>NIS</th>
            <th>NAMA</th>
            <th>ALAMAT</th>
            <th>JURUSAN</th>
            <th>ACTION</th>
        </tr>
        <?php
            $no = 1;
            $tampil = mysqli_query($koneksi, "SELECT * from ts order by id desc ");
            while($data = mysqli_fetch_array($tampil)) :
        
        ?>
        <tr>
            <td><?=$no++;?></td>
            <td><?=$data['nis']?></td>
            <td><?=$data['nama']?></td>
            <td><?=$data['alamat']?></td>
            <td><?=$data['jurusan']?></td>
            <td>
                <a href="index.php?hal=edit&id=<?=$data['id']?>" class="btn btn-warning"> Edit </a>
                <a href="index.php?hal=hapus&id=<?=$data['id']?>" onclick="return confirm('Apakah Yakin Ingin Menghapus Data Ini?')" class="btn btn-danger"> Hapus </a>


            </td>
            

        </tr>
            <?php endwhile;?> <!---penutup perulangan while--->
    
    </table>

   
  </div>
</div>
<!--- AKHIR CARD TABLE--->
</div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>