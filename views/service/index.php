<?php
//$this->loginFalse();
?>
<div class="container">
    <!--//    make by Shikaru-->
    <h2>การแจ้งซ่อม</h2>
    <?php
    $logged = Session::get('User');
    ?>
    <div class="form-horizontal">        

        <div class="form-group has-feedback">
            <label class="control-label col-sm-2" for="choose_service_status">สถานะการซ่อม : </label>
            <div class="col-sm-10" >
                <select class="form-control selectpicker" id="choose_service_status" name="choose_service_status[]" multiple title='เลือกสถานะการซ่อม...' data-selected-text-format="count>7"></select>                
            </div>
            <input type="hidden" id="txtSearch" name="txtSearch"  value="<?= Session::get('session_txtSearch') ?>" />
        </div>     

        <div class="form-group has-feedback" id="div_search">
            <label class="control-label col-sm-2" for="search">ค้นใบแจ้งซ่อม :</label>
            <div class="col-sm-10" >
                <input type="text" id="search" name="search" class="form-control" />
                <span class="glyphicon glyphicon-search form-control-feedback"></span>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label" for="show_dialog"></label>
            <div class="col-sm-10" >
                <button type="button" id="show_dialog" class="btn btn-primary col-sm-2" data-toggle="modal" data-target=".input-dialog">Add New</button>
                <!--<button type="button" id="show_dialog" class="btn btn-primary col-sm-2" data-toggle="modal" href="#stack1">Add New</button>-->
                <div class="pagin" align="right" style="margin: -20px 10px;"></div>
            </div>
        </div>

    </div>

    <div class="modal fade bs-example-modal-lg input-dialog" tabindex="-1" data-focus-on="input:first">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="service" class="form-horizontal" role="form" action="<?= URL; ?>service/xhrInsert" method="post">
                    <div class="modal-header">
                        <button id="model-close" type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true"><span>&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">ข้อมูลใบขอซ่อม</h4><!--Form Input Data-->
                        <input type="hidden" id="userType" name="userType"  value="<?= $logged['type']; ?>" />
                        <input type="hidden" id="userPerson_id" name="userPerson_id"  value="<?= $logged['person_id']; ?>" />
                        <input type="hidden" id="user_rights" name="user_rights"  value="<?= $logged['CRS_system']; ?>" />
                    </div>
                    <div class="modal-body">

                        <div class="form-group" id="div_service_id">
                            <label class="control-label col-sm-3" for="service_id">เลขที่ :</label>
                            <div class="col-sm-9" >
                                <input type="hidden" id="service_id" name="service_id" class="form-control" readonly />
                                <input type="text" id="service_no" name="service_no" class="form-control" readonly />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="service_year">ปีงบประมาณ <b style="color:red;">*</b> :</label>
                            <div class="col-sm-9" >
                                <select class="form-control" id="service_year" name="service_year"> 
                                    <?php
                                    // getServiceYear
                                    //xhrServiceYear
                                    foreach ($this->getServiceYear as $value) {
                                        echo "<option value='{$value['service_year']}'>{$value['service_year']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3" for="service_type">เรื่อง <b style="color:red;">*</b> :</label>
                            <div class="col-sm-9" >
                                <label class="radio-inline"><input type="radio" id="service_type_1" name="service_type" value="repair" checked="checked" />แจ้งซ่อม</label>
                                <label class="radio-inline"><input type="radio" id="service_type_2" name="service_type" value="other" />แจ้งรายการอื่นๆ</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="service_depart">จากหน่วยงาน <b style="color:red;">*</b> :</label>
                            <div class="col-sm-9" >
                                <select class="form-control selectpicker selectpicker-live-search" id="service_depart" name="service_depart" >
                                    <?php
                                    foreach ($this->getDepart as $value) {
                                        $selected = ($logged['depart_id'] == $value['depart_id']) ? 'selected' : '';
                                        echo "<option value='{$value['depart_id']}' {$selected}>{$value['depart_name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3" for="items_name">ชื่ออุปกรณ์ <b style="color:red;">*</b> :</label>
                            <div class="col-sm-7" >
                                <input type="text" id="items_name" name="items_name" class="form-control readOnly" readonly/>
                                <input type="hidden" id="items_id" name="items_id" />
                                <input type="hidden" id="hardware_id" name="hardware_id" />
                                <input type="hidden" id="hardware_type_id" name="hardware_type_id" />
                            </div>
                            <button type="button" id="choose-items" class="btn btn-primary col-sm-2" data-toggle="modal" data-target=".frm-choose-items">Choose Items</button>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3" for="sn_scph">เลขครุภัณฑ์ <b style="color:red;">*</b> :</label>
                            <div class="col-sm-7" >
                                <input type="text" id="sn_scph" name="sn_scph" class="form-control readOnly" readonly/>
                            </div>
                        </div>

                        <div class="form-group" id="div_service_symptom_text">
                            <label class="control-label col-sm-3 service_symptom_text" for="service_symptom_text">อาการเสีย :</label>
                            <div class="col-sm-9" >
                                <textarea id="service_symptom_text" name="service_symptom_text" class="form-control"/></textarea>
                            </div>
                        </div>

                        <?php if ($logged['type'] == 'staff') { ?>
                            <div class="form-group" id="div_service_user">
                                <label class="control-label col-sm-3" for="service_user_name">ผู้ส่งซ่อม <b style="color:red;">*</b> :</label>
                                <div class="col-sm-7" >
                                    <input type="text" id="service_user_name" name="service_user_name" class="form-control readOnly" value="<?= $logged['prefix'] . $logged['firstname'] . ' ' . $logged['lastname'] ?>" readonly/>
                                    <input type="hidden" id="service_user" name="service_user" value="<?= $logged['person_id'] ?>" />
                                    <input type="hidden" id="service_user_name2" name="service_user_name2" value="<?= $logged['prefix'] . $logged['firstname'] . ' ' . $logged['lastname'] ?>" />
                                </div>
                                <button type="button" id="choose-person" class="btn btn-primary col-sm-2" data-toggle="modal" data-target=".frm-choose-person">Choose Person</button>
                            </div>                        
                            <?php
                        } else {
                            echo "<input type='hidden' id='service_user' name='service_user' value='{$logged['person_id']}' />";
                        }
                        ?>

                    </div>
                    <?php if ($logged['type'] == 'staff') { ?>
                        <div class="modal-footer">
                            <h4 class="modal-title" id="gridSystemModalLabel"></h4>
                        </div>
                        <div class="modal-header" style="margin-top: -30px">
                            <h4 class="modal-title" id="gridSystemModalLabel">เจ้าหน้าที่บันทึกการซ่อม</h4>
                        </div>
                        <div class="modal-body">

                            <div class="form-group" id="div_service_symptom">
                                <label class="col-sm-3 control-label" for="service_symptom">อาการเสีย <b style="color:red;">*</b> :</label>
                                <div class="col-sm-9" >
                                    <select class="form-control" id="service_symptom" name="service_symptom">

                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-3" for="service_remark">สาเหตุ <b style="color:red;">*</b> :</label>
                                <div class="col-sm-9" >
                                    <textarea id="service_remark" name="service_remark" class="form-control"></textarea>
                                    <!--<input type="text" id="service_symptom_text" name="service_symptom_text" class="form-control" />-->
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="service_status_id">การซ่อม <b style="color:red;">*</b> :</label>
                                <div class="col-sm-9" >
                                    <select class="form-control" id="service_status_id" name="service_status_id"> 
                                        <?php
                                        foreach ($this->getServiceStatus as $value) {
                                            echo "<option value='{$value['service_status_id']}'>{$value['service_status_name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-3" for="service_text">รายละเอียด :</label>
                                <div class="col-sm-9" >
                                    <textarea id="service_text" name="service_text" class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-3" for="service_servicedate">วันที่รับเรื่อง <b style="color:red;">*</b> :</label>
                                <div class="col-sm-9" >
                                    <input type="text" id="service_servicedate" name="service_servicedate" class="form-control" />
                                </div>
                            </div>

                            <div class="form-group" >
                                <label class="col-sm-3 control-label" for="service_cause">สาเหตุการชำรุด <b style="color:red;">*</b> :</label>
                                <div class="col-sm-9" >
                                    <select class="form-control" id="service_cause" name="service_cause">                  
                                        <?php
                                        /*
                                         *   กำลังปรับ ########################
                                         */
                                        ?>
                                        <?php
                                        foreach ($this->getServiceCause as $value) {
                                            echo "<option value='{$value['service_cause_id']}'>{$value['service_cause_name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group" id="div_service_cause_text">
                                <label class="control-label col-sm-3" for="service_cause_text">ระบุสาเหตุ :</label>
                                <div class="col-sm-9" >
                                    <textarea id="service_cause_text" name="service_cause_text" class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-sm-3" for="service_kpi3day">ซ่อมเสร็จภายใน 3 วัน <b style="color:red;">*</b> :</label>
                                <div class="col-sm-9" >
                                    <label class="radio-inline"><input type="radio" id="service_kpi3day_1" name="service_kpi3day" value="pass" checked="checked" />ทันเวลา</label>
                                    <label class="radio-inline"><input type="radio" id="service_kpi3day_2" name="service_kpi3day" value="fail" />ไม่ทันเวลา</label>
                                </div>
                            </div>

                            <div class="form-group" id="div_service_kpi3day_text">
                                <label class="control-label col-sm-3" for="service_kpi3day_text">ระบุสาเหตุซ่อมเกิน 3 วัน :</label>
                                <div class="col-sm-9" >
                                    <textarea id="service_kpi3day_text" name="service_kpi3day_text" class="form-control"></textarea>
                                </div>
                            </div>

                        </div>
                    <?php } ?>
                    <div class="modal-footer">

                        <button type="submit" id="btn_submit" class="btn btn-lg btn-primary">Save
                            <span class="glyphicon glyphicon-off"></span>
                        </button>
                        <button type="button" id="btn_clear" class="btn btn-lg">Clear
                            <span ></span>
                        </button>
                        <button type="reset" id="btn_reset" class="btn btn-lg btn-danger">Reset
                            <span class="glyphicon glyphicon-repeat"></span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg frm-choose-items" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="form-horizontal">   
                    <div class="modal-header">
                        <button id="model-items-close" type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true"><span>&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">เลือกอุปกรณ์</h4><!--Choose Items Data-->
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="choose_hardware_type_id">ประเภทอุปกรณ์ :</label>
                            <div class="col-sm-10" >
                                <select class="form-control" id="choose_hardware_type_id" name="choose_hardware_type_id">
                                    <option value="0">--ทุกประเภท--</option>
                                    <?php
                                    foreach ($this->getHardwareType as $value) {
                                        echo "<option value='{$value['hardware_type_id']}'>{$value['hardware_type_name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="choose_hardware_id">อุปกรณ์ :</label>
                            <div class="col-sm-10" >
                                <select class="form-control" id="choose_hardware_id" name="choose_hardware_id">
                                    <!--<option value="0">--ทั้งหมด--</option>-->
                                    <?php
                                    foreach ($this->getHardware as $value) {
                                        echo "<option value='{$value['hardware_id']}'>{$value['hardware_name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <label class="control-label col-sm-2" for="choose_search_items">คำค้น :</label>
                            <div class="col-sm-10">
                                <input type="text" id="choose_search_items" name="choose_search_items" class="form-control" />
                                <span class="glyphicon glyphicon-search form-control-feedback"></span>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div class="pagin-items" align="right" style="margin: -20px 10px;"></div>
                    </div>
                </div>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-center" width="40px">#</th>
                            <th class="text-center" width="150">รหัสเครื่อง</th>
                            <th class="text-center" width="200px">เลขครุภัณฑ์</th>
                            <th class="text-center" width="160px">หน่วยงาน</th>
                            <th class="text-center" width="100px">ประเภท</th>
                            <th class="text-center">ยี่ห้อ รุ่น</th>
                            <th class="text-center" width="100px">วันที่จัดซื้อ</th>
                            <th class="text-center" width="100px">หมดประกัน</th>
                            <!--<th style="text-align: center;" width="100px">เลือก</th>-->
                        </tr>
                    </thead>
                    <tbody id="select_items_data">            
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg frm-choose-person" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="form-horizontal">   
                    <div class="modal-header">
                        <button id="model-person-close" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">Choose Person data</h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group has-feedback">
                            <label class="control-label col-sm-2" for="choose_search_person">คำค้น :</label>
                            <div class="col-sm-10" >
                                <input type="text" id="choose_search_person" name="choose_search_person" class="form-control" />
                                <span class="glyphicon glyphicon-search form-control-feedback"></span>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div class="pagin-person" align="right" style="margin: -20px 10px;"></div>
                    </div>
                </div>

                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th width="130px">เลขประจำตัว</th>
                            <th width="280px">ชื่อ-สกุล</th>
                            <th>หน่วยงาน</th>
                            <!--<th style="text-align: center;" width="100px">เลือก</th>-->
                        </tr>
                    </thead>
                    <tbody id="select_person_data">            
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg frm-edit-items" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="items" class="form-horizontal" role="form" action="<?= URL; ?>items/xhrInsert" method="post">
                    <div class="modal-header">
                        <button id="model-close" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">Form input data</h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group" id="div_items_id">
                            <label class="control-label col-sm-2" for="items_id">รหัสแก้ไข :</label>
                            <div class="col-sm-10" >
                                <input type="text" id="items_id" name="items_id" class="form-control" readonly />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="items_group">กลุ่มอุปกรณ์ :</label>
                            <div class="col-sm-10" >
                                <select class="form-control" id="items_group" name="items_group">
                                    <?php
                                    foreach ($this->getItemsCode as $value) {
                                        echo "<option value='{$value['items_code']}'>{$value['description']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="items_code">รหัสเครื่อง :</label>
                            <div class="col-sm-10" >
                                <input type="text" id="items_code" name="items_code" class="form-control" readonly/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="sn_scph">เลขครุภัณฑ์ <b style="color: red;">*</b> :</label>
                            <div class="col-sm-10" >
                                <input type="text" id="sn_scph" name="sn_scph" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="serial_number">serial_number :</label>
                            <div class="col-sm-10" >
                                <input type="text" id="serial_number" name="serial_number" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="hardware_id">อุปกรณ์ <b style="color: red;">*</b> :</label>
                            <div class="col-sm-10" >
                                <select class="form-control" id="hardware_id" name="hardware_id">
                                    <?php
                                    foreach ($this->getHardware as $value) {
                                        echo "<option value='{$value['hardware_id']}'>[{$value['hardware_type_name']}] {$value['hardware_name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="brand">ยี่ห้อ <b style="color: red;">*</b> :</label>
                            <div class="col-sm-10" >
                                <input type="text" id="brand" name="brand" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="model">รุ่น <b style="color: red;">*</b> :</label>
                            <div class="col-sm-10" >
                                <input type="text" id="model" name="model" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="items_name">ชื่อเครื่อง :</label>
                            <div class="col-sm-10" >
                                <input type="text" id="items_name" name="items_name" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="ipaddress">IP Address :</label>
                            <div class="col-sm-10" >
                                <input type="text" id="ipaddress" name="ipaddress" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="depart_id">หน่วยงาน <b style="color: red;">*</b> :</label>
                            <div class="col-sm-10" >
                                <select class="form-control" id="depart_id" name="depart_id">
                                    <?php
                                    foreach ($this->getDepart as $value) {
                                        echo "<option value='{$value['depart_id']}'>{$value['depart_name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="buydate">วันที่เริ่มนับประกัน <b style="color: red;">*</b> :</label>
                            <div class="col-sm-10" >
                                <input type="text" id="buydate" name="buydate" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="expdate">วันที่หมดประกัน <b style="color: red;">*</b> :</label>
                            <div class="col-sm-10" >
                                <input type="text" id="expdate" name="expdate" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="distribute_date">วันที่จำหน่ายครุภัณฑ์ :</label>
                            <div class="col-sm-10" >
                                <input type="text" id="distribute_date" name="distribute_date" class="form-control" />
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btn_submit" class="btn btn-lg btn-primary">Save
                            <span class="glyphicon glyphicon-off"></span>
                        </button>
                        <button type="button" id="btn_reset" class="btn btn-lg">Clear
                            <span ></span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!--// create by komsan 11/06/2558        modal fade bs-example-modal-lg      -->

    <div class="modal fade bs-example-modal-lg2 frm-choose-partManagement" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg2">
            <div class="modal-content">
                <form id="partManagement" name="partManagement" class="form-horizontal" role="form" action="<?= URL; ?>parts_items/xhrInsertPart" method="post">
                    <div class="modal-header">
                        <button id="model-close" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel" >Management :: <label id="service_items_name"></label></h4>
                        <input type="hidden" id="userPerson_id" name="userPerson_id" value="<?= $logged['person_id']; ?>" />
                    </div>
                    <div class="modal-body">
                        <!--tabs-->
                        <ul class="nav nav-tabs">
                            <li id="li-tab-parts" class="active"><a data-toggle="tab" href="#tab-jobs">งานซ่อม</a></li>
                            <li id="li-tab-parts"><a data-toggle="tab" href="#tab-parts">อะไหล่</a></li>
                        </ul>
                        <!------>
                        <div class="tab-content">
                            <!--tab content for "#home"-->
                            <div id="tab-jobs" class="tab-pane fade in active">
                                <div class="col-md-12" >
                                    <button type="button" id="choose-jobs" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".frm-choose-jobs">เลือกงานซ่อม</button>
                                </div>
                                <div class="col-md-12" id="no-more-tables" >
                                    <table class="col-md-12 table-striped table-bordered table-condensed cf">
                                        <thead class="cf">
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">รายการ</th>
                                                <th class="text-center numeric">ราคา/หน่วย</th>
                                                <th class="text-center numeric">จำนวน</th>
                                                <th class="text-center numeric">ราคารวม</th>
                                                <th class="text-center">วันที่</th>
                                                <th class="text-center">เจ้าหน้าที่</th>
                                                <th class="text-center">ลบ</th>
                                                <th style="display: none;">jobs_items_id</th>
                                                <th style="display: none;">hos_guid</th>
                                                <th style="display: none;">manage</th>
                                            </tr>
                                        </thead>
                                        <tbody id="select_jobsManagement_data"></tbody>
<!--                                    <tfoot>
                                            <tr>
                                                <td class="text-center col-sm-6" colspan="4"></td>
                                                <td class="text-right col-sm-2"></td>
                                                <td class="text-right col-sm-4" colspan="3"></td>
                                            </tr>
                                        </tfoot>  -->
                                    </table>
                                </div>
                                <div class="col-md-12 text-success">&nbsp;&nbsp;&nbsp;&nbsp;--Job&nbsp;ทั้งหมด--&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" class="text-right" id="sum_price_all_jobs" name="sum_price_all_jobs" size="8" value="SUM&nbsp;ALL" disabled />
                                    <input type="hidden" id="arrJobs" name="arrJobs" value="">
                                </div>
                            </div>
                            <!--tab content for "#menu1"-->
                            <div id="tab-parts" class="tab-pane fade ">
                                <div class="col-md-12" >
                                    <button type="button" id="choose-parts" class="btn btn-sm btn-primary" data-toggle="modal" data-target=".frm-choose-parts">เลือกอะไหล่</button>
                                </div>
                                <div class="col-md-12" id="no-more-tables" >
                                    <table class="col-md-12 table-bordered table-striped table-condensed cf">
                                        <thead class="cf">
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">ใบสั่งซื้อ</th><!--LOT&nbsp;NO-->
                                                <th class="text-center">ประเภท</th><!--TYPE NAME-->
                                                <th class="text-center">รุ่น</th><!--MODEL NAME-->
                                                <th class="text-center">SERIAL</th><!--SERIAL-->
                                                <th class="text-center numeric">หน่วยนับ</th><!--TYPE COUNT-->
                                                <th class="text-center numeric">ราคา/หน่วย</th><!--SUM PRICE-->
                                                <th class="text-center numeric">จำนวน</th><!--LOT&nbsp;NO-->
                                                <th class="text-center numeric">รวมราคา</th><!--LOT&nbsp;NO-->
                                                <th class="text-center">วันที่</th><!--DATE-->
                                                <th class="text-center numeric">คงเหลือ</th><!--STOCK-->
                                                <th class="text-center">ลบ</th><!--DELETE-->
                                                <th style="display: none; " width="100px">parts_items_id</th>
                                                <th style="display: none; " width="100px">qty_old</th>
                                                <th style="display: none; " width="1px">hos_guid</th>
                                                <th style="display: none; " width="1px">manage</th>
                                            </tr>
                                        </thead>
                                        <tbody id="select_partManagement_data"></tbody>
                                    </table>
                                </div>
                                <div class="col-md-12 text-success">&nbsp;&nbsp;&nbsp;&nbsp;--Part&nbsp;ทั้งหมด--&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="text" class="text-right" id="sum_price_all_parts" name="sum_price_all_parts" size="8" value="SUM&nbsp;ALL" disabled />
                                    <input type="hidden" id="arrParts" name="arrParts" value="">
                                </div>
                            </div>
                        </div>

                        <table class="table table-striped">
                            <tr>
                                <td class="col-xs-3 col-md-2 col-lg-2 text-center">ราคารวม <label id="sumAllService" name="sumAllService">1.00</label> บาท</td>
                                <td class="col-xs-4 col-md-3 col-lg-2 text-center"> [<label id="sumAllServiceThaiBaht" name="sumAllServiceThaiBaht">หนึ่งบาทถ้วน</label>] </td>
                                <td class="col-xs-5 col-md-7 col-lg-8 text-right"><button type="submit" id="btn_submit_jobpart" class="btn btn-primary">Save
                                        <span class="glyphicon glyphicon-off"></span>
                                    </button>
                                    <button type="button" id="btn_reset_jobpart" class="btn btn-danger">Reset
                                        <span class="glyphicon glyphicon-repeat"></span>
                                    </button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg frm-choose-parts" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="form-horizontal">   
                    <div class="modal-header">
                        <button id="model-items-close" type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true"><span>&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">เลือกอะไหล่ซ่อม</h4><!--Choose Parts Data-->
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="show_store_type_id">ประเภท :</label>
                            <div class="col-sm-8" >
                                <select class="form-control" id="show_store_type_id" name="show_store_type_id">
                                    <option value="0">--ทุกประเภท--</option>
                                    <?php
                                    foreach ($this->storeTypeRs as $value) {
                                        echo "<option value='{$value['store_type_id']}'>{$value['store_type_name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group has-feedback">
                            <label class="control-label col-sm-2" for="choose_search_parts">คำค้น :</label>
                            <div class="col-sm-10">
                                <input type="text" id="choose_search_parts" name="choose_search_parts" class="form-control" />
                                <span class="glyphicon glyphicon-search form-control-feedback"></span>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div class="pagin-parts" align="right" style="margin: -20px 10px;"></div>
                    </div>
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="col-xs-1 col-lg-1 text-center"width="40px">#</th>
                            <th class="col-xs-1 col-lg-1 text-center"width="60px">ใบสั่งซื้อ</th>
                            <th class="col-xs-1 col-lg-1 text-center"width="180px">ประเภท</th>
                            <th>รุ่น</th>
                            <th class="col-xs-1 col-lg-1 text-center"width="100px">SERIAL</th>
                            <th class="col-xs-1 col-lg-1 text-center"width="50px">หน่วยนับ</th>
                            <th class="col-xs-1 col-lg-1 text-center"width="50px">จำนวน</th>
                            <th class="col-xs-1 col-lg-1 text-center"width="100px">วันที่เพิ่ม</th>
                            <th class="col-xs-1 col-lg-1 text-center"width="100px">เลือก</th>

                        </tr>
                    </thead>
                    <tbody id="select_parts_data">            
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg frm-choose-jobs" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="form-horizontal">   
                    <div class="modal-header">
                        <button id="model-items-close" type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true"><span>&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">เลือกงานซ่อม</h4><!--Choose Jobs Data-->
                    </div>
                    <div class="modal-body">

                        <div class="form-group has-feedback">
                            <label class="control-label col-sm-2" for="choose_search_jobs">คำค้น :</label>
                            <div class="col-sm-10">
                                <input type="text" id="choose_search_jobs" name="choose_search_jobs" class="form-control" />
                                <span class="glyphicon glyphicon-search form-control-feedback"></span>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div class="pagin-jobs" align="right" style="margin: -20px 10px;"></div>
                    </div>
                </div>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="col-xs-1 col-lg-1 text-center"width="100px">#</th>
                            <th class="col-xs-1 col-lg-1 text-center"width="100px">รายการงาน</th>
                            <th class="col-xs-1 col-lg-1 text-center"width="100px">ราคา/หน่วย</th>
                            <th class="col-xs-1 col-lg-1 text-center"width="100px">กลุ่มงาน</th>
                            <th style="display: none; " width="1px" >jobs_items_id</th>
                            <th style="display: none; " width="1px" >hos_guid</th>
                            <th class="col-xs-1 col-lg-1 text-center"width="100px">เลือก</th>
                        </tr>
                    </thead>
                    <tbody id="select_jobs_data">            
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <!--////////////////table view main/////////////////// table table-striped table-bordered-->
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th style="text-align: center;" width="50px">#</th>
                <th style="text-align: center;" width="80px">รหัสเครื่อง</th>
                <th style="text-align: center;" width="180px">เลขคุรุภัณฑ์</th>
                <th style="text-align: center;" width="150px">หน่วยงาน</th>
                <th style="text-align: center;">รุ่น</th>
                <th style="text-align: center;" width="90px">วันรับเรื่อง</th>
                <th style="text-align: center;" width="170px">อาการเสีย</th>
                <th style="text-align: center;" width="170px">ผู้รับเรื่อง</th>
                <?php
                if ($logged['type'] == 'staff') {
                    echo '<th style="text-align: center;" width="80px">สถานะซ่อม</th>';
                }
                ?>
                <th style="text-align: center;" width="40px">จัดการ</th>
            </tr>
        </thead>
        <tbody id="select_service_data">            
        </tbody>
    </table>
    <hr/>
</div>