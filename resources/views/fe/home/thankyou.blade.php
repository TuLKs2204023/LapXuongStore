@extends('fe.layout.layout')

@section('myCss')
    <style>
        .section-big-py-space {
            padding-top: 50px;
            padding-bottom: 50px;
        }

        .success-text {
            text-align: center;
        }

        .success-text i {
            font-size: 80px;
            color: var(--violet);
        }

        .success-text h2 {
            text-transform: uppercase;
            font-size: calc(20px + (36 - 20) * ((100vw - 320px) / (1920 - 320)));
            color: $font-color;
            font-weight: 700;
            padding: 1rem 0;
        }

        .success-text p {
            text-transform: capitalize;
            font-size: calc(14px + (18 - 14) * ((100vw - 320px) / (1920 - 320)));
        }

        .success-text.order-fail i {
            color: var(--danger);
        }
    </style>
@endsection

@section('content')
    <!-- thank-you section start -->
    <section class="section-big-py-space light-layout">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="success-text"><i class="fa fa-check-circle" aria-hidden="true"></i>
                        <h2>Thank you</h2>
                        <p>Your order is successfully processsed and is on the way</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section ends -->
@endsection
