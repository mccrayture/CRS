<div class="container">
    <h1>เจ้าหน้าที่เทคนิค</h1>
    <p>รายชื่อเจ้าหน้าที่เทคนิค</p>
    
    <div class="modal fade bs-example-modal-lg input-dialog" tabindex="-1" data-focus-on="input:first">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="form-horizontal" name="editForm" id="editForm" role="form" action="<?php echo URL; ?>technician/" method="post">
                    <div class="modal-header">
                        <button id="model-close" type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true"><span>&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">Form Input Data</h4>
                    </div>
                    <div class="modal-body">
                        <div id="formAlert"></div>
                        <div class="form-group" >
                            <label class="control-label col-sm-2" for="div_tech_name">ชื่อ :</label>
                            <div class="col-sm-7" >
                                <input type="text" id="tech_name" name="tech_name" class="form-control" autocomplete="off" disabled="disabled"/>
                <!--                <input type="hidden" id="tech_user" name="tech_user" />-->
                            </div>
                            <button type="button" id="choose-person" class="btn btn-primary col-sm-2" data-toggle="modal" data-target=".frm-choose-person">Choose Person</button>
                        </div>

                        <div class="form-group" id="div_tech_cid" name="div_tech_cid">
                            <label class="control-label col-sm-2" for="div_tech_cid">เลขประจำตัวประชาชน :</label>
                            <div class="col-sm-10" >
                                <input type="text" id="technician_cid" name="technician_cid" class="form-control" readonly="readonly" autocomplete="off" />
                            </div>
                        </div>
                        <div class="form-group" id="div_tech_status" name="div_tech_status">
                            <div class="col-sm-offset-2 col-sm-10" >
                                <div class="checkbox checkbox-success">
                                    <input type="checkbox" id="tech_status" name="tech_status" autocomplete="off" checked/>
                                    <label for="tech_status">ใช้งาน</label>
                                </div>
                            </div>
                        </div>
                    </div>
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
</div>
<div class="modal fade bs-example-modal-lg frm-choose-person" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="form-horizontal">  
                <div class="modal-header">
                    <button id="model-close" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
                    <div class="pagin-person" align="right" style="margin: -10px 10px;"></div>
                </div>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th width="130px">CID</th>
                        <th width="280px">NAME</th>
                        <th>DEPARTMENT</th>
                        <th style="text-align: center;" width="100px">CHOOSE</th>
                    </tr>
                </thead>
                <tbody id="select_person_data">            
                </tbody>
            </table>

        </div>
    </div>
</div>
<div class="container">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-10">
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="tech_filter_status">สถานะการใช้งาน :</label>
                        <div class="radio radio-info radio-inline" >
                            <input type="radio" id="tech_filter_status_0" name="tech_filter_status" value="all" checked />
                            <label for="tech_filter_status_0"> แสดงทั้งหมด </label>
                        </div>
                        <div class="radio radio-info radio-inline" >
                            <input type="radio" id="tech_filter_status_1" name="tech_filter_status" value="use" />
                            <label for="tech_filter_status_1"> ใช้งาน </label>
                        </div>
                        <div class="radio radio-info radio-inline" >
                            <input type="radio" id="tech_filter_status_2" name="tech_filter_status" value="no_use" />
                            <label for="tech_filter_status_2"> ไม่ใช้งาน </label>
                        </div>
                    </div>
                </div>                
                <div class="col-md-2">
                    <button type="button" id="show_dialog" class="btn btn-warning" data-toggle="modal" data-target=".input-dialog">
                        <span class="glyphicon glyphicon-plus"></span><br />เพิ่มเจ้าหน้าที่เทคนิคใหม่
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!--<div class="pagin" align="right" style="margin: -20px 10px;"></div>-->
</div>
<div id="listings" class="container">
</div>

    