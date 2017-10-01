
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.VueApollo = require('vue-apollo');
window.Vue = require('vue');
window.gql = require('graphql-tag');

import ProjectService from './graphql/ProjectService';

window.projectService = new ProjectService();
window.DJ = new Vue();

Vue.component('project-card-summary', require('./components/dashboard/ProjectCardSummary.vue'));

window.DashboardManager = new Vue({
    el: '#root',
    data: {
        viewer: {
            original: {},
            projects: []
        },
        project: null
    },
    created() {
        DJ.$on('projectInit', () => {
            this.project = this.viewer.projects[0];
        });
    },
    mounted() {
        axios.get('api/viewer').then(
            response => {
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
            let vm = DashboardManager;
            let event = DJ;
            _.each(data.repositories, function (repository) {
                projectService.findAllRepositoryProjects(repository)
                    .then(data => {
                        let repo = data.data.viewer.repository;
                        if (!repo) return;
                        let projects = projectService.syncProjectsData(repo, vm.viewer.original.repositories);
                        console.log({projects: projects});
                        _.each(projects, function (project) {
                            vm.viewer.projects.push(project);
                        });
                        event.$emit('projectInit', vm.viewer.projects);
                    })
                    .catch(error => console.log(error));
            });

        }
    }
});
