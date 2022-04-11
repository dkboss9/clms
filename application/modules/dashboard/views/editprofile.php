

<div class="panel-body">
	<div class="form-group mt-lg">
		<label class="col-sm-3 control-label">First Name</label>
		<div class="col-sm-9">			
			<input type="text" name="profile_fname" id="profile_firstname" value="<?php echo $row->first_name; ?>"  class="form-control" required/>
		</div>
	</div>

	<div class="form-group mt-lg">
		<label class="col-sm-3 control-label">Last Name</label>
		<div class="col-sm-9">			
			<input type="text" name="profile_lname" id="profile_lastname" value="<?php echo $row->last_name; ?>"  class="form-control" required />
		</div>
	</div>
	<div class="form-group mt-lg">
		<label class="col-sm-3 control-label">Email</label>
		<div class="col-sm-9">			
			<input type="email" name="profile_email" id="profile_email" value="<?php echo $row->email; ?>" class="form-control" />
		</div>
	</div>
	<div class="form-group mt-lg">
		<label class="col-sm-3 control-label">Phone</label>
		<div class="col-sm-9">			
			<input type="text" name="profile_phone" id="profile_phone" value="<?php echo $row->phone; ?>"  class="form-control" required />
		</div>
	</div>
	<div class="form-group mt-lg">
		<label class="col-sm-3 control-label">Username</label>
		<div class="col-sm-9">			
			<input type="text" name="username" class="form-control" id="user_name" value="<?php echo $row->user_name; ?>" readonly="readonly" required />
		</div>
	</div>
	<div class="form-group mt-lg">
		<label class="col-sm-3 control-label">Password</label>
		<div class="col-sm-9">			
			<input type="password" name="profile_password"  class="form-control" id="profile_password" />
		</div>
	</div>
	<div class="form-group mt-lg">
		<label class="col-sm-3 control-label">Pass Code</label>
		<div class="col-sm-9">			
			<input type="password" name="profile_passcode"  class="form-control" id="profile_passcode" />
		</div>
	</div>
	<div class="form-group mt-lg">
		<label class="col-sm-3 control-label">Twitter Consumer Key (API Key)</label>
		<div class="col-sm-9">			
			<input type="text" name="consumer_key" value="<?php echo $row->consumer_key; ?>"  class="form-control" id="consumer_key" />
		</div>
	</div>
	<div class="form-group mt-lg">
		<label class="col-sm-3 control-label">Twitter Consumer Secret (API Secret)</label>
		<div class="col-sm-9">			
			<input type="text" name="consumer_secret"  class="form-control" value="<?php echo $row->consumer_secret; ?>" id="consumer_secret" />
		</div>
	</div>
	<div class="form-group mt-lg">
		<label class="col-sm-3 control-label">Twitter Access Token</label>
		<div class="col-sm-9">			
			<input type="text" name="access_token"  class="form-control" value="<?php echo $row->access_token; ?>" id="access_token" />
		</div>
	</div>
	<div class="form-group mt-lg">
		<label class="col-sm-3 control-label">Twitter Access Token Secret</label>
		<div class="col-sm-9">			
			<input type="text" name="access_secret"  class="form-control" value="<?php echo $row->access_secret; ?>" id="access_secret" />
		</div>
	</div>
	<div class="form-group mt-lg">
		<label class="col-sm-3 control-label">Profile Picture</label>
		<div class="col-sm-9">			
			<div id="image-name-edit"></div>
			<div id="container_edit">

				<div id="image-list-edit">
					<div>
						<?php if(file_exists('./assets/uploads/users/thumb/'.$row->thumbnail) && $row->thumbnail !=""){ ?>
						<img src="<?php echo SITE_URL.'assets/uploads/users/thumb/'.$row->thumbnail;?>" width="100" height="100">
						<?php }?>
					</div>
				</div>

				<div id="filelist-edit">No runtime found.</div>
				<div class="clear"></div>
				<a id="pickfiles-edit" href="javascript:;" class="btn" style="border: 1px solid #c4c4c4">Select Images</a><br><br>
				<a id="uploadfiles-edit" href="javascript:;" class="btn" style="border: 1px solid #c4c4c4">Add Images</a>
				<p>&nbsp;</p>
				<p class="pds-field-desc">Click Select Images to Select the images and Add images to upload the selected images.</p>
			</div>
		</div>
	</div>
	<div class="form-group mt-lg">
		<label class="col-sm-3 control-label"></label>
		<div class="col-sm-9">			
			<input type="submit" name="save" value="Save Details" class="btn btn-primary" />
			<button type="button" class="btn btn-danger mfp-close" data-dismiss="modal" style="height: 43px;font-size: 15px;">Close</button>
		</div>
	</div>

</div>
<script type="text/javascript">

// Custom example logic
var webpath = '<?php echo SITE_URL; ?>';
var uploader = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
	multi_selection: false,
  browse_button : 'pickfiles-edit', // you can pass in id...
  container: document.getElementById('container_edit'), // ... or DOM Element itself
  url : '<?php echo SITE_URL; ?>assets/upload.php',
  flash_swf_url : '../js/Moxie.swf',
  silverlight_xap_url : '../js/Moxie.xap',
  
  filters : {
  	max_file_size : '10mb',
  	mime_types: [
  	{title : "Image files", extensions : "jpg,gif,png"},
  	{title : "Zip files", extensions : "zip"}
  	]
  },

  init: {
  	PostInit: function() {
  		document.getElementById('filelist-edit').innerHTML = '';

  		document.getElementById('uploadfiles-edit').onclick = function() {
  			uploader.start();
  			return false;
  		};
  	},

  	FilesAdded: function(up, files) {
  		plupload.each(files, function(file) {
  			document.getElementById('filelist-edit').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
  			document.getElementById('image-name-edit').innerHTML = '<input type="hidden" id="images_picture" name="images_picture" value="'+file.name+'">';
  		});
  	},

  	UploadProgress: function(up, file) {
  		document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
  	},
  	UploadComplete: function(up, files) {
  		$("#image-list").html("");
  		document.getElementById('filelist-edit').innerHTML = '';
  		for(var i in files){
  			$("#image-list-edit").html('<div id="'+files[i].name+'" style="float:left;padding-left:5px;"><img src="'+webpath+'assets/uploads/users/'+files[i].name+'" width="100" height="100"></div>');
        //$("#image-name").append('<input type="hidden" name="images_clinic[]" value="'+file.name+'">');

    }
     // $("#image-list").append('<div style="clear:both;"></div>');
        // Called when all files are either uploaded or failed
                       // log('[UploadComplete]');
    },


    Error: function(up, err) {
    	document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
    }
}
});

uploader.init();


</script>
