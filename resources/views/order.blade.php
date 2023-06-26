@extends("layouts.app")
@section("content")
<section class="order-complete inner-page-sec-padding-bottom">
  <div class="container">
    <div class="row">
      {!! $output  !!}
    </div>
  </div>
</section>

@include("sections.footer")
@endsection