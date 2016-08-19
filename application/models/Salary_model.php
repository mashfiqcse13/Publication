<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Description of Salary_model
 *
 * @author MD. Mashfiq
 */
class Salary_model extends CI_Model {

    //put your code here
    function select_all($tbl_name) {
        $this->db->select('*');
        $this->db->from($tbl_name);
        $query = $this->db->get();
        return $query->result();
    }

    function save_info($tbl_name, $data) {
        $this->db->insert($tbl_name, $data);
        return $this->db->insert_id();
    }

    function update_advance($update_advance, $advance_amount, $id) {
        $this->db->where('id_salary_advance', $id);
        $this->db->update('salary_advance', $update_advance);
    }

    function get_employee_dropdown() {
        $items = $this->db->get('employee')->result();

        $data = array();
        $data['blank'] = 'Select Employee name';
        foreach ($items as $item) {
            $data[$item->id_employee] = $item->name_employee;
        }
        $js = 'id="shirts"';
        return form_dropdown('id_employee', $data, 'required', ' class="select2" required');
    }

    function select_salary_payment_by_salary_id($id) {
        $this->db->select('*');
        $this->db->from('salary_payment');
        $this->db->join('salary_bonus', 'salary_payment.id_salary_payment = salary_bonus.id_salary_payment', 'left');
        $this->db->join('salary_advance', 'salary_payment.id_employee = salary_advance.id_employee', 'left');
        $this->db->join('loan', 'salary_payment.id_employee = loan.id_employee', 'left');
        $this->db->where('salary_payment.id_employee', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function select_all_info() {
        $current = date('n', now());
        $current_month = date('m');
        $current_year = date('Y');
        $this->db->select('*', 'employee.id_employee');
        $this->db->from('employee');
        $this->db->join('salary_advance', 'employee.id_employee = salary_advance.id_employee', 'left');
        $this->db->join('loan', 'employee.id_employee = loan.id_employee', 'left');
        $this->db->join('salary_payment', 'employee.id_employee = salary_payment.id_employee', 'left');
        $this->db->join('salary_bonus', 'salary_payment.id_salary_payment = salary_bonus.id_salary_payment', 'left');
        $this->db->where('salary_payment.status_salary_payment !=', null);
        $this->db->where('salary_payment.month_salary_payment', $current);
        return $query = $this->db->get()->result();
    }

    function select_all_info_by_month($month, $year) {
        $this->db->select('*', 'employee.id_employee');
        $this->db->from('employee');
        $this->db->join('salary_advance', 'employee.id_employee = salary_advance.id_employee', 'left');
        $this->db->join('loan', 'employee.id_employee = loan.id_employee', 'left');
        $this->db->join('salary_payment', 'employee.id_employee = salary_payment.id_employee', 'left');
        $this->db->join('salary_bonus', 'salary_payment.id_salary_payment = salary_bonus.id_salary_payment', 'left');
        $this->db->where('salary_payment.status_salary_payment !=', null);
        $this->db->where('salary_payment.month_salary_payment', $month);
        $this->db->where('salary_payment.year_salary_payment', $year);
        $query = $this->db->get();
        return $query->result();
    }

    function select_employee_salary_advance() {
        $this->db->select('*');
        $this->db->from('employee');
//        $this->db->join('salary_advance', 'employee.id_employee = salary_advance.id_employee', 'left');
//        $this->db->where('status_salary_advance', 1);
        $query = $this->db->get();
        return $query->result();
    }

    function select_all_salary_info($id) {
        $this->db->select('*');
        $this->db->from('employee_salary_info');
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function select_all_employee() {
        $this->db->select('*');
        $this->db->from('employee');
        $this->db->join('employee_salary_info', 'employee.id_employee = employee_salary_info.id_employee');
        $query = $this->db->get();
        return $query->result();
    }

    function select_all_employee_by_month_year($month, $year) {
        $this->db->select('*');
        $this->db->from('employee');
        $this->db->join('employee_salary_info', 'employee.id_employee = employee_salary_info.id_employee');
        $this->db->join('salary_payment', 'employee.id_employee = salary_payment.id_employee');
        $this->db->where('salary_payment.month_salary_payment', $month);
        $this->db->where('salary_payment.year_salary_payment', $year);
        $query = $this->db->get();
        return $query->result();
    }

    function update_info($tbl_name, $condition, $data, $id, $return_id) {
        $this->db->where($condition, $id);
        $this->db->update($tbl_name, $data);
        $this->db->select($return_id);
        $this->db->from($tbl_name);
        $this->db->where($condition, $id);
        $query = $this->db->get();
        return $query->row();
    }

    function deduction_update($tbl_name, $condition, $data, $id, $amount, $column, $return_id) {
        $this->db->set($column, $amount);
        $this->db->where($condition, $id);
        $this->db->update($tbl_name, $data);
        $this->db->select($return_id);
        $this->db->from($tbl_name);
        $this->db->where($condition, $id);
        $query = $this->db->get();
        return $query->row();
    }

    function select_employee_salary($id) {
        $sql = $this->db->query('SELECT  (SUM(basic)+SUM(medical)+SUM(house_rent)+SUM(transport_allowance)+SUM(lunch)) AS Total
 FROM employee_salary_info WHERE id_employee=' . $id);
        return $sql->result();
    }

    function announce($id) {
        $month = date('n', now());
        $year = date('Y', now());
        $this->db->select('*');
        $this->db->from('salary_payment');
        $this->db->where('id_employee', $id);
        $this->db->where('month_salary_payment', $month);
        $this->db->where('year_salary_payment', $year);
        $this->db->order_by('id_salary_payment', 'desc');
        $query = $this->db->get();
        return $query->row();
    }

    function announce_by_month_year($id, $month, $year) {
        $this->db->select('*');
        $this->db->from('salary_payment');
        $this->db->where('id_employee', $id);
        $this->db->where('month_salary_payment', $month);
        $this->db->where('year_salary_payment', $year);
        $this->db->order_by('id_salary_payment', 'desc');
        $query = $this->db->get();
        return $query->row();
    }

    function bonus($id) {
        $this->db->select('*');
        $this->db->from('salary_bonus');
        $this->db->where('id_salary_payment', $id);
        $query = $this->db->get();
        return $query->row();
    }

    function bonus_type() {
        $this->db->select('*');
        $this->db->from('salary_bonus_type');
        $this->db->join('salary_bonus_announce', 'salary_bonus_type.id_salary_bonus_type = salary_bonus_announce.id_salary_bonus_type', 'left_join');
        $query = $this->db->get();
        return $query->result();
    }

    function select_bonus_amount($id) {
        $this->db->select('amount');
        $this->db->from('salary_bonus_announce');
        $this->db->where('id_salary_bonus_type', $id);
        $query = $this->db->get();
        return $query->result();
    }

    function employee_info() {
        $this->db->select('id_employee');
        $this->db->from('salary_payment');
        $query = $this->db->get();
        return $query->result();
    }

//    function update_cash($tbl_name,$value){
//        $this->db->query('UPDATE `cash` SET `balance`= `balance`-'.$value.', `total_out`=`total_out`+'.$value.' WHERE `id_cash`='. 1);
//    }

    function current_salary($month) {
        $this->db->select('*');
        $this->db->from('salary_payment', 'salary_advance');
        $this->db->join('employee', 'employee.id_employee = salary_payment.id_employee', 'left');
        $this->db->join('salary_bonus', 'salary_payment.id_salary_payment = salary_bonus.id_salary_payment', 'left');
        $this->db->join('salary_advance', 'salary_payment.id_employee = salary_advance.id_employee', 'left');
        $this->db->where('month_salary_payment', $month);
        $query = $this->db->get();
        return $query->result();
    }

    function select_all_salary_of_employee() {
        $this->db->select('*');
        $this->db->from('salary_payment');
        $this->db->join('employee', 'employee.id_employee = salary_payment.id_employee', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    function salary_advance_with_employee() {
        $this->db->select('*');
        $this->db->from('salary_advance');
        $this->db->join('employee', 'employee.id_employee = salary_advance.id_employee', 'left');
        $query = $this->db->get();
        return $query->result();
    }

    function save_advance($post_array) {
        $current_month = date('m');
        $current_year = date('Y');
        $data['amount_given_salary_advance'] = $post_array['amount_given_salary_advance'];
        $amount = $data['amount_given_salary_advance'];
        $data['id_employee'] = $post_array['id_employee'];
        $data['status_salary_advance'] = $post_array['status_salary_advance'];
        $data['date_given_salary_advance'] = date('Y-m-d H:i:s');

        $expense['id_name_expense'] = 3;
        $expense['amount_expense'] = $amount;
        $expense['date_expense'] = date('Y-m-d H:i:s');
        $expense['description_expense'] = 'Employee Salary Advance';

        $this->db->insert('expense', $expense);

        $sql = 'SELECT * FROM `salary_advance` WHERE `id_employee`= ' . $data['id_employee'] . ' AND MONTH(date_given_salary_advance) = ' . $current_month . ' AND YEAR(date_given_salary_advance) = ' . $current_year;
        $result = $this->db->query($sql)->result();

        if (empty($result)) {
            $this->db->insert('salary_advance', $data);
            $this->advance_add($amount, $data['id_employee']);
            return true;
        } else {
            $id = $result[0]->id_salary_advance;
            $update = "UPDATE `salary_advance` SET `amount_given_salary_advance` = `amount_given_salary_advance` + $amount  WHERE `id_salary_advance` = $id";
            $this->db->query($update);
            $this->advance_reduce($amount, $data['id_employee']);
            return true;
        }
    }

//    search employee
    function salary_advance_by_employee_id($employee,$from, $to) {
        $this->db->select('*');
        $this->db->from('salary_advance');
        $this->db->join('employee', 'employee.id_employee = salary_advance.id_employee', 'left');
        if(!empty($employee)) {
            $this->db->where('salary_advance.id_employee', $employee);
        }if($from != "1970-01-01"){            
            $condition = "DATE(date_given_salary_advance) BETWEEN '$from' AND '$to'";
            $this->db->where($condition);
        }
        $query = $this->db->get();
        return $query->result();
    }

    

    function select_all_paid_salary() {
        $sql = $this->db->query('SELECT *, SUM(`amount_salary_payment`) AS total FROM `salary_payment` LEFT JOIN `employee`
ON `salary_payment`.`id_employee`=`employee`.`id_employee` WHERE `status_salary_payment` = 2 GROUP BY `date_salary_payment` ORDER BY `id_salary_payment` DESC');

        return $sql->result();
    }

    function total_info_by_date($from, $to) {
//        $sql =  $this->db->query('SELECT *, SUM(`amount_salary_payment`) AS total FROM `salary_payment` LEFT JOIN `employee` ON `salary_payment`.`id_employee`=`employee`.`id_employee` WHERE `status_salary_payment` = 2 AND `date_salary_payment` >= '.$from.' AND `date_salary_payment` <= '.$to.' GROUP BY `date_salary_payment` ');
        $this->db->select('*');
        $this->db->select('SUM(amount_salary_payment) AS total ');
        $this->db->from('salary_payment');
        $this->db->join('employee', 'employee.id_employee = salary_payment.id_employee', 'left');
        $this->db->where('status_salary_payment', 2);
        $this->db->where('date_salary_payment >= ', $from);
        $this->db->where('date_salary_payment <= ', $to);
        $this->db->group_by('date_salary_payment');
        $query = $this->db->get();
        return $query->result();
    }

    function advance_add($amount, $employee_id) {
        $this->db->select('*')
                        ->from('salary_advance_total')
                        ->where('id_employee', $employee_id)
                        ->get()
                        ->result() or
                $this->db->query("INSERT INTO `salary_advance_total` 
                    (`id_employee`, `total_in`, `total_out`, `balance`) 
                    VALUES ($employee_id, '0', '0', '0');");

        $sql = "UPDATE `salary_advance_total` SET 
                `total_in` = `total_in`+'$amount', 
                `balance` = `balance`+'$amount' 
            WHERE `salary_advance_total`.`id_employee` = $employee_id;";
        $this->db->query($sql);
        return TRUE;
    }

    function advance_reduce($amount, $employee_id) {
        // cheching if there is a row , otherwise creating it
        $this->db->select('*')
                        ->from('salary_advance_total')
                        ->where('id_employee', $employee_id)
                        ->get()
                        ->result() or
                $this->db->query("INSERT INTO `salary_advance_total` 
                    (`id_employee`, `total_in`, `total_out`, `balance`) 
                    VALUES ($employee_id, '0', '0', '0');");

        $current = $this->db->select('*')
                ->from('salary_advance_total')
                ->where('id_employee', $employee_id)
                ->get()
                ->result();
        $current = $current[0];
        if ($current->balance >= $amount) {
            $sql = "UPDATE `salary_advance_total` SET 
                `total_out` = `total_out`+'$amount', 
                `balance` = `balance`-'$amount' 
            WHERE `salary_advance_total`.`id_employee` = $employee_id;";
            $this->db->query($sql);
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
