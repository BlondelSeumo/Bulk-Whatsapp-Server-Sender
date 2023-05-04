@extends('frontend.layouts.main')
@section('content')
@include('frontend.layouts.header-2')
<main>
      <!-- breadcrumb area start -->
      <div class="breadcrumb__area breadcrumb-height p-relative grey-bg"
         data-background="{{ asset('assets/frontend/img/breadcrumb/breadcrumb.jpg') }}">
         <div class="breadcrumb__scroll-bottom smooth">
            <a href="#blog">
               <i class="far fa-arrow-down"></i>
            </a>
         </div>
         <div class="container">
            <div class="row">
               <div class="col-xxl-12">
                  <div class="breadcrumb__content text-center">
                     <h3 class="breadcrumb__title">{{ __('Recent Blogs') }}</h3>
                     <div class="breadcrumb__list">
                        <span><a href="{{ url('/') }}">{{ __('Home') }}</a></span>
                        <span class="dvdr"><i class="fa fa-angle-right"></i></span>
                        <span>{{ __('Blog') }}</span>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- breadcrumb area end -->

      <!-- postbox area start -->
      <div class="postbox__area pt-120 pb-120">
         <div class="container">
            <div class="row">
               <div class="col-xxl-8 col-xl-8 col-lg-8">
                  <div id="blog" class="postbox__wrapper pr-20">
                     @foreach($blogs ?? [] as $blog)
                     <article class="postbox__item format-image mb-50 transition-3">
                        <div class="postbox__thumb w-img">
                           <a href="{{ url('/blog',$blog->slug) }}">
                              <img src="{{ asset($blog->preview->value ?? '') }}" alt="">
                           </a>
                        </div>
                        <div class="postbox__content">
                           <div class="postbox__meta">
                              <span><a href="{{ url('/blogs') }}"><i class="fal fa-user-circle"></i> {{ __('Admin') }} </a></span>
                              <span><a href="{{ url('/blogs?date='.$blog->created_at->format('d-m-Y')) }}"><i class="fal fa-clock"></i> {{ $blog->created_at->format('F d,Y') }}</a></span>
                              
                           </div>
                           <h3 class="postbox__title">
                              <a href="{{ url('blog',$blog->slug) }}">{{ $blog->title }}</a>
                           </h3>
                           <div class="postbox__text">
                              <p>{{ Str::limit($blog->shortDescription->value ?? '',200) }}</p>
                           </div>
                           <div class="post__button">
                              <a class="tp-btn-blue-square" href="{{ url('blog',$blog->slug) }}"><span>{{ __('READ MORE') }}</span></a>
                           </div>
                        </div>
                     </article>
                     @endforeach
                     @if(count($blogs) == 0)
                     <div class="alert alert-warning" role="alert">
                      {{ __('Opps there is no blog post available') }}
                     </div>
                     @endif
                     <div class="basic-pagination">
                       {{ $blogs->appends($request->all())->links('vendor.pagination.bootstrap-5') }}
                     </div>
                  </div>
               </div>
               <div class="col-xxl-4 col-xl-4 col-lg-4">
                  <div class="sidebar__wrapper">
                     <div class="sidebar__widget mb-40">
                        <h3 class="sidebar__widget-title">{{ __('Search Here') }}</h3>
                        <div class="sidebar__widget-content">
                           <div class="sidebar__search">
                              <form>
                                 <div class="sidebar__search-input-2">
                                    <input type="text" name="search" value="{{ $request->search ?? '' }}" placeholder="{{ __('Search your keyword...') }}">
                                    <button type="submit"><i class="far fa-search"></i></button>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                     @if(count($recent_blogs) > 0)
                     <div class="sidebar__widget mb-40">
                        <h3 class="sidebar__widget-title">{{ __('Recent Posts') }}</h3>
                        <div class="sidebar__widget-content">
                           <div class="sidebar__post rc__post">
                              @foreach($recent_blogs as $recent_blog)
                              <div class="rc__post mb-20 d-flex">
                                 <div class="rc__post-thumb mr-20">
                                    <a href="{{ url('/blog',$recent_blog->slug) }}">
                                       <img src="{{ asset($recent_blog->preview->value ?? '') }}" alt="">
                                    </a>
                                 </div>
                                 <div class="rc__post-content">
                                    <div class="rc__meta">
                                       <span>{{ $recent_blog->created_at->format('d F, Y') }}</span>
                                    </div>
                                    <h3 class="rc__post-title">
                                       <a href="{{ url('/blog',$recent_blog->slug) }}">{{ Str::limit($recent_blog->title,35) }}</a>
                                    </h3>
                                 </div>
                              </div>
                              @endforeach
                           </div>
                        </div>
                     </div>
                     @endif
                     @if(count($categories) > 0)
                     <div class="sidebar__widget mb-40">
                        <h3 class="sidebar__widget-title">{{ __('Categories') }}</h3>
                        <div class="sidebar__widget-content">
                           <ul>
                              @foreach($categories as $category)
                              <li><a href="{{ url('category/'.$category->slug.'/'.$category->id) }}">{{ $category->title }}<span><i class="fal fa-angle-right"></i></span></a></li>
                              @endforeach
                             
                           </ul>
                        </div>
                     </div>
                     @endif
                     @if(count($tags) > 0)
                     <div class="sidebar__widget mb-40">
                        <h3 class="sidebar__widget-title">{{ __('Tags') }}</h3>
                        <div class="sidebar__widget-content">
                           <div class="tagcloud">
                              @foreach($tags as $tag)
                              <a href="{{ url('tag/'.$tag->slug.'/'.$tag->id) }}">{{ $tag->title }}</a>
                              @endforeach
                           </div>
                        </div>
                     </div>
                     @endif
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- postbox area end -->
   </main>
@endsection