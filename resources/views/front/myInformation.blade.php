@extends('layouts.front.head')
@section('Content')
<section>
    <div class="container">
        <div class="row">
            @foreach ($information as $item)
            <div class="col-lg-4">
                <div class="podt-list">
                    <div class="psot-meta">

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
