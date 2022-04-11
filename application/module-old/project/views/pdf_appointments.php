<table style="width: 100%;" >
                <tr>
                    <th>Sn.</th>
                  <th>Appointment No.</th>
                  <th>Client Name </th>
                  <th>Mobile</th>
                  <th>Type</th>
                  <th>Appointment date</th>
                  <th>Appointment time</th>
                  <th>Email</th>
                  <th>Country</th>
                  <th>Lead By</th>
                  <th>Counseller</th>
                </tr>
          
                <?php 

                foreach ($appointments->result() as $key => $lead) {
                 $publish = ($lead->status == 1 ? 'Published' : 'Unpublished');
                 ?>
                 <tr class="gradeX">
                  <td><?php echo $key+1;?></td>
                  <td><?php echo $lead->lead_id;?></td>
                  <td><?php echo $lead->lead_name.' '.$lead->lead_lname;?></td>
                  <td><?php echo $lead->phone_number;?></td>
                  <td><?php echo $lead->status_id == 5 ? 'Appointment':'Counceling';?></td>
                  <td><?php echo date("d/m/Y",strtotime($lead->booking_date));?></td>
                  <td><?php echo $lead->booking_time;?></td>
                  <td><?php echo $lead->email;?></td>
                  <td><?php echo $lead->country;?></td>
                  <?php 
                  $handler = $this->appointmentmodel->getusers($lead->handle);
                  ?>
                  <td><?php echo @$handler->user_name;?></td>
                  <?php
                  $handler = $this->appointmentmodel->getusers($lead->consultant);
                  ?>
                  <td><?php echo isset($handler->user_name)?$handler->first_name.' '.$handler->last_name:'';?></td>
                  </tr>
                  <?php
                } ?>
            </table>