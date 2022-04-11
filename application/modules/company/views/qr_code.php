<table style="width: 100%;">
    <tr>
        <td style="height: 20px;"></td>
    </tr>
    <tr>
        <td style="text-align:center;"><img src="<?php echo "./assets/uploads/users/thumb/$company->thumbnail";?>" style="width: 100px;"></td>
    </tr>
    <tr>
        <td style="height: 70px;"></td>
    </tr>
    <tr>
        <td style="text-align: center;">
            <img src="<?php echo "./uploads/qr_image/".$company->uuid.".png"?>">
        </td>
    </tr>
    <tr>
        <td style="height: 20px;"></td>
    </tr>
    <tr>
        <td style="text-align: center;"><h3>Please Scan Here to Check in </h3></td>
    </tr>
    <tr>
        <td style="height: 70px;"></td>
    </tr>
    <?php
  $row = $this->generalsettingsmodel->getConfigData(24)->row();
  ?>
    <tr>
        <td style="text-align:right;vertical-align: middle; height: 50px;">
            <img src="<?php echo "./uploads/logo/".$row->config_value;?>"  width="150" />
        </td>
    </tr>
    <tr>
        <td style="text-align:right;vertical-align: middle;"><?php echo date("Y")?>Powered By</td>
    </tr>
    <tr>
        <td style="text-align:right;vertical-align: middle;"><?php echo date("Y")?>
            AusNep IT Solutions (https://www.ausnepit.com.au)
        </td>
    </tr>
</table>