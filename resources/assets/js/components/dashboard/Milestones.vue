<template>

    <table class="table is-fullwidth">
            <thead>
            <tr>
                <th><abbr title="number">#</abbr></th>
                <th>Title & Description</th>
                <th><abbr title="Open / Closed / Completion">Progress</abbr></th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th><abbr title="number">#</abbr></th>
                <th>Title & Description</th>
                <th><abbr title="Open / Closed / Completion">Progress</abbr></th>
            </tr>
            </tfoot>
            <tbody>
            <tr v-for="milestone in collection">
                <th>{{ milestone.number }}</th>
                <td>
                    <p><a :href="milestone.url" :title="milestone.title">{{ milestone.title }}</a>
                    <p>
                    <p>
                        <small>{{ milestone.description }}</small>
                    </p>
                    <p :style="isAlreadyDue(milestone.dueOn) ? 'font-weight: bold; color: red' : 'font-weight:auto'">
                        <small>
                            <span class="icon"><i
                                    :class="isAlreadyDue(milestone.dueOn) ? 'fa fa-warning' : 'fa fa-calendar'"></i>
                            </span>Due {{ getDueDate(milestone.dueOn) }}
                        </small>
                    </p>
                </td>
                <td>
                    <div class="bd-snippet-preview" style="padding-bottom: 10px">
                        <progress class="progress is-small is-primary"
                                  :value="getProgressPercentage(milestone)"
                                  max="100">{{ getProgressPercentage(milestone) }}
                        </progress>
                    </div>
                    <div id="meta" class="field is-grouped is-grouped-multiline">
                        <div class="control">
                            <div class="tags has-addons">
                                <span class="tag">OPEN</span>
                                <span class="tag is-danger">{{ milestone.openIssues}}</span>
                            </div>
                        </div>
                        <div class="control">
                            <div class="tags  has-addons">
                                <span class="tag">CLOSED</span>
                                <span class="tag is-success">{{ milestone.closedIssues }}</span>
                            </div>
                        </div>
                        <div class="control">
                            <div class="tags"><span class="tag is-info">{{ getProgressPercentage(milestone) }} %</span>
                            </div>

                        </div>

                    </div>
                </td>
            </tr>
            </tbody>
        </table>
</template>
<script>
    export default {
        data() {
            return {
                collection: []
            }
        },

        created() {
            DJ.$on('projectInit', (event) => {
                this.fetchCollection(event[0])
            });

            DJ.$on('projectChanged', (event) => this.fetchCollection(event));
        },

        methods: {
            fetchCollection(data) {
                let project = data;
                milestoneService.findAll(project.repository_name)
                    .then(data => {
                        this.collection = data.data.viewer.repository.milestones.nodes;
                        this.fetchIssueCollection(project.repository_name);
                    })
                    .catch(error => console.log(error));
            },

            fetchIssueCollection(repoName) {
                issueService.findAll(repoName)
                    .then(data => {
                        let rootData = data.data.viewer.repository;
                        this.collection = milestoneService.syncIssues(this.collection, rootData.issues.nodes, rootData.pullRequests.nodes);
                    })
                    .catch(error => console.log(error));
            },

            getProgressPercentage(milestone) {
                if (!milestone.hasOwnProperty('closedIssues') || milestone.closedIssues < 1) return 0;
                let total = milestone.openIssues + milestone.closedIssues;
                return Math.round((milestone.closedIssues / total) * 100);
            },

            getDueDate(date) {
                return milestoneService.getFromNow(date);
            },

            isAlreadyDue(date) {
                let today = moment();
                let due = moment(date);
                return due < today;
            }
        }
    }
</script>