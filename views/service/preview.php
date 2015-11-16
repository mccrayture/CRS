<!--// State Change--> 
<div class="modal fade bs-example-modal-lg frm-preview" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="form-horizontal">   
                <div class="modal-header bg-primary">
                    <button id="model-preview-close" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="gridSystemModalLabel">ข้อมูลการซ่อม</h4>
                </div>
                <div class="modal-body">

                    <div class="panel-group" id="accordion">
                        <div class="panel panel-default" id="panel1">
                            <div class="panel-heading" onmouseover="this.style.cursor = 'pointer'" data-toggle="collapse" data-target="#collapseOne">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-target="#collapseOne"></a>
                                    รายละเอียดใบส่งซ่อม
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in">
                                <div class="panel-body text-left">
                                    <div class='row'> 
                                        <div class='col-xs-6 col-lg-2'><strong>เลขที่ :</strong></div> 
                                        <div class='col-xs-6 col-lg-4 service_id'></div> 
                                        <div class='col-xs-6 col-lg-2'><strong>ปีงบประมาณ :</strong></div> 
                                        <div class='col-xs-6 col-lg-4 service_year'></div> 
                                    </div> 
                                    <div class='row'> 
                                        <div class='col-xs-6 col-lg-2'><strong>หน่วยงาน :</strong></div> 
                                        <div class='col-xs-6 col-lg-4 depart_name'></div> 
                                        <div class='col-xs-6 col-lg-2'><strong>เรื่อง :</strong></div> 
                                        <div class='col-xs-6 col-lg-4 service_type'></div> 
                                    </div> 
                                    <div class='row'> 
                                        <div class='col-xs-6 col-lg-2'><strong>ชื่ออุปกรณ์ :</strong></div> 
                                        <div class='col-xs-6 col-lg-4 brand_model'></div> 
                                        <div class='col-xs-6 col-lg-2'><strong>เลขครุภัณฑ์ :</strong></div> 
                                        <div class='col-xs-6 col-lg-4 items_depart_name'></div> 
                                    </div> 
                                    <div class='row'> 
                                        <div class='col-xs-6 col-lg-2'><strong>อาการเสีย :</strong></div> 
                                        <div class='col-xs-6 col-lg-4 sym_name'></div> 
                                        <div class='col-xs-6 col-lg-2'><strong>หมายเหตุ :</strong></div> 
                                        <div class='col-xs-6 col-lg-4 service_symptom_text'></div> 
                                    </div> 
                                    <div class='row'> 
                                        <div class='col-xs-6 col-lg-2'><strong>ผู้ส่งซ่อม :</strong></div> 
                                        <div class='col-xs-6 col-lg-4 service_user'></div> 
                                        <div class='col-xs-6 col-lg-2'><strong>เจ้าหน้าที่บันทึก :</strong></div> 
                                        <div class='col-xs-6 col-lg-4 service_technician'></div> 
                                    </div> 
                                    <div class='row'> 
                                        <div class='col-xs-6 col-lg-2'><strong>สาเหตุ :</strong></div> 
                                        <div class='col-xs-6 col-lg-4 service_remark'></div> 
                                        <div class='col-xs-6 col-lg-2'><strong>การซ่อม :</strong></div> 
                                        <div class='col-xs-6 col-lg-4 service_status_name'></div> 
                                    </div> 
                                    <div class='row'> 
                                        <div class='col-xs-6 col-lg-2'><strong>รายละเอียด :</strong></div> 
                                        <div class='col-xs-6 col-lg-4 service_text'></div> 
                                        <div class='col-xs-6 col-lg-2'><strong>วันที่รับเรื่อง :</strong></div> 
                                        <div class='col-xs-6 col-lg-4 service_servicedate'></div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default" id="panel2">
                            <div class="panel-heading" onmouseover="this.style.cursor = 'pointer'" data-toggle="collapse" data-target="#collapseTwo">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-target="#collapseTwo" class="collapsed"></a>
                                    รายละเอียดการซ่อม
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse">
                                <div class="panel-body">

                                    <table class="table table-striped table-bordered table-condensed" id="table-preview_state_data">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">สถานะ</th>
                                                <th class="text-center">เวลา</th>
                                                <th class="text-center">การปฏิบัติ</th>
                                                <th class="text-center">รายละเอียด</th>
                                            </tr>
                                        </thead>
                                        <tbody id="preview_state_data"></tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default" id="panel3">
                            <div class="panel-heading" onmouseover="this.style.cursor = 'pointer'" data-toggle="collapse" data-target="#collapseThree">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-target="#collapseThree" class="collapsed"></a>
                                    รายการงานซ่อม
                                </h4>
                            </div>
                            <div id="collapseThree" class="panel-collapse collapse">
                                <div class="panel-body">

                                    <table class="table table-striped table-bordered table-condensed" id="table-preview_jobs_items">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">รายการ</th>
                                                <th class="text-center">ราคา/หน่วย</th>
                                                <th class="text-center">จำนวน</th>
                                                <th class="text-center">ราคารวม</th>
                                                <th class="text-center">วันที่</th>
                                                <th class="text-center">เจ้าหน้าที่</th>
                                            </tr>
                                        </thead>
                                        <tbody id="preview_jobs_items"></tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default" id="panel4">
                            <div class="panel-heading" onmouseover="this.style.cursor = 'pointer'" data-toggle="collapse" data-target="#collapseFour" class="collapsed">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-target="#collapseFour" class="collapsed"></a>
                                    รายการอะไหล่
                                </h4>
                            </div>
                            <div id="collapseFour" class="panel-collapse collapse">
                                <div class="panel-body">

                                    <table class="table table-striped table-bordered table-condensed" id="table-preview_parts_items">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">ประเภท</th>
                                                <th class="text-center">รุ่น</th>
                                                <th class="text-center">serial</th>
                                                <th class="text-center">หน่วยนับ</th>
                                                <th class="text-center">ราคา/หน่วย</th>
                                                <th class="text-center">จำนวน</th>
                                                <th class="text-center">ราคารวม</th>
                                                <th class="text-center">วันที่</th>
                                                <th class="text-center">เจ้าหน้าที่</th>
                                            </tr>
                                        </thead>
                                        <tbody id="preview_parts_items"></tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer center">
                    <button id="model-preview-close" class="btn btn-lg btn-primary" data-dismiss="modal" aria-label="Close">OK <span class="glyphicon glyphicon-off"></span></button>
<!--                    <button id="btn_submit_change_state" class="btn btn-lg btn-primary">Save <span class="glyphicon glyphicon-off"></span></button>
                    <button id="btn_reset_state_change" class="btn btn-lg btn-danger">Reset <span class="glyphicon glyphicon-repeat"></span></button>-->
                </div>
            </div>
        </div>
    </div>
</div>