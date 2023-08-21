<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$pageTitle}}</title>
    <link
        rel="shortcut icon"
        type="image/png"
        href="{{asset("images/logos/polandstudylogo.png")}}"
    />
    @vite(['resources/scss/styles.scss'])
</head>

<body class="overflow-x-hidden">

@yield('main')

@vite(['resources/scss/styles.scss',
            'resources/libs/jquery/dist/jquery.min.js',
            'resources/libs/bootstrap/dist/js/bootstrap.bundle.min.js',
            'resources/js/dashboard.js',
            'resources/js/main.js',
            'resources/libs/apexcharts/dist/apexcharts.min.js',
            'resources/libs/simplebar/dist/simplebar.js'])

@yield('scripts')

</body>
</html>


{{--<div class="row">--}}
{{--    <div class="col-lg-12 d-flex align-items-stretch">--}}
{{--        <div class="card w-100">--}}
{{--            <div class="card-header p-3">--}}
{{--                <div class="row align-items-center">--}}
{{--                    <div class="col-8">--}}
{{--                        <h5 class="card-title fw-semibold m-0">--}}
{{--                            personal--}}
{{--                        </h5>--}}
{{--                    </div>--}}
{{--                    <div class="col-4 text-end">--}}
{{--                        <div id="userFormBtn1" class="d-none">--}}
{{--                            <button--}}
{{--                                type="button"--}}
{{--                                class="btn btn-success btn-block m-1 btnSaveClass"--}}
{{--                                id="btnSave1"--}}
{{--                                data-category="1"--}}
{{--                            >--}}
{{--                                Save--}}
{{--                            </button>--}}
{{--                            <button--}}
{{--                                type="button"--}}
{{--                                class="btn btn-danger btn-block m-1 btnCancelClass"--}}
{{--                                id="btnCancel1"--}}
{{--                                data-category="1"--}}
{{--                            >--}}
{{--                                Cancel--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                        <div id="displayFormBtn1">--}}
{{--                            <button--}}
{{--                                type="button"--}}
{{--                                class="btn btn-danger btn-block m-1 btnEditClass"--}}
{{--                                id="btnEdit1"--}}
{{--                                data-category="1"--}}
{{--                            >--}}
{{--                                Edit--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="card-body">--}}
{{--                <form id="displayForm1" class="mt-4 ">--}}
{{--                    <div class="col">--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">Country</label>--}}
{{--                                    <p id="displayCountry" class="form-control-static">--}}
{{--                                        Serbia--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">Date of birth</label>--}}
{{--                                    <p id="displayDate of birth" class="form-control-static">--}}
{{--                                        2003-02-20--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">Passport number</label>--}}
{{--                                    <p id="displayPassport number" class="form-control-static">--}}
{{--                                        111333000--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">Father's name</label>--}}
{{--                                    <p id="displayFather's name" class="form-control-static">--}}
{{--                                        Pavle--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">Mother's name</label>--}}
{{--                                    <p id="displayMother's name" class="form-control-static">--}}
{{--                                        Milica--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">How tall</label>--}}
{{--                                    <p id="displayHow tall" class="form-control-static">--}}
{{--                                        180--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">Eyes color</label>--}}
{{--                                    <p id="displayEyes color" class="form-control-static">--}}
{{--                                        Plaveee--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">New Surname</label>--}}
{{--                                    <p id="displayNew Surname" class="form-control-static">--}}
{{--                                        Jovicic--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">Swift Code</label>--}}
{{--                                    <p id="displaySwift Code" class="form-control-static">--}}
{{--                                        313144--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">Bank Address</label>--}}
{{--                                    <p id="displayBank Address" class="form-control-static">--}}
{{--                                        Nova adresa!--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">IBAN</label>--}}
{{--                                    <p id="displayIBAN" class="form-control-static">--}}
{{--                                        ne znam sta je iban???--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">Visa refusal letter</label>--}}
{{--                                    <p id="displayVisa refusal letter" class="form-control-static">--}}

{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--            <form id="userForm1" class="mt-4 ">--}}
{{--                <div class="col">--}}
{{--                    <div class="row my-2">--}}
{{--                        <div class="col-sm-4">--}}
{{--                            <label for="undefined">Country</label>--}}
{{--                            <input class="form-control" value="Serbia" data-field-id="91" name="UF_CRM_1680032120828"/>--}}
{{--                        </div>--}}
{{--                        <div class="col-sm-4">--}}
{{--                            <label for="undefined">Date of birth</label>--}}
{{--                            <input type="date" name="UF_CRM_1680032383794" value="2003-02-20" data-field-id="92"--}}
{{--                                   class="form-control">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="row my-2">--}}
{{--                        <div class="col-sm-4">--}}
{{--                            <label for="undefined">Passport number</label>--}}
{{--                            <input class="form-control" value="111333000" data-field-id="94"--}}
{{--                                   name="UF_CRM_1680298400987"/>--}}
{{--                        </div>--}}
{{--                        <div class="col-sm-4">--}}
{{--                            <label for="undefined">Father's name</label>--}}
{{--                            <input class="form-control" value="Pavle" data-field-id="95" name="UF_CRM_1680603233821"/>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="row my-2">--}}
{{--                        <div class="col-sm-4">--}}
{{--                            <label for="undefined">Mother's name</label>--}}
{{--                            <input class="form-control" value="Milica" data-field-id="96" name="UF_CRM_1680603245745"/>--}}
{{--                        </div>--}}
{{--                        <div class="col-sm-4">--}}
{{--                            <label for="undefined">How tall</label>--}}
{{--                            <input class="form-control" value="180" data-field-id="98" name="UF_CRM_1680603289265"/>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="row my-2">--}}
{{--                        <div class="col-sm-4">--}}
{{--                            <label for="undefined">Eyes color</label>--}}
{{--                            <input class="form-control" value="Plaveee" data-field-id="99" name="UF_CRM_1680603305002"/>--}}
{{--                        </div>--}}
{{--                        <div class="col-sm-4">--}}
{{--                            <label for="undefined">New Surname</label>--}}
{{--                            <input class="form-control" value="Jovicic" data-field-id="104"--}}
{{--                                   name="UF_CRM_1680603499003"/>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="row my-2">--}}
{{--                        <div class="col-sm-4">--}}
{{--                            <label for="undefined">Swift Code</label>--}}
{{--                            <input class="form-control" value="313144" data-field-id="109" name="UF_CRM_1680636696101"/>--}}
{{--                        </div>--}}
{{--                        <div class="col-sm-4">--}}
{{--                            <label for="undefined">Bank Address</label>--}}
{{--                            <input class="form-control" value="Nova adresa!" data-field-id="110"--}}
{{--                                   name="UF_CRM_1680636704623"/>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="row my-2">--}}
{{--                        <div class="col-sm-4">--}}
{{--                            <label for="undefined">IBAN</label>--}}
{{--                            <input class="form-control" value="ne znam sta je iban???" data-field-id="111"--}}
{{--                                   name="UF_CRM_1680636714360"/>--}}
{{--                        </div>--}}
{{--                        <div class="col-sm-4">--}}
{{--                            <label for="undefined">Visa refusal letter</label>--}}
{{--                            <input type="file" name="UF_CRM_1680638095155" class="form-control">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}


{{--<div class="row">--}}
{{--    <div class="col-lg-12 d-flex align-items-stretch">--}}
{{--        <div class="card w-100">--}}
{{--            <div class="card-header p-3">--}}
{{--                <div class="row align-items-center">--}}
{{--                    <div class="col-8">--}}
{{--                        <h5 class="card-title fw-semibold m-0">--}}
{{--                            address--}}
{{--                        </h5>--}}
{{--                    </div>--}}
{{--                    <div class="col-4 text-end">--}}
{{--                        <div id="userFormBtn2" class="d-none">--}}
{{--                            <button--}}
{{--                                type="button"--}}
{{--                                class="btn btn-success btn-block m-1 btnSaveClass"--}}
{{--                                id="btnSave2"--}}
{{--                                data-category="2"--}}
{{--                            >--}}
{{--                                Save--}}
{{--                            </button>--}}
{{--                            <button--}}
{{--                                type="button"--}}
{{--                                class="btn btn-danger btn-block m-1 btnCancelClass"--}}
{{--                                id="btnCancel2"--}}
{{--                                data-category="2"--}}
{{--                            >--}}
{{--                                Cancel--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                        <div id="displayFormBtn2">--}}
{{--                            <button--}}
{{--                                type="button"--}}
{{--                                class="btn btn-danger btn-block m-1 btnEditClass"--}}
{{--                                id="btnEdit2"--}}
{{--                                data-category="2"--}}
{{--                            >--}}
{{--                                Edit--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="card-body">--}}
{{--                <form id="displayForm2" class="mt-4 ">--}}

{{--                    <div class="col">--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">IS_RETURN_CUSTOMER</label>--}}
{{--                                    <p id="displayIS_RETURN_CUSTOMER" class="form-control-static">--}}
{{--                                        Unos 1--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">PROBABILITY</label>--}}
{{--                                    <p id="displayPROBABILITY" class="form-control-static">--}}
{{--                                        Unos 33--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">CURRENCY_ID</label>--}}
{{--                                    <p id="displayCURRENCY_ID" class="form-control-static">--}}
{{--                                        Dinar--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">OPPORTUNITY</label>--}}
{{--                                    <p id="displayOPPORTUNITY" class="form-control-static">--}}
{{--                                        Ne Razem--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">IS_MANUAL_OPPORTUNITY</label>--}}
{{--                                    <p id="displayIS_MANUAL_OPPORTUNITY" class="form-control-static">--}}
{{--                                        Hehehe--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">TAX_VALUE</label>--}}
{{--                                    <p id="displayTAX_VALUE" class="form-control-static">--}}
{{--                                        Pozdravv--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">COMPANY_ID</label>--}}
{{--                                    <p id="displayCOMPANY_ID" class="form-control-static">--}}
{{--                                        Nova firma--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">MODIFY_BY_ID</label>--}}
{{--                                    <p id="displayMODIFY_BY_ID" class="form-control-static">--}}

{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">Address</label>--}}
{{--                                    <p id="displayAddress" class="form-control-static">--}}
{{--                                        dasdas--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">Local no</label>--}}
{{--                                    <p id="displayLocal no" class="form-control-static">--}}
{{--                                        eqwda--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">Room no</label>--}}
{{--                                    <p id="displayRoom no" class="form-control-static">--}}
{{--                                        asda--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--                <form id="userForm2" class="mt-4 ">--}}

{{--                    <div class="col">--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <label for="undefined">Deal powracający</label>--}}
{{--                                <input class="form-control" value="Unos 1" data-field-id="9" name="IS_RETURN_CUSTOMER"/>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <label for="undefined">Prawdopodobieństwo</label>--}}
{{--                                <input class="form-control" value="Unos 33" data-field-id="11" name="PROBABILITY"/>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <label for="undefined">Waluta</label>--}}
{{--                                <input class="form-control" value="Dinar" data-field-id="12" name="CURRENCY_ID"/>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <label for="undefined">Razem</label>--}}
{{--                                <input class="form-control" value="Ne Razem" data-field-id="13" name="OPPORTUNITY"/>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <label for="undefined">IS_MANUAL_OPPORTUNITY</label>--}}
{{--                                <input class="form-control" value="Hehehe" data-field-id="14"--}}
{{--                                       name="IS_MANUAL_OPPORTUNITY"/>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <label for="undefined">Stawka podatku</label>--}}
{{--                                <input class="form-control" value="Pozdravv" data-field-id="15" name="TAX_VALUE"/>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <label for="undefined">Firma</label>--}}
{{--                                <input class="form-control" value="Nova firma" data-field-id="16" name="COMPANY_ID"/>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <label for="undefined">Zmodyfikowane przez</label>--}}
{{--                                <input class="form-control" readonly value="" data-field-id="27" name="MODIFY_BY_ID"/>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <label for="undefined">Address</label>--}}
{{--                                <input class="form-control" value="dasdas" data-field-id="60"--}}
{{--                                       name="UF_CRM_1667336539785"/>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <label for="undefined">Local no</label>--}}
{{--                                <input class="form-control" value="eqwda" data-field-id="61"--}}
{{--                                       name="UF_CRM_1667336565703"/>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <label for="undefined">Room no</label>--}}
{{--                                <input class="form-control" value="asda" data-field-id="62"--}}
{{--                                       name="UF_CRM_1667336578485"/>--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="row">--}}
{{--    <div class="col-lg-12 d-flex align-items-stretch">--}}
{{--        <div class="card w-100">--}}
{{--            <div class="card-header p-3">--}}
{{--                <div class="row align-items-center">--}}
{{--                    <div class="col-8">--}}
{{--                        <h5 class="card-title fw-semibold m-0">--}}
{{--                            documents--}}
{{--                        </h5>--}}
{{--                    </div>--}}
{{--                    <div class="col-4 text-end">--}}
{{--                        <div id="userFormBtn3" class="d-none">--}}
{{--                            <button--}}
{{--                                type="button"--}}
{{--                                class="btn btn-success btn-block m-1 btnSaveClass"--}}
{{--                                id="btnSave3"--}}
{{--                                data-category="3"--}}
{{--                            >--}}
{{--                                Save--}}
{{--                            </button>--}}
{{--                            <button--}}
{{--                                type="button"--}}
{{--                                class="btn btn-danger btn-block m-1 btnCancelClass"--}}
{{--                                id="btnCancel3"--}}
{{--                                data-category="3"--}}
{{--                            >--}}
{{--                                Cancel--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                        <div id="displayFormBtn3">--}}
{{--                            <button--}}
{{--                                type="button"--}}
{{--                                class="btn btn-danger btn-block m-1 btnEditClass"--}}
{{--                                id="btnEdit3"--}}
{{--                                data-category="3"--}}
{{--                            >--}}
{{--                                Edit--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="card-body">--}}
{{--                <form id="displayForm3" class="mt-4 ">--}}

{{--                    <div class="col">--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">BEGINDATE</label>--}}
{{--                                    <p id="displayBEGINDATE" class="form-control-static">--}}
{{--                                        2003-02-20--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">All entries and exits you have made in the last 5 years--}}
{{--                                        with the name of the country</label>--}}
{{--                                    <p id="displayAll entries and exits you have made in the last 5 years with the name of the country"--}}
{{--                                       class="form-control-static">--}}
{{--                                        Najjace--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">Account holder name</label>--}}
{{--                                    <p id="displayAccount holder name" class="form-control-static">--}}
{{--                                        I don't give commentar--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">Account Number</label>--}}
{{--                                    <p id="displayAccount Number" class="form-control-static">--}}

{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">CV for internship</label>--}}
{{--                                    <p id="displayCV for internship" class="form-control-static">--}}

{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">Department applying for</label>--}}
{{--                                    <p id="displayDepartment applying for" class="form-control-static">--}}
{{--                                        Business Administration--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">Post office confirmation forwarded</label>--}}
{{--                                    <p id="displayPost office confirmation forwarded" class="form-control-static">--}}
{{--                                        Pozdrav!--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--                <form id="userForm3" class="mt-4 ">--}}

{{--                    <div class="col">--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <label for="undefined">Data rozpoczęcia</label>--}}
{{--                                <input type="date" name="BEGINDATE" value="2003-02-20" data-field-id="20"--}}
{{--                                       class="form-control">--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <label for="undefined">All entries and exits you have made in the last 5 years with the--}}
{{--                                    name of the country</label>--}}
{{--                                <input class="form-control" value="Najjace" data-field-id="102"--}}
{{--                                       name="UF_CRM_1680603447777"/>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <label for="undefined">Account holder name</label>--}}
{{--                                <input class="form-control" value="I don't give commentar" data-field-id="107"--}}
{{--                                       name="UF_CRM_1680636675205"/>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <label for="undefined">Account Number</label>--}}
{{--                                <input class="form-control" value="" data-field-id="108" name="UF_CRM_1680636685514"/>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <label for="undefined">CV for internship</label>--}}
{{--                                <input type="file" name="UF_CRM_1680901809249" class="form-control">--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <label for="undefined">Department applying for</label>--}}
{{--                                <select class="form-control" data-field-id="125" name="UF_CRM_1681228055796">--}}
{{--                                    <option value="0">Select</option>--}}
{{--                                    <option value="Business Administration" selected>Business Administration</option>--}}
{{--                                    <option value="Sales and Marketing">Sales and Marketing</option>--}}
{{--                                    <option value="Graphic Design and Social Media">Graphic Design and Social Media--}}
{{--                                    </option>--}}
{{--                                    <option value="Web Development">Web Development</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <label for="undefined">Post office confirmation forwarded</label>--}}
{{--                                <input class="form-control" value="Pozdrav!" data-field-id="126"--}}
{{--                                       name="UF_CRM_1681383385628"/>--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </form>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--</div>--}}
{{--<div class="row">--}}
{{--    <div class="col-lg-12 d-flex align-items-stretch">--}}
{{--        <div class="card w-100">--}}
{{--            <div class="card-header p-3">--}}
{{--                <div class="row align-items-center">--}}
{{--                    <div class="col-8">--}}
{{--                        <h5 class="card-title fw-semibold m-0">--}}
{{--                            deals--}}
{{--                        </h5>--}}
{{--                    </div>--}}
{{--                    <div class="col-4 text-end">--}}
{{--                        <div id="userFormBtn4" class="d-none">--}}
{{--                            <button--}}
{{--                                type="button"--}}
{{--                                class="btn btn-success btn-block m-1 btnSaveClass"--}}
{{--                                id="btnSave4"--}}
{{--                                data-category="4"--}}
{{--                            >--}}
{{--                                Save--}}
{{--                            </button>--}}
{{--                            <button--}}
{{--                                type="button"--}}
{{--                                class="btn btn-danger btn-block m-1 btnCancelClass"--}}
{{--                                id="btnCancel4"--}}
{{--                                data-category="4"--}}
{{--                            >--}}
{{--                                Cancel--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                        <div id="displayFormBtn4">--}}
{{--                            <button--}}
{{--                                type="button"--}}
{{--                                class="btn btn-danger btn-block m-1 btnEditClass"--}}
{{--                                id="btnEdit4"--}}
{{--                                data-category="4"--}}
{{--                            >--}}
{{--                                Edit--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="card-body">--}}
{{--                <form id="displayForm4" class="mt-4 ">--}}

{{--                    <div class="col">--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">Start date of the visa</label>--}}
{{--                                    <p id="displayStart date of the visa" class="form-control-static">--}}
{{--                                        2003-11-02--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">Visa expire date</label>--}}
{{--                                    <p id="displayVisa expire date" class="form-control-static">--}}
{{--                                        2002-01-01--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">Documents</label>--}}
{{--                                    <p id="displayDocuments" class="form-control-static">--}}
{{--                                        Passport copies--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">Date of decision</label>--}}
{{--                                    <p id="displayDate of decision" class="form-control-static">--}}
{{--                                        2002-11-11--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">Street name/number</label>--}}
{{--                                    <p id="displayStreet name/number" class="form-control-static">--}}
{{--                                        Novii i--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">Building no</label>--}}
{{--                                    <p id="displayBuilding no" class="form-control-static">--}}
{{--                                        sadad--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row my-2">--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">Apartment no</label>--}}
{{--                                    <p id="displayApartment no" class="form-control-static">--}}
{{--                                        Pozdravv--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-sm-4">--}}
{{--                                <div class="mb-3">--}}
{{--                                    <label class="form-label">Zip-code</label>--}}
{{--                                    <p id="displayZip-code" class="form-control-static">--}}
{{--                                        14210--}}
{{--                                    </p>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--            </div>--}}
{{--            </form>--}}
{{--            <form id="userForm4" class="mt-4 ">--}}

{{--                <div class="col">--}}
{{--                    <div class="row my-2">--}}
{{--                        <div class="col-sm-4">--}}
{{--                            <label for="undefined">Start date of the visa</label>--}}
{{--                            <input type="date" name="UF_CRM_1672738144775" value="2003-11-02" data-field-id="77"--}}
{{--                                   class="form-control">--}}
{{--                        </div>--}}
{{--                        <div class="col-sm-4">--}}
{{--                            <label for="undefined">Visa expire date</label>--}}
{{--                            <input type="date" name="UF_CRM_1672738192917" value="2002-01-01" data-field-id="78"--}}
{{--                                   class="form-control">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="row my-2">--}}
{{--                        <div class="col-sm-4">--}}
{{--                            <label for="undefined">Documents</label>--}}
{{--                            <select class="form-control" data-field-id="83" name="UF_CRM_1676223111107">--}}
{{--                                <option value="0">Select</option>--}}
{{--                                <option value="4 photo (3.5x4.5)">4 photo (3.5x4.5)</option>--}}
{{--                                <option value="Confirmation from the bank (340 PLN)">Confirmation from the bank (340--}}
{{--                                    PLN)--}}
{{--                                </option>--}}
{{--                                <option value="Passport copies" selected>Passport copies</option>--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="col-sm-4">--}}
{{--                            <label for="undefined">Date of decision</label>--}}
{{--                            <input type="date" name="UF_CRM_1676223478323" value="2002-11-11" data-field-id="85"--}}
{{--                                   class="form-control">--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="row my-2">--}}
{{--                        <div class="col-sm-4">--}}
{{--                            <label for="undefined">Street name/number</label>--}}
{{--                            <input class="form-control" value="Novii i" data-field-id="86" name="UF_CRM_1680032015767"/>--}}
{{--                        </div>--}}
{{--                        <div class="col-sm-4">--}}
{{--                            <label for="undefined">Building no</label>--}}
{{--                            <input class="form-control" value="sadad" data-field-id="87" name="UF_CRM_1680032052359"/>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="row my-2">--}}
{{--                        <div class="col-sm-4">--}}
{{--                            <label for="undefined">Apartment no</label>--}}
{{--                            <input class="form-control" value="Pozdravv" data-field-id="88"--}}
{{--                                   name="UF_CRM_1680032063562"/>--}}
{{--                        </div>--}}
{{--                        <div class="col-sm-4">--}}
{{--                            <label for="undefined">Zip-code</label>--}}
{{--                            <input class="form-control" value="14210" data-field-id="89" name="UF_CRM_1680032097700"/>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--        </div>--}}
{{--        </form>--}}
{{--    </div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
{{--</div>--}}
