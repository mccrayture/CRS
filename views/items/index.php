<div class="container">
    <!--//    make by Shikaru-->
    <h2>ทะเบียนคอมพิวเตอร์</h2>
    
    <div class="panel panel-default">
        <!--        <div class="panel-heading">
                    <h3 class="panel-title">Panel title</h3>
                </div>-->
        <div class="panel-body">
            <div class="row">
                <div class="col-md-10">
                    <div class="form-horizontal">        

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="search_type">ตัวกรอง :</label>
                            <div class="col-sm-10">
                                <div class="radio radio-info radio-inline" >
                                    <input type="radio" id="search_type_1" name="search_type" value="find" />
                                    <label for="search_type_1"> ป้อนคำค้น </label>
                                </div>
                                <div class="radio radio-info radio-inline" >
                                    <input type="radio" id="search_type_2" name="search_type" value="choice" />
                                    <label for="search_type_2"> หมวดหมู่ </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" id="div_show_depart_id">
                            <label class="col-sm-2 control-label" for="show_depart_id">หน่วยงาน :</label>
                            <div class="col-sm-10" >
                                <select class="form-control" id="show_depart_id" name="show_depart_id">
                                    <option value="0">--ทุกหน่วยงาน--</option>
                                    <?php
                                    foreach ($this->getDepart as $value) {
                                        echo "<option value='{$value['depart_id']}'>{$value['depart_name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="div_show_hardware_id">
                            <label class="col-sm-2 control-label" for="show_hardware_id">อุปกรณ์ :</label>
                            <div class="col-sm-10" >
                                <select class="form-control" id="show_hardware_id" name="show_hardware_id">
                                    <option value="0">--ทุกประเภท--</option>
                                    <?php
                                    foreach ($this->getHardware as $value) {
//                                        if(!isset($pre_hw) || $value['hardware_type_name'] <> $pre_hw){
//                                            $pre_hw = $value['hardware_type_name'];        
//                                            echo "<optgroup label = '{$value['hardware_type_name']}'>";
//                                        }
                                        echo "<option value='{$value['hardware_id']}'>[{$value['hardware_type_name']}] {$value['hardware_name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="div_search">
                            <label class="control-label col-sm-2" for="search">ป้อนคำค้น :</label>
                            <div class="col-sm-10" >
                                <input type="text" id="search" name="search" class="form-control" />
                            </div>
                        </div>

<!--                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="show_dialog"></label>
                            <div class="col-sm-10" >
                                <button type="button" id="show_dialog" class="btn btn-primary col-sm-2" data-toggle="modal" data-target=".bs-example-modal-lg">Add New</button>
                                <div class="pagin" align="right" style="margin: -20px 10px;"></div>
                            </div>
                        </div>-->

                    </div>
                </div>
                <div class="col-md-2">
                    <button type="button" id="show_dialog" class="btn btn-warning btn-block" data-toggle="modal" data-target=".bs-example-modal-lg">
                        <span class="glyphicon glyphicon-plus"></span><br />Add New
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="pagin" align="right" style="margin: -20px 10px;"></div><br/>
    

    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="items" class="form-horizontal" role="form" action="<?= URL; ?>items/xhrInsert" method="post">
                    <div class="modal-header">
                        <button id="model-close" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">ข้อมูลทะเบียนคอมพิวเตอร์</h4>
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
                                <input type="text" id="items_code" name="items_code" class="form-control" />
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
    <table class="table table-striped">
        <thead>
            <tr>
                <th style="text-align: center;" width="40px">#</th>
                <th style="text-align: center;" width="200px">รหัสเครื่อง</th>
                <th style="text-align: center;" width="200px">เลขคุรุภัณฑ์</th>
                <th style="text-align: center;" width="80px">อายุ</th>
                <th style="text-align: center;" width="180px">ประเภท</th>
                <th>ยี่ห้อ รุ่น</th>
                <th style="text-align: center;" width="130px">หน่วยงาน</th>
                <th style="text-align: center;" width="100px">วันที่จัดซื้อ</th>
                <th style="text-align: center;" width="100px">หมดประกัน</th>
                <th style="text-align: center;" width="100px">จัดการ</th>
            </tr>
        </thead>
        <tbody id="select_data">            
        </tbody>
    </table>
    <hr/>
</div>