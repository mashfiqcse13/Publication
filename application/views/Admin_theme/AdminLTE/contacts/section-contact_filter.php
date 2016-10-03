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

<div class="col-md-12 form_input_work">
    <h3>Search Teacher Information : </h3>
    <form action="<?= site_url("contacts/teacher") ?>" method="post" class="form-inline">  
        <div class="row">
            <div class="form-group col-md-3 div_45">
                <label for="filter_teacher_name">Teacher Name : </label>
                <?= $filter_elements['input_teacher_name'] ?>
            </div>
            <div class="form-group col-md-3 div_45">
                <label for="dropdown_division">Division  : &nbsp; </label>
                <?= $filter_elements['dropdown_division'] ?>
            </div>
            <div class="form-group col-md-3 div_45">
                <label for="dropdown_district">District : &nbsp; </label>
                <?= $filter_elements['dropdown_district'] ?>
            </div>
            <div class="form-group col-md-3 div_45">
                <label for="filter_institute_name">Institute Name : &nbsp;</label>
                <?= $filter_elements['input_institute_name'] ?>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-3 div_45">
                <label for="dropdown_upazila">Upazila : &nbsp; </label>
                <?= $filter_elements['dropdown_upazila'] ?>
            </div>
            <div class="form-group col-lg-3 div_45">
                <label for="dropdown_subject">Subject : &nbsp; </label>
                <?= $filter_elements['dropdown_subject'] ?>
            </div>
            <div class="form-group col-lg-6 teacher_button_area">
                <div class="row">
                    <div class="col-sm-4">
                        <button type="submit" style="margin: 29px 0;" class="btn btn-success">Search Teacher Contact</button>
                    </div>
                    <div class="col-sm-4">
                        <?= anchor("contacts/teacher/reset_filter", 'Reset Filter', 'class="btn btn-primary" style="margin:29px 0" title="Reset"'); ?>
                    </div>
                    <div class="col-sm-4">
                        <?php if ($this->uri->segment(3) !== 'read' && $this->uri->segment(3) !== 'add' && $this->uri->segment(3) !== 'edit') { ?>
                        <input class="only_print btn btn-primary " type="button"  onClick="window.print()" style="margin:29px 0" value="Print Report"/>
                        <?php } ?>
                        </div>
                    </div>




                    


                
            </div>
            <!--            <div class="form-group col-md-3">
                            
                        </div> -->
        </div>
    </form>
</div>

<style>
    .form_input_work input{width:100%!important}
    .teacher_button_area .btn{
        width:152px!important;
    }
    @media only print{
        table tr th:nth-child(10) {
            display: none;
        }

        table tr td:nth-child(10) {
            display: none;
        }
        .flexigrid div.bDiv td {
            border: 1px solid #222;
        }
        table, tr, td, th, tbody, thead {
            border: 1px solid #222!important;
        }
        
    } 
    

    @media only screen and (max-width:1000px){
        .form-group .teacher_button_area {
            width: 100%;
        }
        .form-group.col-md-3.div_45 {
            width: 45%!important;
        }

      .form-group.col-lg-3.div_45 {
            width: 45%!important;
        }
       
    }
    @media only screen and  (max-wdith:750px){
               .form-group.col-md-3.div_45 {
            width: 100%!important;
        }

      .form-group.col-lg-3.div_45 {
            width: 100%!important;
        }
    }
    

    
</style>