<?php $pageTitle = "Student profile" ?>
@extends("layouts.student")

@section('main-content')
    @php
        $categories = \Illuminate\Support\Facades\DB::table('field_categories')->select('field_category_id','category_name')->get();

        #DODAJ JAVASCRIPT ZA DETEKTOVANJE KLIKA NA ADD-CATEGORY I KREIRANJE DROPDOWNA I SEARCHA
            foreach ($categories as $category) :
    @endphp
    <div class="container w-25">
        <div class="row">
            <div class="col-12 position-relative">
                <div class="add-category d-flex justify-content-between" id="{{ $category->field_category_id }}">
                    <div class="add-category-text">
                        <p class="add-new-category">Add new category</p>
                    </div>
                    <div class="add-category-icon">
                        <p>+</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php endforeach; @endphp
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            let currentCategory = null; // To keep track of the currently focused category

            $('.add-category').click(function(event) {
                const clickedCategory = $(this);

                if (currentCategory && currentCategory.is(clickedCategory)) {
                    currentCategory.next('#search-dropdown').remove();
                    currentCategory = null;
                    return;
                }

                if (currentCategory && currentCategory !== clickedCategory) {
                    currentCategory.next('#search-dropdown').remove();
                    currentCategory = null;
                }

                //IF DROPDOWN SEARCH DOESN'T ALREADY EXIST MAKE IT
                if (!$('#search-dropdown').length) {
                    if (clickedCategory.next().attr('id') !== 'search-dropdown') {
                        const html = `
                        <div class="container d-block" id="search-dropdown">
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <form action="search-dropdown">
                                        <input type="text" name="search-fields" id="search-fields" class="d-block w-100 form-control"/>
                                        <select id="search-list" class="w-100 form-select" size="10"></select>
                                    </form>
                                </div>
                            </div>
                        </div>`;

                        clickedCategory.after(html);
                        currentCategory = clickedCategory;

                        // Fetch initial data and populate the dropdown
                        fetchDropdownData("");
                    }
                }
                event.stopPropagation();
            });

            //REMOVE DROPDOWN SEARCH OFF FOCUS
            $(document).on('click', function(event) {
                if (!$(event.target).closest('#search-dropdown').length) {
                    $('#search-dropdown').remove();
                    currentCategory = null
                }
            });

            let searchTimeout;

            // Event delegation for input change event
            $(document).on("input", "#search-fields", function() {
                clearTimeout(searchTimeout);
                let query = $(this).val();
                searchTimeout = setTimeout(function() {
                    fetchDropdownData(query);
                }, 400);
            });

            // Event delegation for select change event
            $(document).on("change", "#search-list", function() {
                let selectedOption = $(this).find("option:selected");
                let selectedValue = selectedOption.val();
                let selectedText = selectedOption.text();

                console.log("Selected Value:", selectedValue);
                console.log("Selected Text:", selectedText);

                $("#search-fields").val(selectedText);
                // Remove #search-dropdown
                currentCategory.next('#search-dropdown').remove();
                currentCategory = null;
            });
        });

        function ajaxCallback(route,method,data,success, error){
            $.ajax({
                url: route,
                method: method,
                data: data,
                success: success,
                error: error
            });
        }

        function fetchDropdownData(query) {
            ajaxCallback("/search-dropdown","get",{"search":query}, function(result) {
                $("#search-list").html(result);

                let numOptions = $("#search-list option").length;
                numOptions = Math.max(Math.min(numOptions, 10), 2); // Limit to a maximum of 10 options and min 2
                $("#search-list").attr("size", numOptions);
            }, function() {
                console.error("Failed to retrieve search results.");

                // Reset the dropdown to show all options
                $("#search-list").attr("size", $("#search-list option").length);
            })
        }
    </script>
@endsection

@section('scripts')
    @vite('resources/js/profile.js');

@endsection


