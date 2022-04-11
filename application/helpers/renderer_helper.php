<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/** Get Record from Database * */
function pds_get_form_data($id) {
    $CI = & get_instance();
    $CI->db->where("forms_id", $id);
    $query = $CI->db->get('pnp_form');
    return $query->row();
}

function getpostdata($id,$module) {
    $CI = & get_instance();
    if($module == "Project"){
        $CI->db->where("task_id", $id);
        $query = $CI->db->get('pnp_lms_project');
    }elseif($module == "Order"){
       $CI->db->where("project_id", $id);
       $query = $CI->db->get('pnp_projects');
   }else{
    $CI->db->where("lead_id", $id);
    $query = $CI->db->get('pnp_leads');
}
return $query->row();
}




/* * ******** List all states *************** */

function listState($state = '') {
    $CI = & get_instance();
    $states = '';
    $query = $CI->db->get('states');
    if ($query->num_rows() > 0) {
        foreach ($query->result() as $row):
           $select = ($state!='' && $state==$row->state_id)?' selected="selected"':'';
       $states .= '<option value="' . $row->state_id . '"'.$select.'>' . $row->state_name . '</option>';
       endforeach;
   }
   return $states;
}
function listRegion($state,$region = '') {
    $CI = & get_instance();
    $regions = '';
    $CI->db->where('state_id',$state);
    $query = $CI->db->get('regions');
    if ($query->num_rows() > 0) {
        foreach ($query->result() as $row):
           $select = ($region!='' && $region==$row->region_id)?' selected="selected"':'';
       $regions .= '<option value="' . $row->region_id . '"'.$select.'>' . $row->region_name . '</option>';
       endforeach;
   }
   return $regions;
}

/** Render Dynamic Form * */
function pds_form_render($id,$postid="") {
    $CI = & get_instance();
    if ($id) {
        $record = pds_get_form_data($id);
        if ($record && $record->forms_status == 1) {
            $func = 'pdsform_render_custom_' . $id;
            if (!function_exists($func))
                $func = 'pdsform_render_custom';
            if (function_exists($func)) {
                $func(pds_object_to_array($record));
                return;
            }

            $captcha = '';
            $template = unserialize($record->forms_template);
            $errorFields = array();
            if (!empty($_POST) && isset($_POST['customform-submitted'])) {
                $valid = true;
                $errorMsgs = array();
                $fields = pds_parse_form_fields($template);
                $formdata = array();
                $activeFieldValid = false;
                foreach ($fields as $name => $data) {
                    $activeFieldValid = false;
                    if (!$data['required'] && $data['value'] == '')
                        $activeFieldValid = true;
                    else {
                        $activeFieldValid = pds_apply_validation($data['value'], $data['validate']);
                        if ($activeFieldValid['valid'] === false) {
                            if ($data['type'] == 'checkbox' || $data['type'] == 'multiplechoice' || $data['type'] == 'dropdown' || $data['type'] == 'file') {
                                $data_sing = 'select a ';
                            } else if ($data['type'] == 'file')
                            $data_sing = 'select a valid ';
                            else
                                $data_sing = 'enter a valid ';
                            array_push($errorMsgs, '<strong>' . $data['label'] . ':</strong> Please ' . $data_sing . $activeFieldValid['data']);
                            $activeFieldValid = false;
                        } else {
                            $data['value'] = $activeFieldValid['value'];
                            $activeFieldValid = true;
                        }
                    }
                    if ($data['type'] == 'file' && $data['value'] != '') {
                        $uploadResult = pds_upload_file($data['file'], ABSPATH . 'wp-content/uploads/formfiles/', $data['maxsize'], $data['filter'], $data['exts']);
                        if ($uploadResult['error'] !== false) {
                            if ($uploadResult['error'] == 'ext') {
                                if ($data['filter'] == 'only_allow')
                                    array_push($errorMsgs, 'File Type Not allowed');
                                else if ($data['filter'] == 'only_block')
                                    array_push($errorMsgs, 'File Type Not allowed');
                            } else {
                                array_push($errorMsgs, 'File Size is very big');
                            }
                            $activeFieldValid = false;
                        } else {
                            $data['value'] = UPLOADS_DIR . $uploadResult['filename'];
                            $activeFieldValid = true;
                        }
                    }
                    if ($activeFieldValid) {
                        $formdata[$name] = array(
                            'label' => $data['label'],
                            'value' => $data['value']
                            );
                    } else {
                        array_push($errorFields, $name);
                    }
                }
                if ($captcha != '') {
                    $validCaptcha = false;
                    if ($captcha == 'm' || $captcha == 'i') {
                        $cval = $_POST['form_captcha'];
                        $cindex = $captcha . '_c_out';
                        if ($cval == $_SESSION[$cindex])
                            $validCaptcha = true;
                        else
                            $validCaptcha = false;
                    } else {
                        $resp = recaptcha_check_answer(RECAPTCHA_PRIVATE_KEY, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
                        $validCaptcha = $resp->is_valid;
                    }
                    if (!$validCaptcha) {
                        array_push($errorMsgs, '<strong>Captcha: Invalid Captcha Input');
                        array_push($errorFields, 'form_captcha');
                    }
                }
                if (sizeof($errorMsgs) > 0)
                    $valid = false;
                if ($valid) {
                    $saved = false;
                    $dataToDB = array();
                    $dataToDB['forms_id'] = $id;
                    $dataToDB['data_data'] = serialize($formdata);
                    $dataToDB['data_ip'] = pds_get_ip();
                    $dataToDB['data_added'] = date("Y-m-d H:i:s");
//$saved = addFormEntryToDatabase($dataToDB);
                    if ($saved)
                        pds_message_output('Successfully Submitted', 'Form Submitted Successfully', 'info');
                    else
                        pds_message_output('Subsmission Error', 'Unable to Submit Form at this moment', 'warning');
                    return;
                } else {
                    $errorMsg = '<ul id="pds-form-' . $id . '-errors" class="pds-form-errors"><li>';
                    $errorMsg .= implode('</li><li>', $errorMsgs);
                    $errorMsg .= '</li></ul>';
                    pds_message_output('Please fix the following errors', $errorMsg, 'error');
                }
            }
            if($postid!=""){
                $data_field = getpostdata($postid, $record->module_name);
                $fielddata = unserialize($data_field->form_post);
                
            }



            ?>

            
            <div id="pds-form-header-<?php echo $id; ?>" class="pds-form-header">
                <h2 class="form-header-title"><?php echo $template['title']; ?></h2>
                <p class="form-header-desc"><?php echo $template['desc']; ?></p>
            </div>
            <div id="pds-form-body-<?php echo $id; ?>" class="pds-form-body">

                <?php
                foreach ($template['fields'] as $field) {
                   $func = 'pds_form_create_field_' . $field['attrs']['type'];
                   if (isset($fielddata)) {
                    foreach ($fielddata as $k => $v) {
                        if ($k == $field['attrs']['name'])
                            $value = $v;
                    }
                }else {
                    if ($field['attrs']['type'] == "checkbox" || $field['attrs']['type'] == "multiplechoice")
                        $value = array();
                    else
                        $value = null;
                }


                $childs = (isset($field['childs']) ? $field['childs'] : array());
                if (isset($field['attrs']['active']) && $field['attrs']['active'] == '1') {
                    if (function_exists($func))
                        $func($field['attrs'], $childs, $errorFields, $value);
                }
            }
            ?>
            <?php //if ($captcha != '') pds_form_create_field_captcha($captcha, $errorFields);    ?>

            <input type="hidden" name="form_id" value="<?php echo $id; ?>" />
            <div class="clear"></div>
        </div>
        <div id="pds-form-footer-<?php echo $id; ?>" class="pds-form-footer">
            <p class="form-footer-desc"><?php echo $template['footer_desc']; ?></p>
        </div>
        <input type="hidden" name="customform-submitted" value="1" />


        <?php
    }
}
}

function pds_apply_validation($value, $validate) {
    $data = '';
    $preg = '';
    $valid = false;
    switch (strtolower($validate)) {
        case 'email':
        $valid = pds_valid_email($value);
        $data = 'email address';
        break;
        case 'number':
        $valid = pds_valid_number($value);
        $data = 'number';
        break;
        case 'date':
        $valid = pds_valid_date_format($value);
        $data = 'date';
        break;
        case 'time':
        $valid = pds_valid_time_format($value);
        $data = 'time';
        break;
        case 'phone':
        $valid = pds_valid_phonenumber($value);
        $data = 'phone number';
        break;
        case 'website':
        $valid = pds_valid_url($value);
        $data = 'url';
        break;
        default:
        if ($value != '')
            $valid = true;
        $data = 'value';
    }
    if ($preg != '')
        $valid = preg_match($preg, $value);
//$valid = (bool) $valid;
//if(!$valid && $data!='')	return $data;
    return array('valid' => (bool) $valid, 'data' => $data, 'value' => $value);
}

function pds_message_output($title, $message, $type = 'warning') {
    ?>
    <div class="notif-message notif-<?php echo $type; ?>">
        <h2><?php echo $title; ?></h2>
        <div><?php echo $message; ?></div>
    </div>
    <?php
}

function pds_get_field_value($field, $default = '') {
    if (isset($_REQUEST[$field]))
        return $_REQUEST[$field];
    return $default;
}

function pds_parse_form_fields($template) {
//print_r($template);
    $fields = array();
    foreach ($template['fields'] as $field) {
        $fielddata = array(
            'label' => $field['attrs']['label'],
            'type' => $field['attrs']['type'],
            'required' => (($field['attrs']['required'] && $field['attrs']['required'] == '1') ? true : false),
            'validate' => ((isset($field['attrs']['as']) && $field['attrs']['as'] != '') ? $field['attrs']['as'] : false),
            'value' => ''
            );
        if (isset($field['attrs']['as']) && $field['attrs']['as'] != '')
            $fielddata['type'] = $field['attrs']['as'];
        if ($field['attrs']['type'] == 'file') {
            $fielddata['file'] = (isset($_FILES[$field['attrs']['name']]) ? $_FILES[$field['attrs']['name']] : array());
            if (isset($fielddata['file']) && isset($fielddata['file']['name']))
                $fielddata['value'] = $fielddata['file']['name'];
            $fielddata['maxsize'] = $field['attrs']['maxsize'];
            $fielddata['filter'] = $field['attrs']['filter'];
            $fielddata['exts'] = $field['attrs']['exts'];
        } else {
            if (isset($_REQUEST[$field['attrs']['name']])) {
                if (is_array($_REQUEST[$field['attrs']['name']]))
                    $fielddata['value'] = implode('|', $_REQUEST[$field['attrs']['name']]);
                else
                    $fielddata['value'] = $_REQUEST[$field['attrs']['name']];
            }
        }
        $fields[$field['attrs']['name']] = $fielddata;
    }
    return $fields;
}

function pds_field_output_class($field, $errorFields = array()) {
    if (in_array($field, $errorFields))
        return 'error-row';
    return '';
}

function pds_form_create_field_captcha($captcha, $errorFields = array()) {
    if ($captcha == 'm' || $captcha == 'i') {
        ?>
        <div class="pds-form-row  <?php echo pds_field_output_class('form_captcha', $errorFields); ?>">
            <label class="description" for="form-captcha">Please type <?php echo (($captcha == 'm') ? 'output of the expression' : 'extract words to the box below'); ?> *</label>
            <div class="pds-field-input"> <br/>
                <img src="<?php echo BASE_URL . 'libs/' . $captcha; ?>_captcha.php" alt="Click to reload image" title="Click to reload image" id="captcha" onclick="this.src = this.src" style="cursor:pointer;" /> <br/>
                <input name="form_captcha" id="form-captcha" class="text type-captcha small" type="text" required/>
            </div>
            <div class="clear"></div>
        </div>
        <?php
    } else {
        ?>
        <div class="pds-form-row">
            <label class="description" for="recaptcha_response_field">Please type <?php echo (($captcha == 'm') ? 'output of the expression' : 'extract words to the box below'); ?> *</label>
            <div class="pds-field-input"> <br/>
                <?php echo recaptcha_get_html(RECAPTCHA_PUBLIC_KEY); ?> </div>
                <div class="clear"></div>
            </div>
            <?php
        }
    }

    function pds_form_create_field_text($attrs, $childs = null, $errorFields = array(), $value = null) {
        ?>

        <div class="form-group <?php echo pds_field_output_class($attrs['name'], $errorFields); ?>">
          <label class="col-md-3 control-label"><?php echo $attrs['label']; ?><?php echo (($attrs['required'] && $attrs['required'] == '1') ? ' *' : ''); ?></label>
          <div class="col-md-6">

              <input id="<?php echo $attrs['name']; ?>" name="<?php echo $attrs['name']; ?>" class="form-control type-<?php echo $attrs['as']; ?> <?php echo $attrs['size'] . ' ' . $attrs['class']; ?>" value="<?php echo $value; ?>" type="<?php echo $attrs['as']; ?>" <?php echo $attrs['placeholder'] != '' ? 'placeholder="' . $attrs['placeholder'] . '"' : ''; ?> <?php echo $attrs['attrs'] != '' ? $attrs['attrs'] . '"' : ''; ?> <?php echo (($attrs['required'] && $attrs['required'] == '1') ? 'required' : ''); ?>/>
              <?php if ($attrs['desc'] != '') { ?>
              <p class="pds-field-desc"><?php echo $attrs['desc']; ?></p>
              <?php } ?>
          </div>
      </div>

      <?php
  }

  function pds_form_create_field_file($attrs, $childs = null, $errorFields = array(), $value = null) {
    ?>

    <div class="form-group <?php echo pds_field_output_class($attrs['name'], $errorFields); ?>">
      <label class="col-md-3 control-label" for="inputDefault"><?php echo $attrs['label']; ?><?php echo (($attrs['required'] && $attrs['required'] == '1') ? ' *' : ''); ?></label>
      <div class="col-md-6">
          <input id="<?php echo $attrs['name']; ?>" name="<?php echo $attrs['name']; ?>" class="form-control <?php echo $attrs['class']; ?>" type="file" <?php echo $attrs['attrs'] != '' ? $attrs['attrs'] . '"' : ''; ?> <?php echo (($attrs['required'] && $attrs['required'] == '1') ? 'required' : ''); ?>/>
          <?php if ($attrs['desc'] != '') { ?>
          <p class="pds-field-desc"><?php echo $attrs['desc']; ?></p>
          <?php } ?>
      </div>
  </div>

  <?php
}

function pds_form_create_field_textarea($attrs, $childs = null, $errorFields = array(), $value = null) {
    ?>

    <div class="form-group <?php echo pds_field_output_class($attrs['name'], $errorFields); ?>">
      <label class="col-md-3 control-label"><?php echo $attrs['label']; ?><?php echo (($attrs['required'] && $attrs['required'] == '1') ? ' *' : ''); ?></label>
      <div class="col-md-6">

          <textarea id="<?php echo $attrs['name']; ?>" name="<?php echo $attrs['name']; ?>" class="textarea <?php echo $attrs['class']; ?> form-control" rows="<?php echo $attrs['rows']; ?>" cols="<?php echo $attrs['cols']; ?>" <?php echo $attrs['attrs'] != '' ? $attrs['attrs'] . '"' : ''; ?> <?php echo (($attrs['required'] && $attrs['required'] == '1') ? 'required' : ''); ?>><?php echo $value; ?></textarea>
          <?php if ($attrs['desc'] != '') { ?>
          <p class="pds-field-desc"><?php echo $attrs['desc']; ?></p>
          <?php } ?>
      </div>
  </div>
  <?php
}

function pds_form_create_field_dropdown($attrs, $childs = null, $errorFields = array(), $value = array()) {
//echo $value;
//echo $attrs['name']
//$value = pds_get_field_value($attrs['name'], '');
    ?>

    <div class="form-group <?php echo pds_field_output_class($attrs['name'], $errorFields); ?>" >
        <label class="col-md-3 control-label" for="inputDefault"><?php echo $attrs['label']; ?><?php echo (($attrs['required'] && $attrs['required'] == '1') ? ' *' : ''); ?></label>
        <div class="col-md-6">
            <select id="<?php echo $attrs['name']; ?>" name="<?php echo $attrs['name']; ?>" class="form-control <?php echo $attrs['size'] . ' ' . $attrs['class']; ?>" <?php echo $attrs['attrs'] != '' ? $attrs['attrs'] . '"' : ''; ?> <?php echo (($attrs['required'] && $attrs['required'] == '1') ? 'required' : ''); ?>>
                <?php echo $attrs['value']; ?>
                <?php
                $count = 1;
                foreach ($childs as $choice) {
                    ?>
                    <option value="<?php echo $choice['value']; ?>" <?php echo (($choice['value'] == $value) ? 'selected' : ''); ?>><?php echo $choice["label"]; ?></option>
                    <?php
                    $count++;
                }
                ?>
            </select>
            <?php if ($attrs['desc'] != '') { ?>
            <p class="pds-field-desc"><?php echo $attrs['desc']; ?></p>
            <?php } ?>
        </div>
        <div class="col-md-3" id="div_customer"></div>
    </div>
    <?php
}

function pds_form_create_field_checkbox($attrs, $childs = null, $errorFields = array(), $value = array()) {
    $values = pds_get_field_value($attrs['name'], array());
    if (!is_array($value)) {
        $value = array();
    }
    ?>

    <div class="form-group <?php echo pds_field_output_class($attrs['name'], $errorFields); ?>">
        <label class="col-md-3 control-label" for="inputDefault"><?php echo $attrs['label']; ?><?php echo (($attrs['required'] && $attrs['required'] == '1') ? ' *' : ''); ?></label>
        <div class="col-md-9">

            <div style="float:left;margin-right:20px;width:200px;">
              <?php
              $count = 1;
              foreach ($childs as $choice) {
                ?>
                <label for="<?php echo $attrs['name'] . '_' . $count; ?>">
                    <input type="checkbox" id="<?php echo $attrs['name'] . '_' . $count; ?>" name="<?php echo $attrs['name']; ?>[]" class=" <?php echo $attrs['class']; ?>" value="<?php echo $choice['value']; ?>" <?php echo $attrs['attrs'] != '' ? $attrs['attrs'] . '"' : ''; ?> <?php echo (in_array($choice['value'], $value) ? 'checked' : ''); ?>/>
                    <?php echo $choice['label']; ?> </label>
                    <?php echo (($count < sizeof($childs)) ? '<br/>' : ''); ?>
                    <?php
                    $count++;
                }
                ?>
            </div>
            <?php if ($attrs['desc'] != '') { ?>
            <p class="pds-field-desc"><?php echo $attrs['desc']; ?></p>
            <?php } ?>
        </div>

    </div>

    <?php
}

function pds_form_create_field_multiplechoice($attrs, $childs = null, $errorFields = array(), $value = array()) {
// $value = pds_get_field_value($attrs['name'], '');
    ?>
    <div class="form-group <?php echo pds_field_output_class($attrs['name'], $errorFields); ?>">
        <label class="col-md-3 control-label" for="inputDefault"><?php echo $attrs['label']; ?><?php echo (($attrs['required'] && $attrs['required'] == '1') ? ' *' : ''); ?></label>
        <div class="col-md-6">
            <?php
            $count = 1;
            foreach ($childs as $choice) {
                ?>

                <input type="radio" id="<?php echo $attrs['name'] . '_' . $count; ?>" name="<?php echo $attrs['name']; ?>" class="<?php echo $attrs['class']; ?>" value="<?php echo $choice['value']; ?>" <?php echo $attrs['attrs'] != '' ? $attrs['attrs'] . '"' : ''; ?> <?php echo (($choice['value'] == $value) ? 'checked' : ''); ?>/>
                <?php echo trim($choice['label']); ?> 
                <?php echo (($count < sizeof($childs)) ? '<br/>' : ''); ?>
                <?php
                $count++;
            }
            ?>
            <?php if ($attrs['desc'] != '') { ?>
            <p class="pds-field-desc"><?php echo $attrs['desc']; ?></p>
            <?php } ?>
        </div>
    </div>

    <?php
}
?>
