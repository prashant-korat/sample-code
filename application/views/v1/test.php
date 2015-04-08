<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<script type="text/javascript" src="<?php echo base_url() ?>js/jquery-1.9.1.js"></script>

<script type="text/javascript">
$(document).ready(function(e) {
    $('form').submit(function(){
		$.post($(this).attr('action'), $(this).serialize(), function(data){
			
			alert(data);
			try{
				console.log($.parseJSON(data));
			}catch(err){
				console.log(data);
				$('#showData').html(data);
			}
		})
		return false;
	});
});
</script>

<style type="text/css">
form{
	float:left;
	width:50%;
}
.clear{
	float:none;
	clear:both;
}
</style>
<body>
<div id="showData"></div>
<?php $formAction = site_url('v1/service/userLogin'); ?>
<form action="<?php echo $formAction; ?>">
	<h1>userLogin</h1>
    <h5>url for this function : <?php echo $formAction ?></h5>
    <h3>req param : 'fname', 'lname', 'email', 'fb_id', 'password'</h3>
    <h5>notes : if you dont using fb login then you have to pass email and password to this function</h5>
	<table>
    	<?php 
			$req_field = array('fname', 'lname', 'email', 'fb_id', 'password'); 
			foreach($req_field as $f){
				echo '<tr>
						  <td>'.$f.'</td>
						  <td><input type="text" name="'.$f.'" /></td>
					  </tr>';
			};
		?>
    	<tr>
    		<td></td>
    		<td><input type="submit" /></td>
    	</tr>
    </table>
</form>


<?php $formAction = site_url('v1/service/userReg'); ?>
<form action="<?php echo $formAction; ?>">
	<h1>userReg</h1>
    <h5>url for this function : <?php echo $formAction ?></h5>
    <h3>req param : 'fname', 'lname', 'email', 'fb_id'</h3>
    <h5>notes : this function will call when user registre.</h5>
	<table>
    	<?php 
			$req_field = array('fname','lname','email','password'); 
			foreach($req_field as $f){
				echo '<tr>
						  <td>'.$f.'</td>
						  <td><input type="text" name="'.$f.'" /></td>
					  </tr>';
			};
		?>
    	<tr>
    		<td></td>
    		<td><input type="submit" /></td>
    	</tr>
    </table>
</form>

<div class="clear"></div>
<?php $formAction = site_url('v1/service/getAllTest'); ?>
<form action="<?php echo $formAction; ?>">
	<h1>getAllTest</h1>
    <h5>url for this function : <?php echo $formAction ?></h5>
    <h3>req param : none</h3>
    <h5>notes : for get name of all questions set.</h5>
	<table>
    	<?php 
			$req_field = array('user_id', 'cat_id'); 
			foreach($req_field as $f){
				echo '<tr>
						  <td>'.$f.'</td>
						  <td><input type="text" name="'.$f.'" /></td>
					  </tr>';
			};
		?>
    	<tr>
    		<td></td>
    		<td><input type="submit" /></td>
    	</tr>
    </table>
</form>

<?php $formAction = site_url('v1/service/getTestQue'); ?>
<form action="<?php echo $formAction; ?>">
	<h1>getTestQue</h1>
    <h5>url for this function : <?php echo $formAction ?></h5>
    <h3>req param : 'test_id'</h3>
    <h5>notes : pass test id which you get list from getAllTest function.</h5>
	<table>
    	<?php 
			$req_field = array('test_id', 'user_id'); 
			foreach($req_field as $f){
				echo '<tr>
						  <td>'.$f.'</td>
						  <td><input type="text" name="'.$f.'" /></td>
					  </tr>';
			};
		?>
    	<tr>
    		<td></td>
    		<td><input type="submit" /></td>
    	</tr>
    </table>
</form>

<div class="clear"></div>

<?php $formAction = site_url('v1/service/saveUserAns'); ?>
<?php 		$data = array();
		$data['test_id'] = 9;
		$data['user_id'] = 2;
		$data['ans_arr'][6] = 20;
		$data['ans_arr'][7] = 26;
		$data['ans_arr'][8] = 29;
 ?>
<form action="<?php echo $formAction; ?>">
	<h1>saveUserAns</h1>
    <h5>url for this function : <?php echo $formAction ?></h5>
    <h3>req param : 'test_id', 'user_id', 'ans_arr'</h3>
    <h5>
    	notes : this function call when user want to submit their/ save data in db. this function will return result of the test which is user attmpt at last.
        <br />
        <span style="color:#F00">
        	sample of json format for pass to this function  : <br />
			<?php echo json_encode($data); ?> <br />
            where 6,7 and 8 are <strong>que_id</strong> and <br />
            20,26,27 are <strong>ans_id</strong> which are selected by user.</span>
    </h5>
	<table>
    	<?php 
			$req_field = array('test_id', 'user_id', 'ans_arr'); 
			foreach($req_field as $f){
				echo '<tr>
						  <td>'.$f.'</td>
						  <td><input type="text" name="'.$f.'" /></td>
					  </tr>';
			};
		?>
    	<tr>
    		<td></td>
    		<td><input type="submit" /></td>
    	</tr>
    </table>
</form>

<?php $formAction = site_url('v1/service/materialsList'); ?>
<form action="<?php echo $formAction; ?>">
	<h1>materialsList</h1>
    <h5>url for this function : <?php echo $formAction ?></h5>
	<table>
    	<?php 
			$req_field = array(); 
			foreach($req_field as $f){
				echo '<tr>
						  <td>'.$f.'</td>
						  <td><input type="text" name="'.$f.'" /></td>
					  </tr>';
			};
		?>
    	<tr>
    		<td></td>
    		<td><input type="submit" /></td>
    	</tr>
    </table>
</form>

<?php $formAction = site_url('v1/service/materialsGetDetail'); ?>
<form action="<?php echo $formAction; ?>">
	<h1>materialsGetDetail</h1>
    <h5>url for this function : <?php echo $formAction ?></h5>
	<table>
    	<?php 
			$req_field = array('material_id'); 
			foreach($req_field as $f){
				echo '<tr>
						  <td>'.$f.'</td>
						  <td><input type="text" name="'.$f.'" /></td>
					  </tr>';
			};
		?>
    	<tr>
    		<td></td>
    		<td><input type="submit" /></td>
    	</tr>
    </table>
</form>


<?php $formAction = site_url('v1/service/discussionList'); ?>
<form action="<?php echo $formAction; ?>">
	<h1>discussionList</h1>
    <h5>url for this function : <?php echo $formAction ?></h5>
    <span style="color:#F00">
        	parent_id : will 0 for que and will discussion_id for ans</span>
	<table>
    	<?php 
			$req_field = array('parent_id', 'user_id');
			foreach($req_field as $f){
				echo '<tr>
						  <td>'.$f.'</td>
						  <td><input type="text" name="'.$f.'" /></td>
					  </tr>';
			};
		?>
    	<tr>
    		<td></td>
    		<td><input type="submit" /></td>
    	</tr>
    </table>
</form>

<?php $formAction = site_url('v1/service/discussionSave'); ?>
<form action="<?php echo $formAction; ?>">
	<h1>discussionSave</h1>
    <h5>url for this function : <?php echo $formAction ?></h5>
    <span style="color:#F00">
        	parent_id : will 0 for que and will discussion_id for ans</span>
	<table>
    	<?php 
			$req_field = array('discussion_id', 'cat_id', 'parent_id', 'user_id', 'discussion_text');
			foreach($req_field as $f){
				echo '<tr>
						  <td>'.$f.'</td>
						  <td><input type="text" name="'.$f.'" /></td>
					  </tr>';
			};
		?>
    	<tr>
    		<td></td>
    		<td><input type="submit" /></td>
    	</tr>
    </table>
</form>

<?php $formAction = site_url('v1/service/discussionReview'); ?>
<form action="<?php echo $formAction; ?>">
	<h1>discussionReview</h1>
    <h5>url for this function : <?php echo $formAction ?></h5>
    <span style="color:#F00">
        	type : 1 FOR LIKE AND 0 FOR UNLIKE</span>
	<table>
    	<?php 
			$req_field = array('discussion_id', 'user_id', 'type');
			foreach($req_field as $f){
				echo '<tr>
						  <td>'.$f.'</td>
						  <td><input type="text" name="'.$f.'" /></td>
					  </tr>';
			};
		?>
    	<tr>
    		<td></td>
    		<td><input type="submit" /></td>
    	</tr>
    </table>
</form>

<?php $formAction = site_url('v1/service/discussionDelete'); ?>
<form action="<?php echo $formAction; ?>">
	<h1>discussionDelete</h1>
    <h5>url for this function : <?php echo $formAction ?></h5>
	<table>
    	<?php 
			$req_field = array('discussion_id');
			foreach($req_field as $f){
				echo '<tr>
						  <td>'.$f.'</td>
						  <td><input type="text" name="'.$f.'" /></td>
					  </tr>';
			};
		?>
    	<tr>
    		<td></td>
    		<td><input type="submit" /></td>
    	</tr>
    </table>
</form>

<?php $formAction = site_url('v1/service/getCategory'); ?>
<form action="<?php echo $formAction; ?>">
	<h1>getCategory</h1>
    <h5>url for this function : <?php echo $formAction ?></h5>
	<table>
    	<?php 
			$req_field = array();
			foreach($req_field as $f){
				echo '<tr>
						  <td>'.$f.'</td>
						  <td><input type="text" name="'.$f.'" /></td>
					  </tr>';
			};
		?>
    	<tr>
    		<td></td>
    		<td><input type="submit" /></td>
    	</tr>
    </table>
</form>

<?php $formAction = site_url('v1/service/newsList'); ?>
<form action="<?php echo $formAction; ?>">
	<h1>newsList</h1>
    <h5>url for this function : <?php echo $formAction ?></h5>
	<table>
    	<?php 
			$req_field = array();
			foreach($req_field as $f){
				echo '<tr>
						  <td>'.$f.'</td>
						  <td><input type="text" name="'.$f.'" /></td>
					  </tr>';
			};
		?>
    	<tr>
    		<td></td>
    		<td><input type="submit" /></td>
    	</tr>
    </table>
</form>

<?php $formAction = site_url('v1/service/newsView'); ?>
<form action="<?php echo $formAction; ?>">
	<h1>newsView</h1>
    <h5>url for this function : <?php echo $formAction ?></h5>
	<table>
    	<?php 
			$req_field = array('news_id');
			foreach($req_field as $f){
				echo '<tr>
						  <td>'.$f.'</td>
						  <td><input type="text" name="'.$f.'" /></td>
					  </tr>';
			};
		?>
    	<tr>
    		<td></td>
    		<td><input type="submit" /></td>
    	</tr>
    </table>
</form>

</body>
</html>