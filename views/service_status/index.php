<div class="container">
<!--//    make by Shikaru--> 
    <h2>การดำเนินการ</h2>
    <form id="service_status" class="form-horizontal" role="form" action="<?= URL; ?>service_status/xhrInsert" method="post">
        <input type="hidden" id="service_status_id" name="service_status_id" class="form-control"/>

        <div class="form-group">
            <label class="control-label col-sm-2" for="service_status_name">การดำเนินการ :</label>
            <div class="col-sm-10" >
                <input type="text" id="service_status_name" name="service_status_name" class="form-control" />
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
                <th width="50px">SORT</th>
                <th width="100px">MANAGE</th>
            </tr>
        </thead>
        <tbody id="select_data">            
        </tbody>
    </table>
    <hr/>
</div>