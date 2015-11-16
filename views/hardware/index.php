<div class="container">
    <h3>อุปกรณ์</h3>
    <p>กรอกชื่ออุปกรณ์</p> <?php //insertByID  editByID ?>

    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="form-horizontal" name="editForm" id="editForm" role="form" action="<?php echo URL; ?>hardware/insertByID" method="post">                    <!--modal Header--> 
                    <div class="modal-header">
                        <button id="model-close" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">Form input data</h4>
                    </div>
                    <!---------------->
                    <!--modal Body--> 
                    <div class="modal-body">
                        <div id="formAlert"></div>
                        <div class="form-group" id="div_hardware_id">
                            <label class="control-label col-sm-2" for="hardware_id">รหัสแก้ไข :</label>
                            <div class="col-sm-10" >
                                <input type="text" id="hardware_id" name="hardware_id" class="form-control" readonly />
                            </div>
                        </div>
                        <div class="form-group" id="div_hardware_name" name="div_hardware_name">
                            <label class="control-label col-sm-2" for="hardware_name">ชื่ออุปกรณ์ :</label>
                            <div class="col-sm-10" >
                                <input type="text" id="hardware_name" name="hardware_name" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="hardware_type_id">ประเภทอุปกรณ์ :</label>
                            <div class="col-sm-10" >
                                <select class="form-control" id="hardware_type_id" name="hardware_type_id" onchange="
                        if (this.value === '99') {
                        }">
                                            <?php
                                            foreach ($this->getHardwareTypeRs as $value) {
                                                echo "<option value='{$value['hardware_type_id']}'>{$value['hardware_type_name']}</option>";
                                            }
                                            ?>
                                </select><br />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="hardware_group_id">กลุ่มอุปกรณ์ :</label>
                            <div class="col-sm-10" >
                                <select class="form-control" id="hardware_group_id"  name="hardware_group_id">
                                    <option value="1">กลุ่ม 1</option>
                                    <option value="2">กลุ่ม 2</option>

                                </select><br />
                            </div>

                        </div>

                        <div class="form-group" id="div_hardware_sort" name="div_hardware_sort">
                            <label class="control-label col-sm-2" for="hardware_sort">Sort :</label>
                            <div class="col-sm-10" >
                                <input type="text" id="hardware_sort" name="hardware_sort" class="form-control" value ="Max Sort" />
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
        <!--        <div class="panel-heading">
                    <h3 class="panel-title">Panel title</h3>
                </div>-->
        <div class="panel-body">
            <div class="row">
                <div class="col-md-10">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="item_type_id_Filter">กรองอุปกรณ์  :</label>
                        <div class="col-sm-10" >
                            <select class="form-control" id="item_type_id_Filter" name="item_type_id_Filter" onchange="
                                if (this.value === '99') {
                                }">
                                        <?php
                                        foreach ($this->getHardwareTypeRs as $value) {
                                            echo "<option value='{$value['hardware_type_id']}'>{$value['hardware_type_name']}</option>";
                                        }
                                        ?>
                            </select><br />
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="button" id="show_dialog" class="btn btn-warning btn-block" data-toggle="modal" data-target=".bs-example-modal-lg">
                        <span class="glyphicon glyphicon-plus"></span><br />เพิ่มอุปกรณ์ใหม่
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="pagin" align="right" style="margin: -20px 10px;"></div>
<br/>
<div id="listings" class="container">
</div>
<hr/>
