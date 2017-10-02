require('./bootstrap');
window.VueApollo = require('vue-apollo');
window.Vue = require('vue');
window.gql = require('graphql-tag');
window.moment = require('moment-timezone');

import ProjectService from './graphql/ProjectService';
import MilestoneService from './graphql/MilestoneService';
import IssueService from './graphql/IssueService';

window.projectService = new ProjectService();
window.milestoneService = new MilestoneService();
window.issueService = new IssueService();

window.DJ = new Vue();

Vue.component('project-card-summary', require('./components/dashboard/ProjectCardSummary.vue'));
Vue.component('repository-milestones', require('./components/dashboard/Milestones.vue'));

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

        },

        changeProject(id) {
            let match = _.find(this.viewer.projects, function (project) {
                return project.id === id;
            });
            this.project = match;
            DJ.$emit('projectChanged', match);
        },

        //receive update from Git webhook vie socket.io
        processLiveUpdate(event) {
            console.log({liveUpdate: event});
            if (event.hasOwnProperty('repository')) {
                console.log({ename: event.repository.name, pname: this.project.repository_name})
            }
            if (event.hasOwnProperty('repository') && this.project.repository_name === event.repository.name) {
                this.changeProject(this.project.id);
            }
        }
    }
});
