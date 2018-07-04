@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Currency Converter</div>

                    <div class="panel-body">
                        <currency-component></currency-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


<script>
    let API_URL = "{{env('API_URL')}}"
</script>
