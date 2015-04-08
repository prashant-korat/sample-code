<!-- View Users Information -->
<div>
    <div class="row_cont">
        <div>Coupon Name:</div>
        <label><?php echo $viewInfo['coupon_name'];?></label>
    </div>
    <div class="row_cont">
        <div>Coupon Name:</div>
        <label><?php echo $viewInfo['coupon_code'];?></label>
    </div>
    <div class="row_cont">
        <div>Maximum No.Of Use:</div>
        <label><?php echo $viewInfo['maximum_use'];?></label>
    </div>
    <div class="row_cont">
        <div>Coupon Type:</div>
        <label><?php echo $viewInfo['coupon_type'];?></label>
    </div>
    <div class="row_cont">
        <div>Coupon Discount Amount:</div>
        <label><?php echo $viewInfo['coupon_discount_amt'];?></label>
    </div>
    <div class="row_cont">
        <div>Expiry Date:</div>
        <label><?php echo $viewInfo['expiry_date'];?></label>
    </div>
    <div class="row_cont">
        <div>Description:</div>
        <label><?php echo $viewInfo['description'];?></label>
    </div>
    <div class="row_cont">
        <div>Date:</div>
        <label><?php echo date('m-d-Y h:i:s',strtotime($viewInfo['created_time']));?></label>
    </div>
    
      
</div>