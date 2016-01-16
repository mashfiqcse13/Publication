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
    <form action="<?= site_url("admin/manage_contact_teacher") ?>" method="post">
        <div class="form-group col-lg-3">
            <label for="exampleInputName2">Division  : &nbsp; </label>
            <?= $filter_dropdowns['dropdown_division'] ?>
        </div>
        <div class="form-group col-lg-3">
            <label for="exampleInputEmail2">District : &nbsp; </label>
            <?= $filter_dropdowns['dropdown_district'] ?>
        </div>
        <div class="form-group col-lg-3">
            <label for="exampleInputEmail2">Upazila : &nbsp; </label>
            <?= $filter_dropdowns['dropdown_upazila'] ?>
        </div>
        <div class="form-group col-lg-3">
            <label for="exampleInputEmail2">Subject : &nbsp; </label>
            <?= $filter_dropdowns['dropdown_subject'] ?>
        </div>
        <div class="form-group col-lg-3">
            <button type="submit" class="btn btn-success">Search Teacher Contact</button>
        </div>
        <div class="form-group col-lg-3">
            <?= anchor("admin/manage_contact_teacher", 'Click here for Reset Filter', 'class="btn btn-primary" title="Reset"'); ?>
        </div>
    </form>
</div>