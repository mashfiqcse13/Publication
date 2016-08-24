<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*
 * File Developed by MD; Mashfiqur Rahman
 * Email : mashfiqnahid@gmail.com
 * Website : mashfiqnahid.com
 */
?>

<div class="col-md-12">
    <h3>Search Teacher Information : </h3>
    <form action="<?= site_url("contacts/teacher") ?>" method="post">
        <div class="row">
            <div class="form-group col-lg-3">
                <label for="filter_teacher_name">Teacher Name : </label>
                <?= $filter_elements['input_teacher_name'] ?>
            </div>
            <div class="form-group col-lg-3">
                <label for="dropdown_division">Division  : &nbsp; </label>
                <?= $filter_elements['dropdown_division'] ?>
            </div>
            <div class="form-group col-lg-3">
                <label for="dropdown_district">District : &nbsp; </label>
                <?= $filter_elements['dropdown_district'] ?>
            </div>
            <div class="form-group col-lg-3">
                <label for="filter_institute_name">Institute Name : &nbsp;</label>
                <?= $filter_elements['input_institute_name'] ?>
            </div>
        </div>
        <!--        <div class="form-group col-lg-3">
                    <label for="dropdown_upazila">Upazila : &nbsp; </label>
        <?= $filter_elements['dropdown_upazila'] ?>
                </div>-->
        <div class="row">
            
            <div class="form-group col-lg-3">
                <label for="dropdown_subject">Subject : &nbsp; </label>
                <?= $filter_elements['dropdown_subject'] ?>
            </div>
            <div class="form-group col-lg-3">
                <button type="submit" style="margin: 29px 0;" class="btn btn-success">Search Teacher Contact</button>
            </div>
            <div class="form-group col-lg-3">
                <?= anchor("contacts/teacher/reset_filter", 'Click here for Reset Filter', 'class="btn btn-primary" style="margin: 29px 0;" title="Reset"'); ?>
            </div>
            <div class="form-group col-lg-3">
                <?php if ($this->uri->segment(3) !== 'read' && $this->uri->segment(3) !== 'add' && $this->uri->segment(3) !== 'edit') { ?>

                    <input class="only_print pull-right btn btn-primary" type="button"  onClick="window.print()"  style="margin: 29px 0;" value="Print Report"/>
                   

                <?php } ?>
            </div> 
        </div>
    </form>
</div>