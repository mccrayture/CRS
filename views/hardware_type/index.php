<div class="container">
    <!--//    make by Shikaru-->   
    <h2>ประเภทอุปกรณ์</h2>
    <p></p> <?php //insertByID  editByID ?>

    <div class="modal fade bs-example-modal-lg" id="frm-new-hardware-type" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="hardware_type" class="form-horizontal" role="form" action="<?= URL; ?>hardware_type/xhrInsert" method="post">                    <!--modal Header--> 
                    <div class="modal-header bg-primary">
                        <button id="model-close" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="gridSystemModalLabel">Form input data</h4>
                    </div>
                    <!---------------->
                    <!--modal Body--> 
                    <div class="modal-body">
                        <div id="formAlert"></div>
                        <input type="hidden" id="hardware_type_id" name="hardware_type_id" class="form-control"/>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="hardware_type_name">ชื่ออุปกรณ์ :</label>
                            <div class="col-sm-10" >
                                <input type="text" id="hardware_type_name" name="hardware_type_name" class="form-control" />
                            </div>
                        </div>

                        <div class="form-group" id="div_sort">
                            <label class="control-label col-sm-2" for="sort">Sort :</label>
                            <div class="col-sm-10" >
                                <input type="text" id="sort" name="sort" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <!---------------->
                    <!--modal Footer-->
                    <div class="modal-footer">
                        <button type="submit" id="btn_submit" class="btn btn-lg btn-primary">Save
                            <span class="glyphicon glyphicon-off"></span>
                        </button>
                        <button type="reset" id="btn_reset" value="reset" class="btn btn-lg">Reset
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
                        <span class="glyphicon glyphicon-plus"></span><br />เพิ่มประเภทอุปกรณ์ใหม่
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="pagin" align="right" style="margin: -20px 10px;"></div>
    <br/>
    <table align="center" class="table table-striped">
        <thead>
            <tr>
                <th class="col-md-3">ID</th>
                <th class="col-md-5">NAME</th>
                <th class="col-md-1">SORT</th>
                <th class="col-md-3">MANAGE</th>
            </tr>
        </thead>
        <tbody id="select_data">            
        </tbody>
    </table>
    <hr/>
</div>