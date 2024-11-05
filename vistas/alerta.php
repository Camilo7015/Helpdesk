<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <title></title>
</head>
<body>
    <div class="alert alert-light position-absolute d-inline-flex p-1" role="alert">
        <p>&nbsp;</p> <div id="number" class="text-light" style="color: green"></div>
    </div>

    <script type="text/javascript">
        n = 600
        var l = document.getElementById("number");
        var id = window.setInterval(function(){
            document.onmousemove = function(){
                n = 600
            };
            

            l.innerText = n;
            n--;
            if(n <- -1){
                alert("La Sesion expiro");
                location.href="sali.php";
            }
        },1200);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    
</body>
</html>