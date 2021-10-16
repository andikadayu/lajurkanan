<?php
class ViewShopee
{
    public $con;
    public function __construct($con)
    {
        $this->con = $con;
    }
    public function getRow()
    {
        // $sql = mysqli_query($this->con, "SELECT sc.*,user.name,(SELECT COUNT(*) FROM tb_shopee WHERE tb_shopee.id_scrape = sc.id_scrap) as counts FROM tb_scrap as sc INNER JOIN tb_user as user ON user.id_user = sc.id_user WHERE sc.id_commerce=1 AND sc.id_user='" . $_SESSION['id_user'] . "' ORDER BY sc.tgl_scrap DESC");

        if ($_SESSION['role'] == 'user') {
            $sql = mysqli_query($this->con, "SELECT tb_scrap.id_scrap,count(tb_shopee.id_shopee) as counts,tb_scrap.tgl_scrap,tb_user.`name` FROM tb_shopee INNER JOIN tb_scrap ON tb_scrap.id_scrap = tb_shopee.id_scrape
INNER JOIN tb_user ON tb_user.id_user = tb_scrap.id_user WHERE tb_scrap.id_user = '".$_SESSION['id_user']."' GROUP BY tb_shopee.id_scrape DESC");
        } else {
            $sql = mysqli_query($this->con, "SELECT tb_scrap.id_scrap,count(tb_shopee.id_shopee) as counts,tb_scrap.tgl_scrap,tb_user.`name` FROM tb_shopee INNER JOIN tb_scrap ON tb_scrap.id_scrap = tb_shopee.id_scrape
INNER JOIN tb_user ON tb_user.id_user = tb_scrap.id_user GROUP BY tb_shopee.id_scrape DESC");
        }
        $var = "";
        $no = 1;
        while ($d = mysqli_fetch_assoc($sql)) {
            $var .= "<tr>
                        <td>" . $no . "</td>
                        <td>" . date_format(date_create($d['tgl_scrap']), 'D,d-M-Y H:i:s') . "</td>
                        <td>" . $d['counts'] . "</td>
                        <td>" . $d['name'] . "</td>
                        <td>
                            <button type='button' aria-label='excel' class='btn btn-sm btn-success btn-float rounded-circle' id='btnexc$no' aria-hidden='false' onclick='cetakExcel(" . $d['id_scrap'] . ")' data-bs-toggle='modal' data-bs-target='#modalExport'><i class='fa fa-file-excel'></i></button>
                            <button type='button' aria-label='delete' class='btn btn-sm btn-danger btn-float rounded-circle' id='btndel$no' aria-hidden='false' onclick='deleteScrap(" . $d['id_scrap'] . ")'><i class='fa fa-trash'></i></button>
                        </td>
                    </tr>";
            $no++;
        }
        return $var;
    }
}
