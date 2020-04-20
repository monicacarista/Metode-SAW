<?php
$server = "localhost";
$username = "root";
$password = "";
$db_name = "spk";

$conn = mysqli_connect($server, $username, $password, $db_name);

if(!$conn){
    echo "Database tidak terkoneksi";
} else {
   // echo "Database terkoneksi";
}

// cara menentukan bobot
$bobot = array(0.25, 0.25, 0.50);
echo "<h3>Data Bobot </h3>"; 
for($x=0;$x<count($bobot);$x++){
    echo 'index ke ' ,$x, ' = ' ,$bobot[$x],'<br/>'; 
}
?>

<table>
<thead>
    <tr>
        <td>ID</td>
        <td>Alternatif</td>
    </tr>
    <?php
    echo "<h3>Data Alternatif  </h3>"; 
    $sql = mysqli_query($conn, 'SELECT id, alternatif from tb_alternatif');
    while($r = mysqli_fetch_array($sql, MYSQLI_ASSOC)){
        ?>
        <tbody>
        <tr>
            <td><?php echo $r['id']?> </td>
            <td><?php echo $r['alternatif']?></td> 
        </tr>
        </tbody>
        <?php
    }
    ?>
    </thead>
</table>

<!-- Matriks -->
<table>
    <tr>
        <td>ID</td>
        <td>Alternatif</td>
        <td>C1</td>
        <td>C2</td>
        <td>C3</td>
    </tr>
    <?php
    echo "<h3>Data Matriks  </h3>"; 
    $sql1 = mysqli_query($conn, 'SELECT * from tb_alternatif');
    while($r1 = mysqli_fetch_array($sql1, MYSQLI_ASSOC)){
        ?>
        <tr>
            <td><?php echo $r1['id']?> </td>
            <td><?php echo $r1['alternatif']?></td> 
            <td><?php echo $r1['c1']?> </td>
            <td><?php echo $r1['c2']?> </td>
            <td><?php echo $r1['c3']?> </td>
        </tr>
        <?php
    }
    ?>
</table>
 <!-- Normalisasi -->
 <table>
    <tr>
        <td>ID</td>
        <td>Alternatif</td>
        <td>C1</td>
        <td>C2</td>
        <td>C3</td>
    </tr>
    <?php
    echo "<h3>Data normalisasi  </h3>"; 
    $atribut = mysqli_query($conn, 'SELECT min(c1)as min1, max(c2) as max1, max(c3)as max2 FROM tb_alternatif');
    
    $atr = mysqli_fetch_array($atribut);


    $sql2 = mysqli_query($conn, 'SELECT * from tb_alternatif');
    while($r2 = mysqli_fetch_array($sql2, MYSQLI_ASSOC)){
        ?>
        <tr>
            <td><?php echo $r2['id']?> </td>
            <td><?php echo $r2['alternatif']?></td> 
            <td><?php echo ($atr['min1']/$r2['c1'])?> </td>
            <td><?php echo ($r2['c2']/$atr['max1']) ?> </td>
            <td><?php echo ($r2['c3']/$atr['max2'])?> </td>
        </tr>
        <?php
    }
    ?>
</table>

<!-- nilai referensi -->
<table>
    <tr>
        <td>ID</td>
        <td>Alternatif</td>
        <td>Total Poin</td>
    </tr>
    <?php
    echo "<h3>Data referensi  </h3>"; 
    $atribut1 = mysqli_query($conn, 'SELECT min(c1)as min1, max(c2) as max1, max(c3)as max2 FROM tb_alternatif');
    
    $atr1 = mysqli_fetch_array($atribut1);


    $sql3= mysqli_query($conn, 'SELECT * from tb_alternatif');
    while($r3 = mysqli_fetch_array($sql3, MYSQLI_ASSOC)){
        $poin = ((($atr1['min1']/$r3['c1'])*$bobot[0])+(($r3['c2']/$atr1['max1'])*$bobot[1])+(($r3['c3']/$atr1['max2'])*$bobot[2]));
        ?>
        <tr>
            <td><?php echo $r3['id']?> </td>
            <td><?php echo $r3['alternatif']?></td> 
            <td><?php echo $poin;?></td> 
        </tr>
        <?php
    }
    ?>
</table>