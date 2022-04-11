<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <base href="http://www.deal2deal.com.au/" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>ClassiDeal</title>
        <style>
             table > tbody > tr > td{
                border:none; vertical-align: middle; text-align: left;

            }
        </style>
    </head>


<body>
<table width="636px" border="0" cellpadding="0" cellspacing="10" bgcolor="#00cc67" style="border-radius:10px;border:solid 2px #00cc67;font-family:Arial, Helvetica, sans-serif;">
	<tr>
    	<td  style="margin-bottom: 10px;">
        	<table width="100%" cellpadding="10" cellspacing="0" border="0" style="background-color: #fff;" >
            	<tr>
                	<td style="border:none; vertical-align: middle; text-align: left;">
                    	<a href="<?php echo base_url()?>"><img src="<?php echo base_url();?>assets/uploads/logo/<?php echo $logo;?>" width="256" height="56" alt="ClassiDeal" /></a>
                    </td>
                    <td style="font-family:Arial, Helvetica, sans-serif;border:none; vertical-align: middle; text-align: left; "><h3  style="font-family:Arial, Helvetica, sans-serif;border:none; vertical-align: middle; text-align: left; font-size:18px; margin-top:32px;  font-weight: 700; color: #000000;">A Special Deal For You</h3></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
    	<td bgcolor="#ffffff">
        	<table width="100%" cellpadding="0" cellspacing="10" border="0" style="font-size:12px;color:#00cc67;line-height:18px;text-align:justify;">
            	<tr>
                	<td colspan="2" style="color:#00aff0"><a href="<?php echo $this->config->item('base_url_front')."dailydeals/".$news->city."/".$news->id;?>" target="_blank" style="text-decoration:none;color:#000000;font-style:italic;"><h1 style="font-size: 24px; font-style: italic;font-weight: 700;border:none; vertical-align: middle; text-align: left;color: #000000; padding-top: 15px; padding-bottom: 15px;"><?php echo $news->dealstitle;?></h1></a></td>
                </tr>
                <tr>
                	<td width="230px" valign="top">
                    	<table width="100%" cellpadding="0" cellspacing="0" border="0" style="font-family:Impact;border:solid 2px #00cc67;border-radius:5px;padding-bottom:10px;">
                        	<tr>
                            	<td valign="middle" colspan="3" style="background:#00cc67;color:#fff;font-size:34px;height:80px;padding:0 10px;height:80px;"><span style="float:left;line-height:48px;">$<?php  $discount=$news->price-($news->price*$news->discount/100); echo round($discount);?></span> <a href="<?php echo $this->config->item('base_url_front')."dailydeals/".$news->city."/".$news->id;?>" target="_blank"><img src="<?php echo base_url();?>assets/images/view_deal.png" width="120" height="48" style="float:right" /></a></td>
                            </tr>
                            <tr style="text-align:center;">
                            	<td>worth</td>
                                <td>discount</td>
                                <td>savings</td>
                            </tr>
                            <tr style="font-size:24px;text-align:center;">
                            	<td>$<?php echo round($news->price);?></td>
                                <td><?php echo round($news->discount);?>%</td>
                                <td>$<?php $dif=$news->price-$news->discount; echo round($dif);?></td>
                            </tr>
                        </table>
                    </td>
                    <td rowspan="3" style="vertical-align:top;"><img src="<?php echo base_url();?>assets/uploads/deals/<?php echo $image->image_name;?>" width="350" height="212" alt="" /></td>
                </tr>
                <tr>
                  <td valign="top" style="color:black;line-height: 1.5"><b><?php echo $news->subtitle;?></b> </td>
                </tr>
                <tr>
                  <td valign="top" style="color:black;"><b>Location:</b>
                    <?php echo $news->city; ?></td>
                </tr>
                <tr>
                	<td></td>
                    <td style="color:black;">
                    	<?php echo $news->description; ?>
                                         
                        <p><a href="<?php echo base_url()."dailydeals/".$news->city."/".$news->id;?>" target="_blank" style="text-decoration:none;color:#000;font-style:italic;">Read More</a>
                    </td>
                </tr>       
            </table>
        </td>
    </tr>
    <tr>
    	<td bgcolor="#ffffff" align="center" style="font-size:12px;height:40px;color: black; background-color: #fff;text-align: center;">Need help? Have feedback? Feel free to <a href="<?php echo base_url()."dailydeals/help";?>" target="_blank" style="text-decoration:none;color:#0e5eb1;font-weight:bold;">contact us</a>.</td>
    </tr>
   
</table>
</body>
</html>
