<div class="container">
<!--//    make by Shikaru-->
    <h2>สถานะการซ่อม</h2>
    <form id="service_detail_status" class="form-horizontal" role="form" action="<?= URL; ?>service_detail_status/xhrInsert" method="post">
        <input type="hidden" id="status_id" name="status_id" class="form-control"/>

        <div class="form-group">
            <label class="control-label col-sm-2" for="status_name">ชื่อสถานะ :</label>
            <div class="col-sm-10" >
                <input type="text" id="status_name" name="status_name" class="form-control" />
            </div>
        </div>
        
        <div class="form-group">
            <label class="control-label col-sm-2" for="status_color">สีสถานะ :</label> 
            <div class="col-sm-10" >
                <input type="color" id="status_color" name="status_color" class="form-control" />
            </div>
        </div>

        <div class="form-group" id="div_sort">
            <label class="control-label col-sm-2" for="sort">Sort :</label>
            <div class="col-sm-10" >
                <input type="text" id="sort" name="sort" class="form-control" />
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
                <th width="50px">ID</th>
                <th>NAME</th>
                <th width="100px">COLOR</th>
                <th width="50px">SORT</th>
                <th width="100px">MANAGE</th>
            </tr>
        </thead>
        <tbody id="select_data">            
        </tbody>
    </table>
    <hr/>
</div>