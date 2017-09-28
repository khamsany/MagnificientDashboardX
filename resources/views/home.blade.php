@extends('layouts.app')

@section('content')
    <div class="container">
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
        window.DashboardManager = new Vue({
            el: '#root',
            data: {
                viewer: {
                    original: {},
                    projects: []
                }
            },
            mounted() {
                axios.get('api/viewer').then(
                    response => {
                        console.log(response.data);
                        this.viewer.original = response.data;
                        this.initViewer(response.data);
                    }
                ).catch(
                    error => {
                        console.log(error);
                    }
                );

            },
            methods: {
                initViewer(data) {
                    _.each(data.repositories, function (item) {
                        console.log({call: item});
                        apollo.query({
                            query: gql`
                            query ($repo_name: String!) {
                                  viewer {
                                    repository(name: $repo_name) {
                                      id
                                      name
                                      projects(first: 100) {
                                        totalCount
                                        nodes {
                                            number
                                            name
                                            id
                                        }
                                      }
                                    }
                                  }
                                }
                                `,
                            variables: {
                                repo_name: item.name,
                            }
                        })
                            .then(data => {
                                let result = data.data;
                                console.log({result: result});
                                if (result.viewer.repository && result.viewer.repository.projects.totalCount > 0) {
                                    console.log({goloop: result.viewer.repository.name});
                                    _.each(result.viewer.repository.projects.nodes, function (project) { //2 loop 1: mag 2:Hand
                                        console.log({goloop: result.viewer.repository.name});
                                        _.each(DashboardManager.viewer.original.repositories, function (repo) {
                                            if (repo.name == result.viewer.repository.name) {
                                                console.log({oripo: repo.name, vipo: result.viewer.repository.name});
                                                let obj = {
                                                    id: project.id,
                                                    name: project.name,
                                                    number: project.number,
                                                    client_id: repo.owner.id,
                                                    client_name: repo.owner.name,
                                                    role: repo.owner.members[0].pivot.role
                                                };
                                                DashboardManager.viewer.projects.push(obj);
                                            }
                                        });
                                    })
                                }

                                console.log({projects: DashboardManager.viewer});
                            })
                            .catch(error => console.error(error));
                    })
                }
            }
        });
    </script>
@endsection
