<div class="container">
    <!--<div class="jumbotron" style="background: url('./public/images/error.png') no-repeat right #D5D5D5; background-size: 300px 250px;">-->
    <div class="jumbotron text-center" style="background: #D5D5D5;">
        <img src='./public/images/denied.png' class="img-responsive" style="margin: 0 auto; height: 250px; max-height: 250px">
        <h1>คุณไม่มีสิทธิ์เข้าใช้งานหน้าจอนี้ !</h1>
        <p>กรุณาติดต่อผู้ดูแลระบบ</p>
    </div>
    <div class="alert  alert-warning">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <p><strong>error : </strong><?php echo $this->msg; ?></p>
    </div>
</div>