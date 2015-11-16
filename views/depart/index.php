<div class="container">
    <h3>หน่วยงาน</h3>
    <p>กรอกชื่อหน่วยงานในโรงพยาบาล</p> <?php //insertByID  editByID  ?>
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form class="form-horizontal" name="editForm" id="editForm" role="form" action="<?php echo URL; ?>depart/insertByID" method="post">                    <!--modal Header--> 
                    <div class="modal-header">
                        <button id="model-close" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">Form input data</h4>
                    </div>
                    <!---------------->
                    <!--modal Body--> 
                    <div class="modal-body">
                        <div id="formAlert"></div>
                        <div class="form-group" id="div_depart_id">
                            <label class="control-label col-sm-2" for="depart_id">รหัสแก้ไข :</label>
                            <div class="col-sm-10" >
                                <input type="text" id="depart_id" name="depart_id" class="form-control" readonly />
                            </div>
                        </div>                        
                        <div class="form-group" id="div_depart_name" name="div_depart_name">
                            <label class="control-label col-sm-2" for="depart_name"><b style="color: red;">*</b> ชื่อหน่วยงาน :</label>
                            <div class="col-sm-10" >
                                <input type="text" id="depart_name" name="depart_name" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group" id="div_depart_tel" name="div_depart_tel">
                            <label class="control-label col-sm-2" for="depart_tel">เบอร์โทร. :</label>
                            <div class="col-sm-10" >
                                <input type="text" id="depart_tel" name="depart_tel" class="form-control" />
                            </div>
                        </div>
                        <div class="form-group" id="div_depart_status" name="div_tech_status">
                            <div class="col-sm-offset-2 col-sm-10" >
                                <div class="checkbox checkbox-success">
                                    <input type="checkbox" id="depart_status" name="depart_status" autocomplete="off" value="1" checked/>
                                    <label for="depart_status">ใช้งาน</label>
                                </div>
                            </div>
                        </div>
<!--                        <div class="form-group">
                            <label class="control-label col-sm-2" for="depart_status">สถานะใช้งาน :</label>
                            <div class="col-sm-10" >
                                <select class="form-control" id="depart_status"  name="depart_status">
                                    <option value="1">ใช้งาน</option>
                                    <option value="0">ยกเลิกใช้งาน</option>

                                </select><br />
                            </div>
                        </div>-->
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
                    <div class="form-group" id="div_search">
                        <label class="control-label col-sm-2" for="search">ป้อนคำค้น :</label>
                        <div class="col-sm-10" >
                            <input type="text" id="search" name="search" class="form-control" />
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="button" id="show_dialog" class="btn btn-warning btn-block" data-toggle="modal" data-target=".bs-example-modal-lg">
                        <span class="glyphicon glyphicon-plus"></span><br />เพิ่มหน่วยงานใหม่
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="pagin" align="right" style="margin: -20px 10px;"></div>
    <br/>
</div>
<div id="listings" class="container">
</div>
<hr/>
