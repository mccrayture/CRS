<div class="container">
    <!--    <div class="page-header">
            <h1>รายการงานซ่อม <small>...</small></h1>
        </div> -->
    <h3>รายการงานซ่อม</h3>
    <p></p> <?php //insertByID  editByID ?>

    <div class="modal fade bs-example-modal-lg" id="frm-new-jobs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="form-horizontal" name="editForm" id="editForm" role="form" action="<?php echo URL; ?>jobs/insertByID" method="post">
                    <!--modal Header--> 
                    <div class="modal-header bg-primary">
                        <button id="model-close" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">Form input data</h4>
                    </div>
                    <!---------------->
                    <!--modal Body--> 
                    <div class="modal-body">
                        <div id="formAlert"></div>
                        <div class="form-group" id="div_jobs_id">
                            <label class="control-label col-sm-2" for="jobs_id">รหัสแก้ไข :</label>
                            <div class="col-sm-10" >
                                <input type="text" id="jobs_id" name="jobs_id" class="form-control" readonly />
                            </div>
                        </div>
                        <div class="form-group" id="div_jobs_name" name="div_jobs_name">
                            <label class="control-label col-sm-2" for="jobs_name">ชื่องานซ่อม :</label>
                            <div class="col-sm-10" >
                                <input type="text" id="jobs_name" name="jobs_name" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group" id="div_jobs_unit_price" name="div_jobs_name">
                            <label class="control-label col-sm-2" for="jobs_name">ราคาต่อหน่วย :</label>
                            <div class="col-sm-10" >
                                <input type="number" min="0" id="jobs_unit_price" name="jobs_unit_price" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="jobs_group_id">กลุ่ม :</label>
                            <div class="col-sm-10" >
                                <select class="form-control" id="jobs_group" name="jobs_group" onchange="
                                        if (this.value === '99') {
                                        }">
                                            <?php
                                            foreach ($this->jobGroupRS as $value) {
                                                echo "<option value='{$value['jobs_group_id']}'>{$value['jobs_group_name']}</option>";
                                            }
                                            ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="div_jobs_sort" name="div_jobs_sort">
                            <label class="control-label col-sm-2" for="jobs_sort">Sort :</label>
                            <div class="col-sm-10" >
                                <input type="text" id="jobs_sort" name="jobs_sort" class="form-control" value ="Max Sort" />
                            </div>
                        </div>

                    </div>
                    <!---------------->
                    <!--modal Footer-->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-lg btn-primary" id="btn_submit" name="btn_submit" >Save
                            <span class="glyphicon glyphicon-off"></span>
                        </button>
                        <button type="reset" value = "reset" class="btn btn-lg" id="btn_reset" name="btn_reset" >Reset
                            <span ></span>
                        </button>
                    </div>
                    <!---------------->
                </form>
            </div>
        </div>
    </div>
    <hr/>
</div>
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading">Search filter</div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-10">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="jobs_group_id_Filter">filter :</label>
                        <div class="col-sm-10" >
                            <select class="form-control" id="jobs_group_id_Filter" name="jobs_group_id_Filter" onchange="
                                    if (this.value === '99') {
                                    }">
                                        <?php
                                        foreach ($this->jobGroupRS as $value) {
                                            echo "<option value='{$value['jobs_group_id']}'>{$value['jobs_group_name']}</option>";
                                        }
                                        ?>
                            </select><br />
                        </div>
                    </div> 
                </div>
                <div class="col-md-2">
                    <button type="button" id="show_dialog" class="btn btn-warning btn-block" data-toggle="modal" data-target=".bs-example-modal-lg">
                        <span class="glyphicon glyphicon-plus"></span><br />Add New Job
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="pagin" align="right" style="margin: -20px 10px;"></div>
</div>
<div id="listings" class="container">
</div>
<hr/>

