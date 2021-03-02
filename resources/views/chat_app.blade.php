@include('layouts/header')

<body>
<div class="container">

    <!-- Page header start -->
    <div class="page-title">
        <div class="gutters">
            <div class="w3-right">
                <h2 class="title"> <img src="{{ asset('assets/images/smile.png') }}" width="25" height="25" style="display: inline" alt=""> تعال انبوكس   </h2>
            </div>
        </div>
    </div>
    <!-- Page header end -->

    <!-- Content wrapper start -->
    <div class="w3-clear content-wrapper">

        <!-- Row start -->
        <div class="row gutters">

            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

                <div class="card m-0">
                    <!-- Row start -->
                    <div id="app">
                      <chat-app :user="{{ auth()->user() }}"></chat-app>
                    </div>
                    <!-- Row end -->
                </div>

            </div>

        </div>
        <!-- Row end -->

    </div>
    <!-- Content wrapper end -->

</div>
<script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script type="text/javascript">

</script>
</body>
</html>
