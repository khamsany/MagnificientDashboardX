
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.VueApollo = require('vue-apollo');
window.Vue = require('vue');
window.gql = require('graphql-tag');

import {Schema} from './graphql/Schema';
import ProjectService from './graphql/ProjectService';

Vue.use(VueApollo);

window.DashboardManager = new Vue({
    el: '#root',
    data: {
        viewer: {
            original: {},
            projects: []
        },
        projectService: new ProjectService(),
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
        query(item) {
            console.log({'gql': Schema.VIEWER_PROJECTS});
            return apollo.query({
                query: Schema.VIEWER_PROJECTS,
                variables: {
                    repo_name: item.name,
                }
            });
        },
        initViewer(data) {
            let vm = DashboardManager;
            return vm.projectService.findAllProjects(data.repositories);
            _.each(data.repositories, function (item) {
                console.log({call: item});
                vm.query(item)
                    .then(data => {
                        let result = data.data;
                        console.log({result: result});
                        if (result.viewer.repository && result.viewer.repository.projects.totalCount > 0) {
                            console.log({goloop: result.viewer.repository.name});
                            _.each(result.viewer.repository.projects.nodes, function (project) { //2 loop 1: mag 2:Hand
                                console.log({goloop: result.viewer.repository.name});
                                _.each(vm.viewer.original.repositories, function (repo) {
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
                                        vm.viewer.projects.push(obj);
                                    }
                                });
                            })
                        }

                        console.log({projects: vm.viewer});
                    })
                    .catch(error => console.error(error));
            })
        }
    }
});
