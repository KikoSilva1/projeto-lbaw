<!-- resources/views/search.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Live Search</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-r6jDoWp74eP/jjSxY5L2tM6Owpg8hLu3Xab8ae/XGxUg7ot2gy3WuoRg" crossorigin="anonymous">

</head>
<body>
    <div class="container" style="margin-top: 50px;">
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">                   
                <div class="form-group">
                    <input type="text" name="search" id="search" placeholder="Search Questions" class="form-control" onfocus="this.value=''">
                </div>
                <div id="search_list"></div>
            </div>
            <div class="col-lg-3"></div>
        </div>
    </div>

    <!-- Bootstrap JavaScript (Popper.js and Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXqOOgSHu94TAJpcMGrF4xgRZZ5QFjWM+ND" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+Wy6u9z2BD6zHo3mKCzu6VPpDVIaS/NbJva" crossorigin="anonymous"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var searchInput = document.getElementById('search');
            var searchList = document.getElementById('search_list');

            searchInput.addEventListener('input', function () {
                var query = this.value;
                var xhr = new XMLHttpRequest();

                xhr.onreadystatechange = function () {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // Parse the JSON response
                            var response = JSON.parse(xhr.responseText);
                            // Update the HTML of the searchList div
                            searchList.innerHTML = response.output;
                        }
                    }
                };

                xhr.open('GET', 'search?search=' + encodeURIComponent(query), true);
                xhr.send();
            });
        });
    </script>
</body>
</html>
