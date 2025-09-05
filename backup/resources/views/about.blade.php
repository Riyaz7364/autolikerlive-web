@extends('layouts.master')

@section('title', 'About us')
@section('description', 'Know more about Autoliker live app for android without token for live fb auto followers.')

@section('content')


        <main class="flex-shrink-0">
            <!-- Navigation-->
            <x-navbar></x-navbar>
            <!-- Header-->
            <header class="py-5">
                <div class="container px-5">
                    <div class="row justify-content-center">
                        <div class="col-lg-8 col-xxl-6">
                            <div class="text-center my-5">
                                <h1 class="fw-bolder mb-3">Our mission is to make Apps for everyone.</h1>
                                <p class="lead fw-normal text-muted mb-4">This is theRiyazSaifi director of tRS Apps. Hey welcome to the Autoliker Live app the perfect app to gain more Facebook followers in easy way. This Fb autoliker app is free of cost.  The wait is now finally over now. We finally  launched this amazing Autoliker app to you.</p>
                                <p class="lead fw-normal text-muted mb-4">The auto liker is one of the most well-liked and most famous app to use by thousands of people around the world. It is use by the old and the young alike. In the Facebook, the people make friends and promote his/her brand. The people directory promote brand on social media to get more buys or fans on the page. To famous themselves on Facebook. The best place for this is Autoliker Live APP.</p>

                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- About section two-->
            <section class="py-5">
                <div class="container px-5 my-5">
                    <div class="row gx-5 align-items-center">
                        <h3>How to use Autoliker Live</h3>
                    <table class="table table-dark">
                      <thead>
                        <tr>


                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">First</th>
                          <td>Download and install the latest version of the Autoliker Live APP from here. Download</td>

                        </tr>
                        <tr>
                          <th scope="row">Step 1</th>
                          <td>After app install you need to Login with your Google account to access the dashboard.</td>

                        <tr>
                          <th scope="row">Step 2</th>
                          <td>To start the app you need to add your Facebook account in the app. You can see the Login with Facebook button on the dashboard. Click the button then a popup screen comes slide it to the end then enter Facebook credentials to login.</td>

                        </tr>
                        <tr>
                          <th scope="row">Step 3</th>
                          <td>Finally you can now Start the bot click on the big red start button to start the bot. For the first time app will ask for some permissions. You need to allow all permission to start the app.</td>

                        </tr>
                        <tr>
                          <th scope="row">Add Profile</th>
                          <td>You have to add your or any Facebook profile to get followers on that profile it could be any profile. You need to enter the FB account username or numeric id to search the profile and add it into app.</td>

                        </tr>
                      </tbody>
                    </table>
                    </div>
                </div>
            </section>
            <!-- Team members section-->
            <section class="py-5 bg-dark">
                <div class="container px-5 my-5">
                    <div class="text-center">
                        <h2 class="fw-bolder">Our team</h2>
                        <p class="lead fw-normal text-muted mb-5">Dedicated to quality and your success</p>
                    </div>
                    <div class="row gx-5 row-cols-1 row-cols-sm-2 row-cols-xl-4 justify-content-center">
                        <div class="col mb-5 mb-5 mb-xl-0">
                            <div class="text-center">
                                <img class="img-fluid rounded-circle mb-4 px-4" src="{{ asset('images/admin.webp') }}" alt="..." />
                                <h5 class="fw-bolder">theRiyazSaifi</h5>
                                <div class="fst-italic text-muted">Developer &amp; Admin</div>
                            </div>
                        </div>
                        <div class="col mb-5 mb-5 mb-xl-0">
                            <div class="text-center">
                                <img class="img-fluid rounded-circle mb-4 px-4" src="{{ asset('images/trsApps.webp') }}" alt="..." />
                                <h5 class="fw-bolder">Company</h5>
                                <div class="fst-italic text-muted">tRS Apps</div>
                            </div>
                        </div>


                    </div>
                </div>
            </section>
        </main>
@stop
