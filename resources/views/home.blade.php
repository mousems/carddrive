<!DOCTYPE html>
<html>
    <head>
        <title>Card Drive</title>

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
                    <span class="title">CardDrive</span>
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
                    <!-- <li class="list-group-item" id="contact123">
                        <div class="col-xs-12 col-sm-2">
                            <img src="http://api.randomuser.me/portraits/men/49.jpg" alt="Scott Stevens" class="img-responsive img-circle person-img">
                        </div>
                        <div class="col-xs-12 col-sm-10">
                            <span class="name">Scott Stevens</span><br>
                        </div>
                        <div class="clearfix"></div>
                    </li> -->
                </ul>
            </div>
        </div>
	</div>
    <div class="modal" id="form_new" data-backdrop="static">
    	<div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title">補齊您的資料</h4>
            </div>
            <div class="modal-body">

              <form class="form-horizontal" action="/home/save" method="post">
                <label class="control-label">Name</label>
                <div class="form-group">
                  <div class="col-sm-6">
                    <input type="input" class="form-control" id="formLastName" name="formLastName" placeholder="Last Name">
                  </div>
                  <div class="col-sm-6">
                    <input type="input" class="form-control" id="formFirstName" name="formFirstName" placeholder="First Name">
                  </div>
                </div>
                <label class="control-label">Company</label>
                <div class="form-group">
                  <div class="col-sm-6">
                    <input type="input" class="form-control" id="formCompany" name="formCompany" placeholder="Company Name">
                  </div>
                  <div class="col-sm-6">
                    <input type="input" class="form-control" id="formTitle" name="formTitle" placeholder="Job Title">
                  </div>
                </div>
                <label class="control-label">Phone</label>
                <div class="form-group">
                  <div class="col-sm-4">
                    <select class="form-control" id="formPhoneType" name="formPhoneType">
                      <option value="Mobile">Mobile</option>
                      <option value="Home">Home</option>
                      <option value="Work">Work</option>
                    </select>
                  </div>
                  <div class="col-sm-6">
                    <input type="input" class="form-control" id="formPhone" name="formPhone" placeholder="Phone">
                  </div>
                </div>
                  <label class="control-label">E-mail</label>
                  <div class="form-group">
                    <div class="col-sm-4">
                      <select class="form-control" id="formEmailType" name="formEmailType">
                        <option value="Main">Main</option>
                        <option value="Work">Work</option>
                      </select>
                    </div>
                    <div class="col-sm-6">
                      <input type="input" class="form-control" id="formEmail" name="formEmail" placeholder="E-mail">
                    </div>
                  </div>
                <label class="control-label">Address</label>
                <div class="form-group">
                  <div class="col-sm-3">
                    <select class="form-control" id="formAddressType" name="formAddressType">
                      <option value="Home">Home</option>
                      <option value="Work">Work</option>
                      <option value="Postal">Postal</option>
                    </select>
                  </div>
                  <div class="col-sm-3">
                    <input type="input" class="form-control" id="formAddressCountry" name="formAddressCountry" placeholder="Country">
                  </div>
                  <div class="col-sm-3">
                    <input type="input" class="form-control" id="formAddressZIP" name="formAddressZIP" placeholder="ZIP">
                  </div>
                  <div class="col-sm-3">
                    <input type="input" class="form-control" id="formAddressCity" name="formAddressCity" placeholder="Country/City">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-4">
                    <input type="input" class="form-control" id="formAddressTownship" name="formAddressTownship" placeholder="Township/District">
                  </div>
                  <div class="col-sm-6">
                    <input type="input" class="form-control" id="formAddressStreet" name="formAddressStreet" placeholder="Street">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-3">
                    <button type="submit" class="btn btn-default">save</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
    <div class="modal" id="form_update" data-backdrop="static">
    	<div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title">About Me</h4>
            </div>
            <div class="modal-body">

              <form class="form-horizontal" action="/home/update" method="post">
                <label class="control-label">Name</label>
                <div class="form-group">
                  <div class="col-sm-6">
                    <input type="input" class="form-control" id="formOldLastName" name="formLastName" placeholder="Last Name">
                  </div>
                  <div class="col-sm-6">
                    <input type="input" class="form-control" id="formOldFirstName" name="formFirstName" placeholder="First Name">
                  </div>
                </div>
                <label class="control-label">Company</label>
                <div class="form-group">
                  <div class="col-sm-6">
                    <input type="input" class="form-control" id="formOldCompany" name="formCompany" placeholder="Company Name">
                  </div>
                  <div class="col-sm-6">
                    <input type="input" class="form-control" id="formOldTitle" name="formTitle" placeholder="Job Title">
                  </div>
                </div>
                <label class="control-label">Phone</label>
                <div class="form-group">
                  <div class="col-sm-4">
                    <select class="form-control" id="formOldPhoneType" name="formPhoneType">
                      <option value="Mobile">Mobile</option>
                      <option value="Home">Home</option>
                      <option value="Work">Work</option>
                    </select>
                  </div>
                  <div class="col-sm-6">
                    <input type="input" class="form-control" id="formOldPhone" name="formPhone" placeholder="Phone">
                  </div>
                </div>
                  <label class="control-label">E-mail</label>
                  <div class="form-group">
                    <div class="col-sm-4">
                      <select class="form-control" id="formOldEmailType" name="formEmailType">
                        <option value="Main">Main</option>
                        <option value="Work">Work</option>
                      </select>
                    </div>
                    <div class="col-sm-6">
                      <input type="input" class="form-control" id="formOldEmail" name="formEmail" placeholder="E-mail">
                    </div>
                  </div>
                <label class="control-label">Address</label>
                <div class="form-group">
                  <div class="col-sm-3">
                    <select class="form-control" id="formOldAddressType" name="formAddressType">
                      <option value="Home">Home</option>
                      <option value="Work">Work</option>
                      <option value="Postal">Postal</option>
                    </select>
                  </div>
                  <div class="col-sm-3">
                    <input type="input" class="form-control" id="formOldAddressCountry" name="formAddressCountry" placeholder="Country">
                  </div>
                  <div class="col-sm-3">
                    <input type="input" class="form-control" id="formOldAddressZIP" name="formAddressZIP" placeholder="ZIP">
                  </div>
                  <div class="col-sm-3">
                    <input type="input" class="form-control" id="formOldAddressCity" name="formAddressCity" placeholder="Country/City">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-4">
                    <input type="input" class="form-control" id="formOldAddressTownship" name="formAddressTownship" placeholder="Township/District">
                  </div>
                  <div class="col-sm-6">
                    <input type="input" class="form-control" id="formOldAddressStreet" name="formAddressStreet" placeholder="Street">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-3">
                    <button type="submit" class="btn btn-default">save</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
    </div>
    <div class="modal" id="form_share" data-backdrop="static">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              <h4 class="modal-title">共享資料</h4>
            </div>
            <div class="modal-body">

              <form class="form-horizontal" action="/home/share" method="post">
                <label class="control-label">Name</label>
                <div class="form-group">
                  <div class="col-sm-6">
                    <input type="input" class="form-control" id="formLastName" name="formLastName" placeholder="Last Name">
                  </div>
                  <div class="col-sm-6">
                    <input type="input" class="form-control" id="formFirstName" name="formFirstName" placeholder="First Name">
                  </div>
                </div>
                <label class="control-label">Company</label>
                <div class="form-group">
                  <div class="col-sm-6">
                    <input type="input" class="form-control" id="formCompany" name="formCompany" placeholder="Company Name">
                  </div>
                  <div class="col-sm-6">
                    <input type="input" class="form-control" id="formTitle" name="formTitle" placeholder="Job Title">
                  </div>
                </div>
                <label class="control-label">Phone</label>
                <div class="form-group">
                  <div class="col-sm-4">
                    <select class="form-control" id="formPhoneType" name="formPhoneType">
                      <option value="Mobile">Mobile</option>
                      <option value="Home">Home</option>
                      <option value="Work">Work</option>
                    </select>
                  </div>
                  <div class="col-sm-6">
                    <input type="input" class="form-control" id="formPhone" name="formPhone" placeholder="Phone">
                  </div>
                </div>
                  <label class="control-label">E-mail</label>
                  <div class="form-group">
                    <div class="col-sm-4">
                      <select class="form-control" id="formEmailType" name="formEmailType">
                        <option value="Main">Main</option>
                        <option value="Work">Work</option>
                      </select>
                    </div>
                    <div class="col-sm-6">
                      <input type="input" class="form-control" id="formEmail" name="formEmail" placeholder="E-mail">
                    </div>
                  </div>
                <label class="control-label">Address</label>
                <div class="form-group">
                  <div class="col-sm-3">
                    <select class="form-control" id="formAddressType" name="formAddressType">
                      <option value="Home">Home</option>
                      <option value="Work">Work</option>
                      <option value="Postal">Postal</option>
                    </select>
                  </div>
                  <div class="col-sm-3">
                    <input type="input" class="form-control" id="formAddressCountry" name="formAddressCountry" placeholder="Country">
                  </div>
                  <div class="col-sm-3">
                    <input type="input" class="form-control" id="formAddressZIP" name="formAddressZIP" placeholder="ZIP">
                  </div>
                  <div class="col-sm-3">
                    <input type="input" class="form-control" id="formAddressCity" name="formAddressCity" placeholder="Country/City">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-4">
                    <input type="input" class="form-control" id="formAddressTownship" name="formAddressTownship" placeholder="Township/District">
                  </div>
                  <div class="col-sm-6">
                    <input type="input" class="form-control" id="formAddressStreet" name="formAddressStreet" placeholder="Street">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-3">
                    <button type="submit" class="btn btn-default">save</button>
                  </div>
                </div>
              </form>
            </div>
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
                    $("#form_new").modal("show");
                }else if (resp.error=="fail") {
                    alert("讀取自己的資料失敗！")
                }else if (resp.error==null) {
                    new_contact(resp.myid, "http://api.randomuser.me/portraits/men/49.jpg", resp.myname);
                    $("#nocontacts").remove();
                }
            }
        });
    });
    function new_contact(contact_id, imgurl, name) {
        $("#contact-list").append('<li class="list-group-item" id="contact'+contact_id+'"><div class="col-xs-12 col-sm-2"><img src="'+imgurl+'" class="img-responsive img-circle person-img"></div><div class="col-xs-12 col-sm-9"><span class="name">'+name+'</span></span><div class="col-sm-offset-11 col-sm-1"><span class="icon'+contact_id+' glyphicon glyphicon-chevron-right" style="cursor: pointer;"></div><br></div><div class="clearfix"></div></li>');
        $(".icon"+contact_id).on("click",function(event) {
            open_contact(contact_id);
        });
    };
    function open_contact(contact_id){
        $("#form_update").modal("show");
        $.ajax({
            url: '/api/contact_data/'+contact_id,
            method: 'GET',
            success: function(resp) {
                for (var resp_key in resp) {
                    var r_data = resp[resp_key].data;
                    var r_title = resp[resp_key].title;
                    if (r_title.match(/(.+)_(.+)/)) {
                        r_title_matches = r_title.match(/(.+)_(.+)/);
                        r_title_column = r_title_matches[1];
                        r_title_type = r_title_matches[2];
                    }else{
                        r_title_column = r_title;
                    }
                    if (r_title.match(/Address(.+)_(.+)/)) {
                        r_title_Addr_type = r_title.match(/Address(.+)_(.+)/);
                        $("#formOldAddressType").val(r_title_Addr_type[2]);
                    }else if (r_title.match(/Email_(.+)/)) {
                        r_title_Addr_type = r_title.match(/Email_(.+)/);
                        $("#formOldEmailType").val(r_title_Addr_type[1]);
                    }else if (r_title.match(/Phone_(.+)/)) {
                        r_title_Addr_type = r_title.match(/Phone_(.+)/);
                        $("#formOldPhoneType").val(r_title_Addr_type[1]);
                    }
                    $("#formOld"+r_title_column).val(r_data);
                }
            }
        });
        $(".icon"+contact_id).on("click",function(event) {
            open_contact(contact_id);
        });
    }
    </script>
    </body>
</html>
