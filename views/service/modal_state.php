<!--// State Change--> 
<?php $logged = Session::get('User'); ?>
<div class="modal fade bs-example-modal-lg frm-choose-state" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="form-horizontal">   
                <div class="modal-header bg-primary">
                    <button id="model-state-close" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">Change State</h4>
                </div>
                <div class="modal-body">

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="service_id">id : </label>
                        <div class="col-sm-10" >
                            <input type="text" class="form-control" id="service_id" name="service_id" readonly />
                        </div>
                    </div>
                    <div class="form-group has-feedback">
                        <label class="control-label col-sm-2" for="choose_service_detail_status">สถานะการซ่อม : </label>
                        <div class="col-sm-10" >
                            <select class="form-control" id="choose_service_detail_status_id" name="choose_service_detail_status_id">service_detail_list</select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-2" for="service_text">รายละเอียด :</label>
                        <div class="col-sm-10" >
                            <textarea id="service_detail_text" name="service_detail_text" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="div_service_coworker form-group">
                        <label class="col-sm-2 control-label" for="service_coworker">ผู้ปฏิบัติ <!--b style="color:red;">*</b--> :</label>
                        <div class="col-sm-10" >
                            <select class="form-control selectpicker selectpicker-live-search" id="service_coworker" name="service_coworker[]" multiple title='เลือกผู้ร่วมดำเนินการซ่อม...' data-selected-text-format="count>5">
                                <?php
                                foreach ($this->getTechnicianList as $value) {
                                    $disabled = ($logged['person_id'] == $value['technician_cid']) ? 'disabled="disabled"' : '';
                                    echo "<option value='{$value['technician_cid']}' $disabled>" . ($value['prefix'] . $value['firstname'] . " " . $value['lastname']) . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="div_service_borrow form-group">
                        <label class="col-sm-2 control-label" for="service_borrow"></label>
                        <div class="col-sm-10" >
                            <button type="button" id="service_borrow" class="btn btn-primary col-sm-2" data-toggle="modal" data-target=".frm-choose-items">ยืมเครื่อง</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-12 text-center" style="color:red;"> * กรณีมีผู้ปฏิบัติมากกว่า 1 คน ให้เลือก "สถานะการซ่อม" เป็น "ดำเนินการ" แล้วเลือกผู้ปฏิบัติเพิ่มเติม</label>
                    </div>
                    
                    <table class="table table-striped table-bordered table-condensed" id="table-state_data">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">สถานะ</th>
                                <th class="text-center">เวลา</th>
                                <th class="text-center">การปฏิบัติ</th>
                                <th class="text-center">รายละเอียด</th>
                                <th class="text-center">ลบ</th>
                            </tr>
                        </thead>
                        <tbody id="state_data"></tbody>
                    </table>

                </div>
                <div class="modal-footer">
                    <button id="btn_submit_change_state" class="btn btn-lg btn-primary">Save <span class="glyphicon glyphicon-off"></span></button>
                    <button id="btn_reset_state_change" class="btn btn-lg btn-danger">Reset <span class="glyphicon glyphicon-repeat"></span></button>
                </div>
            </div>
        </div>
    </div>
</div>