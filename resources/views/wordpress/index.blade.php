
@extends('wordpress.master')
@section('title','TikTok Money Counter')
@section('description', 'Get Latest News about all your daily news. Earn online, Hire high profile loyers, Earn Crypto and much more.')

@section('content')
<header class="navigation">
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light px-0">
        <a class="navbar-brand order-1 py-0" href="{{url('tech')}}">
          <h1>TikTok Money Counter</h1>
        </a>
        <div class="navbar-actions order-3 ml-0 ml-md-4">
          <button aria-label="navbar toggler" class="navbar-toggler border-0" type="button" data-toggle="collapse"
            data-target="#navigation"> <span class="navbar-toggler-icon"></span>
          </button>
        </div>
      </nav>
    </div>
  </header>


  <main>
    <section class="section">
      <div class="container">
        <div class="row no-gutters-lg">
          <div class="col-12">
            <h2 class="section-title">Latest Articles</h2>
          </div>
          <div class="col-lg-8 mb-5 mb-lg-0">
            <div class="row">
                @foreach ($tech_posts as $post)
                <div class="col-12 mb-4">
                    <article class="card article-card">
                      <a href="article.html">
                        <div class="card-image">
                          <div class="post-info"> <span class="text-uppercase">{{ $post->created_at }}</span>
                          </div>
                        </div>
                      </a>
                      <div class="card-body px-0 pb-1">
                        <ul class="post-meta mb-2">
                          <li> <a href="#!">travel</a>
                            <a href="#!">news</a>
                          </li>
                        </ul>
                        <h2 class="h1"><a class="post-title" href="{{ url('tech/') }}/{{$post->slug}}">{{ $post->title }}</a></h2>
                        <p class="card-text">{{ $post->subtitle }}</p>
                        <div class="content"> <a class="read-more-btn" href="{{ url('tech') }}/{{$post->slug}}">Read Full Article</a>
                        </div>
                      </div>
                    </article>
                  </div>
                @endforeach
            </div>
          </div>
          <div class="col-lg-4">
    <div class="widget-blocks">
      <div class="row">
        <div class="col-lg-12 col-md-6">
          <div class="widget">
            <h2 class="section-title mb-3">Categories</h2>
            <div class="widget-body">
              <ul class="widget-list">
                <li><a href="#!">computer<span class="ml-auto">(3)</span></a>
                </li>
                <li><a href="#!">cruises<span class="ml-auto">(2)</span></a>
                </li>
                <li><a href="#!">destination<span class="ml-auto">(1)</span></a>
                </li>
                <li><a href="#!">internet<span class="ml-auto">(4)</span></a>
                </li>
                <li><a href="#!">lifestyle<span class="ml-auto">(2)</span></a>
                </li>
                <li><a href="#!">news<span class="ml-auto">(5)</span></a>
                </li>
                <li><a href="#!">telephone<span class="ml-auto">(1)</span></a>
                </li>
                <li><a href="#!">tips<span class="ml-auto">(1)</span></a>
                </li>
                <li><a href="#!">travel<span class="ml-auto">(3)</span></a>
                </li>
                <li><a href="#!">website<span class="ml-auto">(4)</span></a>
                </li>
                <li><a href="#!">hugo<span class="ml-auto">(2)</span></a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
        </div>
      </div>
    </section>
  </main>
  @stop
