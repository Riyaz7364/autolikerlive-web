@extends('layouts.master')

@section('title', 'Earn credits ' . $user['loginType'])
@section('description', 'Earn Credits')


@section('javascripts')
    @livewireStyles
@endsection



@push('styles')
@endpush

@section('content')
    <x-navbar></x-navbar>
    <main class="bg-light">
        <div class="container mt-5">
            <div class="row">
                <h1 class="text-center">Earn Credits</h1>


                <x-instagram.logout :username="$user['username']" :logintype="$user['loginType']"></x-instagram.logout>

                <x-instagram.options :logintype="$user['loginType']" :earntype="$user['earnType']"></x-instagram.options>
                @livewire('instagram.credits-component')



                <div class="mt-2 mb-2" style="height: auto !important;">

                    <div class="col-md-8" style="height: auto !important;">
                        <div class="card text-dark bg-white mt-3 mb-2 border-dark text-center fs15">
                            <div class="card-body">



                                <!-- result alert -->
                                <div id="result_alert" class="alert text-white mt-2 d-none" role="alert">

                                </div>

                                <!-- result spinner -->
                                <img id="result_spinner" class="d-none" src="/autoliker/img/result_load.svg"
                                    draggable="false" alt="loading">



                                <br>

                                <!-- promotion spinner -->
                                <img id="promotion_spinner" class="loading"
                                    src="{{ url('assets/images/promotion_load.svg') }}" draggable="false" alt="loading">
                                <input type="hidden" id="frsc" value="">
                                <!-- promotion -->
                                <div id="promotion" class="d-none">
                                    <h5 class="card-title">
                                        Earn <b id="forpoints" style="color:green">1 </b>
                                        Credit
                                        <span id="showText"> By
                                            <b style="color:green;"> Liking </b> This Reel From
                                            <b style="color:#6610f2"> </b>.
                                        </span>
                                    </h5>
                                    <button class="btn btn-success" id="actionbtn">Like</button>

                                </div>
                                <!-- promotion alert -->
                                <div id="promotion_alert" class="alert bg-warning text-white mt-2 d-none" role="alert">
                                </div>

                            </div>
                        </div>

                        <div class="text-center mt-2 mb-2" style="min-height: 0px !important; height: auto !important;">
                            <!-- Google Ads -->
                        </div>
                        <!-- Temp Mail Center  adsbygoogle-->

                        <div class="alert bg-info text-white text-center fs15 mt-2 mb-2">
                            <b>NOTE: Do not close the tab too fast, else credit will not be added.
                            </b>
                            <br>
                            <b>NOTE: If you are following, but credits not added, try changing the account from which
                                you are following.
                            </b>
                        </div>

                        <center>
                            <div class="card border-primary mb-3 fs15">
                                <div class="card-body">
                                    <p>If you have any bugs to report or any suggestions, please let us know!</p>
                                    <a href="/contact" class="btn btn-primary btn-sm">SEND FEEDBACK</a>
                                </div>
                            </div>
                        </center>
                    </div>

                    <div class="col-md-4">

                        <div class="card border-primary mb-3 fs15">
                            <h3 class="card-title text-center bg-primary text-white my-auto"><img class="m-1"
                                    src="{{ url('assets/images/gift-box.png') }}" alt="Daily bonus"
                                    style="width: 50px;">Claim Daily Bonus!</h3>
                            <div class="card-body">
                                <p class="text-center">After completing 10 promotions daily, you can claim your daily bonus.
                                    You will receive credits between 10 to 50 daily.</p>


                                <div class="text-center">

                                    <div id="claim_result" class="alert bg-warning text-white text-center my-4 d-none"
                                        role="alert">
                                        A simple primary alert—check it out!
                                    </div>


                                    <div id="claim_spinner" class="d-none">
                                        <img src="{{ url('assets/images/claim.svg') }}" draggable="false" alt="loading"
                                            style="height: 150px;">
                                    </div>

                                    <button class="btn btn-primary" id="claim">Claim Daily Bonus</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            var _foil;

            function load() {
                $('#promotion').addClass('d-none');
                $('#promotion_spinner').removeClass('d-none');
                let csrfToken = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ route('autoliker.earn.load') }}", // Replace with your actual API endpoint
                    type: "POST",
                    data: {
                        _token: csrfToken,
                    },
                    success: function(response) {
                        let data = response.data;
                        console.log(data);

                        // Update UI elements dynamically
                        $("#forpoints").text(data.cost); // Update the credit amount
                        $("#showText").html(`By <b style="color:green;">${data.service}</b> This ${data.type} From
                            <b style="color:#6610f2">${data.username}</b>.`); // Update the text

                        // Store the link in a data attribute for the button
                        _foil = data.link;
                        $("#actionbtn").html(data.service.toUpperCase());
                        $('#promotion').removeClass('d-none');
                        $('#promotion_spinner').addClass('d-none');
                        $('#frsc').val(data.tokne);
                    },
                    error: function() {
                        console.log('response fail');
                        $("#showText").html(`No data available`); // Update the text
                        $('#promotion').removeClass('d-none');
                        $('#promotion_spinner').addClass('d-none');
                        $('#actionbtn').addClass('d-none');
                        $("#forpoints").addClass('d-none');
                    }
                });
            }


            function check() {
                var frsc = $('#frsc').val();

                $('#promotion').addClass('d-none');
                $('#promotion_spinner').removeClass('d-none');
                let csrfToken = $('meta[name="csrf-token"]').attr('content');
                setTimeout(() => {
                    $.ajax({
                        url: "{{ route('autoliker.earn.check') }}", // Replace with your actual API endpoint
                        type: "POST",
                        data: {
                            _token: csrfToken,
                            frsc: frsc
                        },
                        success: function(response) {
                            console.log(response);
                            $('#result_alert').removeClass('d-none');
                            $('#result_alert').text(response.message);

                            setTimeout(() => {
                                $('#result_alert').addClass('d-none');
                            }, 2000);

                            if (response.success === false) {
                                $('#result_alert').removeClass('bg-success');
                                $('#result_alert').addClass('bg-warning');
                            } else {
                                $('#result_alert').removeClass('bg-warning');
                                $('#result_alert').addClass('bg-success');
                            }
                            Livewire.dispatch('updateCredits');
                            load();
                        },
                        error: function() {
                            alert("Failed to update. Try again.");
                            window.location.reload();
                        }
                    });
                }, 2000);
            }

            $("#actionbtn").click(function() {
                let popup = window.open(_foil, "_blank", "width=675,height=667");


                // Function to send API request
                if (popup) {
                    let closedManually = false;

                    let userLeft = false;

                    // Detect when user leaves the page
                    $(window).on("blur", function() {
                        userLeft = true;
                    });

                    // Detect when user returns to the page
                    $(window).on("focus", function() {
                        if (userLeft) {
                            closedManually = true;
                            check();
                            userLeft = false;
                            popup.close();
                            $(window).off("blur focus"); // Remove event listeners
                        }
                    });


                    popup.onload = function() {
                        /* my code */
                        this.onbeforeunload = function() {
                            console.log(popup);
                            /* my code */
                        }
                    }
                    // Check if user manually closes the window
                    let checkClosed = setInterval(function() {}, 1000);
                } else {
                    alert("Popup blocked! Allow popups for this site.");
                }
            });

            $("#claim").click(function() {
                let claimButton = $(this);
                let claimResult = $("#claim_result");
                let claimSpinner = $("#claim_spinner");

                // Hide previous messages and show spinner
                claimButton.prop("disabled", true);
                claimResult.addClass("d-none");
                claimSpinner.removeClass("d-none");

                $.ajax({
                    url: "{{ route('autoliker.claim.daily.bonus') }}", // Update with your actual route
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}" // Laravel CSRF protection
                    },
                    success: function(response) {
                        claimSpinner.addClass("d-none"); // Hide spinner
                        claimResult.removeClass("d-none").removeClass(
                            "bg-warning bg-danger bg-success");

                        if (response.status === "success") {
                            claimResult.addClass("bg-success").text(response.message);
                        } else if (response.status === "info") {
                            claimResult.addClass("bg-warning").text(response.message);
                        } else {
                            claimResult.addClass("bg-danger").text(
                                "Something went wrong, please try again.");
                        }

                        claimButton.prop("disabled", false);
                    },
                    error: function() {
                        claimSpinner.addClass("d-none");
                        claimResult.removeClass("d-none").addClass("bg-danger").text(
                            "Server error! Try again later.");
                        claimButton.prop("disabled", false);
                    }
                });

            });

            load();
        });
    </script>
@endsection

@section('footer')
    @livewireScripts
@endsection
