<?php
$User = Session::get('User');
$active = ' class="active"';
?>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <span class="navbar-brand" href="<?= URL; ?>index">CRS</span>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navCRS">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>                      
                <span class="icon-bar"></span>                      
            </button>
        </div>
        <div class="collapse navbar-collapse" id="navCRS">
            <ul class="nav navbar-nav">
                <li <?= ($this->pageMenu == 'index' || $this->pageMenu == '') ? $active : ''; ?>>
                    <a href="<?= URL; ?>index"><span class="glyphicon glyphicon-home"></span> หน้าแรก</a></li>
                <?php if (isset($User['type'])) { 
                        if (accessMenu('user') === 1) { ?>
                    <li <?= ($this->pageMenu == 'service') ? $active : ''; ?>>
                        <a href="<?= URL; ?>service"><span class="glyphicon glyphicon-inbox"></span> แจ้งซ่อม</a></li>
                <?php   }?>
                            <?php if (accessMenu('staff') === 1) { ?>
                        <li <?= ($this->pageMenu == 'report') ? $active : ''; ?>>
                            <a href="reports"><span class="glyphicon glyphicon-stats"></span> รายงาน<!--<span class="caret"></span>--></a>
                            <!--                            <ul class="dropdown-menu">
                                                            <li><a href="#">report 1</a></li>
                                                            <li><a href="#">report 2</a></li>
                                                            <li><a href="#">report 3</a></li>
                                                        </ul>-->
                        </li>
                        <!--                        <li class="btn-group">
                                                    <a class="btn btn-danger">Action</a>
                                                    <a class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <span class="caret"></span>
                                                        <span class="sr-only">Toggle Dropdown</span>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="#">Action</a></li>
                                                        <li><a href="#">Another action</a></li>
                                                        <li><a href="#">Something else here</a></li>
                                                        <li role="separator" class="divider"></li>
                                                        <li><a href="#">Separated link</a></li>
                                                    </ul>
                                                </li>-->

                        <li <?= ($this->pageMenu == 'hardware' || $this->pageMenu == 'hardware_type' || $this->pageMenu == 'symptom' || $this->pageMenu == 'depart' || $this->pageMenu == 'technician' || $this->pageMenu == 'service_status' || $this->pageMenu == 'store' || $this->pageMenu == 'store_type' || $this->pageMenu == 'items') ? $active : ''; ?> class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-cog"></span> ตั้งค่า<span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li <?= ($this->pageMenu == 'store') ? $active : ''; ?>>
                                    <a href="<?= URL; ?>store">รายการ อะไหล่</a></li>
                                <li <?= ($this->pageMenu == 'store_type') ? $active : ''; ?>>
                                    <a href="<?= URL; ?>store_type">ประเภท อะไหล่</a></li>
                                <li class="divider"></li>
                                <li <?= ($this->pageMenu == 'items') ? $active : ''; ?>>
                                    <a href="<?= URL; ?>items">ลงทะเบียน คุรุภัณฑ์</a></li>
                                <li class="divider"></li>
                                <li <?= ($this->pageMenu == 'hardware') ? $active : ''; ?>>
                                    <a href="<?= URL; ?>hardware">อุปกรณ์</a></li>
                                <li <?= ($this->pageMenu == 'hardware_type') ? $active : ''; ?>>
                                    <a href="<?= URL; ?>hardware_type">ประเภท อุปกรณ์</a></li>
                                <li class="divider"></li>
                                <li <?= ($this->pageMenu == 'jobs') ? $active : ''; ?>>
                                    <a href="<?= URL; ?>jobs">รายการงานซ่อม</a></li>
                                <li <?= ($this->pageMenu == 'symptom') ? $active : ''; ?>>
                                    <a href="<?= URL; ?>symptom">อาการเสีย</a></li>
                                <li <?= ($this->pageMenu == 'depart') ? $active : ''; ?>>
                                    <a href="<?= URL; ?>depart">หน่วยงาน</a></li>
                                <li <?= ($this->pageMenu == 'technician') ? $active : ''; ?>>
                                    <a href="<?= URL; ?>technician">รายชื่อช่างเทคนิค</a></li>
                                <li <?= ($this->pageMenu == 'service_detail_status') ? $active : ''; ?>>
                                    <a href="<?= URL; ?>service_detail_status">สถานะการซ่อม</a></li>
                                <li <?= ($this->pageMenu == 'service_status') ? $active : ''; ?>>
                                    <a href="<?= URL; ?>service_status">การปฏิบัติ</a></li>

                            </ul>
                        </li>
                        <?php
                    }
                }
                ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="glyphicon glyphicon-info-sign"></span> ช่วยเหลือ<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= URL; ?>denied">คู่มือ</a></li>
                         <!--<li><a href="#">ข้อซักถาม</a></li> 
                        <li><a href="#">ผู้พัฒนา</a></li> --->
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if (sizeof($User) > 0) { ?>  
                    <li class="dropdown">
                        <!--<a href="#" class="dropdown-toggle profile-image" data-toggle="dropdown" role="button" aria-expanded="false">-->
                        <?php
                        $imgurl = "http://192.168.5.250/p4p/images/PhotoPersonal/" . $User['person_photo'];
                        if (!empty($User['person_photo'])) {
                            ?>
                            <a href="#" class="dropdown-toggle profile-image" data-toggle="dropdown" role="button" aria-expanded="false">
                                <span class="profile-navbar-image"><img class="img-circle" src="<?= $imgurl ?>" /></span>
                            <?php } else { ?>
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span> 
                                    <?php
                                }//end set photo  
                                echo $User['firstname'] . ' ' . $User['lastname'];
                                ?><span class="caret" aria-hidden="true"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?= URL; ?>uprofile"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> แก้ไขข้อมูลส่วนตัว</a></li>
                                <li><a href="#">...</a></li>
                                <li class="divider"></li>
                                <li><a href="<?= URL; ?>login/logout"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> ออกจากระบบ</a></li>
                            </ul>
                    </li>
                <?php } else { ?>
                    <li><a href="#" onclick="
                            BootstrapDialog.show({
                                message: $('<div></div>').load('<?= URL ?>login'),
                                onshown: function(dialog) {
                                    if ($('#username').val() !== '')
                                    {
                                        //when cookie is usable, always check this box until remove it
                                        $('#password').focus();
                                        $('#check_remember').prop('checked', true);
                                    } else {
                                        $('#username').focus();
                                        $('#check_remember').prop('checked', false);
                                    }
                                }
                            });" >
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span> ลงชื่อเข้าใช้</a></li>
                <?php } ?>
                <li><a href="<?= URL; ?>about"><span class="glyphicon glyphicon-copyright-mark" aria-hidden="true"></span> เกี่ยวกับ</a></li>
            </ul>
        </div>
    </div>
</nav>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

