@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="tile is-ancestor">
            <project-card-summary></project-card-summary>
        </div>
        <div class="tile is-ancestor">
            <div class="tile is-8 is-vertical">
                <div class="tabs is-parent">
                    <ul>
                        <li class="is-active"><a class="title">Milestones</a></li>
                    </ul>
                </div>
                <div class="is-parent">
                    <repository-milestones></repository-milestones>
                </div>
            </div>
            <div class="tile is-4 is-vertical" style="margin-left: 20px">
                <div class="tabs is-parent">
                    <ul>
                        <li class="is-active"><a class="title">Cards</a></li>
                    </ul>
                </div>
                <div class="is-parent">
                    <project-cards></project-cards>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('scripts')

@endsection
