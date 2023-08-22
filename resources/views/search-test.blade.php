<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"/>
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-4">
                <h1>Autocomplete search dropdown</h1>
                <form action="search-dropdown">
                    <input type="text" name="search-fields" id="search-fields" class="d-block w-100 form-control"/>
                    <select id="search-list" class="w-100 form-select" size="10"></select>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            let searchTimeout;
            // Fetch initial data and populate the dropdown
            fetchDropdownData("");

            $("#search-fields").on("input", function() {
                clearTimeout(searchTimeout);
                let query = $(this).val();
                searchTimeout = setTimeout(function() {
                    fetchDropdownData(query);
                }, 400);
            });

            //FILL IN INPUT TEXT
            $("#search-list").on("change", function() {
                let selectedText = $(this).find("option:selected").text();

                $("#search-fields").val(selectedText);
            });
        });

        function fetchDropdownData(query) {
            $.ajax({
                url: "/search-dropdown",
                method: "get",
                data: {"search": query},
                success: function(result) {
                    $("#search-list").html(result);

                    let numOptions = $("#search-list option").length;
                    numOptions = Math.min(numOptions, 10); // Limit to a maximum of 10 options
                    $("#search-list").attr("size", numOptions);
                },
                error: function() {
                    // Handle AJAX error here
                    console.error("Failed to retrieve search results.");

                    // Reset the dropdown to show all options
                    $("#search-list").attr("size", $("#search-list option").length);
                }
            });
        }
    </script>
</body>
</html>
