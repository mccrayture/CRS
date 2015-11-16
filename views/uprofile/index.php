<div class="container">    
    <h2>ข้อมูลส่วนตัว</h2>
    <div class="row">
        <div class="col-lg-3 col-sm-12">
            <?php
              $logged = Session::get('User');
            ?>
            <div id="person_photo">
                <img class="img-responsive" src="./public/images/fb-no-profile-picture-icon-620x389.jpg" />
            </div>
            <br/>
            <div class="well well-sm">
                <p>เปลี่ยนรูปโปรไฟล์</p>
                <input type="file" id="imgupload" name="imgupload[]" accept="image/*" />
                <br/>
                <button class="btn btn-block btn-danger"><span class="glyphicon glyphicon-trash" ></span>  ลบรูป</button>

            </div>
            
            
<!--            <form role="form">
                <div class="form-group">
                    <label for="u_username">Username:</label>
                    <input type="text" class="form-control" id="u_username">
                </div>
                <div class="form-group">
                    <label for="u_password">Password:</label>
                    <input type="text" class="form-control" id="u_password">
                </div>
            </form>-->
        </div>
        <div class="col-lg-9 col-sm-12">
            <h3>แก้ไขข้อมูลส่วนตัว</h3>
            <div>
                <div class="well">
                    <form id="frm-uprofile" name="frm-uprofile" action="uprofile/editById" role="form">
                        <input type="hidden" id="person_id" value="<?= $logged["person_id"] ?>" />
                        <div class="form-group">
                            <label for="person_username">ชื่อผู้ใช้งาน:</label>
                            <input type="text" class="form-control" id="person_username" name="person_username" value="<?= $logged["person_username"] ?>" />
                        </div>
                        <div class="form-group">
                            <label for="person_password">รหัสผ่านใหม่ <span class="text-danger">(หากไม่ต้องการเปลี่ยน ให้เว้นว่างเอาไว้)</span>:</label>
                            <input type="password" class="form-control" id="person_password" name="person_password" value="" autocomplete="false">
                        </div>
                        <div class="form-group">
                            <label for="person_prefix">คำนำหน้า:</label>
                            <select class="form-control selectpicker selectpicker-live-search" id="person_prefix">
                                <?php
                                foreach ($this->getPrefix as $value) {
                                    echo "<option value='{$value['prefix_id']}'>{$value['prefix_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="person_fname">ชื่อ:</label>
                            <input type="text" class="form-control" id="person_fname" name="person_fname" />
                        </div>
                        <div class="form-group">
                            <label for="person_lname">นามสกุล:</label>
                            <input type="text" class="form-control" id="person_lname" name="person_lname" />
                        </div>
                        <div class="form-group">
                            <label for="person_position">ตำแหน่งงาน:</label>
                            <select class="form-control selectpicker show-tick" data-live-search="true" id="person_position" name="person_position">
                                <?php
                                foreach ($this->getPosition as $value) {
                                    echo "<option value='{$value['position_id']}'>{$value['position_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="person_office">สถานที่ปฏิบัติงาน:</label>
                            <select class="form-control selectpicker show-tick" data-live-search="true" id="person_office" name="person_office">
                                <?php
                                foreach ($this->getOffice as $value) {
                                    echo "<option value='{$value['ward_id']}'>{$value['ward_name']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <input type="submit" id="btn-submit" class="btn btn-success btn-block" value="บันทึกการเปลี่ยนแปลง" />
                        </div>
                    </form>
                </div>                
            </div>
        </div>
    </div>
</div>