<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="robots" content="noindex, follow" />
        <title>410 Gone — Content Removed</title>
        {{-- Bootstrap CSS removed for Tailwind migration --}}
    </head>

    <body>
        <div class="d-flex align-items-center justify-content-center vh-100">
            <div class="text-center row">
                <div class=" col-md-6">
                    <img src="https://cdn.pixabay.com/photo/2017/03/09/12/31/error-2129569__340.jpg" alt=""
                        class="img-fluid">
                </div>
                <div class=" col-md-6 mt-5">
                    <p class="fs-3"> <span class="text-danger">Gone!</span> This page was removed.</p>
                    <p class="lead">
                        The content you're looking for has been permanently removed. Try our free tools instead.
                    </p>
                    <a href="{{ url('/') }}" class="btn btn-primary">Go Home</a>
                    <a href="{{ url('services') }}" class="btn btn-outline-primary">All Free Tools</a>
                </div>

            </div>
        </div>
    </body>

</html>
