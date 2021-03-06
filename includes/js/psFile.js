var currentFolder = "uploads";
$(document).ready(function(){
	$('#showFilesContainer').load("showFiles.php?folderName=uploads");
	/*****************/
	/* Create Folder */
	/*****************/
	$('#createFolderLink').click(function(){
		$('#createFolderContainer').slideDown();
		$('#uploadFilesContainer').slideUp();
		$('#leechFileContainer').slideUp();
		$('#resizeImageContainer').slideUp();
		$('#folderName').val("");
		$('#processResult').html("");
	});
    $('#cancelCreateFolderButton').click(function(){
        $('#createFolderContainer').slideUp();
    });
    $('#createFolderButton').click(function(){
        var folderName = $('#folderName').val().replace(" ", "_");
        $("#processResult").slideDown();
        $("#processResult").load("fileProcess.php?action=createFolder&folderName=" + folderName + "&mainFolder=" + currentFolder, function(responseTxt,statusTxt,xhr){
            if(statusTxt=="success"){
				$("#showFilesContainer").load("showFiles.php?folderName=" + currentFolder);
				$('#createFolderContainer').slideUp();
            }
        })
    });
	/****************/
	/* Upload Files */
	/****************/
	$('#uploadFilesLink').click(function(){
		$('#createFolderContainer').slideUp();
		$('#uploadFilesContainer').slideDown();
		$('#leechFileContainer').slideUp();
		$('#resizeImageContainer').slideUp();
		$('#files').val("");
		$('#processResult').html("");
	});
    $('#canceluploadFilesButton').click(function(){
        $('#uploadFilesContainer').slideUp();
    });
	//Program a custom submit function for the form
	$('#form1').submit(function(event){
	  $('#mainFolder').val(currentFolder);
	  //disable the default form submission
	  event.preventDefault();
	 
	  //grab all form data  
	  var formData = new FormData($(this)[0]);
	 
	  $.ajax({
		url: 'uploadFiles.php',
		type: 'POST',
		data: formData,
		async: false,
		cache: false,
		contentType: false,
		processData: false,
		success: function (returndata) {
			$("#showFilesContainer").load("showFiles.php?folderName=" + currentFolder, function(responseTxt,statusTxt,xhr){
				if(statusTxt=="success" && returndata == ""){
					$('#uploadFilesContainer').slideUp();
				}
			});
			$('#processResult').slideDown();
			$('#processResult').html("<span style='color:#F00;'>" + returndata + "</span>");
		}
	  });
	 
	  return false;
	});
	/**************/
	/* Leech File */
	/**************/
	$('#leechFileLink').click(function(){
		$('#createFolderContainer').slideUp();
		$('#uploadFilesContainer').slideUp();
		$('#leechFileContainer').slideDown();
		$('#resizeImageContainer').slideUp();
		$('#leechURL').val("");
		$('#processResult').html("");
	});
    $('#cancelLeechFileButton').click(function(){
        $('#leechFileContainer').slideUp();
    });
    $('#leechFileButton').click(function(){
        $("#processResult").slideDown();
        $("#processResult").load("leechFile.php?leechURL=" + $('#leechURL').val() + "&leechDestination=" + $('#leechDestination').val(), function(responseTxt,statusTxt,xhr){
            if(statusTxt=="success"){
            	$("#showFilesContainer").load("showFiles.php?folderName=" + currentFolder);
				$('#leechFileContainer').slideUp();
            }
        })
    });
	/****************/
	/* Resize Image */
	/****************/
	$('#cancelResizeImageButton').click(function(){
        $('#resizeImageContainer').slideUp();
    });
	$('#resizeImageButton').click(function(){
        if($('#imageWidth').val() != "" && $('#imageHeight').val() != ""){
		$("#processResult").slideDown();
		$.post("resizeImage.php",
		  {
			imageFile: $('#imageFile').val(),
			imageWidth: $('#imageWidth').val(),
			imageHeight: $('#imageHeight').val()
		  },
		  function(data,status){
			  if(status=="success" && data != "error"){
				  alert("Image has been resized!");
				  $("#showFilesContainer").load("showFiles.php?folderName=" + data);
				  $('#resizeImageContainer').slideUp();
			  }else{
				  alert("Could not resize!");
			  }
		  });
        }else{
            alert("Please fill all fields!");
        }
	});
    /****************/
    /* Rename File */
    /****************/
    $('#cancelRenameFileButton').click(function(){
        $('#renameFileContainer').slideUp();
    });
    $('#renameFileButton').click(function(){
        if($('#renameFileName').val() != ""){
            $("#processResult").slideDown();
            $.post("renameFile.php",
                {
                    renameNewFileName: $('#renameNewFileName').val(),
                    renameOldFileName: $('#renameOldFileName').val(),
                    type: $('#renameFileType').val()
                },
                function(data,status){
                    if(status=="success" && data != "error"){
                        alert("Item has been renamed!");
                        $("#showFilesContainer").load("showFiles.php?folderName=" + data);
                        $('#renameFileContainer').slideUp();
                    }else{
                        alert("Could not rename! Item already exists!");
                    }
                });
        }else{
            alert("Please fill all fields!");
        }
    });


});
/***************/
/* open Folder */
/***************/
function openFolder(folderName){
	currentFolder = folderName;
	$('#createFolderContainer').slideUp();
	$('#uploadFilesContainer').slideUp();
	$('#leechFileContainer').slideUp();
	$('#resizeImageContainer').slideUp();
	$('#files').val("");
	$('#processResult').html("");
		
	$('#currentFolder').html(folderName + ":");
	$('#leechDestination').val(folderName);
	$("#showFilesContainer").load("showFiles.php?folderName=" + folderName);
}
/****************/
/* Delete Object*/
/****************/
function deleteObject(object, objectType){
	if(confirm("Are you sure you want to delete this?")){
		$.post("fileProcess.php",
		  {
			action:"deleteObject",
			object:object,
			objectType: objectType
		  },
		  function(data,status){
			  if(status=="success" && data != "error"){
				  $("#showFilesContainer").load("showFiles.php?folderName=" + data);
			  }else{
				  alert("Could not delete!");
			  }
		  });
	}
}
/***************************/
/* Show Resize Image Panel */
/***************************/
function showResizeImagePanel(image, width, height){
	$('#createFolderContainer').slideUp();
	$('#uploadFilesContainer').slideUp();
	$('#leechFileContainer').slideUp();
	$('#processResult').html("");
	
	$('#resizeImageContainer').slideDown();
	$('#imageFile').val(image);
	$('#imageWidth').val(width);
	$('#imageHeight').val(height);
    $('#showImageFileName').html("<strong>Resize "+image+":</strong>");
}
function showRenameFilePanel(oldFilename, newFilename, type){
    $('#createFolderContainer').slideUp();
    $('#uploadFilesContainer').slideUp();
    $('#leechFileContainer').slideUp();
    $('#resizeImageContainer').slideUp();
    $('#processResult').html("");

    $('#renameFileContainer').slideDown();
    $('#renameNewFileName').val(newFilename);
    $('#renameOldFileName').val(oldFilename);
    $('#renameFileType').val(type);
}
function showFileOptions(object){
    $(object).show();
}
function hideFileOptions(object){
    $(object).hide();
}