@extends('layouts.master')

@section('title', 'Boost your profile')
@section('description', 'Boost your profile - Start promotion here')




@section('content')
    <x-navbar></x-navbar>
    <main class="bg-light">
        <div class="container mt-5">
            <div class="row">
                <h1 class="text-center">Boost Profile</h1>


                <x-instagram.logout :username="$user['username']" :logintype="$user['loginType']"></x-instagram.logout>

                <x-instagram.options :logintype="$user['loginType']" :earntype="$user['earnType']"></x-instagram.options>
                <x-instagram.credits :credits="$user['credits']"></x-instagram.credits>



                <div class="card mb-3 mainb">
                    <div class="card-body row">

                        <div class="container">
                            <form action="{{ route('autoliker.boost.submit') }}" method="post">
                                @csrf

                                <label for="service" class="form-label">Select Service:</label>
                                <select id="service" name="type" class="form-select">
                                    @foreach ($services as $service)
                                        <option value="{{ $service->name }}" data-cost="{{ $service->cost }}">
                                            {{ $service->s_name }}</option>
                                    @endforeach
                                </select>

                                <div id="inputs" class="mt-3">
                                    <label for="number" class="form-label">Number of Followers:</label>
                                    <input type="number" id="number" name="limit" class="form-control" min="10"
                                        value="10">
                                </div>

                                <div id="linkInput" class="mt-3 d-none">
                                    <label for="link" class="form-label">Enter Post Link:</label>
                                    <input type="text" id="link" name="link" class="form-control"
                                        value="{{ $user['username'] }}">
                                </div>

                                <p class="mt-3 fw-bold">Total Cost: <span id="totalCost">20</span> Credits</p>
                                <p class="text-danger" id="creditWarning" style="display: none;">Insufficient credits!</p>
                                <button id="submitBtn" class="btn btn-primary" disabled>Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        let userCredits = {{ $user['credits'] }}; // Example credit balance

        function updateForm() {
            let service = $('#service').val();
            let num = parseInt($('#number').val());
            let costPerUnit = $('#service').find(':selected').data('cost');
            let totalCost = num * costPerUnit;

            $('#totalCost').text(totalCost);
            $('#inputs label').text(service === 'followers' ? 'Number of Followers:' : 'Number of Likes:');
            $('#linkInput').toggleClass('d-none', service === 'followers');
            if (service === 'followers') {
                $('#link').val("{{ $user['username'] }}");
            } else {
                $('#link').val("");
            }

            $('#inputs').toggleClass('d-none', service !== 'followers' && service !== 'likes' && service !== 'reels_likes');
            $('#submitBtn').prop('disabled', totalCost > userCredits);
            $('#creditWarning').toggle(totalCost > userCredits);
        }

        $('#service, #number').on('input change', updateForm);
        $(document).ready(updateForm);
    </script>
@endsection
