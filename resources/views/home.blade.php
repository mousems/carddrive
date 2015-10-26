<!DOCTYPE html>
<html>
    <head>
        <title>Card Drive</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <!-- Latest compiled and minified JavaScript -->



        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 96px;
            }
            .name {
                font-size: 28px;
            }
            .nocontacts {
                font-size: 24px;
                text-align: center;
            }
            .person-img {
                height: 56px;
            }

        </style>
    </head>
    <body>
        <div class="row">
        <div class="col-xs-12 col-sm-offset-3 col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading c-list">
                    <span class="title">Contacts</span>
                    <ul class="pull-right c-controls"  style="display: none;">
                        <li><a href="#cant-do-all-the-work-for-you" data-toggle="tooltip" data-placement="top" title="Add Contact"><i class="glyphicon glyphicon-plus"></i></a></li>
                        <li><a href="#" class="hide-search" data-command="toggle-search" data-toggle="tooltip" data-placement="top" title="Toggle Search"><i class="fa fa-ellipsis-v"></i></a></li>
                    </ul>
                </div>

                <div class="row" style="display: none;">
                    <div class="col-xs-12">
                        <div class="input-group c-search">
                            <input type="text" class="form-control" id="contact-list-search">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-search text-muted"></span></button>
                            </span>
                        </div>
                    </div>
                </div>

                <ul class="list-group" id="contact-list">

                    <li class="list-group-item" id="nocontacts">
                        <div class="col-xs-12 col-sm-12">
                            <span class="bg-info">資料載入中...</span>
                        </div>
                        <div class="clearfix"></div>
                    </li>
                    <li class="list-group-item" id="contact123">
                        <div class="col-xs-12 col-sm-2">
                            <img src="http://api.randomuser.me/portraits/men/49.jpg" alt="Scott Stevens" class="img-responsive img-circle person-img">
                        </div>
                        <div class="col-xs-12 col-sm-10">
                            <span class="name">Scott Stevens</span><br>
                        </div>
                        <div class="clearfix"></div>
                    </li>
                </ul>
            </div>
        </div>
	</div>
    <div class="modal" id="form" data-backdrop="static">
    	<div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title">補齊您的資料</h4>
            </div>
            <form class="form-horizontal">
              <div class="form-group">
                <label class="col-sm-2 control-label">Name</label>
                <div class="col-sm-4">
                  <input type="input" class="form-control" id="formLastName" placeholder="Last Name">
                </div>
                  <label class="col-sm-2 control-label">Last Name</label>
                  <div class="col-sm-4">
                    <input type="input" class="form-control" id="formFirstName" placeholder="First Naem">
                  </div>
              </div>
             <div class="form-group">
               <label class="col-sm-2 control-label">Phone</label>
               <div class="col-sm-4">
                 <input type="input" class="form-control" id="formPhone" placeholder="Phone">
               </div>
            </div>
              <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-default">Sign in</button>
                </div>
              </div>
            </form>
          </div>
        </div>
    </div>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <script>
    $(function() {
        $.ajax({
            url: '/api/contact/me',
            method: 'GET',
            success: function(resp) {
                if (resp.error=="notfound") {
                    $("#form").modal("show");
                }else{

                }
            }
        });
        $("#contact123").on("click","li", function(event) {
            console.log('you cick 123');
        });
    });
    function new_contact(contact_id, imgurl, name) {
        $("#contact-list").append('<li class="list-group-item" id="contact'+contact_id+'"><div class="col-xs-12 col-sm-2"><img src="'+imgurl+'" class="img-responsive img-circle person-img"></div><div class="col-xs-12 col-sm-10"><span class="name">'+name+'</span><br></div><div class="clearfix"></div></li>');
    };
    </script>
    </body>
</html>
