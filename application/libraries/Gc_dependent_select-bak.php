<?php

/*
 * Dynamic Dependent Select Box using Jquery and Ajax
 * Created by Victor Golovko for the fans of Grocerycrud library.
 * SITE: http://svc.by
 * SKYPE: ipgolovko
 * E-MAIL: siptik@mail.ru
 * v.1.2.0
 */

class Gc_dependent_select
{

    const version = '1.5.0';

    protected $ci;
    protected $grocery_crud_obj;
    protected $fields;
    protected $state;
    protected $config;
    protected $segment_name = 'get_items';
    protected $id;
    protected $field_name;
    protected $data;
    protected $segments;

    function __construct($crud_obj = null, $fields = null, $config = null)
    {

        if (func_num_args() !== 3) {
            return false;
        }

        $this->ci = &get_instance();
        $this->grocery_crud_obj = $crud_obj;
        $this->fields = $fields;
        $this->config = $config;

        $this->set_segment_name();
        $this->set_callbacks();

        $this->segments = $this->ci->uri->segment_array();

        $this->get_items();

        if (in_array("edit", $this->segments)) {

            if (!empty($this->segments[(array_search("edit", $this->segments) + 1)])) {
                $this->id = $this->segments[(array_search("edit", $this->segments) + 1)];

                $this->data = $this->ci->db->get_where($this->config['main_table'], array($this->config['main_table_primary'] => $this->id))->row_array();
            }
        }
    }


    protected function get_items()
    {

        if (in_array($this->segment_name, $this->segments)) {

            if (count($this->segments) >= (array_search($this->segment_name, $this->segments) + 2)) {

                $this->field_name = $this->get_field_name();

                $this->id = $this->get_id_value();

                if (empty($this->id) || empty($this->field_name)) {
                    throw new Exception('Your data is damaged');
                }

                $this->get_json();
                exit;

            }

            $array = array();
            echo json_encode($array);
            exit;

        }
    }

    protected function get_field_name()
    {
        return $this->segments[(array_search($this->segment_name, $this->segments) + 1)];
    }

    protected function get_id_value()
    {
        return $this->segments[(array_search($this->segment_name, $this->segments) + 2)];
    }

    protected function set_segment_name()
    {
        if (!empty($this->config['segment_name'])) {
            $this->segment_name = $this->config['segment_name'];
        }

        if ($this->segment_name == '') {
            throw new Exception('segment name can\'t be empty');
        }
    }

    protected function set_callbacks()
    {
        if (!empty($this->fields)) {
            foreach ($this->fields as $k => $v) {
                if (!empty($v['relate'])) {
                    $this->grocery_crud_obj->callback_edit_field($k, array($this, 'callback_edit'));
                    $this->grocery_crud_obj->callback_add_field($k, array($this, 'callback_add'));
                }
            }
        }
    }

    function callback_edit($value, $primary_key, $field_info)
    {
        $i = 0;
        $f_array = array();
        $parent = array();
        foreach ($this->fields as $k => $v) {
            $v['field'] = $k;
            $f_array[] = $v;
            if ($field_info->name == $k) {
                $parent = $f_array[($i - 1)];
                break;
            }
            $i++;
        }
        $where = array(
            $this->fields[$field_info->name]['relate'] => $this->data[$parent['field']]
        );

        $this->ci->db->select("*")->from($field_info->extras[1])->where($where);

        if (!empty($this->fields[$field_info->name]['where'])) {
            $this->ci->db->where($this->fields[$field_info->name]['where'], null, FALSE);
        }

        if (!empty($this->fields[$field_info->name]['order_by'])) {
            $this->ci->db->order_by($this->fields[$field_info->name]['order_by']);
        }


        $result = $this->ci->db->get()->result_array();

        $html = $this->get_select_html($result, $value, $field_info);
        return $html;
    }

    function get_select_html($result, $value, $field_info)
    {
        $html = '<select name="'. $field_info->name . '" class="chosen-select" data-placeholder="' . $this->fields[$field_info->name]['data-placeholder'] . '" style="width: 300px;">';
        if (!empty($result)) {

            $substr_count = substr_count($this->fields[$field_info->name]['title'], "{");

            if ($substr_count > 0) {
                preg_match_all('/{(.+?)}/', $this->fields[$field_info->name]['title'], $fields_array);
            }

            foreach ($result as $item) {

                if (!empty($fields_array[1])) {
                    foreach ($fields_array[1] as $w) {
                        $replace[] = $item[$w];
                    }
                }

                $html .= '<option value="' . $item[$this->fields[$field_info->name]['id_field']] . '"';
                if ($item[$this->fields[$field_info->name]['id_field']] == $value) {
                    $html .= 'selected="selected"';
                }
                $html .= '>';

                if ($substr_count > 0) {
                    $html .= str_replace($fields_array[0], $replace, $this->fields[$field_info->name]['title']);
                } else {
                    $html .= $item[$this->fields[$field_info->name]['title']];
                }

                $html .= '</option>';
                $replace = NULL;
            }
        }

        $html .= '</select>';

        return $html;
    }


    function callback_add($value, $primary_key, $field_info)
    {
        $html = '<select name="' . $field_info->name . '" class="chosen-select" data-placeholder="' . $this->fields[$field_info->name]['data-placeholder'] . '" disabled="disabled" style="width: 300px;">';
        $html .= '</select>';
        return $html;
    }

    function get_js()
    {
        $js = '<script type="text/javascript">';
        $js .= '$(document).ready(function() {';

        $count = count($this->fields);
        $i = 0;
        foreach ($this->fields as $k => $v) {
            $js .= 'var ' . $k . ' = $(\'select[name="' . $k . '"]\');';
            if (!empty($this->config['ajax_loader'])) {
                if ($i != $count - 1) {
                    $js .= '$(\'#' . $k . '_input_box\').append(\'<img src="' . $this->config['ajax_loader'] . '" border="0" id="' . $k . '_ajax_loader" class="dd_ajax_loader" style="display: none;">\');';
                }
            }
            if ($i > 0 && $this->grocery_crud_obj->getState() == 'add') {
                $js .= $k . '.children().remove().end();';
            }
            $i++;
        };

        foreach ($this->fields as $a => $b) {
            $field_data = $b;
            $field_data['field'] = $a;
            $dd_dropdowns[] = $field_data;
        }

        for ($i = 1; $i <= sizeof($dd_dropdowns) - 1; $i++) {

            $js .= $dd_dropdowns[$i - 1]['field'] . '.change(function() {';
            $js .= 'var select_value = this.value;';
            if (!empty($this->config['ajax_loader'])) {
                $js .= '$(\'#' . $dd_dropdowns[$i - 1]['field'] . '_ajax_loader\').show();';
            }
            $js .= $dd_dropdowns[$i]['field'] . '.find(\'option\').remove();';

            $js .= 'var myOptions = "";';
            $js .= '$.getJSON(\'' . $this->config['url'] . $this->segment_name . '/' . $dd_dropdowns[$i]['field'] . '/' . '\'+select_value, function(data) {';
            $js .= 'if(data==\'\'){';

            $js .= $dd_dropdowns[$i]['field'] . '.children().remove().end();';
            $js .= $dd_dropdowns[$i]['field'] . '.attr(\'disabled\', true);';
            $js .= $dd_dropdowns[$i]['field'] . '.find(\'option\').remove();';
            $js .= $dd_dropdowns[$i]['field'] . '.append(\'<option value=""></option>\');';
            $js .= $dd_dropdowns[$i]['field'] . '.trigger("chosen:updated");';
            $js .= '}else{';

            $js .= $dd_dropdowns[$i]['field'] . '.append(\'<option value=""></option>\');';
            $js .= '$.each(data, function(key, val) {';
            $js .= $dd_dropdowns[$i]['field'] . '.append(';
            $js .= '$(\'<option></option>\').val(val.value).html(val.property)';
            $js .= ');';
            $js .= '});';
            $js .= $dd_dropdowns[$i]['field'] . '.removeAttr(\'disabled\');';
            $js .= $dd_dropdowns[$i]['field'] . '.trigger("chosen:updated");';
            $js .= '}';

            for ($x = $i + 1; $x <= sizeof($dd_dropdowns) - 1; $x++) {
                $js .= $dd_dropdowns[$x]['field'] . '.children().remove().end();';
                $js .= $dd_dropdowns[$x]['field'] . '.attr(\'disabled\', true);';
                $js .= $dd_dropdowns[$x]['field'] . '.find(\'option\').remove();';
                $js .= $dd_dropdowns[$x]['field'] . '.trigger("chosen:updated");';
            };

            $js .= $dd_dropdowns[$i - 1]['field'] . '.trigger("chosen:updated");';
            $js .= $dd_dropdowns[$i]['field'] . '.trigger("chosen:updated");';
            if (!empty($this->config['ajax_loader'])) {
                $js .= '$(\'#' . $dd_dropdowns[$i - 1]['field'] . '_ajax_loader\').hide();';
            }
            $js .= '});';
            $js .= '});';
        };

        $js .= '});';
        $js .= '</script>';
        return $js;
    }

    public function get_json()
    {
        if (empty($this->fields[$this->field_name]))
            exit();

        $substr_count = substr_count($this->fields[$this->field_name]['title'], "{");
        if ($substr_count > 0) {
            preg_match_all('/{(.+?)}/', $this->fields[$this->field_name]['title'], $fields_array);
        }

        $this->ci->db->select("*")
            ->from($this->fields[$this->field_name]['table_name'])
            ->where($this->fields[$this->field_name]['relate'], $this->id);

        if (!empty($this->fields[$this->field_name]['where'])) {
            $this->ci->db->where($this->fields[$this->field_name]['where'], null, FALSE);
        }

        if (!empty($this->fields[$this->field_name]['order_by'])) {
            $this->ci->db->order_by($this->fields[$this->field_name]['order_by']);
        }

        $db = $this->ci->db->get();

        $array = array();

        foreach ($db->result_array() as $row) {

            if (!empty($fields_array[1])) {
                foreach ($fields_array[1] as $w) {
                    $replace[] = $row[$w];
                }
            }

            if ($substr_count > 0) {
                $array[] = array("value" => $row[$this->fields[$this->field_name]['id_field']], "property" => str_replace($fields_array[0], $replace, $this->fields[$this->field_name]['title']));
            } else {
                $array[] = array("value" => $row[$this->fields[$this->field_name]['id_field']], "property" => $row[$this->fields[$this->field_name]['title']]);
            }
            $replace = NULL;
        };

        echo json_encode($array);
        exit;
    }

    function render()
    {
        $js = $this->get_js();
        $output = $this->grocery_crud_obj->render();
        $output->output .= $js;
        return $output;
    }

}
