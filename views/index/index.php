<div class="container-fluid">
    <div class="jumbotron">
        <h1>Computer Repair Service</h1>
        <p>Sakaeo Crown Prince Hospital</p>
        <?php $logged = Session::get('User'); ?> 
    </div>
    <div class="row">

        <div class="col-lg-5 col-sm-5">
            <div id="menu" >
                <div class="hidden-xs">
                    <div class="panel panel-default">
                        <div class="panel-heading"><span class="glyphicon glyphicon-th-large"></span> Menu</div>
                        <div class="panel-body">
                            <?php
                            if ($logged['type'] == 'staff') {
                                ?>
                                <div class="col-lg-6">
                                    <a href="<?= URL ?>service" class="btn btn-block btn-default btn-lg" role="button">
                                        <span class="glyphicon glyphicon-list-alt"></span><br />ระบบงานแจ้งซ่อม<br />
                                    </a>
                                </div>
                                <div class="col-lg-6">
                                    <a href="<?= URL ?>items" class="btn btn-block btn-default btn-lg" role="button">
                                        <span class="glyphicon glyphicon-plus-sign"></span><br />ลงทะเบียน คุรุภัณฑ์<br />
                                    </a>
                                </div>
                                <?php
                            } else {
                                ?>
                                <div class="col-lg-12">
                                    <a href="<?= URL ?>service" class="btn btn-block btn-default btn-lg" role="button">
                                        <span class="glyphicon glyphicon-list-alt"></span><br />ระบบงานแจ้งซ่อม<?= $logged['type'] ?>.<br />
                                    </a>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
<!--                <div class="hidden-lg hidden-md hidden-sm">
                    <div class="list-group">
                        <a href="<?= URL ?>service" class="list-group-item list-group-item-primary">
                            <h3 class="list-group-item-heading">ระบบงานแจ้งซ่อม<span class="glyphicon glyphicon-list-alt"></span></h3>
                            <p class="list-group-item-text">ลงข้อมูลการแจ้งซ่อมออนไลน์</p>
                        </a>
                        <?php
//                        if ($logged['type'] == 'staff') {
                            ?>
                            <a href="<?= URL ?>items" class="list-group-item">
                                <h3 class="list-group-item-heading">ลงทะเบียน คุรุภัณฑ์ <span class="glyphicon glyphicon-plus-sign"></span></h3>
                                <p class="list-group-item-text"></p>
                            </a>
                            <?php
//                        }
                        ?>
                    </div>
                </div>-->
            </div>

            <div id="menu" >
                <div class="hidden-xs">
                    <div class="panel panel-default">
                        <div class="panel-heading"><span class="glyphicon glyphicon-th-large"></span> Config User </div>
                        <div class="panel-body">
                            <div class="col-lg-12 col-sm-12">
                                <pre>
                                    <?php
//                                    $logged = Session::get('User');
                                    var_dump($logged);
                                    ?>                
                                </pre>
                                <div id="reportResult"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php
        $report = $this->getSummaryReport;
        //var_dump($report);
        ?> 
        <div class="col-lg-7 col-sm-7">
            <div id="menu" >
                <div class="hidden-xs">
                    <div class="panel panel-default">
                        <div class="alert alert-danger"><span class="glyphicon glyphicon-th-large"></span> สรุปรายงานปีงบ <?= $report [0]['year'] ?></div>
                        <div class="panel-body">
                            <div class="row">

                                <div class="col-lg-6 col-sm-6 text-center">
                                    <a href="#" class="list-group-item list-group-item-primary">
                                        <h3 class="list-group-item-heading">จำนวนใบซ่อม <span class="glyphicon glyphicon-duplicate"></span></h3>
                                        <p class="list-group-item-text"><?= number_format($report [0]['cntService']) ?> ใบ</p>
                                    </a>
                                </div>

                                <div class="col-lg-6 col-sm-6 text-center">
                                    <a href="#" class="list-group-item list-group-item-primary">
                                        <h3 class="list-group-item-heading">ราคาค่าซ่อม <span class="glyphicon glyphicon-briefcase"></span></h3>
                                        <p class="list-group-item-text"><?= number_format($report [0]['jobsPrice'], 2) ?> บาท</p>
                                    </a>
                                </div>
                            </div>
                            <br> 
                            <div class="row">

                                <div class="col-lg-6 col-sm-6 text-center">
                                    <a href="#" class="list-group-item list-group-item-primary">
                                        <h3 class="list-group-item-heading">ราคาอะไหล่ <span class="glyphicon glyphicon-wrench"></span></h3>
                                        <p  class="list-group-item-text"><?= number_format($report [0]['partsPrice'], 2) ?>  บาท</p>
                                    </a>
                                </div>

                                <div class="col-lg-6 col-sm-6 text-center">
                                    <a href="#" class="list-group-item list-group-item-primary">
                                        <h3 class="list-group-item-heading">ราคารวม <span class="glyphicon glyphicon-xbt"></span></h3>
                                        <p  class="list-group-item-text"><?= number_format(($report [0]['jobsPrice'] + $report [0]['partsPrice']), 2) ?>  บาท</p>
                                    </a>
                                </div>

                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>