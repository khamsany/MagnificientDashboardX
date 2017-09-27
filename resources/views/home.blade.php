@extends('layouts.app')

@section('content')
    <div class="container" id="root">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        You are logged in!
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var app = new Vue({
            el: '#root',
            apolloProvider,
            apollo: {
                viewer: {
                    manual: true,
                    query: gql`query { viewer { repositories(first: 100) {nodes{id, name}} }}`,
                    result(data) {
                        console.log(data);
                    }
                },
            },
            data: {
                viewer: ''
            },
            mounted() {
                console.log(this.viewer);
                console.log(axios.defaults.headers.common);
                axios.get('api/viewer').then(
                    response => {
                        console.log(response.data);
                    }
                ).catch(
                    error => {
                        console.log(error);
                    }
                );
                //console.log(this.$apollo.queries.viewer);
            }
        });
    </script>
@endsection
