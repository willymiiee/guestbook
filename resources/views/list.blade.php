<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Guestbook App</title>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
        <link rel="stylesheet" href="http://getbootstrap.com/examples/signin/signin.css">
    </head>
    <body style="padding-top:70px;">
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="center-block">
                    <a class="navbar-brand" href="#">Guestbook App</a>
                </div>
            </div>
        </nav>

        <div class="container">
            <form class="form-signin">
                <h2 class="form-signin-heading">Enter Your Name</h2>
                <label for="input" class="sr-only">Name</label>
                <input type="text" id="input" class="form-control" placeholder="Name" required="" autofocus="">
                <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
            </form>

            <h2 class="sub-header">Section title</h2>
            <div class="table-responsive">
                <table class="table table-striped" id="dataTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

                <div class="text-center" id="loading">
                    <i class="fa fa-spinner fa-spin fa-3x fa-fw text-center"></i>
                </div>

                <div id="loadMore" onclick="getData()">
                    Load more
                </div>
            </div>
        </div><!-- /.container -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        <script>
            var url = window.location.protocol;
            var page = 1;
            var start = 0;

            function getData() {
                $("#loading").show();

                $.get(url+"/api/guests?page="+page, function(data) {
                    if (data.items.length != 10) {
                        $("#loadMore").hide();
                    }

                    $.each(data.items, function(index, value){
                        $("#dataTable").append('<tr><td>'+parseInt(index+1+start)+'</td><td>'+value.name+'</td><td>'+value.created_date+'</td></tr>')
                    });

                    start+=10;
                });

                page++;
                $("#loading").hide();
            }

            $(function() {
                getData();

                // $('#myTable > tbody:last-child').append('<tr>...</tr><tr>...</tr>');
                // alert('cok');
            });
        </script>
    </body>
</html>