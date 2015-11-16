<div class="container">
    <!--//    make by Shikaru-->
    <h2>ทะเบียนอะไหล่</h2>
    <?php $logged = Session::get('User'); ?>
    <p></p>
    <hr>
    <div class="panel panel-default">
        <!--        <div class="panel-heading">
                    <h3 class="panel-title">Panel title</h3>
                </div>-->
        <div class="panel-body">
            <div class="row">
                <div class="col-md-10">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="show_store_type_id">ประเภท :</label>
                        <div class="col-sm-8" >
                            <select class="form-control" id="show_store_type_id" name="show_store_type_id">
                                <?php
                                foreach ($this->getStoreType as $value) {
                                    echo "<option value='{$value['store_type_id']}' data-store-type='{$value['store_type_keeping']}' data-type-count='{$value['store_type_count']}'>{$value['store_type_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="button" id="show_dialog" class="btn btn-warning btn-block" data-toggle="modal" data-target=".bs-example-modal-lg">
                        <span class="glyphicon glyphicon-plus"></span><br />เพิ่มอะไหล่ใหม่
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="pagin" align="right" style="margin: -20px 10px;"></div>

    <div class="modal fade bs-example-modal-lg input-store-dialog" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="store" class="form-horizontal" role="form" action="<?= URL; ?>store/xhrInsert" method="post">
                    <div class="modal-header">
                        <button id="model-close" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">Form input data</h4>
                        <input type="hidden" id="store_type_keeping" name="store_type_keeping"  value="" />
                        <input type="hidden" id="userPerson_id" name="userPerson_id"  value="<?= $logged['person_id']; ?>" />
                    </div>
                    <div class="modal-body">

                        <div class="form-group" id="div_store_id">
                            <label class="control-label col-sm-3" for="store_id">รหัสแก้ไข :</label>
                            <div class="col-sm-8" >
                                <input type="text" id="store_id" name="store_id" class="form-control" readonly />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3" for="store_type_id">ประเภทอุปกรณ์ :</label>
                            <div class="col-sm-8" >
                                <select class="form-control" id="store_type_id" name="store_type_id">
                                    <?php
                                    foreach ($this->getStoreType as $value) {
                                        echo "<option value='{$value['store_type_id']}' data-store-type='{$value['store_type_keeping']}' data-type-count='{$value['store_type_count']}'>{$value['store_type_name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3" for="store_lotno">เลขที่ใบสั่งซื้อ/ใบเบิก <b style="color:red;">*</b>:</label>
                            <div class="col-sm-8" >
                                <input type="text" id="store_lotno" name="store_lotno" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3" for="store_name">รุ่น/ยี่ห้อ/ชนิด <b style="color:red;">*</b>:</label>
                            <div class="col-sm-8" >
                                <input type="text" id="store_name" name="store_name" class="form-control" />
                            </div>
                        </div>
                        
                        <div class="form-group" id="div_store_unit_price" name="div_store_unit_price">
                            <label class="control-label col-sm-3" for="jobs_name">ราคาต่อหน่วย :</label>
                            <div class="col-sm-8" >
                                <input type="number" min="0" id="store_unit_price" name="store_unit_price" class="form-control" />
                            </div>
                        </div>
                        
                        <div class="form-group" id="div_serial_number">
                            <label class="control-label col-sm-3" for="serial_number">Serial number :</label>
                            <div class="col-sm-8" >
                                <input type="text" id="serial_number" name="serial_number" class="form-control" />
                            </div>
                            <label class="control-label col-sm-3" ></label>
                            <label><h6><p style="color:red;">*** S/N มีของผู้ผลิตให้ใช้ของผู้ผลิต หากไม่มีให้ใช้ของผู้จำหน่าย ***</p></h6></label>
                        </div>

                        <div class="form-group" id="div_store_stock">
                            <label class="control-label col-sm-3" for="store_stock">จำนวนคงเหลือ :</label>
                            <div class="col-sm-8" >
                                <input type="text" id="store_stock" name="store_stock" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group" id="div_store_max_count">
                            <label class="control-label col-sm-3" for="store_max_count">จำนวน(ทั้งหมด) :</label>
                            <div class="col-sm-8" >
                                <input type="text" id="store_max_count" name="store_max_count" class="form-control" />
                            </div>
                            <label class="control-label col-sm-1" for="store_type_count" id="store_type_count"></label>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-3" for="store_adddate">วันที่ขึ้นทะเบียน :</label>
                            <div class="col-sm-8" >
                                <input type="text" id="store_adddate" name="store_adddate" class="form-control" />
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="btn_submit" class="btn btn-lg btn-primary">Save
                            <span class="glyphicon glyphicon-off"></span>
                        </button>
                        <button type="reset" id="btn_reset" value="reset" class="btn btn-lg">Clear
                            <span ></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <table class="table table-striped">
        <thead>
            <tr>
                <th style="text-align: center;" width="40px">#</th>
                <th style="text-align: center;" width="60px">LOT&nbsp;NO</th>
                <th style="text-align: center;" width="180px">TYPE NAME</th>
                <th>MODEL NAME</th>
                <th style="text-align: right;" width="70px">UNIT PRICE</th>
                <th style="text-align: center;" width="100px" id="title_stock"></th>
                <th style="text-align: center;" width="100px" id="title_type"></th>
                <th style="text-align: center;" width="50px">TYPE COUNT</th>
                <th style="text-align: center;" width="50px">DATEADD</th>
                <th style="text-align: center;" width="50px">STAFF</th>
                <th style="text-align: center;" width="100px">MANAGE</th>
            </tr>
        </thead>
        <tbody id="select_data">            
        </tbody>
    </table>
    <hr/>
</div>