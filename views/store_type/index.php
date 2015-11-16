<div class="container">
    <!--//    make by Shikaru-->
    <h2>ประเภทอะไหล่</h2>
    <form id="store_type" class="form-horizontal" role="form" action="<?= URL; ?>store_type/xhrInsert" method="post">
        <input type="hidden" id="store_type_id" name="store_type_id" class="form-control"/>

        <div class="form-group">
            <label class="control-label col-sm-2" for="store_type_name">ชื่อประเภทอะไหล่ :</label>
            <div class="col-sm-10" >
                <input type="text" id="store_type_name" name="store_type_name" class="form-control" />
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2" for="store_type_keeping">วิธีการเก็บ :</label>
            <div class="col-sm-10" >
                <label class="radio-inline"><input type="radio" id="keeping_1" name="store_type_keeping" value="serial" />Serial</label>
                <label class="radio-inline"><input type="radio" id="keeping_2" name="store_type_keeping" value="value" />นับจำนวน</label>
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-sm-2" for="store_type_count">หน่วยนับ :</label>
            <div class="col-sm-10" >
                <input type="text" id="store_type_count" name="store_type_count" class="form-control" />
            </div>
        </div>

        <div class="form-group" id="div_sort">
            <label class="control-label col-sm-2" for="store_type_sort">ลำดับ :</label>
            <div class="col-sm-10" >
                <input type="text" id="store_type_sort" name="store_type_sort" class="form-control" />
            </div>
        </div>

        <div class="form-group">        
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" id="btn_submit" class="btn btn-lg btn-primary">Save
                    <span class="glyphicon glyphicon-off"></span>
                </button>
                <button type="reset" id="btn_reset" value="reset" class="btn btn-lg">Reset
                    <span ></span>
                </button>
            </div>
        </div> 
    </form>

    <hr/>
    <table align="center" class="table table-striped">
        <thead>
            <tr>
                <th style="text-align: center;" width="50px">#</th>
                <th>NAME</th>
                <th width="100px">KEEPING</th>
                <th width="100px">TYPE COUNT</th>
                <th width="100px">MANAGE</th>
            </tr>
        </thead>
        <tbody id="select_data">            
        </tbody>
    </table>
    <hr/>
</div>