                        <table style="width: 100%;">

                            <tr>
                                <th>Sn.</th>
                                <th>Order Number</th>
                                <th>Customer Name</th>
                                <th>Nature of Order</th>
                                <th>Price</th>
                                <th>Due</th>
                                <th>Commision</th>
                                <th>Ordered Date</th>
                                <th>Order Status</th>
                                <th>Invoice Status</th>
                            </tr>


                            <?php 
                            foreach ($order->result() as $key => $row) {
                             $publish = ($row->status == 1 ? '<a href="javascript:void(0);" class="mb-1 mt-1 mr-1 " ><span class="glyphicon glyphicon-ok-sign" data-toggle="tooltip" title="Published"></span></a>' : '<a href="javascript:void(0);" class="mb-1 mt-1 mr-1 " ><span class="glyphicon glyphicon-remove-sign" data-toggle="tooltip" title="Unpublished"></span></a>');
                             $customer = $this->quotemodel->getCustomer($row->customer_id);

                             $status = $this->ordermodel->getstatus($row->order_status);
                             $invoice = $this->ordermodel->getinvoicestatus($row->invoice_status);
                             $install = $this->ordermodel->getOrderInstallers($row->order_id);
                             $notes = $this->ordermodel->getOrderInstallersNotes($row->order_id);
                             $counter = $this->ordermodel->getemailcount($row->order_id);
                             $orderseen = $this->ordermodel->countseen($row->order_id);
                             $note_string = '';
                             foreach ($notes as $key => $note) {
                              $note_string.=$note->notes.'\n';
                              $note_string.= $note->first_name.' '.$note->last_name.' \t \t Added Date:'.date("d/m/Y",$note->added_date).'\n';
                            }
                            ?>
                            <tr class="gradeX">
                                <td><?php echo $key+1; ?></td>
                                <td><?php echo $row->order_number;?>
                                </td>
                                <td><?php echo @$customer->first_name.' '.@$customer->last_name;?> </td>
                                <td><?php echo @$row->product;?></td>
                                <td>
                                    <?php echo number_format($row->price,2);?>
                                </td>
                                <td>
                                    <?php echo number_format($row->due_amount,2);?>
                                </td>

                                <td>
                                    <?php echo number_format($row->commision,2);?>
                                </td>

                                <td><?php echo date("d/m/Y",$row->added_date);?></td>
                                <td>
                                    <?php echo @$status->name;?></br><?php echo @$install->first_name.' '.@$install->last_name;?>
                                    <br> <?php echo @$install->position_type;?>

                                </td>
                                <td>
                                    <?php echo @$invoice->status_name;?>
                                </td>


                            </tr>
                            <?php
                        } ?>



                        </table>