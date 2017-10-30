<style>
     
.img-upload-btn {
    position: relative;
    overflow: hidden;
    padding-top: 95%;
} 

.img-upload-btn input[type=file] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
} 

.img-upload-btn i {
    position: absolute;
    height: 16px;
    width: 16px;
    top: 50%;
    left: 50%;
    margin-top: -8px;
    margin-left: -8px;
}

.btn-radio {
    position: relative;
    overflow: hidden;
}

.btn-radio input[type=radio] {
    position: absolute;
    top: 0;
    right: 0;
    min-width: 100%;
    min-height: 100%;
    font-size: 100px;
    text-align: right;
    filter: alpha(opacity=0);
    opacity: 0;
    outline: none;
    background: white;
    cursor: inherit;
    display: block;
}
</style>
<div class="container upload_form">
    <br>
    <div class="col-sm-8 ">
      		<legend>Wallpaper data</legend>
            <?php echo $error; ?>
            
         	<?php echo form_open_multipart('WallpaperController/do_upload','id="upload_form"');?>
         	
         	
     		<div class="row">
				<div class="form-group col-sm-2">
     				<label>Title:<span style="color:red;"> *</span></label><br />
     				<input id="title" name="title" size="40" aria-invalid="false" placeholder="Wallpaper Title(min 5 - max 100 chars)" type="text" />
     			</div>
     		</div>
     		
     		<div class="row">
				<div class="form-group col-sm-2">
     				<label>Thumbnail:<span style="color:red;"> *</span></label><br />
					<div id="thumbnail" class="img-picker"></div>
				</div>
			</div>
			
     		<div class="row">
				<div class="form-group col-sm-2">
     				<label>Author:<span style="color:red;"> *</span></label><br />
     				<input id="author" name="author" size="40" aria-invalid="false" placeholder="Added BY(min 5 - max 100 chars)" type="text" />
     			</div>
     		</div>
			
     		<div class="row">
				<div class="form-group col-sm-2">
     				<label>Directory:<span style="color:red;"> *</span></label><br />
     				<input id="directory" name="directory" size="40" aria-invalid="false" placeholder="Directory(folder) name" type="text" />
     			</div>
     		</div>
     		
         	<label>Wallpaper Layers(from front layer to background layer order): <span style="color:red;"> *</span></label>
            <div class="row">
                <div class="form-group col-sm-2">
                    <div id="userfile0" class="img-picker"></div>
                </div>
                <div class="form-group col-sm-2">
                    <div id="userfile1" class="img-picker"></div>
                </div>
                <div class="form-group col-sm-2">
                    <div id="userfile2" class="img-picker"></div>
                </div>
                <div class="form-group col-sm-2">
                    <div id="userfile3" class="img-picker"></div>
                </div>
                <div class="form-group col-sm-2">
                    <div id="userfile4" class="img-picker"></div>
                </div>
     		</div>
     		<br/>
     		
     		<div class="row">
				<div class="form-group col-sm-2">
            		<button type="submit" name='submit' class="btn btn-primary">Submit</button>
            	</div>
            </div>
            
     		<?php echo "</form>" ?>
    </div>
</div>