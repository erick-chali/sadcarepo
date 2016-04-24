<?php
include ('../verifysession.php');
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Repositorio | FTP</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">

<!--    <link href="../css/style.css" rel="stylesheet" type="text/css">-->
</head>
<body>
<style>
    .col-centered{
        float: none;
        margin: 0 auto;
    }

    body {
        padding-top: 70px;
    }
    /* Rules for sizing the icon. */
    .material-icons.md-12 { font-size: 12px; }
    .material-icons.md-18 { font-size: 18px; }
    .material-icons.md-24 { font-size: 24px; }
    .material-icons.md-36 { font-size: 36px; }
    .material-icons.md-48 { font-size: 48px; }

    /* Rules for using icons as black on a light background. */
    .material-icons.md-dark { color: rgba(0, 0, 0, 0.54); }
    .material-icons.md-dark.md-inactive { color: rgba(0, 0, 0, 0.26); }

    /* Rules for using icons as white on a dark background. */
    .material-icons.md-light { color: rgba(255, 255, 255, 1); }
    .material-icons.md-light.md-inactive { color: rgba(255, 255, 255, 0.3); }
</style>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">

            <a class="navbar-brand" href="dashboard.php">FTP</a>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <i class="material-icons">menu</i>
            </button>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href=""></a></li>

            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="">Usuario: <?php echo $_SESSION['login_user']?></a></li>
                <li><a href=""></a></li>
                <li><a href="../logout.php">Cerrar Sesi&oacute;n</a></li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>
<div class="container" id="upload-wrapper">
    <div class="col-lg-6 col-md-8 col-centered">
        <div class="well">
            <h3>Subir Archivos</h3>
            <form action="subir.php" method="post" enctype="multipart/form-data" id="MyUploadForm">
                <div class="form-group">
                    <label>Opci&oacute;n</label>
                    <select id="opcion" name="opcion" class="form-control input-sm">
                        <option value="1">Op 1</option>
                        <option value="2">Op 2</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Seleccione archivo</label>
                    <input name="FileInput[]" id="FileInput"  type="file" multiple />
                    <input type="submit"  id="submit-btn" value="Subir Archivo" class="btn btn-primary btn-sm"/>

                </div>
            </form>
            <div class="col-centered">
                <img src="../img/gears.gif" id="loading-img" style="display: none" alt="Porfavor espere."/>
            </div>
<!--            <div id="progressbox" ><div id="progressbar"></div ><div id="statustxt">0%</div></div>-->
            <div >
                <ul id="output"></ul>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="../js/jquery-2.2.3.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/jquery.form.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
//        $('#loading-img').hide();
        var options = {
            target:   '#output',   // target element(s) to be updated with server response
            beforeSubmit:  beforeSubmit,  // pre-submit callback
            success:       afterSuccess,  // post-submit callback
            uploadProgress: OnProgress, //upload progress callback
            resetForm: true        // reset the form after successful submit
        };

        $('#MyUploadForm').submit(function() {
            $(this).ajaxSubmit(options);
            // always return false to prevent standard browser submit and page navigation
            return false;
        });


//function after succesful file upload (when server response)
        function afterSuccess()
        {
            $('#submit-btn').show(); //hide submit button
            $('#loading-img').hide(); //hide submit button
            $('#progressbox').delay( 1000 ).fadeOut(); //hide progress bar

        }

//function to check file size before uploading.
        function beforeSubmit(){
            //check whether browser fully supports all File API
            if (window.File && window.FileReader && window.FileList && window.Blob)
            {

                if( !$('#FileInput').val()) //check empty input filed
                {
                    $("#output").html("Necesita seleccionar almenos un archivo antes de intentar subir");
                    return false
                }
                for (var i = 0; i < $('#FileInput')[0].files.length; ++i) {

                    var fname = $('#FileInput')[0].files[i].name; //get file size
                    var fsize = $('#FileInput')[0].files[i].size; //get file size
                    var ftype = $('#FileInput')[0].files[i].type; // get file type


                    //allow file types
//                    switch(ftype)
//                    {
//                        case 'image/png':
//                        case 'image/gif':
//                        case 'image/jpeg':
//                        case 'image/pjpeg':
//                        case 'text/plain':
//                        case 'text/html':
//                        case 'application/x-zip-compressed':
//                        case 'application/pdf':
//                        case 'application/msword':
//                        case 'application/vnd.ms-excel':
//                        case 'video/mp4':
//                            break;
//                        default:
//                            $("#output").html("<b>"+fname+": "+ftype+"</b> Unsupported file type!");
//                            return false
//                    }

                    //Allowed file size is less than 5 MB (1048576)
//                    if(fsize>(5242880*100))
//                    {
//                        $("#output").html("<b>"+bytesToSize(fsize) +"</b> Too big file! <br />File is too big, it should be less than 5 MB.");
//                        return false
//                    }

                }

                $('#submit-btn').hide(); //hide submit button
                $('#loading-img').show(); //hide submit button
                $("#output").html("Subiendo archivos...");
            }
            else
            {
                //Output error to older unsupported browsers that doesn't support HTML5 File API
                $("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
                return false;
            }
        }

//progress bar function
        function OnProgress(event, position, total, percentComplete)
        {
            //Progress bar
//                $('#progressbox').show();
//                $('#progressbar').width(percentComplete + '%') //update progressbar percent complete
//                $('#statustxt').html(percentComplete + '%'); //update status text
//                if(percentComplete>50)
//                {
//                    $('#statustxt').css('color','#000'); //change status text to white after 50%
//                }
        }

//function to format bites bit.ly/19yoIPO
        function bytesToSize(bytes) {
            var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
            if (bytes == 0) return '0 Bytes';
            var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
            return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
        }

    });

</script>
</body>
</html>