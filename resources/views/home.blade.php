@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="tile is-ancestor">
            <project-card-summary></project-card-summary>
        </div>
        <div class="tile is-ancestor">
            <div class="tile is-12 is-vertical">
                <div class="tabs is-parent">
                    <ul>
                        <li class="is-active"><a class="title">Milestones</a></li>
                    </ul>
                </div>
                <div class="is-parent">
                    <repository-milestones></repository-milestones>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('scripts')
    <script>
        var socket = io.connect('http://magdash.app:4567');
        socket.on('payload-update', function (event) {
            DashboardManager.processLiveUpdate(event);
        });
    </script>
@endsection
