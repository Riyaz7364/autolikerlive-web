@extends('web-app.master')
@section('title', 'FBSUB - Dashboard')
@section('description', '')
@section('javascripts')

@stop
@section('content')

    <style type="text/css">
        .font-weight-bold {
            font-weight: 700;
        }

        .container p,
        h5 {
            color: black;
        }

        .nopad {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        /*image gallery*/
        .image-checkbox {
            cursor: pointer;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            border: 4px solid transparent;
            margin-bottom: 0;
            outline: 0;
        }

        .image-checkbox input[type="checkbox"] {
            display: none;
        }

        .image-checkbox-checked {
            border-color: #4783B0;
            border-radius: 50%;
        }

        .image-checkbox .fa {
            position: absolute;
            color: #4A79A3;
            background-color: #fff;
            padding: 10px;
            top: 0;
            right: 0;
        }

        .image-checkbox-checked .fa {
            display: block !important;
        }

        .emoji-size {
            width: 3rem;
            height: 3rem;
        }

        .emoji-row {
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 0;
            display: flex;
            flex-wrap: wrap;
            margin-top: calc(-1 * var(--bs-gutter-y));
            margin-right: calc(-.5 * var(--bs-gutter-x));
            margin-left: calc(-.5 * var(--bs-gutter-x));

        }

        .spinner-10x {
            width: 10rem;
            height: 10rem;
        }
    </style>

    @php
        $reactions = [
            'like' => 1,
            // 'love' => 2,
            // 'care' => 16,
            // 'haha' => 4,
            // 'wow' => 3,
            // 'sad' => 7,
            // 'engry' => 8,
        ];
    @endphp

    <main class="flex-shrink-0">
        <!-- Navigation-->
        <x-WebAppNavbar like="{{ $user->credits->FB }}" follow="{{ $user->credits->IG }}"></x-WebAppNavbar>
        <!-- Header-->
        <header class="bg-light py-5">
            <div class="container px-5">
                <div class="row">
                    <div class="col"></div>
                    <div class="col-sm-12 col-md-10 col-lg-10">
                        <div class="card" id="menu-card">
                            <div class="card-header text-center h5 text-dark font-weight-bold">
                                {{ $user->name }}
                            </div>
                            <div class="card-body text-center">
                                <h5 class="card-title">You have <span class="credits">{{ $user->credits->FB }}
                                        <x-like-icon :size="32" /></span></h5>
                                <button class="btn btn-primary m-2" id="earnButton"><x-like-icon :size="25" /> Earn
                                    Credits</button>
                                <button type="button" class="btn btn-danger  m-2 text-white" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal"><i class="bi bi-plus-circle-fill"></i> Add New
                                    Link</button>
                                <a href="https://www.cheapsmmlive.com/" target="_blank" class="btn btn-warning m-2">Buy
                                    Premium Services</a>

                            </div>
                        </div>
                        <!-- Start Earn Modal -->
                        <div class="modal-dialog d-none" id="earnModal">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="earnModalLabel"><i class="bi bi-database-fill"></i> Earn
                                        Credits</h5>
                                    <button class="btn-close" id="closeBTN"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <h5 class="card-title">You have <span class="credits">{{ $user->credits->FB }}</span>
                                        <i class="bi bi-database-fill"></i>
                                    </h5>
                                    <div class="text-center d-none" id="spinner">
                                        <div class="spinner-border m-5 spinner-10x" role="status">
                                            <span class="sr-only "></span>
                                        </div>
                                    </div>
                                    <button class="btn btn-danger btn-lg" id="startEarn">Start</button>
                                    <button class="btn btn-danger btn-lg d-none" id="stopEarn">Stop</button>
                                </div>
                                <div class="modal-footer">

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col"></div>
                </div>
            </div>
        </header>
        <section class="bg-light mb-5">
            <div class="container">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            {{-- <th scope="col">Start Count</th> --}}
                            <th scope="col">Remains</th>
                            <th scope="col">Limit</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts['links'] as $post)
                            <tr>
                                <th scope="row">
                                    {{ json_decode('"' . $post['name'] . '"') }}
                                    <br />
                                    <div class="row">
                                        @if ($post['type'] == 'like')
                                            <br />
                                            <div class="emoji-row">
                                                @foreach (explode(',', $post['reactions']) as $key)
                                                    <div class="col">
                                                        <label class="image-checkbox">
                                                            <img class="img-responsive" style="width: 25px"
                                                                src="{{ url('reaction/' . array_search($key, $reactions) . '.png') }}">
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                        @if ($post['type'] == 'story_like')
                                            @foreach (explode(',', $post['reactions']) as $key)
                                                <div class="col-1">
                                                    <label class="image-checkbox">
                                                        <span class="img-responsive"
                                                            style="width: 25px">{{ $key }}</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </th>
                                {{-- <td>{{ $post['start_count'] == 0 ? 'Not found!' : $post['start_count'] }}</td> --}}
                                <td>{{ $post['limit'] - $post['count'] }}</td>
                                <td>{{ $post['limit'] }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">

                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><button class="dropdown-item"
                                                    href="https://www.autolikerlive.com/sms-bomber" data-bs-toggle="modal"
                                                    data-bs-target="#EditlinkModel"
                                                    onclick="editJob('{{ json_encode($post) }}')">Edit Limit</button></li>
                                            <li><button onclick="deleteJob('{{ $post['id'] }}')"
                                                    class="dropdown-item text-danger font-weight-bold"
                                                    href="https://www.autolikerlive.com/download"
                                                    data-toggle="dropdown">Delete</button>
                                            </li>
                                        </ul>
                                    </div>

                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </section>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type="text/javascript"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


        <!-- Edit Link Modal -->
        <div class="modal fade" id="EditlinkModel" tabindex="-1" aria-labelledby="EditlinkModelLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="EditlinkModelLabel"><i class="bi bi-pencil-square"></i> Edit Job!
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="lid" value="">
                        <input type="hidden" id="link" value="">
                        <p id="name" class="text-dark"></p>
                        <label>how much credit should be used?</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white" id="inputGroup-sizing-lg"> LIMIT: </span>
                            </div>
                            <input type="number" class="form-control" id="limit">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="editSave" class="btn btn-primary">
                            <span id="edit-spninner" class="spinner-border spinner-border-sm d-none" role="status"
                                aria-hidden="true"></span>
                            Edit
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <!--Add Link Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><i class="bi bi-plus-circle-fill"></i> Add new
                            Link!</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="job-url" class="form-control mb-3" placeholder="Enter URL">
                        <label>how much credit should be used?</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text bg-white" id="inputGroup-sizing-lg"> LIMIT: </span>
                            </div>
                            <input type="number" class="form-control" id="job-limit" value="{{ $user->credits->FB }}">
                        </div>
                        <select class="form-select" id="job-type" aria-label="">

                            <option value="like" selected>Status & Photo Likes</option>
                            <option value="like_profile" selected>Profile Pic (DP)</option>
                            {{-- <option value="story_like" selected>Story Reactions</option> --}}

                        </select>
                        {{-- <div class="emoji-row">
                            @foreach ($reactions as $key => $value)
                                <div class="col">
                                    <label class="image-checkbox">
                                        <img class="img-responsive emoji-size"
                                            src="{{ url('reaction/' . $key . '.png') }}">
                                        <input name="reactions[]" value="{{ $value }}" type="checkbox">
                                        <i class="fa fa-check hidden"></i>
                                    </label>
                                </div>
                            @endforeach
                        </div> --}}
                        <div class="py-3">
                            <p class="text-dark">
                                <span class="text-danger"><b>Note:</b></span> Short Links not Allows :- <br>
                                Examples = "<span class="text-danger">www.fb.me/xxxx</span>" and "<span
                                    class="text-danger">wwww.fb.watch/xxxx</span>"
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" id="add-job" class="btn btn-primary">
                            Add
                            <span id="add-spninner" class="spinner-border spinner-border-sm d-none" role="status"
                                aria-hidden="true"></span>

                        </button>
                    </div>
                </div>
            </div>
        </div>


        @include('web-app.bottom_navbar')
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js" type="text/javascript"></script>


        <script type="text/javascript">
            $(document).ready(function() {
                $('#add-job').click(function() {
                    var url = $('#job-url').val();
                    var limit = $('#job-limit').val();
                    var type = $('#job-type').val();
                    var profilePic = false;
                    if (type = "like_profile") {
                        profilePic = true;
                        type = "like";
                    }
                    var button = $(this);
                    var selectedReactions = $('input[name="reactions[]"]:checked').map(function() {
                        return $(this).val();
                    }).get();
                    var reactions = 1;
                    if (selectedReactions.length > 0) {
                        reactions = selectedReactions.join(',');
                    }
                    button.prop('disabled', true);
                    $('#add-spninner').removeClass('d-none');
                    $.ajax({
                        type: 'POST',
                        url: '{{ secure_url(route('addjob', [], false)) }}',
                        data: {
                            _token: '{{ csrf_token() }}',
                            url: url,
                            limit: limit,
                            type: type,
                            profilePic: profilePic,
                            reactions: reactions,
                        },
                        success: function(response) {
                            button.prop('disabled', false);
                            $('#add-spninner').addClass('d-none');
                            if (response.success) {
                                location.reload(true);
                            } else {
                                alert(response.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                });




                // Handle the Save Changes button click event
                $('#editSave').on('click', function() {
                    var modal = $('#EditlinkModel');
                    var lid = modal.find('#lid').val();
                    var link = modal.find('#link').val();
                    var newLimit = modal.find('#limit').val();
                    $.ajax({
                        type: 'POST',
                        url: '{{ secure_url(route('editjob', [], false)) }}',
                        data: {
                            _token: '{{ csrf_token() }}',
                            lid: lid,
                            link: link,
                            limit: newLimit,
                        },
                        success: function(response) {
                            $(this).prop('disabled', false);
                            modal.find('#add-spninner').addClass('d-none');
                            location.reload(true);
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                        }
                    });
                });


                var intervalId;
                $('#startEarn').on('click', function() {
                    var spinner = $('#spinner');
                    var startBTN = $(this);
                    var stopBTN = $('#stopEarn');
                    spinner.removeClass('d-none');
                    stopBTN.removeClass('d-none');
                    startBTN.addClass('d-none');
                    intervalId = setInterval(function() {
                        $.ajax({
                            type: 'POST',
                            url: '{{ secure_url(route('earnCredit', [], false)) }}',
                            data: {
                                _token: '{{ csrf_token() }}',
                            },
                            success: function(response) {
                                if (response.success) {
                                    var spans = document.getElementsByClassName("credits");
                                    for (var i = 0; i < spans.length; i++) {
                                        spans[i].textContent = response
                                            .c; // Replace "New Value" with the value you want
                                    }
                                }
                                console.log(response);
                            },
                            error: function(xhr, status, error) {
                                console.log(xhr.responseText);
                            }
                        });
                    }, 10000);

                });

                $('#stopEarn').on('click', function() {
                    // Clear the interval to stop making the AJAX call
                    clearInterval(intervalId);


                    var spinner = $('#spinner');
                    var startbutton = $('#startEarn');
                    var stopbutton = $(this);

                    spinner.addClass('d-none');
                    stopbutton.addClass('d-none');
                    startbutton.removeClass('d-none');
                });


                $('#earnButton').on('click', function() {
                    btn = $('#menu-card');
                    modal = $('#earnModal');

                    btn.addClass('d-none');
                    modal.removeClass('d-none');
                });
                $('#closeBTN').on('click', function() {
                    btn = $('#menu-card');
                    modal = $('#earnModal');
                    btn.removeClass('d-none');
                    modal.addClass('d-none');
                });
            });

            $(".image-checkbox").each(function() {
                if ($(this).find('input[type="checkbox"]').first().attr("checked")) {
                    $(this).addClass('image-checkbox-checked');
                } else {
                    $(this).removeClass('image-checkbox-checked');
                }
            });

            // sync the state to the input
            $(".image-checkbox").on("click", function(e) {
                $(this).toggleClass('image-checkbox-checked');
                var $checkbox = $(this).find('input[type="checkbox"]');
                $checkbox.prop("checked", !$checkbox.prop("checked"))

                e.preventDefault();
            });

            $('#job-type').on('change', function() {

                var type = this.value;
                if (type == 'like' || type == 'story_like') {
                    $('.emoji-row').removeClass('d-none');
                } else {
                    $('.emoji-row').addClass('d-none');
                }
            });

            function editJob(post, id) {
                post = JSON.parse(post);
                var modal = $('#EditlinkModel');
                modal.find('#name').text(post.name + '__' + post.type);
                modal.find('#limit').val(post.limit);
                modal.find('#lid').val(post.id);
                modal.find('#link').val(post.link);
                // modal.find('.modal-body').text('Value from button: ' + myValue);
            };

            function deleteJob(lid) {
                $.ajax({
                    type: 'POST',
                    url: '{{ secure_url(route('deletejob', [], false)) }}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        lid: lid,
                    },
                    success: function(response) {
                        location.reload(true);
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                    }
                });
            };
        </script>

    @stop
