@extends('layouts.master')

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        {{-- <?php
                        if ($userId == 1) { ?>
                            <h5 class="card-title">Dono</h5>
                        <?php
                        } elseif ($userId == 2) { ?>
                            <h5 class="card-title">Rido</h5>
                        <?php
                        } else { ?>
                            <h5 class="card-title">Nama Tidak terdaftar</h5>
                        <?php
                        }
                        ?> --}}

                        @if ($userId == 1)
                            <h5 class="card-title">Dono</h5>
                        @elseif ($userId == 2)
                            <h5 class="card-title">Rido</h5>
                        @else
                            <h5 class="card-title">Nama Tidak terdaftar</h5>
                        @endif
                        
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection