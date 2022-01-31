<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Commonmodel extends CI_Model {

    private $_table = ''; /* TABLE NAME */
    private $_primary_key = '';   /* PRIMARY KEY NAME */

    function __construct() {
        parent::__construct();
    }

    /* ------------------- END BLOCK ------------------- */

    /**
     * FUNCTION FETCH
     */
    public function fetch($p_table = NULL, $p_key = NULL, $cond_and = array(), $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = 0, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE) {

        $primary_key = $p_key == NULL ? $this->_primary_key : $p_key;
        $table = $p_table == NULL ? $this->_table : $p_table;

        if ($table <> NULL) {
            if (count($select_fields) > 0) { /* MULTIPLE FIELDS */
                foreach ($select_fields as $select) {
                    $this->db->select($table . '.' . $select);
                }
            } else {
                $this->db->select($table . '.*');      /* ALL FIELDS */
            }
            $this->db->from($table);

            if (count($cond_and) > 0) {
                foreach ($cond_and as $field => $value) {
                    $this->db->where($table . '.' . $field, $value);
                }
            }

            if (count($cond_or) > 0) {
                foreach ($cond_or as $field => $value) {
                    $this->db->or_where($table . '.' . $field, $value);
                }
            }

            if (count($cond_in) > 0) {
                foreach ($cond_in as $field => $value) {
                    $this->db->where_in($table . '.' . $field, $value);
                }
            }

            if ($cond_custom <> NULL) {
                $where = '1 = 1 ' . $cond_custom;
                $this->db->where($where);
            }

            if (count($join_logic) > 0) {
                $jt = 0;
                foreach ($join_logic as $logic) {
                    $first_table = $logic['first_table'];
                    $second_table = isset($logic['second_table']) ? $logic['second_table'] : $table;
                    $join_on = $logic['join_on'];
                    $join_type = isset($logic['join_type']) ? $logic['join_type'] : 'inner';
                    $join_condition = isset($logic['join_condition']) ? $logic['join_condition'] : array();
                    $join_select = isset($logic['join_select']) ? $logic['join_select'] : array();
                    $join_in = isset($logic['join_in']) ? $logic['join_in'] : array();

                    if ($first_table <> "") {

                        if (count($join_select) > 0) { /* MULTIPLE FIELDS */
                            foreach ($join_select as $select) {
                                $this->db->select($select);
                            }
                        }

                        $this->db->join($first_table, $join_on, $join_type);
                        if (count($join_condition) > 0) {
                            foreach ($join_condition as $field => $value) {
                                $this->db->where($field, $value);
                            }
                        }
                        if (count($join_in) > 0) {
                            foreach ($join_in as $field => $value) {
                                $this->db->where_in($field, $value);
                            }
                        }
                        $jt++;
                    }
                }
            }

            if (count($order_by) > 0) {
                foreach ($order_by as $order_by => $order) {
                    $this->db->order_by($order_by, $order);
                }
            }

            if (count($group_by) > 0) {
                foreach ($group_by as $group) {
                    $this->db->group_by($group);
                }
            }

            $this->db->limit($limit, $offset);

            $query = $this->db->get();

            if ($debug == TRUE) {
                die($this->db->last_query());
            }

            if ($return_object == TRUE) {
                if ($query->num_rows() == 0) {
                    return NULL;
                } else {
                    if ($count_only == TRUE) {
                        return $query->num_rows();
                    } else if ($row_only == TRUE) {
                        return $query->row();
                    } else {
                        return $query->result();
                    }
                }
            } else {
                if ($query->num_rows() == 0) {
                    return NULL;
                } else {
                    if ($count_only == TRUE) {
                        return $query->num_rows();
                    } else if ($row_only == TRUE) {
                        return $query->row_array();
                    } else {
                        return $query->result_array();
                    }
                }
            }
        }
    }

    /**
     * SAVE FUNCTION
     */
    public function save($p_table = NULL, $p_key = NULL, $data_array = array(), $cond = NULL, $debug = FALSE) {
        $primary_key = $p_key == NULL ? $this->_primary_key : $p_key;
        $table = $p_table == NULL ? $this->_table : $p_table;

        if ($cond == NULL) {
            $this->db->insert($table, $data_array);
            $id = $this->db->insert_id();
            return $id;
        } else {
            $condition = "'1' = '1' " . $cond;
            $this->db->select("*");
            $this->db->from($table);
            if ($condition <> "" || $condition <> NULL) {
                $this->db->where($condition);
            }
            $query = $this->db->get();

            if ($debug == TRUE) {
                die($this->db->last_query());
            }

            if ($query->num_rows() == 0) {
                $this->db->insert($table, $data_array);
                $id = $this->db->insert_id();
                return $id;
            } else {
                return NULL;
            }
        }
    }

    /* ----------------- END BLOCK ----------------- */

    /**
     * SAVE BATCH FUNCTION
     */
    public function save_batch($p_table = NULL, $p_key = NULL, $data_array = array(), $cond = NULL, $debug = FALSE) {
        $primary_key = $p_key == NULL ? $this->_primary_key : $p_key;
        $table = $p_table == NULL ? $this->_table : $p_table;

        if (is_array($data_array)) {
            $this->db->insert_batch($table, $data_array);
            return 1;
        }
    }

    /* ----------------- END BLOCK ----------------- */

    /**
     * UPDATE FUNCTION
     */
    public function update($p_table = NULL, $p_key = NULL, $data_array = array(), $cond = NULL, $debug = FALSE) {
        $primary_key = $p_key == NULL ? $this->_primary_key : $p_key;
        $table = $p_table == NULL ? $this->_table : $p_table;

        $pk_value = array_shift($data_array);

        if ($cond == NULL) {
            $this->db->where($primary_key, $pk_value);
            $this->db->update($table, $data_array);
            return $pk_value;
        } else {
            $condition = "'1' = '1' " . $cond;

            $this->db->select("*");
            $this->db->from($table);
            if ($condition <> "" || $condition <> NULL) {
                $this->db->where($condition);
            }
            $this->db->where($primary_key . "<>", $pk_value);
            $query = $this->db->get();

            if ($debug == TRUE) {
                die($this->db->last_query());
            }

            if ($query->num_rows() == 0) {
                $this->db->where($primary_key, $pk_value);
                $this->db->update($table, $data_array);
                return $pk_value;
            } else {
                return NULL;
            }
        }
    }

    /* ----------------- END BLOCK ----------------- */

    /**
     * STATUS FUNCTION
     */
    public function status($p_table = NULL, $p_key = NULL, $row_id = NULL, $debug = FALSE) {
        $primary_key = $p_key == NULL ? $this->_primary_key : $p_key;
        $table = $p_table == NULL ? $this->_table : $p_table;

        $sql = "UPDATE `" . $table . "` SET `status` = IF( `status` = '0', '1', '0' ) WHERE " . $primary_key . " = '" . $row_id . "'";
        if ($debug == TRUE) {
            die($sql);
        }
        $this->db->query($sql);
        return $this->db->affected_rows();
    }

    /* ----------------- END BLOCK ----------------- */

    /**
     * DELETE FUNCTION
     */
    public function delete($p_table = NULL, $p_key = NULL, $row_id = NULL, $debug = FALSE) {
        $primary_key = $p_key == NULL ? $this->_primary_key : $p_key;
        $table = $p_table == NULL ? $this->_table : $p_table;

        $modified = date('Y-m-d H:i:s');
        $sql = "UPDATE `" . $table . "` SET `status` = '5', `modified` = '" . $modified . "' WHERE " . $primary_key . " = '" . $row_id . "'";
        if ($debug == TRUE) {
            die($sql);
        }
        $this->db->query($sql);
        return $this->db->affected_rows();
    }

    /* ----------------- END BLOCK ----------------- */

    /**
     * PERMANENT FUNCTION
     */
    public function p_delete($p_table = NULL, $p_key = NULL, $row_id = NULL, $cond = NULL, $debug = FALSE) {
        $primary_key = $p_key == NULL ? $this->_primary_key : $p_key;
        $table = $p_table == NULL ? $this->_table : $p_table;

        $condition = '1 = 1 ' . $cond;
        $sql = "DELETE FROM `" . $table . "`  WHERE $condition AND " . $primary_key . " = '" . $row_id . "'";
        if ($debug == TRUE) {
            die($sql);
        }
        $this->db->query($sql);
        return $this->db->affected_rows();
    }

    /* ----------------- END BLOCK ----------------- */
    
    /**
     * DATABSE CACHE ON
     */
    public function cache_on(){
        return $this->db->cache_on();
    }
    /* ----------------- END BLOCK ----------------- */
    
    /**
     * DATABSE CACHE OFF
     */
    public function cache_off(){
        return $this->db->cache_off();
    }
    /* ----------------- END BLOCK ----------------- */
    
    /**
     * DATABSE CACHE DELETE
     */
    public function cache_delete($cache_modules = array()){
        if(count($cache_modules) > 0){
            foreach($cache_modules as $cache_module => $cache_method){
                $this->db->cache_delete($cache_module, $cache_method);
            }
        }
        return 1;
    }
    /* ----------------- END BLOCK ----------------- */
    
    /**
     * DATABSE CACHE DELETE ALL
     */
    public function cache_delete_all(){
        return $this->db->cache_delete_all();
    }
    /* ----------------- END BLOCK ----------------- */
    
    /*
     * *******************************************************************************************************************************
     */

    /**
      ----------------------------------------------------------------
      CUSTOM FUNCTIONS FOR ALL MODELS
      ----------------------------------------------------------------
     * Starts
     * Here
     */
    /**
      ----------------------------------------------------------------
      CUSTOM FUNCTIONS FOR ALL MODELS
      ----------------------------------------------------------------
     * Starts
     * Here
     */
    public function generate_temp_table($by_force = FALSE, $survey_code = '0', $survey_id = '0', $no_reply = TRUE) {
        if ($survey_code <> '0' && $survey_id <> '0') {

            $this->load->dbforge();
            /* GET QUESTIONS BY SURVEY ID STARTS */
            
            $cond_and = array('status' => '1');
            $join_logic = array();
            $join_logic[0] = array('first_table' => 'block_questions', 'join_on' => 'block_questions.question_id = questions.id', 'join_type' => 'inner', 'join_select' => array('block_questions.block_id', 'block_questions.question_id'), 'join_condition' => array('block_questions.status' => '1'));
            $join_logic[1] = array('first_table' => 'blocks', 'join_on' => 'block_questions.block_id = blocks.id', 'join_type' => 'inner', 'join_select' => array('blocks.encrypted_code as block_encrypted_code, blocks.name as block_name, blocks.page_number, blocks.description, blocks.is_roster'), 'join_condition' => array('blocks.status' => '1'));
            $join_logic[2] = array('first_table' => 'surveys', 'join_on' => 'surveys.id = blocks.survey_id', 'join_type' => 'inner', 'join_select' => array('surveys.encrypted_code as survey_encrypted_code'), 'join_condition' => array('surveys.encrypted_code' => $survey_code));
            $join_logic[3] = array('first_table' => 'question_details', 'join_on' => 'question_details.question_id = questions.id', 'join_type' => 'inner', 'join_select' => array('question_details.question_id, question_details.question_type_id, question_details.question_sum, question_details.is_other_text, question_details.other_text_name, question_details.is_none_of_the_above, question_details.data_label, question_details.question_code, question_details.is_mandatory, question_details.question_sum, question_details.upper_limit, question_details.lower_limit, question_details.limit_interval, question_details.question_code, question_details.is_other_text, question_details.other_text_name, question_details.data_label, question_details.other_text_weightage, question_details.none_of_the_above_weightage'));
            $join_logic[4] = array('first_table' => 'options', 'join_on' => 'options.question_id = questions.id', 'join_type' => 'left', 'join_select' => array('options.encrypted_code as option_encrypted_code, options.id as option_id, options.name as option_name, options.lower_label_text, options.upper_label_text, options.option_weightage'));
            $join_logic[5] = array('first_table' => 'matrix_options', 'join_on' => 'matrix_options.question_id = questions.id', 'join_type' => 'left', 'join_select' => array('matrix_options.id as matrix_option_id', 'matrix_options.name as matrix_option_name, matrix_options.option_weightage as matrix_option_weightage'));
            $join_logic[6] = array('first_table' => 'question_types', 'join_on' => 'question_types.id = question_details.question_type_id', 'join_type' => 'inner', 'join_select' => array('question_types.encrypted_code as question_type_encrypted_code, question_types.name as question_type'), 'join_condition' => array('question_types.status' => '1'));
            $all_questions = $this->fetch($p_table = 'questions', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('blocks.block_order' => 'ASC', 'block_questions.question_order ' => 'ASC', 'options.option_order' => 'ASC'), $limit = NULL, $offset = 0, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);
            
            if(isset($all_questions)){
                foreach($all_questions as $aq_row){
                    if($aq_row['is_roster'] == '0'){
                        $blocks[$aq_row['block_id']] = $aq_row;
                    }
                }
            }
            
            $cnt = 0;
            if(isset($blocks)){
                foreach ($blocks as $block_row) {
                    $block_id = $block_row['block_id'];
                    $table_report = 'temp_report_' . $survey_id . '_' . $block_id;
                    $roster_table_report = 'temp_roster_report_' . $survey_id . '_' . $block_id;

                    /* GET QUESTIONS BY SURVEY ID STARTS */
                    $results = array();
                    $parent_child = array();
                    $field = array();
                    if (isset($all_questions)) {
                        foreach ($all_questions as $question) {
                            if($question['block_id'] == $block_id){
                                $results[$question['block_id']]['block_id'] = $question['block_id'];
                                $results[$question['block_id']]['name'] = $question['block_name'];

                                $results[$question['block_id']]['questions'][$question['question_id']]['question_id'] = $question['id'];
                                $results[$question['block_id']]['questions'][$question['question_id']]['name'] = $question['name'];
                                $results[$question['block_id']]['questions'][$question['question_id']]['question_type_id'] = $question['question_type_id'];
                                $results[$question['block_id']]['questions'][$question['question_id']]['question_sum'] = $question['question_sum'];
                                $results[$question['block_id']]['questions'][$question['question_id']]['is_none_of_the_above'] = $question['is_none_of_the_above'];
                                $results[$question['block_id']]['questions'][$question['question_id']]['is_other_text'] = $question['is_other_text'];
                                $results[$question['block_id']]['questions'][$question['question_id']]['other_text_name'] = $question['other_text_name'];
                                $results[$question['block_id']]['questions'][$question['question_id']]['data_label'] = $question['data_label'];
                                $results[$question['block_id']]['questions'][$question['question_id']]['question_code'] = $question['question_code'];

                                if (isset($question['option_id'])) {
                                    $results[$question['block_id']]['questions'][$question['question_id']]['options'][$question['option_id']]['option_id'] = $question['option_id'];
                                    $results[$question['block_id']]['questions'][$question['question_id']]['options'][$question['option_id']]['name'] = $question['option_name'];
                                    if (strpos($question['option_name'], '[[') !== false) {
                                        // TEXT PIPING IS AVAILABLE
                                        preg_match_all('/\[{2}ID(.*?)\]{2}/is', $question['option_name'], $match);
                                        foreach ($match[1] as $dy) {
                                            $parent_child[] = $dy;
                                        }
                                    }
                                }

                                if (isset($question['matrix_option_id'])) {
                                    $results[$question['block_id']]['questions'][$question['question_id']]['matrix_options'][$question['matrix_option_id']]['matrix_option_id'] = $question['matrix_option_id'];
                                    $results[$question['block_id']]['questions'][$question['question_id']]['matrix_options'][$question['matrix_option_id']]['name'] = $question['matrix_option_name'];
                                    if (strpos($question['matrix_option_name'], '[[') !== false) {
                                        // TEXT PIPING IS AVAILABLE
                                        preg_match_all('/\[{2}ID(.*?)\]{2}/is', $question['matrix_option_name'], $match);
                                        foreach ($match[1] as $dy) {
                                            $parent_child[] = $dy;
                                        }
                                    }
                                }

                                if ($question['is_other_text'] == '1') {
                                    $results[$question['block_id']]['questions'][$question['question_id']]['options']['0']['option_id'] = '0';
                                    $results[$question['block_id']]['questions'][$question['question_id']]['options']['0']['name'] = $question['other_text_name'] <> '' ? $question['other_text_name'] : 'Other';
                                }
                            }
                        }
                    }
                    
                    $pc_questions = array();
                    $pc_qids = array();
                    $pc_question_details = array();
                    if (count($parent_child) > 0) {
                        $parent_child = array_unique($parent_child);
                        $pc_qids = $parent_child;
                        if (isset($all_questions)) {
                            foreach ($all_questions as $question_row) {
                                if(in_array($question_row['question_code'], $parent_child)){
                                    $pc_questions[$question_row['question_code']][] = $question_row;
                                }
                            }
                        }

                        foreach ($pc_questions as $question_code => $questions) {
                            foreach ($questions as $question) {
                                if (isset($question['option_id'])) {
                                    $pc_question_details[$question['question_code']][$question['option_id']]['page_number'] = $question['page_number'];
                                    $pc_question_details[$question['question_code']][$question['option_id']]['is_other_text'] = $question['is_other_text'];
                                    $pc_question_details[$question['question_code']][$question['option_id']]['other_text_name'] = $question['other_text_name'];
                                    $pc_question_details[$question['question_code']][$question['option_id']]['question_type_encrypted_code'] = $question['question_type_encrypted_code'];
                                    $pc_question_details[$question['question_code']][$question['option_id']]['question_encrypted_code'] = $question['encrypted_code'];
                                    $pc_question_details[$question['question_code']][$question['option_id']]['encrypted_code'] = $question['option_encrypted_code'];
                                    $pc_question_details[$question['question_code']][$question['option_id']]['name'] = $question['option_name'];
                                    $pc_question_details[$question['question_code']][$question['option_id']]['question_id'] = $question['question_id'];
                                }
                            }
                        }
                    }
                    /* GET QUESTIONS BY SURVEY ID ENDS */

                    /* GENERATE TABLE WITH STRUCTURE STARTS */
                    if ($by_force == TRUE || !$this->db->table_exists($table_report)) {

                        $data_row_1 = array();
                        $data_row_1['unique_code'] = 'Unique Code';
                        $data_row_1['respondent_id'] = 'ResID';
                        $data_row_1['enumerator'] = 'Enumerator Name';
                        $data_row_1['team'] = 'Team';
                        $data_row_1['accept_status'] = 'Accpeted';
                        $data_row_1['reject_status'] = 'Rejected';
                        $data_row_1['flag_status'] = 'Flagged';
                        $data_row_1['note'] = 'Note';
                        $data_row_1['device_type'] = 'Device Type';
                        $data_row_1['respondent_code'] = 'Respondent';
                        $data_row_1['started_on'] = 'Started';
                        $data_row_1['ended_on'] = 'Ended';
                        $data_row_1['duration'] = 'Duration';
                        $data_row_1['ip_address'] = 'IP Address';
                        $data_row_1['tracking_code'] = 'Tracking Code';
                        $data_row_1['device_id'] = 'Device ID';
                        $data_row_1['device_name'] = 'Device Name';
                        $data_row_1['latitude'] = 'Latitude';
                        $data_row_1['longitude'] = 'Longitude';    
                        $data_row_1['api_level'] = 'API Level';
                        $data_row_1['app_version'] = 'App Version';
                        $data_row_1['survey_status'] = 'Survey Status';

                        $i = count($data_row_1) + 1;
                        $static_part = 'field_';
                        foreach ($results as $block_id => $details) {
                            foreach ($details['questions'] as $question_id => $question_details) {
                                $question_id = $question_details['question_id'];
                                $question_type_id = $question_details['question_type_id'];
                                $question_text = $question_details['name'];
                                $data_label_text = trim($question_details['data_label']) == "" ? $question_details['question_code'] . '-' . substr(str_replace(array(" ", "  "), "-", trim($question_text)), 0, 20) : trim($question_details['data_label']);
                                $option_id = '0';
                                $matrix_option_id = '0';
                                $row_question_id = '0';
                                $column_question_id = '0';

                                if (in_array($question_type_id, array('1'))) {
                                    /* Dichotomous Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                            $i++;
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('2'))) {
                                    /* Text Response Question */
                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text;
                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                    $i++;
                                }
                                if (in_array($question_type_id, array('3'))) {
                                    /* Multiple Choice Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                            $i++;
                                        }
                                    }

                                    if ($question_details['is_other_text'] == '1') {
                                        $option_text = trim($question_details['other_text_name']) == '' ? 'Other' : $question_details['other_text_name'];
                                        $option_id = '0';
                                        $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                        $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                        $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                        $i++;
                                    }
                                    if ($question_details['is_none_of_the_above'] == '1') {
                                        $option_text = 'NOTA';
                                        $option_id = '-1';
                                        $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                        $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                        $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                        $i++;
                                    }
                                }
                                if (in_array($question_type_id, array('4'))) {
                                    /* Single Choice Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                            $i++;
                                        }
                                    }
                                    if ($question_details['is_other_text'] == '1') {
                                        $option_text = trim($question_details['other_text_name']) == '' ? 'Other' : $question_details['other_text_name'];
                                        $option_id = '0';
                                        $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                        $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                        $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                        $i++;
                                    }
                                }
                                if (in_array($question_type_id, array('5'))) {
                                    /* Date and Time Question */
                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text;
                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                    $i++;
                                }
                                if (in_array($question_type_id, array('6'))) {
                                    /* Email Question */
                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text;
                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                    $i++;
                                }
                                if (in_array($question_type_id, array('7'))) {
                                    /* Phone Number Question */
                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text;
                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                    $i++;
                                }
                                if (in_array($question_type_id, array('8'))) {
                                    /* Dropdown Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                            $i++;
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('9'))) {
                                    /* Number Question */
                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text;
                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                    $i++;
                                }
                                if (in_array($question_type_id, array('10'))) {
                                    /* Text Response Grid Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $row_question_id = '0';
                                            $column_question_id = '0';
                                            if (strpos($option_text, '[[') === false) {
                                                /* IF PARENT CHILD ROW IS NOT PRESENT STARTS */
                                                foreach ($question_details['matrix_options'] as $matrix_option_id => $matrix_option_details) {
                                                    $matrix_option_text = $matrix_option_details['name'];
                                                    $section_count = 0;
                                                    if (strpos($matrix_option_text, '[[') === false) {
                                                        /* IF PARENT CHILD COLUMN IS NOT PRESENT STARTS */
                                                        $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                        $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $matrix_option_text;
                                                        $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                        $i++;
                                                        $section_count++;
                                                        /* IF PARENT CHILD COLUMN IS NOT PRESENT ENDS */
                                                    } else {
                                                        /* IF PARENT CHILD COLUMN IS PRESENT STARTS */
                                                        preg_match_all('/\[{2}ID(.*?)\]{2}/is', $matrix_option_text, $match);
                                                        foreach ($match[1] as $dynamic_row) {
                                                            $section_count = 0;
                                                            foreach ($pc_question_details[$dynamic_row] as $dynamic_matrix_option_id => $pc_details) {
                                                                $dynamic_matrix_option_text = $pc_details['name'];
                                                                $dynamic_column_question_id = $pc_details['question_id'];
                                                                $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $dynamic_matrix_option_id . '_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $dynamic_matrix_option_text;
                                                                $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                $i++;
                                                                $section_count++;

                                                                if ($pc_details['is_other_text'] == '1' && count($pc_question_details[$dynamic_row]) == $section_count) {
                                                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $pc_details['other_text_name'];
                                                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                    $i++;
                                                                }
                                                            }
                                                        }
                                                        /* IF PARENT CHILD COLUMN IS PRESENT ENDS */
                                                    }
                                                }
                                                /* IF PARENT CHILD ROW IS NOT PRESENT ENDS */
                                            } else {
                                                /* IF PARENT CHILD ROW IS PRESENT STARTS */
                                                preg_match_all('/\[{2}ID(.*?)\]{2}/is', $option_text, $match);
                                                foreach ($match[1] as $dynamic_row) {
                                                    $section_count = 0;
                                                    foreach ($pc_question_details[$dynamic_row] as $option_id => $pco_details) {
                                                        $option_text = $pco_details['name'];
                                                        $row_question_id = $pco_details['question_id'];
                                                        $is_other_text = $pco_details['is_other_text'];
                                                        $other_text_name = $pco_details['other_text_name'];

                                                        foreach ($question_details['matrix_options'] as $matrix_option_id => $matrix_option_details) {
                                                            $matrix_option_text = $matrix_option_details['name'];
                                                            $section_count = 0;
                                                            if (strpos($matrix_option_text, '[[') === false) {
                                                                /* IF PARENT CHILD COLUMN IS NOT PRESENT STARTS */
                                                                $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                                $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $matrix_option_text;
                                                                $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                $i++;
                                                                $section_count++;
                                                                /* IF PARENT CHILD COLUMN IS NOT PRESENT ENDS */
                                                            } else {
                                                                /* IF PARENT CHILD COLUMN IS PRESENT STARTS */
                                                                preg_match_all('/\[{2}ID(.*?)\]{2}/is', $matrix_option_text, $match);
                                                                foreach ($match[1] as $dynamic_row) {
                                                                    $section_count = 0;
                                                                    foreach ($pc_question_details[$dynamic_row] as $dynamic_matrix_option_id => $pc_details) {
                                                                        $dynamic_matrix_option_text = $pc_details['name'];
                                                                        $dynamic_column_question_id = $pc_details['question_id'];
                                                                        $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $dynamic_matrix_option_id . '_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                        $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $dynamic_matrix_option_text;
                                                                        $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                        $i++;
                                                                        $section_count++;

                                                                        if ($pc_details['is_other_text'] == '1' && count($pc_question_details[$dynamic_row]) == $section_count) {
                                                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $pc_details['other_text_name'];
                                                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                            $i++;
                                                                        }
                                                                    }
                                                                }
                                                                /* IF PARENT CHILD COLUMN IS PRESENT ENDS */
                                                            }
                                                        }
                                                        if ($is_other_text == '1') {
                                                            $option_id = '0';
                                                            $option_text = $other_text_name;
                                                            foreach ($question_details['matrix_options'] as $matrix_option_id => $matrix_option_details) {
                                                                $matrix_option_text = $matrix_option_details['name'];
                                                                $section_count = 0;
                                                                if (strpos($matrix_option_text, '[[') === false) {
                                                                    /* IF PARENT CHILD COLUMN IS NOT PRESENT STARTS */
                                                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $matrix_option_text;
                                                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                    $i++;
                                                                    $section_count++;
                                                                    /* IF PARENT CHILD COLUMN IS NOT PRESENT ENDS */
                                                                } else {
                                                                    /* IF PARENT CHILD COLUMN IS PRESENT STARTS */
                                                                    preg_match_all('/\[{2}ID(.*?)\]{2}/is', $matrix_option_text, $match);
                                                                    foreach ($match[1] as $dynamic_row) {
                                                                        $section_count = 0;
                                                                        foreach ($pc_question_details[$dynamic_row] as $dynamic_matrix_option_id => $pc_details) {
                                                                            $dynamic_matrix_option_text = $pc_details['name'];
                                                                            $dynamic_column_question_id = $pc_details['question_id'];
                                                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $dynamic_matrix_option_id . '_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $dynamic_matrix_option_text;
                                                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                            $i++;
                                                                            $section_count++;

                                                                            if ($pc_details['is_other_text'] == '1' && count($pc_question_details[$dynamic_row]) == $section_count) {
                                                                                $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                                $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $pc_details['other_text_name'];
                                                                                $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                                $i++;
                                                                            }
                                                                        }
                                                                    }
                                                                    /* IF PARENT CHILD COLUMN IS PRESENT ENDS */
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                /* IF PARENT CHILD ROW IS PRESENT ENDS */
                                            }
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('11'))) {
                                    /* Single Choice Grid Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $row_question_id = '0';
                                            $column_question_id = '0';

                                            if (strpos($option_text, '[[') === false) {
                                                /* IF PARENT CHILD ROW IS NOT PRESENT STARTS */
                                                if (isset($question_details['matrix_options'])) {
                                                    foreach ($question_details['matrix_options'] as $matrix_option_id => $matrix_option_details) {
                                                        $matrix_option_text = $matrix_option_details['name'];
                                                        $section_count = 0;
                                                        if (strpos($matrix_option_text, '[[') === false) {
                                                            /* IF PARENT CHILD COLUMN IS NOT PRESENT STARTS */
                                                            //$field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_0_0';
                                                            //$data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $matrix_option_text;
                                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                            $i++;
                                                            $section_count++;
                                                            /* IF PARENT CHILD COLUMN IS NOT PRESENT ENDS */
                                                        } else {
                                                            /* IF PARENT CHILD COLUMN IS PRESENT STARTS */
                                                            preg_match_all('/\[{2}ID(.*?)\]{2}/is', $matrix_option_text, $match);
                                                            foreach ($match[1] as $dynamic_row) {
                                                                $section_count = 0;
                                                                foreach ($pc_question_details[$dynamic_row] as $dynamic_matrix_option_id => $pc_details) {
                                                                    $dynamic_matrix_option_text = $pc_details['name'];
                                                                    $dynamic_column_question_id = $pc_details['question_id'];
                                                                    //$field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $dynamic_matrix_option_id . '_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_0_0';
                                                                    //$data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $dynamic_matrix_option_text;
                                                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                    $i++;
                                                                    $section_count++;

                                                                    if ($pc_details['is_other_text'] == '1' && count($pc_question_details[$dynamic_row]) == $section_count) {
                                                                        //$field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                        $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_0_0';
                                                                        //$data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $pc_details['other_text_name'];
                                                                        $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                                                        $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                        $i++;
                                                                    }
                                                                }
                                                            }
                                                            /* IF PARENT CHILD COLUMN IS PRESENT ENDS */
                                                        }
                                                    }
                                                }
                                                /* IF PARENT CHILD ROW IS NOT PRESENT ENDS */
                                            } else {
                                                /* IF PARENT CHILD ROW IS  PRESENT STARTS */
                                                preg_match_all('/\[{2}ID(.*?)\]{2}/is', $option_text, $match);
                                                foreach ($match[1] as $dynamic_row) {
                                                    $section_count = 0;
                                                    foreach ($pc_question_details[$dynamic_row] as $option_id => $pco_details) {
                                                        $option_text = $pco_details['name'];
                                                        $other_row_question_id = $pco_details['question_id'];
                                                        $is_other_text = $pco_details['is_other_text'];
                                                        $other_text_name = $pco_details['other_text_name'];
                                                        $row_question_id = $other_row_question_id;

                                                        foreach ($question_details['matrix_options'] as $matrix_option_id => $matrix_option_details) {
                                                            $matrix_option_text = $matrix_option_details['name'];
                                                            $section_count = 0;
                                                            if (strpos($matrix_option_text, '[[') === false) {
                                                                /* IF PARENT CHILD COLUMN IS NOT PRESENT STARTS */
                                                                //$field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                                $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_0_0';
                                                                //$data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $matrix_option_text;
                                                                $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                                                $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                $i++;
                                                                $section_count++;
                                                                /* IF PARENT CHILD COLUMN IS NOT PRESENT ENDS */
                                                            } else {
                                                                /* IF PARENT CHILD COLUMN IS PRESENT STARTS */
                                                                preg_match_all('/\[{2}ID(.*?)\]{2}/is', $matrix_option_text, $match);
                                                                foreach ($match[1] as $dynamic_row) {
                                                                    $section_count = 0;
                                                                    foreach ($pc_question_details[$dynamic_row] as $dynamic_matrix_option_id => $pc_details) {
                                                                        $dynamic_matrix_option_text = $pc_details['name'];
                                                                        $dynamic_column_question_id = $pc_details['question_id'];
                                                                        //$field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $dynamic_matrix_option_id . '_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                        $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_0_0';
                                                                        //$data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $dynamic_matrix_option_text;
                                                                        $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                                                        $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                        $i++;
                                                                        $section_count++;

                                                                        if ($pc_details['is_other_text'] == '1' && count($pc_question_details[$dynamic_row]) == $section_count) {
                                                                            //$field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_0_0';
                                                                            //$data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $pc_details['other_text_name'];
                                                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                            $i++;
                                                                        }
                                                                    }
                                                                }
                                                                /* IF PARENT CHILD COLUMN IS PRESENT ENDS */
                                                            }
                                                        }
                                                        if ($is_other_text == '1') {
                                                            $option_id = '0';
                                                            $row_question_id = $other_row_question_id;
                                                            $option_text = $other_text_name;
                                                            foreach ($question_details['matrix_options'] as $matrix_option_id => $matrix_option_details) {
                                                                $matrix_option_text = $matrix_option_details['name'];
                                                                $section_count = 0;
                                                                if (strpos($matrix_option_text, '[[') === false) {
                                                                    /* IF PARENT CHILD COLUMN IS NOT PRESENT STARTS */
                                                                    //$field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_0_0';
                                                                    //$data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $matrix_option_text;
                                                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                    $i++;
                                                                    $section_count++;
                                                                    /* IF PARENT CHILD COLUMN IS NOT PRESENT ENDS */
                                                                } else {
                                                                    /* IF PARENT CHILD COLUMN IS PRESENT STARTS */
                                                                    preg_match_all('/\[{2}ID(.*?)\]{2}/is', $matrix_option_text, $match);
                                                                    foreach ($match[1] as $dynamic_row) {
                                                                        $section_count = 0;
                                                                        foreach ($pc_question_details[$dynamic_row] as $dynamic_matrix_option_id => $pc_details) {
                                                                            $dynamic_matrix_option_text = $pc_details['name'];
                                                                            $dynamic_column_question_id = $pc_details['question_id'];
                                                                            //$field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $dynamic_matrix_option_id . '_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_0_0';
                                                                            //$data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $dynamic_matrix_option_text;
                                                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                            $i++;
                                                                            $section_count++;

                                                                            if ($pc_details['is_other_text'] == '1' && count($pc_question_details[$dynamic_row]) == $section_count) {
                                                                                //$field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                                $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_0_0';
                                                                                //$data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $pc_details['other_text_name'];
                                                                                $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                                                                $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                                $i++;
                                                                            }
                                                                        }
                                                                    }
                                                                    /* IF PARENT CHILD COLUMN IS PRESENT ENDS */
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                /* IF PARENT CHILD ROW IS PRESENT ENDS */
                                            }
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('12'))) {
                                    /* Multiple Choice Grid Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $row_question_id = '0';
                                            $column_question_id = '0';

                                            if (strpos($option_text, '[[') === false) {
                                                /* IF PARENT CHILD ROW IS NOT PRESENT STARTS */
                                                foreach ($question_details['matrix_options'] as $matrix_option_id => $matrix_option_details) {
                                                    $matrix_option_text = $matrix_option_details['name'];
                                                    $section_count = 0;
                                                    if (strpos($matrix_option_text, '[[') === false) {
                                                        /* IF PARENT CHILD COLUMN IS NOT PRESENT STARTS */
                                                        $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                        $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $matrix_option_text;
                                                        $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                        $i++;
                                                        $section_count++;
                                                        /* IF PARENT CHILD COLUMN IS NOT PRESENT ENDS */
                                                    } else {
                                                        /* IF PARENT CHILD COLUMN IS PRESENT STARTS */
                                                        preg_match_all('/\[{2}ID(.*?)\]{2}/is', $matrix_option_text, $match);
                                                        foreach ($match[1] as $dynamic_row) {
                                                            $section_count = 0;
                                                            foreach ($pc_question_details[$dynamic_row] as $dynamic_matrix_option_id => $pc_details) {
                                                                $dynamic_matrix_option_text = $pc_details['name'];
                                                                $dynamic_column_question_id = $pc_details['question_id'];
                                                                $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $dynamic_matrix_option_id . '_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $dynamic_matrix_option_text;
                                                                $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                $i++;
                                                                $section_count++;

                                                                if ($pc_details['is_other_text'] == '1' && count($pc_question_details[$dynamic_row]) == $section_count) {
                                                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $pc_details['other_text_name'];
                                                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                    $i++;
                                                                }
                                                            }
                                                        }
                                                        /* IF PARENT CHILD COLUMN IS PRESENT ENDS */
                                                    }
                                                }
                                                /* IF PARENT CHILD ROW IS NOT PRESENT ENDS */
                                            } else {
                                                /* IF PARENT CHILD ROW IS  PRESENT STARTS */
                                                preg_match_all('/\[{2}ID(.*?)\]{2}/is', $option_text, $match);
                                                foreach ($match[1] as $dynamic_row) {
                                                    $section_count = 0;
                                                    foreach ($pc_question_details[$dynamic_row] as $option_id => $pco_details) {
                                                        $option_text = $pco_details['name'];
                                                        $other_row_question_id = $pco_details['question_id'];
                                                        $is_other_text = $pco_details['is_other_text'];
                                                        $other_text_name = $pco_details['other_text_name'];
                                                        $row_question_id = $other_row_question_id;

                                                        $total_section_count = 0;
                                                        foreach ($question_details['matrix_options'] as $matrix_option_id => $matrix_option_details) {
                                                            $matrix_option_text = $matrix_option_details['name'];
                                                            $section_count = 0;
                                                            if (strpos($matrix_option_text, '[[') === false) {
                                                                /* IF PARENT CHILD COLUMN IS NOT PRESENT STARTS */
                                                                $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                                $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $matrix_option_text;
                                                                $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                $i++;
                                                                $section_count++;

                                                                $total_section_count++;
                                                                if ($is_other_text == '1') {
                                                                    $other_option_id = '0';
                                                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $other_option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $other_text_name . '_' . $matrix_option_text;
                                                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                    $i++;
                                                                }
                                                                /* IF PARENT CHILD COLUMN IS NOT PRESENT ENDS */
                                                            } else {
                                                                /* IF PARENT CHILD COLUMN IS PRESENT STARTS */
                                                                preg_match_all('/\[{2}ID(.*?)\]{2}/is', $matrix_option_text, $match);
                                                                foreach ($match[1] as $dynamic_row) {
                                                                    $section_count = 0;
                                                                    foreach ($pc_question_details[$dynamic_row] as $dynamic_matrix_option_id => $pc_details) {
                                                                        $dynamic_matrix_option_text = $pc_details['name'];
                                                                        $dynamic_column_question_id = $pc_details['question_id'];
                                                                        $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $dynamic_matrix_option_id . '_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                        $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $dynamic_matrix_option_text;
                                                                        $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                        $i++;
                                                                        $section_count++;

                                                                        if ($pc_details['is_other_text'] == '1' && count($pc_question_details[$dynamic_row]) == $section_count) {
                                                                            //echo $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_'.$row_question_id.'_' . $dynamic_column_question_id . ' <br />';
                                                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $pc_details['other_text_name'];
                                                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                            $i++;
                                                                        }
                                                                    }
                                                                }
                                                                /* IF PARENT CHILD COLUMN IS PRESENT ENDS */
                                                            }
                                                        }
                                                        if ($is_other_text == '1') {
                                                            $option_id = '0';
                                                            $row_question_id = $other_row_question_id;
                                                            $option_text = $other_text_name;
                                                            foreach ($question_details['matrix_options'] as $matrix_option_id => $matrix_option_details) {
                                                                $matrix_option_text = $matrix_option_details['name'];
                                                                $section_count = 0;
                                                                if (strpos($matrix_option_text, '[[') === false) {
                                                                    /* IF PARENT CHILD COLUMN IS NOT PRESENT STARTS */
                                                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $matrix_option_text;
                                                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                    $i++;
                                                                    $section_count++;
                                                                    /* IF PARENT CHILD COLUMN IS NOT PRESENT ENDS */
                                                                } else {
                                                                    /* IF PARENT CHILD COLUMN IS PRESENT STARTS */
                                                                    preg_match_all('/\[{2}ID(.*?)\]{2}/is', $matrix_option_text, $match);
                                                                    foreach ($match[1] as $dynamic_row) {
                                                                        $section_count = 0;
                                                                        foreach ($pc_question_details[$dynamic_row] as $dynamic_matrix_option_id => $pc_details) {
                                                                            $dynamic_matrix_option_text = $pc_details['name'];
                                                                            $dynamic_column_question_id = $pc_details['question_id'];
                                                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $dynamic_matrix_option_id . '_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $dynamic_matrix_option_text;
                                                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                            $i++;
                                                                            $section_count++;

                                                                            if ($pc_details['is_other_text'] == '1' && count($pc_question_details[$dynamic_row]) == $section_count) {
                                                                                $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                                $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $pc_details['other_text_name'];
                                                                                $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                                $i++;
                                                                            }
                                                                        }
                                                                    }
                                                                    /* IF PARENT CHILD COLUMN IS PRESENT ENDS */
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                /* IF PARENT CHILD ROW IS PRESENT ENDS */
                                            }
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('13'))) {
                                    /* Five Point Likert Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                            $i++;
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('14'))) {
                                    /* Seven Point Likert Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                            $i++;
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('15'))) {
                                    /* N Point Likert Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                            $i++;
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('16'))) {
                                    /* Net Promoter Score Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                            $i++;
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('17'))) {
                                    /* Rank Order Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                            $i++;
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('18'))) {
                                    /* Constant Sum Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                            $i++;
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('19'))) {
                                    /* Image Choice Question */
                                }
                                if (in_array($question_type_id, array('20'))) {
                                    /* Slider Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                            $i++;
                                        }
                                    }else{
                                        $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                        $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text;
                                        $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                        $i++;
                                    }
                                }
                                if (in_array($question_type_id, array('21'))) {
                                    /* Five Point Emoji Question */
                                }
                                if (in_array($question_type_id, array('22'))) {
                                    /* Seven Pont Emoji Question */
                                }
                                if (in_array($question_type_id, array('23'))) {
                                    /* NPS with Emoji Question */
                                }
                                if (in_array($question_type_id, array('24'))) {
                                    /* Image Upload Question */
                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text;
                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                    $i++;
                                }
                                if (in_array($question_type_id, array('25'))) {
                                    /* Bipolar Matrix Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            /* IF PARENT CHILD ROW IS NOT PRESENT STARTS */
                                            foreach ($question_details['matrix_options'] as $matrix_option_id => $matrix_option_details) {
                                                $matrix_option_text = $matrix_option_details['name'];
                                                $section_count = 0;
                                                /* IF PARENT CHILD COLUMN IS NOT PRESENT STARTS */
                                                $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $matrix_option_text;
                                                $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                $i++;
                                                $section_count++;
                                                /* IF PARENT CHILD COLUMN IS NOT PRESENT ENDS */
                                            }
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('26'))) {
                                    /* Semantic Differential Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                            $i++;
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('27'))) {
                                    /* Star Rating - Single Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                            $i++;
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('28'))) {
                                    /* Star Rating Grid Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $row_question_id = '0';
                                            $column_question_id = '0';

                                            if (strpos($option_text, '[[') === false) {
                                                /* IF PARENT CHILD ROW IS NOT PRESENT STARTS */
                                                foreach ($question_details['matrix_options'] as $matrix_option_id => $matrix_option_details) {
                                                    $matrix_option_text = $matrix_option_details['name'];
                                                    $section_count = 0;
                                                    if (strpos($matrix_option_text, '[[') === false) {
                                                        /* IF PARENT CHILD COLUMN IS NOT PRESENT STARTS */
                                                        $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                        $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $matrix_option_text;
                                                        $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                        $i++;
                                                        $section_count++;
                                                        /* IF PARENT CHILD COLUMN IS NOT PRESENT ENDS */
                                                    } else {
                                                        /* IF PARENT CHILD COLUMN IS PRESENT STARTS */
                                                        preg_match_all('/\[{2}ID(.*?)\]{2}/is', $matrix_option_text, $match);
                                                        foreach ($match[1] as $dynamic_row) {
                                                            $section_count = 0;
                                                            foreach ($pc_question_details[$dynamic_row] as $dynamic_matrix_option_id => $pc_details) {
                                                                $dynamic_matrix_option_text = $pc_details['name'];
                                                                $dynamic_column_question_id = $pc_details['question_id'];
                                                                $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $dynamic_matrix_option_id . '_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $dynamic_matrix_option_text;
                                                                $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                $i++;
                                                                $section_count++;

                                                                if ($pc_details['is_other_text'] == '1' && count($pc_question_details[$dynamic_row]) == $section_count) {
                                                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $pc_details['other_text_name'];
                                                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                    $i++;
                                                                }
                                                            }
                                                        }
                                                        /* IF PARENT CHILD COLUMN IS PRESENT ENDS */
                                                    }
                                                }
                                                /* IF PARENT CHILD ROW IS NOT PRESENT ENDS */
                                            } else {
                                                /* IF PARENT CHILD ROW IS  PRESENT STARTS */
                                                preg_match_all('/\[{2}ID(.*?)\]{2}/is', $option_text, $match);
                                                foreach ($match[1] as $dynamic_row) {
                                                    $section_count = 0;
                                                    foreach ($pc_question_details[$dynamic_row] as $option_id => $pco_details) {
                                                        $option_text = $pco_details['name'];
                                                        $other_row_question_id = $pco_details['question_id'];
                                                        $is_other_text = $pco_details['is_other_text'];
                                                        $other_text_name = $pco_details['other_text_name'];
                                                        $row_question_id = $other_row_question_id;

                                                        $total_section_count = 0;
                                                        foreach ($question_details['matrix_options'] as $matrix_option_id => $matrix_option_details) {
                                                            $matrix_option_text = $matrix_option_details['name'];
                                                            $section_count = 0;
                                                            if (strpos($matrix_option_text, '[[') === false) {
                                                                /* IF PARENT CHILD COLUMN IS NOT PRESENT STARTS */
                                                                $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                                $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $matrix_option_text;
                                                                $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                $i++;
                                                                $section_count++;

                                                                $total_section_count++;
                                                                if ($is_other_text == '1') {
                                                                    $other_option_id = '0';
                                                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $other_option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $other_text_name . '_' . $matrix_option_text;
                                                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                    $i++;
                                                                }
                                                                /* IF PARENT CHILD COLUMN IS NOT PRESENT ENDS */
                                                            } else {
                                                                /* IF PARENT CHILD COLUMN IS PRESENT STARTS */
                                                                preg_match_all('/\[{2}ID(.*?)\]{2}/is', $matrix_option_text, $match);
                                                                foreach ($match[1] as $dynamic_row) {
                                                                    $section_count = 0;
                                                                    foreach ($pc_question_details[$dynamic_row] as $dynamic_matrix_option_id => $pc_details) {
                                                                        $dynamic_matrix_option_text = $pc_details['name'];
                                                                        $dynamic_column_question_id = $pc_details['question_id'];
                                                                        $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $dynamic_matrix_option_id . '_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                        $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $dynamic_matrix_option_text;
                                                                        $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                        $i++;
                                                                        $section_count++;

                                                                        if ($pc_details['is_other_text'] == '1' && count($pc_question_details[$dynamic_row]) == $section_count) {
                                                                            //echo $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_'.$row_question_id.'_' . $dynamic_column_question_id . ' <br />';
                                                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $pc_details['other_text_name'];
                                                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                            $i++;
                                                                        }
                                                                    }
                                                                }
                                                                /* IF PARENT CHILD COLUMN IS PRESENT ENDS */
                                                            }
                                                        }
                                                        if ($is_other_text == '1') {
                                                            $option_id = '0';
                                                            $row_question_id = $other_row_question_id;
                                                            $option_text = $other_text_name;
                                                            foreach ($question_details['matrix_options'] as $matrix_option_id => $matrix_option_details) {
                                                                $matrix_option_text = $matrix_option_details['name'];
                                                                $section_count = 0;
                                                                if (strpos($matrix_option_text, '[[') === false) {
                                                                    /* IF PARENT CHILD COLUMN IS NOT PRESENT STARTS */
                                                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $matrix_option_text;
                                                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                    $i++;
                                                                    $section_count++;
                                                                    /* IF PARENT CHILD COLUMN IS NOT PRESENT ENDS */
                                                                } else {
                                                                    /* IF PARENT CHILD COLUMN IS PRESENT STARTS */
                                                                    preg_match_all('/\[{2}ID(.*?)\]{2}/is', $matrix_option_text, $match);
                                                                    foreach ($match[1] as $dynamic_row) {
                                                                        $section_count = 0;
                                                                        foreach ($pc_question_details[$dynamic_row] as $dynamic_matrix_option_id => $pc_details) {
                                                                            $dynamic_matrix_option_text = $pc_details['name'];
                                                                            $dynamic_column_question_id = $pc_details['question_id'];
                                                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $dynamic_matrix_option_id . '_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $dynamic_matrix_option_text;
                                                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                            $i++;
                                                                            $section_count++;

                                                                            if ($pc_details['is_other_text'] == '1' && count($pc_question_details[$dynamic_row]) == $section_count) {
                                                                                $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                                $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $pc_details['other_text_name'];
                                                                                $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                                $i++;
                                                                            }
                                                                        }
                                                                    }
                                                                    /* IF PARENT CHILD COLUMN IS PRESENT ENDS */
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                /* IF PARENT CHILD ROW IS PRESENT ENDS */
                                            }
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('29'))) {
                                    /* Signature Question */
                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text;
                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                    $i++;
                                }
                                if (in_array($question_type_id, array('30'))) {
                                    /* Preset Questions Question */
                                }
                                if (in_array($question_type_id, array('31'))) {
                                    /* Essay/Long Answer Question */
                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text;
                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                    $i++;
                                }
                                if (in_array($question_type_id, array('32'))) {
                                    /* SEC Question */
                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text;
                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                    $i++;
                                }
                                if (in_array($question_type_id, array('33'))) {
                                    /* Location Question */
                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text;
                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                    $i++;
                                }
                            }
                        }
                        //echo "<pre>";
                        //print_r(array_unique($data_row_1));
                        //echo "</pre>";
                        //exit();

                        $this->dbforge->drop_table($table_report, TRUE);
                        $this->dbforge->drop_table($roster_table_report, TRUE);
                        $fields = array(
                            'id' => array(
                                'type' => 'INT',
                                'constraint' => 11,
                                'auto_increment' => TRUE
                            ),
                            'unique_code' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 50,
                                'null' => TRUE
                            ),
                            'respondent_id' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 30,
                                'null' => TRUE
                            ),
                            'accept_status' => array(
                                'type' => 'TEXT',
                                'null' => TRUE
                            ),
                            'reject_status' => array(
                                'type' => 'TEXT',
                                'null' => TRUE
                            ),
                            'flag_status' => array(
                                'type' => 'TEXT',
                                'null' => TRUE
                            ),
                            'note' => array(
                                'type' => 'TEXT',
                                'null' => TRUE
                            ),
                            'enumerator' => array(
                                'type' => 'TEXT',
                                'null' => TRUE
                            ),
                            'team' => array(
                                'type' => 'TEXT',
                                'null' => TRUE
                            ),
                            'device_type' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 15,
                                'null' => TRUE
                            ),
                            'respondent_code' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 50,
                                'null' => TRUE
                            ),
                            'started_on' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 30,
                                'null' => TRUE
                            ),
                            'ended_on' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 30,
                                'null' => TRUE
                            ),
                            'duration' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 30,
                                'null' => TRUE
                            ),
                            'ip_address' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 20,
                                'null' => TRUE
                            ),
                            'tracking_code' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 30,
                                'null' => TRUE
                            ),
                            'device_id' => array(
                               'type' => 'VARCHAR',
                                'constraint' => 20,
                                'null' => TRUE
                            ),
                            'device_name' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 50,
                                'null' => TRUE
                            ),                        
                            'latitude' => array(
                                'type' => 'TEXT',
                                'null' => TRUE
                            ),
                            'longitude' => array(
                                'type' => 'TEXT',
                                'null' => TRUE
                            ),
                            'api_level' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 10,
                                'null' => TRUE
                            ),
                            'app_version' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 15,
                                'null' => TRUE
                            ),
                            'survey_status' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 20,
                                'null' => TRUE
                            )
                        );
                        foreach ($field as $f_row) {
                            $fields = array_merge($fields, array(
                                $f_row => array(
                                    'type' => 'TEXT',
                                    'null' => TRUE
                                )
                            ));
                        }

                        $this->dbforge->add_key('id', TRUE);
                        $this->dbforge->add_field($fields);
                        $attributes = array('ENGINE' => 'InnoDB', 'ROW_FORMAT' => 'DYNAMIC');
                        $this->dbforge->create_table($table_report, FALSE, $attributes);

                        $this->save($p_table = $table_report, $p_key = 'id', $data_array = $data_row_1, $cond = NULL, $debug = FALSE);

                        if ($cnt == 0) {
                            $data_array = array();
                            $data_array['survey_id'] = $survey_id;
                            $data_array['is_copied_to_temp_table'] = '0';
                            $this->update($p_table = 'survey_respondents', $p_key = 'survey_id', $data_array, $cond = NULL, $debug = FALSE);
                        }
                    }
                    $cnt++;
                }
            }
            if(isset($blocks)){
                $cond_and = array();
                $join_logic = array();
                $cond_and = array('survey_id' => $survey_id, 'is_copied_to_temp_table' => '0');
                $join_logic[0] = array('first_table' => 'enumerators', 'join_on' => 'enumerators.id = survey_respondents.enumerator_id', 'join_type' => 'left', 'join_select' => array('enumerators.name as enumerator_name'));
                $raw_respondents = $this->fetch($p_table = 'survey_respondents', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*, (SELECT GROUP_CONCAT(team_enumerators.team_code) FROM team_enumerators WHERE team_enumerators.`enumerator_code` = enumerators.`encrypted_code`) AS team_code'), $join_logic, $order_by = array('id' => 'ASC'), $limit = NULL, $offset = 0, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);
                
                $data['responses'] = $this->get_temp_table_data($survey_id, $blocks, $no_reply, $all_questions, $raw_respondents);

                /* GENERATE TABLE WITH STRUCTURE ENDS */

                if ($no_reply == FALSE) {
                    return $data;
                }
            }
        }
    }
    
    public function get_temp_table_data($survey_id = '0', $blocks = array(), $no_reply = TRUE, $pc_questions = array(), $raw_respondents = array()) {
        /* INSERT DATA IF LEFT STARTS */
        if (isset($pc_questions)) {
            foreach ($pc_questions as $qs_row) {
                $option_text[$qs_row['option_id']] = $qs_row['option_name'];
                $option_weightage[$qs_row['option_id']] = $qs_row['option_weightage'];
                $matrix_option_text[$qs_row['matrix_option_id']] = $qs_row['matrix_option_name'];
                $matrix_option_weightage[$qs_row['matrix_option_id']] = $qs_row['matrix_option_weightage'];
                $nota_weightage[$qs_row['id']] = $qs_row['none_of_the_above_weightage'];
                $other_weightage[$qs_row['id']] = $qs_row['other_text_weightage'];
            }
        }
        $response_table = 'responses_' . $survey_id;
        $response_array = $this->fetch($p_table = $response_table, $p_key = 'id', $cond_and = array(), $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = 0, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);
        if(isset($response_array)){
            foreach($response_array as $response_data){
                $response_row[$response_data['respondent_code']][] = $response_data;
            }
        }
        
        $block_count = 1;
        foreach ($blocks as $block_row) {
            $data_to_save = array();
            $block_id = $block_row['block_id'];
            $temp_table = 'temp_report_' . $survey_id . '_' . $block_id;
            $respondent_ids = array();
            $fields = $this->db->list_fields($temp_table);
            if (isset($raw_respondents)) {
                /* COPY ROW FROM RESPONSE TABLE */
                foreach ($raw_respondents as $rawp) {
                    if (isset($response_row[$rawp['respondent_code']])) {
                        $existing_fields = array();
                        $rec_count = $rawp['respondent_code'];
                        foreach ($response_row[$rawp['respondent_code']] as $response) {
                            $question_type_id = $response['question_type_id'];
                            $question_id = $response['question_id'];
                            $option_id = $response['option_id'];
                            $matrix_option_id = $response['matrix_option_id'];
                            $row_question_id = $response['row_question_id'];
                            $column_question_id = $response['column_question_id'];
                            $text_response = $response['text_response'];
                            $other_text_response = $response['other_text_response'];
                            $file_name = $response['file_name'];
                            $respondent_code = $response['respondent_code'];
                            
                            if(in_array($question_type_id, array('11'))){
                                $field = 'field_' . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_0_0' ;
                            }else{
                                $field = 'field_' . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                            }
                            $existing_fields[] = $field;
                        }
                        foreach($fields as $table_row){
                            if(!in_array($table_row, $existing_fields)){
                                $data_to_save[$rec_count][$table_row] = NULL;
                            }
                        }
                        foreach ($response_row[$rawp['respondent_code']] as $response) {
                            $question_type_id = $response['question_type_id'];
                            $question_id = $response['question_id'];
                            $option_id = $response['option_id'];
                            $matrix_option_id = $response['matrix_option_id'];
                            $row_question_id = $response['row_question_id'];
                            $column_question_id = $response['column_question_id'];
                            $text_response = $response['text_response'];
                            $other_text_response = $response['other_text_response'];
                            $file_name = $response['file_name'];
                            $respondent_code = $response['respondent_code'];

                            if(in_array($question_type_id, array('11'))){
                                $field = 'field_' . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_0_0' ;
                            }else{
                                $field = 'field_' . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                            }

                            if (!in_array($field, $fields)) {
                                continue;
                            }
                            if (in_array($question_type_id, array('1'))) {
                                /* Dichotomous Question */
                                $data_to_save[$rec_count][$field] = $option_text[$option_id] . '~' . $option_weightage[$option_id];
                            }
                            if (in_array($question_type_id, array('2'))) {
                                /* Text Response Question */
                                $data_to_save[$rec_count][$field] = $text_response;
                            }
                            if (in_array($question_type_id, array('3'))) {
                                /* Multiple Choice Question */
                                $data_to_save[$rec_count][$field] = isset($option_text[$option_id]) ? $option_text[$option_id] . '~' . $option_weightage[$option_id] : ($other_text_response == 'NOTA' ? 'NOTA~' . $nota_weightage[$question_id] : $other_text_response . '~' . $other_weightage[$question_id]);
                            }
                            if (in_array($question_type_id, array('4'))) {
                                /* Single Choice Question */
                                $data_to_save[$rec_count][$field] = $other_text_response == '' ? $option_text[$option_id] . '~' . $option_weightage[$option_id] : ($other_text_response == 'NOTA' ? 'NOTA~' . $nota_weightage[$question_id] : $other_text_response . '~' . $other_weightage[$question_id]);
                            }
                            if (in_array($question_type_id, array('5'))) {
                                /* Date and Time Question */
                                $data_to_save[$rec_count][$field] = $text_response;
                            }
                            if (in_array($question_type_id, array('6'))) {
                                /* Email Question */
                                $data_to_save[$rec_count][$field] = $text_response;
                            }
                            if (in_array($question_type_id, array('7'))) {
                                /* Phone Number Question */
                                $data_to_save[$rec_count][$field] = $text_response;
                            }
                            if (in_array($question_type_id, array('8'))) {
                                /* Dropdown Question */
                                $data_to_save[$rec_count][$field] = isset($option_text[$option_id]) ? $option_text[$option_id] . '~' . $option_weightage[$option_id] : '0';
                            }
                            if (in_array($question_type_id, array('9'))) {
                                /* Number Question */
                                $data_to_save[$rec_count][$field] = $text_response;
                            }
                            if (in_array($question_type_id, array('10'))) {
                                /* Text Response Grid Question */
                                $data_to_save[$rec_count][$field] = $text_response;
                            }
                            if (in_array($question_type_id, array('11'))) {
                                /* Single Choice Grid Question */
                                $field = 'field_' . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_0_0';
                                $data_to_save[$rec_count][$field] = isset($matrix_option_text[$matrix_option_id]) ? $matrix_option_text[$matrix_option_id] . '~' . $matrix_option_weightage[$matrix_option_id] : (isset($option_text[$matrix_option_id]) ? $option_text[$matrix_option_id] : '0');
                            }
                            if (in_array($question_type_id, array('12'))) {
                                /* Multiple Choice Grid Question */
                                $data_to_save[$rec_count][$field] = isset($matrix_option_text[$matrix_option_id]) ? $matrix_option_text[$matrix_option_id] . '~' . $matrix_option_weightage[$matrix_option_id] : (isset($option_text[$matrix_option_id]) ? $option_text[$matrix_option_id] : '0');
                            }
                            if (in_array($question_type_id, array('13'))) {
                                /* Five Point Likert Question */
                                $data_to_save[$rec_count][$field] = $option_text[$option_id] . '~' . $option_weightage[$option_id];
                            }
                            if (in_array($question_type_id, array('14'))) {
                                /* Seven Point Likert Question */
                                $data_to_save[$rec_count][$field] = $option_text[$option_id] . '~' . $option_weightage[$option_id];
                            }
                            if (in_array($question_type_id, array('15'))) {
                                /* N Point Likert Question */
                                $data_to_save[$rec_count][$field] = $option_text[$option_id] . '~' . $option_weightage[$option_id];
                            }
                            if (in_array($question_type_id, array('16'))) {
                                /* Net Promoter Score Question */
                                $data_to_save[$rec_count][$field] = $option_text[$option_id] . '~' . $option_weightage[$option_id];
                            }
                            if (in_array($question_type_id, array('17'))) {
                                /* Rank Order Question */
                                $data_to_save[$rec_count][$field] = $text_response;
                            }
                            if (in_array($question_type_id, array('18'))) {
                                /* Constant Sum Question */
                                $data_to_save[$rec_count][$field] = $text_response;
                            }
                            if (in_array($question_type_id, array('19'))) {
                                /* Image Choice Question */
                            }
                            if (in_array($question_type_id, array('20'))) {
                                /* Slider Question */
                                $data_to_save[$rec_count][$field] = $text_response;
                            }
                            if (in_array($question_type_id, array('21'))) {
                                /* Five Point Emoji Question */
                            }
                            if (in_array($question_type_id, array('22'))) {
                                /* Seven Pont Emoji Question */
                            }
                            if (in_array($question_type_id, array('23'))) {
                                /* NPS with Emoji Question */
                            }
                            if (in_array($question_type_id, array('24'))) {
                                /* Image Upload Question */
                                $data_to_save[$rec_count][$field] = file_exists("./assets/uploads/survey/" . $file_name) ? '<a target="_blank" href="' . site_url("assets/uploads/survey/" . $file_name) . '">Image</a>' : "<span class=\"text-danger font-italic\">No file uploaded</span>";
                            }
                            if (in_array($question_type_id, array('25'))) {
                                /* Bipolar Matrix Question */
                                $data_to_save[$rec_count][$field] = isset($matrix_option_text[$matrix_option_id]) ? $matrix_option_text[$matrix_option_id] . '~' . $matrix_option_weightage[$matrix_option_id] : (isset($option_text[$matrix_option_id]) ? $option_text[$matrix_option_id] : '0');
                            }
                            if (in_array($question_type_id, array('26'))) {
                                /* Semantic Differential Question */
                                $data_to_save[$rec_count][$field] = $text_response;
                            }
                            if (in_array($question_type_id, array('27'))) {
                                /* Star Rating - Single Question */
                                $data_to_save[$rec_count][$field] = $option_id;
                            }
                            if (in_array($question_type_id, array('28'))) {
                                /* Star Rating Grid Question */
                                $data_to_save[$rec_count][$field] = $text_response;
                            }
                            if (in_array($question_type_id, array('29'))) {
                                /* Signature Question */
                                $data_to_save[$rec_count][$field] = file_exists("./assets/uploads/survey/" . $file_name) ? '<a target="_blank" href="' . site_url("assets/uploads/survey/" . $file_name) . '">Image</a>' : "<span class=\"text-danger font-italic\">No file uploaded</span>";
                            }
                            if (in_array($question_type_id, array('30'))) {
                                /* Preset Questions Question */
                            }
                            if (in_array($question_type_id, array('31'))) {
                                /* Essay/Long Answer Question */
                                $data_to_save[$rec_count][$field] = $text_response;
                            }
                            if (in_array($question_type_id, array('32'))) {
                                /* SEC Question */
                                $data_to_save[$rec_count][$field] = $text_response;
                            }
                            if (in_array($question_type_id, array('33'))) {
                                /* Location Question */
                                $data_to_save[$rec_count][$field] = $text_response;
                            }
                        }

                        $data_to_save[$rec_count]['device_id'] = $rawp['device_id'];
                        $data_to_save[$rec_count]['device_name'] = $rawp['device_name'];
                        $data_to_save[$rec_count]['longitude'] = $rawp['longitude'] <> "" && $rawp['lattitude'] <> "" ? '<a target="_blank" href="' . site_url('siteadmin/responses/response_location/' . $rawp['lattitude'] . '/' . $rawp['longitude']) . '">' . $rawp['longitude'] . '</a>' : '';
                        $data_to_save[$rec_count]['latitude'] = $rawp['longitude'] <> "" && $rawp['lattitude'] <> "" ? '<a target="_blank" href="' . site_url('siteadmin/responses/response_location/' . $rawp['lattitude'] . '/' . $rawp['longitude']) . '">' . $rawp['lattitude'] . '</a>' : '';
                        $data_to_save[$rec_count]['api_level'] = $rawp['api_level'];
                        $data_to_save[$rec_count]['app_version'] = $rawp['app_version'];

                        $data_to_save[$rec_count]['unique_code'] = strtoupper(substr($rawp['unique_code'], 0, 10));
                        $data_to_save[$rec_count]['respondent_id'] = $rawp['respondent_id'];
                        $data_to_save[$rec_count]['respondent_code'] = $respondent_code;
                        $data_to_save[$rec_count]['device_type'] = $rawp['device_type'];
                        $data_to_save[$rec_count]['started_on'] = date('h:i A d M, Y', strtotime($rawp['started_on']));
                        $data_to_save[$rec_count]['ended_on'] = $rawp['ended_on'] <> "0000-00-00 00:00:00" ? date('h:i A d M, Y', strtotime($rawp['ended_on'])) : "";

                        $datetime1 = new DateTime(date('Y-m-d H:i:s', strtotime($rawp['started_on'])));
                        $datetime2 = new DateTime(date('Y-m-d H:i:s', strtotime($rawp['ended_on'])));
                        $interval = $datetime2->diff($datetime1);
                        $data_to_save[$rec_count]['duration'] = $rawp['ended_on'] <> "0000-00-00 00:00:00" ? $interval->format('%H Hrs | %i Mins | %s Sec') : "";
                        $data_to_save[$rec_count]['ip_address'] = $rawp['ip_address'];
                        $data_to_save[$rec_count]['tracking_code'] = $rawp['tracking_code'];

                        $data_to_save[$rec_count]['accept_status'] = $rawp['status'] == 1 ? '<span class="text-accept-' . $respondent_code . '">Accepted</span>' : '<a title="Accepted" class="accept-response accept-' . $respondent_code . '" data-respondent-code="' . $respondent_code . '"><i class="fas fa-check mr-2 teal-text" aria-hidden="true"></i></a>';
                        $data_to_save[$rec_count]['reject_status'] = $rawp['status'] == 5 ? '<span class="text-reject-' . $respondent_code . '">Rejected</span>' : '<a title="Rejected" class="reject-response reject-' . $respondent_code . '" data-respondent-code="' . $respondent_code . '"><i class="fas fa-trash mr-2 text-danger" aria-hidden="true"></i></a>';
                        $data_to_save[$rec_count]['flag_status'] = $rawp['status'] == 2 ? '<span class="text-flag-' . $respondent_code . '">Flagged</span>' : '<a title="Note" class="flag-response flag-' . $respondent_code . '" data-respondent-code="' . $respondent_code . '"><i class="fas fa-check mr-2 text-warning" aria-hidden="true"></i></a>';
                        //$data_to_save[$rec_count]['note'] = in_array($rawp['status'], array(2, 5)) ? '<span class="flag-note-' . $respondent_code . '">' . $rawp['note'] . '</span>' : '<span class="flag-note"></span>';
                        $data_to_save[$rec_count]['note'] = in_array($rawp['status'], array(2, 5)) ? (($rawp['note'] <> NULL) ? $rawp['note'] : '<span class="flag-note-' . $respondent_code . '"></span>') : '<span class="flag-note-' . $respondent_code . '"></span>';
                        $data_to_save[$rec_count]['enumerator'] = $rawp['enumerator_name'];
                        $data_to_save[$rec_count]['survey_status'] = $rawp['status'];
                        $data_to_save[$rec_count]['team'] = $rawp['team_code'];
                        
                        //$resp = $this->save($p_table = $temp_table, $p_key = 'id', $data_array = $data_to_save[$rec_count], $cond = NULL, $debug = FALSE);
                    }
                }
                $this->save_batch($p_table = $temp_table, $p_key = 'id', $data_array = array_values($data_to_save), $cond = NULL, $debug = FALSE);
            }
            if ($block_count == count($blocks)) {
                $sql = 'UPDATE `survey_respondents` SET `is_copied_to_temp_table` = \'1\' WHERE `survey_id` = \''.$survey_id.'\' AND `is_copied_to_temp_table` = \'0\'';
                $this->db->query($sql);
            }
            $block_count++;
        }
        /* INSERT DATA IF LEFT ENDS */

        if ($no_reply == FALSE) {
            if(isset($blocks)){
                foreach ($blocks as $block_row) {
                    $block_id = $block_row['block_id'];
                    $temp_table = 'temp_report_' . $survey_id . '_' . $block_id;
                    $data[$block_id] = $this->fetch($p_table = $temp_table, $p_key = 'id', $cond_and = array(), $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = 0, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);
                }
                return $data;
            }
        } else {
            return TRUE;
        }
    }
    
    /**
     * ROSTER TEMP TABLE
     * 29 12 2020 12 45
     * SANDIP
     */
    public function generate_temp_roster_table($by_force = FALSE, $survey_code = '0', $survey_id = '0', $no_reply = TRUE) {
        if ($survey_code <> '0' && $survey_id <> '0') {

            $this->load->dbforge();
            /* GET QUESTIONS BY SURVEY ID STARTS */
            $cond_and = array('status' => '1');
            $join_logic = array();
            $join_logic[0] = array('first_table' => 'block_questions', 'join_on' => 'block_questions.question_id = questions.id', 'join_type' => 'inner', 'join_select' => array('block_questions.block_id', 'block_questions.question_id'), 'join_condition' => array('block_questions.status' => '1'));
            $join_logic[1] = array('first_table' => 'blocks', 'join_on' => 'block_questions.block_id = blocks.id', 'join_type' => 'inner', 'join_select' => array('blocks.encrypted_code as block_encrypted_code, blocks.name as block_name, blocks.page_number, blocks.description, blocks.is_roster'), 'join_condition' => array('blocks.status' => '1'));
            $join_logic[2] = array('first_table' => 'surveys', 'join_on' => 'surveys.id = blocks.survey_id', 'join_type' => 'inner', 'join_select' => array('surveys.encrypted_code as survey_encrypted_code'), 'join_condition' => array('surveys.encrypted_code' => $survey_code));
            $join_logic[3] = array('first_table' => 'question_details', 'join_on' => 'question_details.question_id = questions.id', 'join_type' => 'inner', 'join_select' => array('question_details.question_id, question_details.question_type_id, question_details.question_sum, question_details.is_other_text, question_details.other_text_name, question_details.is_none_of_the_above, question_details.data_label, question_details.question_code, question_details.is_mandatory, question_details.question_sum, question_details.upper_limit, question_details.lower_limit, question_details.limit_interval, question_details.question_code, question_details.is_other_text, question_details.other_text_name, question_details.data_label, question_details.other_text_weightage, question_details.none_of_the_above_weightage'));
            $join_logic[4] = array('first_table' => 'options', 'join_on' => 'options.question_id = questions.id', 'join_type' => 'left', 'join_select' => array('options.encrypted_code as option_encrypted_code, options.id as option_id, options.name as option_name, options.lower_label_text, options.upper_label_text, options.option_weightage'));
            $join_logic[5] = array('first_table' => 'matrix_options', 'join_on' => 'matrix_options.question_id = questions.id', 'join_type' => 'left', 'join_select' => array('matrix_options.id as matrix_option_id', 'matrix_options.name as matrix_option_name, matrix_options.option_weightage as matrix_option_weightage'));
            $join_logic[6] = array('first_table' => 'question_types', 'join_on' => 'question_types.id = question_details.question_type_id', 'join_type' => 'inner', 'join_select' => array('question_types.encrypted_code as question_type_encrypted_code, question_types.name as question_type'), 'join_condition' => array('question_types.status' => '1'));
            $all_questions = $this->fetch($p_table = 'questions', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('blocks.block_order' => 'ASC', 'block_questions.question_order ' => 'ASC', 'options.option_order' => 'ASC'), $limit = NULL, $offset = 0, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);
            
            if(isset($all_questions)){
                foreach($all_questions as $aq_row){
                    if($aq_row['is_roster'] == '1'){
                        $blocks[$aq_row['block_id']] = $aq_row;
                    }
                }
            }
            
            $cnt = 0;
            if(isset($blocks)){
                foreach ($blocks as $block_row) {
                    $block_id = $block_row['block_id'];
                    $table_report = 'temp_report_' . $survey_id . '_' . $block_id;
                    $roster_table_report = 'temp_roster_report_' . $survey_id . '_' . $block_id;

                    /* GET QUESTIONS BY SURVEY ID STARTS */
                    $results = array();
                    $parent_child = array();
                    $field = array();
                    if (isset($all_questions)) {
                        foreach ($all_questions as $question) {
                            if($question['block_id'] == $block_id){
                                $results[$question['block_id']]['block_id'] = $question['block_id'];
                                $results[$question['block_id']]['name'] = $question['block_name'];

                                $results[$question['block_id']]['questions'][$question['question_id']]['question_id'] = $question['id'];
                                $results[$question['block_id']]['questions'][$question['question_id']]['name'] = $question['name'];
                                $results[$question['block_id']]['questions'][$question['question_id']]['question_type_id'] = $question['question_type_id'];
                                $results[$question['block_id']]['questions'][$question['question_id']]['question_sum'] = $question['question_sum'];
                                $results[$question['block_id']]['questions'][$question['question_id']]['is_none_of_the_above'] = $question['is_none_of_the_above'];
                                $results[$question['block_id']]['questions'][$question['question_id']]['is_other_text'] = $question['is_other_text'];
                                $results[$question['block_id']]['questions'][$question['question_id']]['other_text_name'] = $question['other_text_name'];
                                $results[$question['block_id']]['questions'][$question['question_id']]['data_label'] = $question['data_label'];
                                $results[$question['block_id']]['questions'][$question['question_id']]['question_code'] = $question['question_code'];

                                if (isset($question['option_id'])) {
                                    $results[$question['block_id']]['questions'][$question['question_id']]['options'][$question['option_id']]['option_id'] = $question['option_id'];
                                    $results[$question['block_id']]['questions'][$question['question_id']]['options'][$question['option_id']]['name'] = $question['option_name'];
                                    if (strpos($question['option_name'], '[[') !== false) {
                                        // TEXT PIPING IS AVAILABLE
                                        preg_match_all('/\[{2}ID(.*?)\]{2}/is', $question['option_name'], $match);
                                        foreach ($match[1] as $dy) {
                                            $parent_child[] = $dy;
                                        }
                                    }
                                }

                                if (isset($question['matrix_option_id'])) {
                                    $results[$question['block_id']]['questions'][$question['question_id']]['matrix_options'][$question['matrix_option_id']]['matrix_option_id'] = $question['matrix_option_id'];
                                    $results[$question['block_id']]['questions'][$question['question_id']]['matrix_options'][$question['matrix_option_id']]['name'] = $question['matrix_option_name'];
                                    if (strpos($question['matrix_option_name'], '[[') !== false) {
                                        // TEXT PIPING IS AVAILABLE
                                        preg_match_all('/\[{2}ID(.*?)\]{2}/is', $question['matrix_option_name'], $match);
                                        foreach ($match[1] as $dy) {
                                            $parent_child[] = $dy;
                                        }
                                    }
                                }

                                if ($question['is_other_text'] == '1') {
                                    $results[$question['block_id']]['questions'][$question['question_id']]['options']['0']['option_id'] = '0';
                                    $results[$question['block_id']]['questions'][$question['question_id']]['options']['0']['name'] = $question['other_text_name'] <> '' ? $question['other_text_name'] : 'Other';
                                }
                            }
                        }
                    }
                    
                    $pc_questions = array();
                    $pc_qids = array();
                    $pc_question_details = array();
                    if (count($parent_child) > 0) {
                        $parent_child = array_unique($parent_child);
                        $pc_qids = $parent_child;
                        if (isset($all_questions)) {
                            foreach ($all_questions as $question_row) {
                                if(in_array($question_row['question_code'], $parent_child)){
                                    $pc_questions[$question_row['question_code']][] = $question_row;
                                }
                            }
                        }

                        foreach ($pc_questions as $question_code => $questions) {
                            foreach ($questions as $question) {
                                if (isset($question['option_id'])) {
                                    $pc_question_details[$question['question_code']][$question['option_id']]['page_number'] = $question['page_number'];
                                    $pc_question_details[$question['question_code']][$question['option_id']]['is_other_text'] = $question['is_other_text'];
                                    $pc_question_details[$question['question_code']][$question['option_id']]['other_text_name'] = $question['other_text_name'];
                                    $pc_question_details[$question['question_code']][$question['option_id']]['question_type_encrypted_code'] = $question['question_type_encrypted_code'];
                                    $pc_question_details[$question['question_code']][$question['option_id']]['question_encrypted_code'] = $question['encrypted_code'];
                                    $pc_question_details[$question['question_code']][$question['option_id']]['encrypted_code'] = $question['option_encrypted_code'];
                                    $pc_question_details[$question['question_code']][$question['option_id']]['name'] = $question['option_name'];
                                    $pc_question_details[$question['question_code']][$question['option_id']]['question_id'] = $question['question_id'];
                                }
                            }
                        }
                    }
                    /* GET QUESTIONS BY SURVEY ID ENDS */

                    /* GENERATE TABLE WITH STRUCTURE STARTS */
                    if ($by_force == TRUE || !$this->db->table_exists($roster_table_report)) {

                        $data_row_1 = array();
                        $data_row_1['unique_code'] = 'Unique Code';
                        $data_row_1['respondent_id'] = 'ResID';
                        $data_row_1['roster_id'] = 'Roster ID';
                        $data_row_1['parent_roster_id'] = 'Reference Roster ID';
                        $data_row_1['enumerator'] = 'Enumerator Name';
                        $data_row_1['team'] = 'Team';
                        $data_row_1['accept_status'] = 'Accpeted';
                        $data_row_1['reject_status'] = 'Rejected';
                        $data_row_1['flag_status'] = 'Flagged';
                        $data_row_1['note'] = 'Note';
                        $data_row_1['device_type'] = 'Device Type';
                        $data_row_1['respondent_code'] = 'Respondent';
                        $data_row_1['started_on'] = 'Started';
                        $data_row_1['ended_on'] = 'Ended';
                        $data_row_1['duration'] = 'Duration';
                        $data_row_1['ip_address'] = 'IP Address';
                        $data_row_1['tracking_code'] = 'Tracking Code';
                        $data_row_1['device_id'] = 'Device ID';
                        $data_row_1['device_name'] = 'Device Name';
                        $data_row_1['latitude'] = 'Latitude';
                        $data_row_1['longitude'] = 'Longitude';    
                        $data_row_1['api_level'] = 'API Level';
                        $data_row_1['app_version'] = 'App Version';
                        $data_row_1['survey_status'] = 'Survey Status';

                        $i = count($data_row_1) + 1;
                        $static_part = 'field_';
                        foreach ($results as $block_id => $details) {
                            foreach ($details['questions'] as $question_id => $question_details) {
                                $question_id = $question_details['question_id'];
                                $question_type_id = $question_details['question_type_id'];
                                $question_text = $question_details['name'];
                                $data_label_text = trim($question_details['data_label']) == "" ? $question_details['question_code'] . '-' . substr(str_replace(array(" ", "  "), "-", trim($question_text)), 0, 20) : trim($question_details['data_label']);
                                $option_id = '0';
                                $matrix_option_id = '0';
                                $row_question_id = '0';
                                $column_question_id = '0';

                                if (in_array($question_type_id, array('1'))) {
                                    /* Dichotomous Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                            $i++;
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('2'))) {
                                    /* Text Response Question */
                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text;
                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                    $i++;
                                }
                                if (in_array($question_type_id, array('3'))) {
                                    /* Multiple Choice Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                            $i++;
                                        }
                                    }

                                    if ($question_details['is_other_text'] == '1') {
                                        $option_text = trim($question_details['other_text_name']) == '' ? 'Other' : $question_details['other_text_name'];
                                        $option_id = '0';
                                        $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                        $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                        $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                        $i++;
                                    }
                                    if ($question_details['is_none_of_the_above'] == '1') {
                                        $option_text = 'NOTA';
                                        $option_id = '-1';
                                        $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                        $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                        $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                        $i++;
                                    }
                                }
                                if (in_array($question_type_id, array('4'))) {
                                    /* Single Choice Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                            $i++;
                                        }
                                    }
                                    if ($question_details['is_other_text'] == '1') {
                                        $option_text = trim($question_details['other_text_name']) == '' ? 'Other' : $question_details['other_text_name'];
                                        $option_id = '0';
                                        $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                        $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                        $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                        $i++;
                                    }
                                }
                                if (in_array($question_type_id, array('5'))) {
                                    /* Date and Time Question */
                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text;
                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                    $i++;
                                }
                                if (in_array($question_type_id, array('6'))) {
                                    /* Email Question */
                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text;
                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                    $i++;
                                }
                                if (in_array($question_type_id, array('7'))) {
                                    /* Phone Number Question */
                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text;
                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                    $i++;
                                }
                                if (in_array($question_type_id, array('8'))) {
                                    /* Dropdown Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                            $i++;
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('9'))) {
                                    /* Number Question */
                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text;
                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                    $i++;
                                }
                                if (in_array($question_type_id, array('10'))) {
                                    /* Text Response Grid Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $row_question_id = '0';
                                            $column_question_id = '0';
                                            if (strpos($option_text, '[[') === false) {
                                                /* IF PARENT CHILD ROW IS NOT PRESENT STARTS */
                                                foreach ($question_details['matrix_options'] as $matrix_option_id => $matrix_option_details) {
                                                    $matrix_option_text = $matrix_option_details['name'];
                                                    $section_count = 0;
                                                    if (strpos($matrix_option_text, '[[') === false) {
                                                        /* IF PARENT CHILD COLUMN IS NOT PRESENT STARTS */
                                                        $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                        $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $matrix_option_text;
                                                        $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                        $i++;
                                                        $section_count++;
                                                        /* IF PARENT CHILD COLUMN IS NOT PRESENT ENDS */
                                                    } else {
                                                        /* IF PARENT CHILD COLUMN IS PRESENT STARTS */
                                                        preg_match_all('/\[{2}ID(.*?)\]{2}/is', $matrix_option_text, $match);
                                                        foreach ($match[1] as $dynamic_row) {
                                                            $section_count = 0;
                                                            foreach ($pc_question_details[$dynamic_row] as $dynamic_matrix_option_id => $pc_details) {
                                                                $dynamic_matrix_option_text = $pc_details['name'];
                                                                $dynamic_column_question_id = $pc_details['question_id'];
                                                                $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $dynamic_matrix_option_id . '_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $dynamic_matrix_option_text;
                                                                $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                $i++;
                                                                $section_count++;

                                                                if ($pc_details['is_other_text'] == '1' && count($pc_question_details[$dynamic_row]) == $section_count) {
                                                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $pc_details['other_text_name'];
                                                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                    $i++;
                                                                }
                                                            }
                                                        }
                                                        /* IF PARENT CHILD COLUMN IS PRESENT ENDS */
                                                    }
                                                }
                                                /* IF PARENT CHILD ROW IS NOT PRESENT ENDS */
                                            } else {
                                                /* IF PARENT CHILD ROW IS  PRESENT STARTS */
                                                preg_match_all('/\[{2}ID(.*?)\]{2}/is', $option_text, $match);
                                                foreach ($match[1] as $dynamic_row) {
                                                    $section_count = 0;
                                                    foreach ($pc_question_details[$dynamic_row] as $option_id => $pco_details) {
                                                        $option_text = $pco_details['name'];
                                                        $row_question_id = $pco_details['question_id'];
                                                        $is_other_text = $pco_details['is_other_text'];
                                                        $other_text_name = $pco_details['other_text_name'];

                                                        foreach ($question_details['matrix_options'] as $matrix_option_id => $matrix_option_details) {
                                                            $matrix_option_text = $matrix_option_details['name'];
                                                            $section_count = 0;
                                                            if (strpos($matrix_option_text, '[[') === false) {
                                                                /* IF PARENT CHILD COLUMN IS NOT PRESENT STARTS */
                                                                $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                                $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $matrix_option_text;
                                                                $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                $i++;
                                                                $section_count++;
                                                                /* IF PARENT CHILD COLUMN IS NOT PRESENT ENDS */
                                                            } else {
                                                                /* IF PARENT CHILD COLUMN IS PRESENT STARTS */
                                                                preg_match_all('/\[{2}ID(.*?)\]{2}/is', $matrix_option_text, $match);
                                                                foreach ($match[1] as $dynamic_row) {
                                                                    $section_count = 0;
                                                                    foreach ($pc_question_details[$dynamic_row] as $dynamic_matrix_option_id => $pc_details) {
                                                                        $dynamic_matrix_option_text = $pc_details['name'];
                                                                        $dynamic_column_question_id = $pc_details['question_id'];
                                                                        $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $dynamic_matrix_option_id . '_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                        $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $dynamic_matrix_option_text;
                                                                        $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                        $i++;
                                                                        $section_count++;

                                                                        if ($pc_details['is_other_text'] == '1' && count($pc_question_details[$dynamic_row]) == $section_count) {
                                                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $pc_details['other_text_name'];
                                                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                            $i++;
                                                                        }
                                                                    }
                                                                }
                                                                /* IF PARENT CHILD COLUMN IS PRESENT ENDS */
                                                            }
                                                        }
                                                        if ($is_other_text == '1') {
                                                            $option_id = '0';
                                                            $option_text = $other_text_name;
                                                            foreach ($question_details['matrix_options'] as $matrix_option_id => $matrix_option_details) {
                                                                $matrix_option_text = $matrix_option_details['name'];
                                                                $section_count = 0;
                                                                if (strpos($matrix_option_text, '[[') === false) {
                                                                    /* IF PARENT CHILD COLUMN IS NOT PRESENT STARTS */
                                                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $matrix_option_text;
                                                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                    $i++;
                                                                    $section_count++;
                                                                    /* IF PARENT CHILD COLUMN IS NOT PRESENT ENDS */
                                                                } else {
                                                                    /* IF PARENT CHILD COLUMN IS PRESENT STARTS */
                                                                    preg_match_all('/\[{2}ID(.*?)\]{2}/is', $matrix_option_text, $match);
                                                                    foreach ($match[1] as $dynamic_row) {
                                                                        $section_count = 0;
                                                                        foreach ($pc_question_details[$dynamic_row] as $dynamic_matrix_option_id => $pc_details) {
                                                                            $dynamic_matrix_option_text = $pc_details['name'];
                                                                            $dynamic_column_question_id = $pc_details['question_id'];
                                                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $dynamic_matrix_option_id . '_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $dynamic_matrix_option_text;
                                                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                            $i++;
                                                                            $section_count++;

                                                                            if ($pc_details['is_other_text'] == '1' && count($pc_question_details[$dynamic_row]) == $section_count) {
                                                                                $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                                $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $pc_details['other_text_name'];
                                                                                $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                                $i++;
                                                                            }
                                                                        }
                                                                    }
                                                                    /* IF PARENT CHILD COLUMN IS PRESENT ENDS */
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                /* IF PARENT CHILD ROW IS PRESENT ENDS */
                                            }
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('11'))) {
                                    /* Single Choice Grid Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $row_question_id = '0';
                                            $column_question_id = '0';

                                            if (strpos($option_text, '[[') === false) {
                                                /* IF PARENT CHILD ROW IS NOT PRESENT STARTS */
                                                if (isset($question_details['matrix_options'])) {
                                                    foreach ($question_details['matrix_options'] as $matrix_option_id => $matrix_option_details) {
                                                        $matrix_option_text = $matrix_option_details['name'];
                                                        $section_count = 0;
                                                        if (strpos($matrix_option_text, '[[') === false) {
                                                            /* IF PARENT CHILD COLUMN IS NOT PRESENT STARTS */
                                                            //$field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_0_0';
                                                            //$data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $matrix_option_text;
                                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                            $i++;
                                                            $section_count++;
                                                            /* IF PARENT CHILD COLUMN IS NOT PRESENT ENDS */
                                                        } else {
                                                            /* IF PARENT CHILD COLUMN IS PRESENT STARTS */
                                                            preg_match_all('/\[{2}ID(.*?)\]{2}/is', $matrix_option_text, $match);
                                                            foreach ($match[1] as $dynamic_row) {
                                                                $section_count = 0;
                                                                foreach ($pc_question_details[$dynamic_row] as $dynamic_matrix_option_id => $pc_details) {
                                                                    $dynamic_matrix_option_text = $pc_details['name'];
                                                                    $dynamic_column_question_id = $pc_details['question_id'];
                                                                    //$field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $dynamic_matrix_option_id . '_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_0_0';
                                                                    //$data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $dynamic_matrix_option_text;
                                                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                    $i++;
                                                                    $section_count++;

                                                                    if ($pc_details['is_other_text'] == '1' && count($pc_question_details[$dynamic_row]) == $section_count) {
                                                                        //$field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                        $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_0_0';
                                                                        //$data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $pc_details['other_text_name'];
                                                                        $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                                                        $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                        $i++;
                                                                    }
                                                                }
                                                            }
                                                            /* IF PARENT CHILD COLUMN IS PRESENT ENDS */
                                                        }
                                                    }
                                                }
                                                /* IF PARENT CHILD ROW IS NOT PRESENT ENDS */
                                            } else {
                                                /* IF PARENT CHILD ROW IS  PRESENT STARTS */
                                                preg_match_all('/\[{2}ID(.*?)\]{2}/is', $option_text, $match);
                                                foreach ($match[1] as $dynamic_row) {
                                                    $section_count = 0;
                                                    foreach ($pc_question_details[$dynamic_row] as $option_id => $pco_details) {
                                                        $option_text = $pco_details['name'];
                                                        $other_row_question_id = $pco_details['question_id'];
                                                        $is_other_text = $pco_details['is_other_text'];
                                                        $other_text_name = $pco_details['other_text_name'];
                                                        $row_question_id = $other_row_question_id;

                                                        foreach ($question_details['matrix_options'] as $matrix_option_id => $matrix_option_details) {
                                                            $matrix_option_text = $matrix_option_details['name'];
                                                            $section_count = 0;
                                                            if (strpos($matrix_option_text, '[[') === false) {
                                                                /* IF PARENT CHILD COLUMN IS NOT PRESENT STARTS */
                                                                //$field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                                $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_0_0';
                                                                //$data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $matrix_option_text;
                                                                $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                                                $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                $i++;
                                                                $section_count++;
                                                                /* IF PARENT CHILD COLUMN IS NOT PRESENT ENDS */
                                                            } else {
                                                                /* IF PARENT CHILD COLUMN IS PRESENT STARTS */
                                                                preg_match_all('/\[{2}ID(.*?)\]{2}/is', $matrix_option_text, $match);
                                                                foreach ($match[1] as $dynamic_row) {
                                                                    $section_count = 0;
                                                                    foreach ($pc_question_details[$dynamic_row] as $dynamic_matrix_option_id => $pc_details) {
                                                                        $dynamic_matrix_option_text = $pc_details['name'];
                                                                        $dynamic_column_question_id = $pc_details['question_id'];
                                                                        //$field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $dynamic_matrix_option_id . '_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                        $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_0_0';
                                                                        //$data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $dynamic_matrix_option_text;
                                                                        $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                                                        $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                        $i++;
                                                                        $section_count++;

                                                                        if ($pc_details['is_other_text'] == '1' && count($pc_question_details[$dynamic_row]) == $section_count) {
                                                                            //$field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_0_0';
                                                                            //$data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $pc_details['other_text_name'];
                                                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                            $i++;
                                                                        }
                                                                    }
                                                                }
                                                                /* IF PARENT CHILD COLUMN IS PRESENT ENDS */
                                                            }
                                                        }
                                                        if ($is_other_text == '1') {
                                                            $option_id = '0';
                                                            $row_question_id = $other_row_question_id;
                                                            $option_text = $other_text_name;
                                                            foreach ($question_details['matrix_options'] as $matrix_option_id => $matrix_option_details) {
                                                                $matrix_option_text = $matrix_option_details['name'];
                                                                $section_count = 0;
                                                                if (strpos($matrix_option_text, '[[') === false) {
                                                                    /* IF PARENT CHILD COLUMN IS NOT PRESENT STARTS */
                                                                    //$field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_0_0';
                                                                    //$data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $matrix_option_text;
                                                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                    $i++;
                                                                    $section_count++;
                                                                    /* IF PARENT CHILD COLUMN IS NOT PRESENT ENDS */
                                                                } else {
                                                                    /* IF PARENT CHILD COLUMN IS PRESENT STARTS */
                                                                    preg_match_all('/\[{2}ID(.*?)\]{2}/is', $matrix_option_text, $match);
                                                                    foreach ($match[1] as $dynamic_row) {
                                                                        $section_count = 0;
                                                                        foreach ($pc_question_details[$dynamic_row] as $dynamic_matrix_option_id => $pc_details) {
                                                                            $dynamic_matrix_option_text = $pc_details['name'];
                                                                            $dynamic_column_question_id = $pc_details['question_id'];
                                                                            //$field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $dynamic_matrix_option_id . '_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_0_0';
                                                                            //$data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $dynamic_matrix_option_text;
                                                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                            $i++;
                                                                            $section_count++;

                                                                            if ($pc_details['is_other_text'] == '1' && count($pc_question_details[$dynamic_row]) == $section_count) {
                                                                                //$field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                                $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_0_0';
                                                                                //$data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $pc_details['other_text_name'];
                                                                                $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                                                                $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                                $i++;
                                                                            }
                                                                        }
                                                                    }
                                                                    /* IF PARENT CHILD COLUMN IS PRESENT ENDS */
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                /* IF PARENT CHILD ROW IS PRESENT ENDS */
                                            }
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('12'))) {
                                    /* Multiple Choice Grid Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $row_question_id = '0';
                                            $column_question_id = '0';

                                            if (strpos($option_text, '[[') === false) {
                                                /* IF PARENT CHILD ROW IS NOT PRESENT STARTS */
                                                foreach ($question_details['matrix_options'] as $matrix_option_id => $matrix_option_details) {
                                                    $matrix_option_text = $matrix_option_details['name'];
                                                    $section_count = 0;
                                                    if (strpos($matrix_option_text, '[[') === false) {
                                                        /* IF PARENT CHILD COLUMN IS NOT PRESENT STARTS */
                                                        $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                        $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $matrix_option_text;
                                                        $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                        $i++;
                                                        $section_count++;
                                                        /* IF PARENT CHILD COLUMN IS NOT PRESENT ENDS */
                                                    } else {
                                                        /* IF PARENT CHILD COLUMN IS PRESENT STARTS */
                                                        preg_match_all('/\[{2}ID(.*?)\]{2}/is', $matrix_option_text, $match);
                                                        foreach ($match[1] as $dynamic_row) {
                                                            $section_count = 0;
                                                            foreach ($pc_question_details[$dynamic_row] as $dynamic_matrix_option_id => $pc_details) {
                                                                $dynamic_matrix_option_text = $pc_details['name'];
                                                                $dynamic_column_question_id = $pc_details['question_id'];
                                                                $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $dynamic_matrix_option_id . '_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $dynamic_matrix_option_text;
                                                                $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                $i++;
                                                                $section_count++;

                                                                if ($pc_details['is_other_text'] == '1' && count($pc_question_details[$dynamic_row]) == $section_count) {
                                                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $pc_details['other_text_name'];
                                                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                    $i++;
                                                                }
                                                            }
                                                        }
                                                        /* IF PARENT CHILD COLUMN IS PRESENT ENDS */
                                                    }
                                                }
                                                /* IF PARENT CHILD ROW IS NOT PRESENT ENDS */
                                            } else {
                                                /* IF PARENT CHILD ROW IS  PRESENT STARTS */
                                                preg_match_all('/\[{2}ID(.*?)\]{2}/is', $option_text, $match);
                                                foreach ($match[1] as $dynamic_row) {
                                                    $section_count = 0;
                                                    foreach ($pc_question_details[$dynamic_row] as $option_id => $pco_details) {
                                                        $option_text = $pco_details['name'];
                                                        $other_row_question_id = $pco_details['question_id'];
                                                        $is_other_text = $pco_details['is_other_text'];
                                                        $other_text_name = $pco_details['other_text_name'];
                                                        $row_question_id = $other_row_question_id;

                                                        $total_section_count = 0;
                                                        foreach ($question_details['matrix_options'] as $matrix_option_id => $matrix_option_details) {
                                                            $matrix_option_text = $matrix_option_details['name'];
                                                            $section_count = 0;
                                                            if (strpos($matrix_option_text, '[[') === false) {
                                                                /* IF PARENT CHILD COLUMN IS NOT PRESENT STARTS */
                                                                $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                                $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $matrix_option_text;
                                                                $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                $i++;
                                                                $section_count++;

                                                                $total_section_count++;
                                                                if ($is_other_text == '1') {
                                                                    $other_option_id = '0';
                                                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $other_option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $other_text_name . '_' . $matrix_option_text;
                                                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                    $i++;
                                                                }
                                                                /* IF PARENT CHILD COLUMN IS NOT PRESENT ENDS */
                                                            } else {
                                                                /* IF PARENT CHILD COLUMN IS PRESENT STARTS */
                                                                preg_match_all('/\[{2}ID(.*?)\]{2}/is', $matrix_option_text, $match);
                                                                foreach ($match[1] as $dynamic_row) {
                                                                    $section_count = 0;
                                                                    foreach ($pc_question_details[$dynamic_row] as $dynamic_matrix_option_id => $pc_details) {
                                                                        $dynamic_matrix_option_text = $pc_details['name'];
                                                                        $dynamic_column_question_id = $pc_details['question_id'];
                                                                        $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $dynamic_matrix_option_id . '_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                        $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $dynamic_matrix_option_text;
                                                                        $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                        $i++;
                                                                        $section_count++;

                                                                        if ($pc_details['is_other_text'] == '1' && count($pc_question_details[$dynamic_row]) == $section_count) {
                                                                            //echo $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_'.$row_question_id.'_' . $dynamic_column_question_id . ' <br />';
                                                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $pc_details['other_text_name'];
                                                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                            $i++;
                                                                        }
                                                                    }
                                                                }
                                                                /* IF PARENT CHILD COLUMN IS PRESENT ENDS */
                                                            }
                                                        }
                                                        if ($is_other_text == '1') {
                                                            $option_id = '0';
                                                            $row_question_id = $other_row_question_id;
                                                            $option_text = $other_text_name;
                                                            foreach ($question_details['matrix_options'] as $matrix_option_id => $matrix_option_details) {
                                                                $matrix_option_text = $matrix_option_details['name'];
                                                                $section_count = 0;
                                                                if (strpos($matrix_option_text, '[[') === false) {
                                                                    /* IF PARENT CHILD COLUMN IS NOT PRESENT STARTS */
                                                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $matrix_option_text;
                                                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                    $i++;
                                                                    $section_count++;
                                                                    /* IF PARENT CHILD COLUMN IS NOT PRESENT ENDS */
                                                                } else {
                                                                    /* IF PARENT CHILD COLUMN IS PRESENT STARTS */
                                                                    preg_match_all('/\[{2}ID(.*?)\]{2}/is', $matrix_option_text, $match);
                                                                    foreach ($match[1] as $dynamic_row) {
                                                                        $section_count = 0;
                                                                        foreach ($pc_question_details[$dynamic_row] as $dynamic_matrix_option_id => $pc_details) {
                                                                            $dynamic_matrix_option_text = $pc_details['name'];
                                                                            $dynamic_column_question_id = $pc_details['question_id'];
                                                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $dynamic_matrix_option_id . '_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $dynamic_matrix_option_text;
                                                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                            $i++;
                                                                            $section_count++;

                                                                            if ($pc_details['is_other_text'] == '1' && count($pc_question_details[$dynamic_row]) == $section_count) {
                                                                                $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                                $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $pc_details['other_text_name'];
                                                                                $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                                $i++;
                                                                            }
                                                                        }
                                                                    }
                                                                    /* IF PARENT CHILD COLUMN IS PRESENT ENDS */
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                /* IF PARENT CHILD ROW IS PRESENT ENDS */
                                            }
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('13'))) {
                                    /* Five Point Likert Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                            $i++;
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('14'))) {
                                    /* Seven Point Likert Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                            $i++;
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('15'))) {
                                    /* N Point Likert Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                            $i++;
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('16'))) {
                                    /* Net Promoter Score Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                            $i++;
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('17'))) {
                                    /* Rank Order Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                            $i++;
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('18'))) {
                                    /* Constant Sum Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                            $i++;
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('19'))) {
                                    /* Image Choice Question */
                                }
                                if (in_array($question_type_id, array('20'))) {
                                    /* Slider Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                            $i++;
                                        }
                                    }else{
                                        $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                        $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text;
                                        $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                        $i++;
                                    }
                                }
                                if (in_array($question_type_id, array('21'))) {
                                    /* Five Point Emoji Question */
                                }
                                if (in_array($question_type_id, array('22'))) {
                                    /* Seven Pont Emoji Question */
                                }
                                if (in_array($question_type_id, array('23'))) {
                                    /* NPS with Emoji Question */
                                }
                                if (in_array($question_type_id, array('24'))) {
                                    /* Image Upload Question */
                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text;
                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                    $i++;
                                }
                                if (in_array($question_type_id, array('25'))) {
                                    /* Bipolar Matrix Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            /* IF PARENT CHILD ROW IS NOT PRESENT STARTS */
                                            foreach ($question_details['matrix_options'] as $matrix_option_id => $matrix_option_details) {
                                                $matrix_option_text = $matrix_option_details['name'];
                                                $section_count = 0;
                                                /* IF PARENT CHILD COLUMN IS NOT PRESENT STARTS */
                                                $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $matrix_option_text;
                                                $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                $i++;
                                                $section_count++;
                                                /* IF PARENT CHILD COLUMN IS NOT PRESENT ENDS */
                                            }
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('26'))) {
                                    /* Semantic Differential Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                            $i++;
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('27'))) {
                                    /* Star Rating - Single Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text;
                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                            $i++;
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('28'))) {
                                    /* Star Rating Grid Question */
                                    if (isset($question_details['options'])) {
                                        foreach ($question_details['options'] as $option_id => $option_details) {
                                            $option_text = $option_details['name'];
                                            $row_question_id = '0';
                                            $column_question_id = '0';

                                            if (strpos($option_text, '[[') === false) {
                                                /* IF PARENT CHILD ROW IS NOT PRESENT STARTS */
                                                foreach ($question_details['matrix_options'] as $matrix_option_id => $matrix_option_details) {
                                                    $matrix_option_text = $matrix_option_details['name'];
                                                    $section_count = 0;
                                                    if (strpos($matrix_option_text, '[[') === false) {
                                                        /* IF PARENT CHILD COLUMN IS NOT PRESENT STARTS */
                                                        $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                        $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $matrix_option_text;
                                                        $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                        $i++;
                                                        $section_count++;
                                                        /* IF PARENT CHILD COLUMN IS NOT PRESENT ENDS */
                                                    } else {
                                                        /* IF PARENT CHILD COLUMN IS PRESENT STARTS */
                                                        preg_match_all('/\[{2}ID(.*?)\]{2}/is', $matrix_option_text, $match);
                                                        foreach ($match[1] as $dynamic_row) {
                                                            $section_count = 0;
                                                            foreach ($pc_question_details[$dynamic_row] as $dynamic_matrix_option_id => $pc_details) {
                                                                $dynamic_matrix_option_text = $pc_details['name'];
                                                                $dynamic_column_question_id = $pc_details['question_id'];
                                                                $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $dynamic_matrix_option_id . '_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $dynamic_matrix_option_text;
                                                                $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                $i++;
                                                                $section_count++;

                                                                if ($pc_details['is_other_text'] == '1' && count($pc_question_details[$dynamic_row]) == $section_count) {
                                                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $pc_details['other_text_name'];
                                                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                    $i++;
                                                                }
                                                            }
                                                        }
                                                        /* IF PARENT CHILD COLUMN IS PRESENT ENDS */
                                                    }
                                                }
                                                /* IF PARENT CHILD ROW IS NOT PRESENT ENDS */
                                            } else {
                                                /* IF PARENT CHILD ROW IS  PRESENT STARTS */
                                                preg_match_all('/\[{2}ID(.*?)\]{2}/is', $option_text, $match);
                                                foreach ($match[1] as $dynamic_row) {
                                                    $section_count = 0;
                                                    foreach ($pc_question_details[$dynamic_row] as $option_id => $pco_details) {
                                                        $option_text = $pco_details['name'];
                                                        $other_row_question_id = $pco_details['question_id'];
                                                        $is_other_text = $pco_details['is_other_text'];
                                                        $other_text_name = $pco_details['other_text_name'];
                                                        $row_question_id = $other_row_question_id;

                                                        $total_section_count = 0;
                                                        foreach ($question_details['matrix_options'] as $matrix_option_id => $matrix_option_details) {
                                                            $matrix_option_text = $matrix_option_details['name'];
                                                            $section_count = 0;
                                                            if (strpos($matrix_option_text, '[[') === false) {
                                                                /* IF PARENT CHILD COLUMN IS NOT PRESENT STARTS */
                                                                $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                                $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $matrix_option_text;
                                                                $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                $i++;
                                                                $section_count++;

                                                                $total_section_count++;
                                                                if ($is_other_text == '1') {
                                                                    $other_option_id = '0';
                                                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $other_option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $other_text_name . '_' . $matrix_option_text;
                                                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                    $i++;
                                                                }
                                                                /* IF PARENT CHILD COLUMN IS NOT PRESENT ENDS */
                                                            } else {
                                                                /* IF PARENT CHILD COLUMN IS PRESENT STARTS */
                                                                preg_match_all('/\[{2}ID(.*?)\]{2}/is', $matrix_option_text, $match);
                                                                foreach ($match[1] as $dynamic_row) {
                                                                    $section_count = 0;
                                                                    foreach ($pc_question_details[$dynamic_row] as $dynamic_matrix_option_id => $pc_details) {
                                                                        $dynamic_matrix_option_text = $pc_details['name'];
                                                                        $dynamic_column_question_id = $pc_details['question_id'];
                                                                        $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $dynamic_matrix_option_id . '_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                        $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $dynamic_matrix_option_text;
                                                                        $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                        $i++;
                                                                        $section_count++;

                                                                        if ($pc_details['is_other_text'] == '1' && count($pc_question_details[$dynamic_row]) == $section_count) {
                                                                            //echo $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_'.$row_question_id.'_' . $dynamic_column_question_id . ' <br />';
                                                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $pc_details['other_text_name'];
                                                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                            $i++;
                                                                        }
                                                                    }
                                                                }
                                                                /* IF PARENT CHILD COLUMN IS PRESENT ENDS */
                                                            }
                                                        }
                                                        if ($is_other_text == '1') {
                                                            $option_id = '0';
                                                            $row_question_id = $other_row_question_id;
                                                            $option_text = $other_text_name;
                                                            foreach ($question_details['matrix_options'] as $matrix_option_id => $matrix_option_details) {
                                                                $matrix_option_text = $matrix_option_details['name'];
                                                                $section_count = 0;
                                                                if (strpos($matrix_option_text, '[[') === false) {
                                                                    /* IF PARENT CHILD COLUMN IS NOT PRESENT STARTS */
                                                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $matrix_option_text;
                                                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                    $i++;
                                                                    $section_count++;
                                                                    /* IF PARENT CHILD COLUMN IS NOT PRESENT ENDS */
                                                                } else {
                                                                    /* IF PARENT CHILD COLUMN IS PRESENT STARTS */
                                                                    preg_match_all('/\[{2}ID(.*?)\]{2}/is', $matrix_option_text, $match);
                                                                    foreach ($match[1] as $dynamic_row) {
                                                                        $section_count = 0;
                                                                        foreach ($pc_question_details[$dynamic_row] as $dynamic_matrix_option_id => $pc_details) {
                                                                            $dynamic_matrix_option_text = $pc_details['name'];
                                                                            $dynamic_column_question_id = $pc_details['question_id'];
                                                                            $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $dynamic_matrix_option_id . '_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                            $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $dynamic_matrix_option_text;
                                                                            $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                            $i++;
                                                                            $section_count++;

                                                                            if ($pc_details['is_other_text'] == '1' && count($pc_question_details[$dynamic_row]) == $section_count) {
                                                                                $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_' . $row_question_id . '_' . $dynamic_column_question_id;
                                                                                $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text . '_' . $option_text . '_' . $pc_details['other_text_name'];
                                                                                $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                                                                $i++;
                                                                            }
                                                                        }
                                                                    }
                                                                    /* IF PARENT CHILD COLUMN IS PRESENT ENDS */
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                /* IF PARENT CHILD ROW IS PRESENT ENDS */
                                            }
                                        }
                                    }
                                }
                                if (in_array($question_type_id, array('29'))) {
                                    /* Signature Question */
                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text;
                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                    $i++;
                                }
                                if (in_array($question_type_id, array('30'))) {
                                    /* Preset Questions Question */
                                }
                                if (in_array($question_type_id, array('31'))) {
                                    /* Essay/Long Answer Question */
                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text;
                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                    $i++;
                                }
                                if (in_array($question_type_id, array('32'))) {
                                    /* SEC Question */
                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text;
                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                    $i++;
                                }
                                if (in_array($question_type_id, array('33'))) {
                                    /* Location Question */
                                    $field[$i] = $static_part . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                                    $data_row_1[$field[$i]] = $question_type_id . '_' . $question_text;
                                    $data_row_1[$field[$i]] = $data_row_1[$field[$i]] . "|+|" . $data_label_text;
                                    $i++;
                                }
                            }
                        }
                        /*echo "<pre>";
                        print_r(array_unique($data_row_1));
                        echo "</pre>";
                        exit();*/

                        $this->dbforge->drop_table($table_report, TRUE);
                        $this->dbforge->drop_table($roster_table_report, TRUE);                                        
                        $fields = array(
                            'id' => array(
                                'type' => 'INT',
                                'constraint' => 11,
                                'auto_increment' => TRUE
                            ),
                            'unique_code' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 50,
                                'null' => TRUE
                            ),
                            'respondent_id' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 30,
                                'null' => TRUE
                            ),
                            'roster_id' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 50,
                                'null' => TRUE
                            ),
                            'parent_roster_id' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 50,
                                'null' => TRUE
                            ),
                            'accept_status' => array(
                                'type' => 'TEXT',
                                'null' => TRUE
                            ),
                            'reject_status' => array(
                                'type' => 'TEXT',
                                'null' => TRUE
                            ),
                            'flag_status' => array(
                                'type' => 'TEXT',
                                'null' => TRUE
                            ),
                            'note' => array(
                                'type' => 'TEXT',
                                'null' => TRUE
                            ),
                            'enumerator' => array(
                                'type' => 'TEXT',
                                'null' => TRUE
                            ),
                            'team' => array(
                                'type' => 'TEXT',
                                'null' => TRUE
                            ),
                            'device_type' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 15,
                                'null' => TRUE
                            ),
                            'respondent_code' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 50,
                                'null' => TRUE
                            ),
                            'started_on' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 30,
                                'null' => TRUE
                            ),
                            'ended_on' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 30,
                                'null' => TRUE
                            ),
                            'duration' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 30,
                                'null' => TRUE
                            ),
                            'ip_address' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 20,
                                'null' => TRUE
                            ),
                            'tracking_code' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 30,
                                'null' => TRUE
                            ),
                            'device_id' => array(
                               'type' => 'VARCHAR',
                                'constraint' => 20,
                                'null' => TRUE
                            ),
                            'device_name' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 50,
                                'null' => TRUE
                            ),                        
                            'latitude' => array(
                                'type' => 'TEXT',
                                'null' => TRUE
                            ),
                            'longitude' => array(
                                'type' => 'TEXT',
                                'null' => TRUE
                            ),
                            'api_level' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 10,
                                'null' => TRUE
                            ),
                            'app_version' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 15,
                                'null' => TRUE
                            ),
                            'survey_status' => array(
                                'type' => 'VARCHAR',
                                'constraint' => 20,
                                'null' => TRUE
                            )
                        );
                        foreach ($field as $f_row) {
                            $fields = array_merge($fields, array(
                                $f_row => array(
                                    'type' => 'TEXT',
                                    'null' => TRUE
                                )
                            ));
                        }

                        $this->dbforge->add_key('id', TRUE);
                        $this->dbforge->add_field($fields);
                        $attributes = array('ENGINE' => 'InnoDB', 'ROW_FORMAT' => 'DYNAMIC');
                        $this->dbforge->create_table($roster_table_report, FALSE, $attributes);

                        $this->save($p_table = $roster_table_report, $p_key = 'id', $data_array = $data_row_1, $cond = NULL, $debug = FALSE);

                        if ($cnt == 0) {
                            $data_array = array();
                            $data_array['survey_id'] = $survey_id;
                            $data_array['is_copied_to_temp_roster_table'] = '0';
                            $this->update($p_table = 'survey_respondents', $p_key = 'survey_id', $data_array, $cond = NULL, $debug = FALSE);
                        }
                    }
                    $cnt++;
                }
            }
            
            if(isset($blocks)){
                foreach ($blocks as $block_row) {
                    $block_ids[] = $block_row['block_id'];
                }
                $response_table = 'roster_responses_' . $survey_id;
                $cond_and = array();
                $join_logic = array();
                $cond_and = array();
                $join_logic[0] = array('first_table' => 'survey_roster', 'join_on' => 'survey_roster.roster_id = '.$response_table.'.roster_id', 'join_type' => 'inner', 'join_select' => array('survey_roster.roster_id, survey_roster.parent_roster_id'), 'join_condition' => array('survey_roster.status' => '1'));
                $join_logic[1] = array('first_table' => 'block_questions', 'join_on' => 'block_questions.question_id = '.$response_table.'.question_id', 'join_type' => 'inner', 'join_select' => array('block_questions.block_id'), 'join_condition' => array('block_questions.status' => '1'), 'join_in' => array('block_questions.block_id' => $block_ids));
                $response_array = $this->fetch($p_table = $response_table, $p_key = 'id', $cond_and, $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic, $order_by = array('id' => 'ASC'), $limit = NULL, $offset = 0, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);
                
                $data['responses'] = $this->get_temp_roster_table_data($survey_id, $blocks, $no_reply, $all_questions, $response_array);

                /* GENERATE TABLE WITH STRUCTURE ENDS */

                if ($no_reply == FALSE) {
                    return $data;
                }
            }
        }        
    }

    public function get_temp_roster_table_data($survey_id = '0', $blocks = array(), $no_reply = TRUE, $pc_questions = array(), $response_array = array()) {
        /* INSERT DATA IF LEFT STARTS */
        foreach ($blocks as $block_row) {
            $block_ids[] = $block_row['block_id'];
        }
        
        if(isset($response_array)){
            foreach($response_array as $response_data){
                $response_row[$response_data['roster_id']][$response_data['block_id']][] = $response_data;
                $respondent_arr[$response_data['respondent_code']] = $response_data['respondent_code'];
            }
        }
        
        $join_logic = array();
        $cond_and = array();
        $cond_in = array();
        $cond_and = array('survey_id' => $survey_id, 'is_copied_to_temp_roster_table' => '0');
        if(isset($respondent_arr)){
            $cond_in = array('respondent_code' => array_values($respondent_arr));
        }
        $join_logic[0] = array('first_table' => 'enumerators', 'join_on' => 'enumerators.id = survey_respondents.enumerator_id', 'join_type' => 'left', 'join_select' => array('enumerators.name as enumerator_name'));
        $join_logic[1] = array('first_table' => 'survey_roster', 'join_on' => 'survey_roster.respondent_code = survey_respondents.respondent_code', 'join_type' => 'inner', 'join_select' => array('survey_roster.roster_id'));
        $raw_respondents = $this->fetch($p_table = 'survey_respondents', $p_key = 'id', $cond_and, $cond_or = array(), $cond_in, $cond_custom = NULL, $select_fields = array('*, (SELECT GROUP_CONCAT(team_enumerators.team_code) FROM team_enumerators WHERE team_enumerators.`enumerator_code` = enumerators.`encrypted_code`) AS team_code'), $join_logic, $order_by = array('id' => 'ASC'), $limit = NULL, $offset = 0, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);

        if (isset($pc_questions)) {
            foreach ($pc_questions as $qs_row) {
                $option_text[$qs_row['option_id']] = $qs_row['option_name'];
                $option_weightage[$qs_row['option_id']] = $qs_row['option_weightage'];
                $matrix_option_text[$qs_row['matrix_option_id']] = $qs_row['matrix_option_name'];
                $matrix_option_weightage[$qs_row['matrix_option_id']] = $qs_row['matrix_option_weightage'];
                $nota_weightage[$qs_row['id']] = $qs_row['none_of_the_above_weightage'];
                $other_weightage[$qs_row['id']] = $qs_row['other_text_weightage'];
            }
        }
        
        $block_count = 1;
        foreach ($blocks as $block_row) {
            $data_to_save = array();
            $block_id = $block_row['block_id'];
            $temp_table = 'temp_roster_report_' . $survey_id . '_' . $block_id;
            $respondent_ids = array();
            $fields = $this->db->list_fields($temp_table);
            if (isset($raw_respondents)) {
                /* COPY ROW FROM RESPONSE TABLE */
                foreach ($raw_respondents as $rawp) {
                    if (isset($response_row[$rawp['roster_id']][$block_id])) {
                        $existing_fields = array();
                        $rec_count = $rawp['roster_id'];
                        foreach ($response_row[$rawp['roster_id']][$block_id] as $response) {
                            $rec_count = $rawp['roster_id'];
                            $question_type_id = $response['question_type_id'];
                            $question_id = $response['question_id'];
                            $option_id = $response['option_id'];
                            $matrix_option_id = $response['matrix_option_id'];
                            $row_question_id = $response['row_question_id'];
                            $column_question_id = $response['column_question_id'];
                            $text_response = $response['text_response'];
                            $other_text_response = $response['other_text_response'];
                            $file_name = $response['file_name'];
                            $respondent_code = $response['respondent_code'];
                            $roster_id = $response['roster_id'];
                            $parent_roster_id = $response['parent_roster_id'];
                            
                            if(in_array($question_type_id, array('11'))){
                                $field = 'field_' . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_0_0' ;
                            }else{
                                $field = 'field_' . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                            }
                            $existing_fields[] = $field;
                        }
                        foreach($fields as $table_row){
                            if(!in_array($table_row, $existing_fields)){
                                $data_to_save[$rec_count][$table_row] = NULL;
                            }
                        }
                        foreach ($response_row[$rawp['roster_id']][$block_id] as $response) {
                            $question_type_id = $response['question_type_id'];
                            $question_id = $response['question_id'];
                            $option_id = $response['option_id'];
                            $matrix_option_id = $response['matrix_option_id'];
                            $row_question_id = $response['row_question_id'];
                            $column_question_id = $response['column_question_id'];
                            $text_response = $response['text_response'];
                            $other_text_response = $response['other_text_response'];
                            $file_name = $response['file_name'];
                            $respondent_code = $response['respondent_code'];
                            $roster_id = $response['roster_id'];
                            $parent_roster_id = $response['parent_roster_id'];

                            if(in_array($question_type_id, array('11'))){
                                $field = 'field_' . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_0_0' ;
                            }else{
                                $field = 'field_' . $question_type_id . '_' . $question_id . '_' . $option_id . '_' . $matrix_option_id . '_' . $row_question_id . '_' . $column_question_id;
                            }

                            if (!in_array($field, $fields)) {
                                continue;
                            }
                            if (in_array($question_type_id, array('1'))) {
                                /* Dichotomous Question */
                                $data_to_save[$rec_count][$field] = $option_text[$option_id] . '~' . $option_weightage[$option_id];
                            }
                            if (in_array($question_type_id, array('2'))) {
                                /* Text Response Question */
                                $data_to_save[$rec_count][$field] = $text_response;
                            }
                            if (in_array($question_type_id, array('3'))) {
                                /* Multiple Choice Question */
                                $data_to_save[$rec_count][$field] = isset($option_text[$option_id]) ? $option_text[$option_id] . '~' . $option_weightage[$option_id] : ($other_text_response == 'NOTA' ? 'NOTA~' . $nota_weightage[$question_id] : $other_text_response . '~' . $other_weightage[$question_id]);
                            }
                            if (in_array($question_type_id, array('4'))) {
                                /* Single Choice Question */
                                $data_to_save[$rec_count][$field] = $other_text_response == '' ? $option_text[$option_id] . '~' . $option_weightage[$option_id] : ($other_text_response == 'NOTA' ? 'NOTA~' . $nota_weightage[$question_id] : $other_text_response . '~' . $other_weightage[$question_id]);
                            }
                            if (in_array($question_type_id, array('5'))) {
                                /* Date and Time Question */
                                $data_to_save[$rec_count][$field] = $text_response;
                            }
                            if (in_array($question_type_id, array('6'))) {
                                /* Email Question */
                                $data_to_save[$rec_count][$field] = $text_response;
                            }
                            if (in_array($question_type_id, array('7'))) {
                                /* Phone Number Question */
                                $data_to_save[$rec_count][$field] = $text_response;
                            }
                            if (in_array($question_type_id, array('8'))) {
                                /* Dropdown Question */
                                $data_to_save[$rec_count][$field] = isset($option_text[$option_id]) ? $option_text[$option_id] . '~' . $option_weightage[$option_id] : '0';
                            }
                            if (in_array($question_type_id, array('9'))) {
                                /* Number Question */
                                $data_to_save[$rec_count][$field] = $text_response;
                            }
                            if (in_array($question_type_id, array('10'))) {
                                /* Text Response Grid Question */
                                $data_to_save[$rec_count][$field] = $text_response;
                            }
                            if (in_array($question_type_id, array('11'))) {
                                /* Single Choice Grid Question */
                                $field = 'field_' . $question_type_id . '_' . $question_id . '_' . $option_id . '_0_0_0';
                                $data_to_save[$rec_count][$field] = isset($matrix_option_text[$matrix_option_id]) ? $matrix_option_text[$matrix_option_id] . '~' . $matrix_option_weightage[$matrix_option_id] : (isset($option_text[$matrix_option_id]) ? $option_text[$matrix_option_id] : '0');
                            }
                            if (in_array($question_type_id, array('12'))) {
                                /* Multiple Choice Grid Question */
                                $data_to_save[$rec_count][$field] = isset($matrix_option_text[$matrix_option_id]) ? $matrix_option_text[$matrix_option_id] . '~' . $matrix_option_weightage[$matrix_option_id] : (isset($option_text[$matrix_option_id]) ? $option_text[$matrix_option_id] : '0');
                            }
                            if (in_array($question_type_id, array('13'))) {
                                /* Five Point Likert Question */
                                $data_to_save[$rec_count][$field] = $option_text[$option_id] . '~' . $option_weightage[$option_id];
                            }
                            if (in_array($question_type_id, array('14'))) {
                                /* Seven Point Likert Question */
                                $data_to_save[$rec_count][$field] = $option_text[$option_id] . '~' . $option_weightage[$option_id];
                            }
                            if (in_array($question_type_id, array('15'))) {
                                /* N Point Likert Question */
                                $data_to_save[$rec_count][$field] = $option_text[$option_id] . '~' . $option_weightage[$option_id];
                            }
                            if (in_array($question_type_id, array('16'))) {
                                /* Net Promoter Score Question */
                                $data_to_save[$rec_count][$field] = $option_text[$option_id] . '~' . $option_weightage[$option_id];
                            }
                            if (in_array($question_type_id, array('17'))) {
                                /* Rank Order Question */
                                $data_to_save[$rec_count][$field] = $text_response;
                            }
                            if (in_array($question_type_id, array('18'))) {
                                /* Constant Sum Question */
                                $data_to_save[$rec_count][$field] = $text_response;
                            }
                            if (in_array($question_type_id, array('19'))) {
                                /* Image Choice Question */
                            }
                            if (in_array($question_type_id, array('20'))) {
                                /* Slider Question */
                                $data_to_save[$rec_count][$field] = $text_response;
                            }
                            if (in_array($question_type_id, array('21'))) {
                                /* Five Point Emoji Question */
                            }
                            if (in_array($question_type_id, array('22'))) {
                                /* Seven Pont Emoji Question */
                            }
                            if (in_array($question_type_id, array('23'))) {
                                /* NPS with Emoji Question */
                            }
                            if (in_array($question_type_id, array('24'))) {
                                /* Image Upload Question */
                                $data_to_save[$rec_count][$field] = file_exists("./assets/uploads/survey/" . $file_name) ? '<a target="_blank" href="' . site_url("assets/uploads/survey/" . $file_name) . '">Image</a>' : "<span class=\"text-danger font-italic\">No file uploaded</span>";
                            }
                            if (in_array($question_type_id, array('25'))) {
                                /* Bipolar Matrix Question */
                                $data_to_save[$rec_count][$field] = isset($matrix_option_text[$matrix_option_id]) ? $matrix_option_text[$matrix_option_id] . '~' . $matrix_option_weightage[$matrix_option_id] : (isset($option_text[$matrix_option_id]) ? $option_text[$matrix_option_id] : '0');
                            }
                            if (in_array($question_type_id, array('26'))) {
                                /* Semantic Differential Question */
                                $data_to_save[$rec_count][$field] = $text_response;
                            }
                            if (in_array($question_type_id, array('27'))) {
                                /* Star Rating - Single Question */
                                $data_to_save[$rec_count][$field] = $option_id;
                            }
                            if (in_array($question_type_id, array('28'))) {
                                /* Star Rating Grid Question */
                                $data_to_save[$rec_count][$field] = $text_response;
                            }
                            if (in_array($question_type_id, array('29'))) {
                                /* Signature Question */
                                $data_to_save[$rec_count][$field] = file_exists("./assets/uploads/survey/" . $file_name) ? '<a target="_blank" href="' . site_url("assets/uploads/survey/" . $file_name) . '">Image</a>' : "<span class=\"text-danger font-italic\">No file uploaded</span>";
                            }
                            if (in_array($question_type_id, array('30'))) {
                                /* Preset Questions Question */
                            }
                            if (in_array($question_type_id, array('31'))) {
                                /* Essay/Long Answer Question */
                                $data_to_save[$rec_count][$field] = $text_response;
                            }
                            if (in_array($question_type_id, array('32'))) {
                                /* SEC Question */
                                $data_to_save[$rec_count][$field] = $text_response;
                            }
                            if (in_array($question_type_id, array('33'))) {
                                /* Location Question */
                                $data_to_save[$rec_count][$field] = $text_response;
                            }
                        }

                        $data_to_save[$rec_count]['device_id'] = $rawp['device_id'];
                        $data_to_save[$rec_count]['device_name'] = $rawp['device_name'];
                        $data_to_save[$rec_count]['longitude'] = $rawp['longitude'] <> "" && $rawp['lattitude'] <> "" ? '<a target="_blank" href="' . site_url('siteadmin/responses/response_location/' . $rawp['lattitude'] . '/' . $rawp['longitude']) . '">' . $rawp['longitude'] . '</a>' : '';
                        $data_to_save[$rec_count]['latitude'] = $rawp['longitude'] <> "" && $rawp['lattitude'] <> "" ? '<a target="_blank" href="' . site_url('siteadmin/responses/response_location/' . $rawp['lattitude'] . '/' . $rawp['longitude']) . '">' . $rawp['lattitude'] . '</a>' : '';
                        $data_to_save[$rec_count]['api_level'] = $rawp['api_level'];
                        $data_to_save[$rec_count]['app_version'] = $rawp['app_version'];

                        $data_to_save[$rec_count]['unique_code'] = strtoupper(substr($rawp['unique_code'], 0, 10));
                        $data_to_save[$rec_count]['respondent_id'] = $rawp['respondent_id'];
                        $data_to_save[$rec_count]['roster_id'] = $roster_id;
                        $data_to_save[$rec_count]['parent_roster_id'] = $parent_roster_id;
                        $data_to_save[$rec_count]['respondent_code'] = $respondent_code;
                        $data_to_save[$rec_count]['device_type'] = $rawp['device_type'];
                        $data_to_save[$rec_count]['started_on'] = date('h:i A d M, Y', strtotime($rawp['started_on']));
                        $data_to_save[$rec_count]['ended_on'] = $rawp['ended_on'] <> "0000-00-00 00:00:00" ? date('h:i A d M, Y', strtotime($rawp['ended_on'])) : "";

                        $datetime1 = new DateTime(date('Y-m-d H:i:s', strtotime($rawp['started_on'])));
                        $datetime2 = new DateTime(date('Y-m-d H:i:s', strtotime($rawp['ended_on'])));
                        $interval = $datetime2->diff($datetime1);
                        $data_to_save[$rec_count]['duration'] = $rawp['ended_on'] <> "0000-00-00 00:00:00" ? $interval->format('%H Hrs | %i Mins | %s Sec') : "";
                        $data_to_save[$rec_count]['ip_address'] = $rawp['ip_address'];
                        $data_to_save[$rec_count]['tracking_code'] = $rawp['tracking_code'];

                        $data_to_save[$rec_count]['accept_status'] = $rawp['status'] == 1 ? '<span class="text-accept-' . $respondent_code . '">Accepted</span>' : '<a title="Accepted" class="accept-response accept-' . $respondent_code . '" data-respondent-code="' . $respondent_code . '"><i class="fas fa-check mr-2 teal-text" aria-hidden="true"></i></a>';
                        $data_to_save[$rec_count]['reject_status'] = $rawp['status'] == 5 ? '<span class="text-reject-' . $respondent_code . '">Rejected</span>' : '<a title="Rejected" class="reject-response reject-' . $respondent_code . '" data-respondent-code="' . $respondent_code . '"><i class="fas fa-trash mr-2 text-danger" aria-hidden="true"></i></a>';
                        $data_to_save[$rec_count]['flag_status'] = $rawp['status'] == 2 ? '<span class="text-flag-' . $respondent_code . '">Flagged</span>' : '<a title="Note" class="flag-response flag-' . $respondent_code . '" data-respondent-code="' . $respondent_code . '"><i class="fas fa-check mr-2 text-warning" aria-hidden="true"></i></a>';
                        //$data_to_save[$rec_count]['note'] = in_array($rawp['status'], array(2, 5)) ? '<span class="flag-note-' . $respondent_code . '">' . $rawp['note'] . '</span>' : '<span class="flag-note"></span>';
                        $data_to_save[$rec_count]['note'] = in_array($rawp['status'], array(2, 5)) ? (($rawp['note'] <> NULL) ? $rawp['note'] : '<span class="flag-note-' . $respondent_code . '"></span>') : '<span class="flag-note-' . $respondent_code . '"></span>';
                        $data_to_save[$rec_count]['enumerator'] = $rawp['enumerator_name'];
                        $data_to_save[$rec_count]['survey_status'] = $rawp['status'];
                        $data_to_save[$rec_count]['team'] = $rawp['team_code'];
                        
                        //$resp = $this->save($p_table = $temp_table, $p_key = 'id', $data_array = $data_to_save[$rec_count], $cond = NULL, $debug = FALSE);
                    }
                }
                $this->save_batch($p_table = $temp_table, $p_key = 'id', $data_array = array_values($data_to_save), $cond = NULL, $debug = FALSE);
            }
            if ($block_count == count($blocks)) {
                $sql = 'UPDATE `survey_respondents` SET `is_copied_to_temp_roster_table` = \'1\' WHERE `survey_id` = \''.$survey_id.'\' AND `is_copied_to_temp_roster_table` = \'0\'';
                $this->db->query($sql);
            }
            $block_count++;
        }
        //exit();
        /* INSERT DATA IF LEFT ENDS */

        if ($no_reply == FALSE) {
            if(isset($blocks)){
                foreach ($blocks as $block_row) {
                    $block_id = $block_row['block_id'];
                    $temp_table = 'temp_roster_report_' . $survey_id . '_' . $block_id;
                    $data[$block_id] = $this->fetch($p_table = $temp_table, $p_key = 'id', $cond_and = array(), $cond_or = array(), $cond_in = array(), $cond_custom = NULL, $select_fields = array('*'), $join_logic = array(), $order_by = array('id' => 'ASC'), $limit = NULL, $offset = 0, $group_by = array(), $row_only = FALSE, $count_only = FALSE, $return_object = FALSE, $debug = FALSE);
                }
                return $data;
            }
        } else {
            return TRUE;
        }        
    }
    /* ---------------------- END BLOCK ---------------------- */

    /**
     * PERMANENT FUNCTION
     */
    public function add_response_table($p_table = NULL, $debug = FALSE) {
        if (!$this->db->table_exists($p_table)) {
            $sql = "CREATE TABLE `" . $p_table . "` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `unique_code` varchar(255) DEFAULT NULL,
                      `encrypted_code` varchar(255) DEFAULT NULL,
                      `survey_id` int(11) DEFAULT NULL,
                      `respondent_id` int(11) DEFAULT NULL,
                      `respondent_code` varchar(255) DEFAULT NULL,
                      `question_type_id` int(11) DEFAULT NULL,
                      `question_id` int(11) DEFAULT NULL,
                      `row_question_id` int(11) DEFAULT NULL,
                      `column_question_id` int(11) DEFAULT NULL,
                      `option_id` int(11) DEFAULT NULL,
                      `matrix_option_id` int(11) DEFAULT NULL,
                      `text_response` text,
                      `other_text_response` text,
                      `file_name` text,
                      `status` enum('0','1','5') NOT NULL DEFAULT '1',
                      `created` datetime DEFAULT CURRENT_TIMESTAMP,
                      `created_by` int(11) DEFAULT '0',
                      `modified` datetime DEFAULT '0000-00-00 00:00:00',
                      `modified_by` int(11) DEFAULT '0',
                      `deleted` datetime DEFAULT '0000-00-00 00:00:00',
                      `deleted_by` int(11) DEFAULT '0',
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
            $this->db->query($sql);
        }
        if (!$this->db->table_exists('roster_' . $p_table)) {    
            $sql = "CREATE TABLE `roster_" . $p_table . "` (
                      `id` int(11) NOT NULL AUTO_INCREMENT,
                      `unique_code` varchar(255) DEFAULT NULL,
                      `encrypted_code` varchar(255) DEFAULT NULL,
                      `roster_id` varchar(255) DEFAULT NULL,
                      `survey_id` int(11) DEFAULT NULL,
                      `respondent_id` int(11) DEFAULT NULL,
                      `respondent_code` varchar(255) DEFAULT NULL,
                      `question_type_id` int(11) DEFAULT NULL,
                      `question_id` int(11) DEFAULT NULL,
                      `row_question_id` int(11) DEFAULT NULL,
                      `column_question_id` int(11) DEFAULT NULL,
                      `option_id` int(11) DEFAULT NULL,
                      `matrix_option_id` int(11) DEFAULT NULL,
                      `text_response` text,
                      `other_text_response` text,
                      `file_name` text,
                      `status` enum('0','1','5') NOT NULL DEFAULT '1',
                      `created` datetime DEFAULT CURRENT_TIMESTAMP,
                      `created_by` int(11) DEFAULT '0',
                      `modified` datetime DEFAULT '0000-00-00 00:00:00',
                      `modified_by` int(11) DEFAULT '0',
                      `deleted` datetime DEFAULT '0000-00-00 00:00:00',
                      `deleted_by` int(11) DEFAULT '0',
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
            $this->db->query($sql);
        }        
    }

    /* ----------------- END BLOCK ----------------- */

}
