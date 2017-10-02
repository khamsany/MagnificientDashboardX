<template>
    <div class="tile">
        <div class="tile is-parent">
            <article class="tile is-child notification has-text-centered" v-if="pendingCards">
                <p class="title">{{ pendingCards.totalCount }}</p>
                <p class="subtitle">
                    <small>Pendings</small>
                </p>
            </article>
        </div>
        <div class="tile is-parent" v-for="column in columns">
            <article class="tile is-child notification has-text-centered">
                <p class="title" v-if="column.name.toLowerCase() !== 'done'">{{column.cards.totalCount}}</p>
                <div style="padding-bottom: 12px" v-if="column.name.toLowerCase() === 'done'">
                    <progress max="100" class="progress is-large is-primary" :value="donePercentage">50</progress>
                </div>
                <p class="subtitle" style="font-weight: 100">
                    <small>{{column.name.toLowerCase() == 'done' ? `${donePercentage} % Done` : column.name}}</small>
                </p>
            </article>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                columns: null,
                pendingCards: null,
                donePercentage: 0
            };
        },

        created() {
            DJ.$on('projectInit', (event) => {
                this.fetchProjectColumnsSummary(event[0]);
            });
            DJ.$on('projectChanged', (event) => this.fetchProjectColumnsSummary(event));
        },

        methods: {
            fetchProjectColumnsSummary(data) {
                console.log({eventProjectChanged: data});
                let project = data; //use the first project as default
                projectService.findAllProjectColumns(project.repository_name, project.number)
                    .then(data => {
                        this.columns = data.data.viewer.repository.project.columns.nodes;
                        this.pendingCards = data.data.viewer.repository.project.pendingCards;
                        this.computeCompletePercentage(this.columns);
                    })
                    .catch(error => console.log(error));
            },
            computeCompletePercentage(columns) {
                let total = 0;
                let done = 0;
                _.each(columns, function (column) {
                    total += column.cards.totalCount;
                    if (column.name.toLowerCase() === 'done') {
                        done = column.cards.totalCount;
                    }
                });

                this.donePercentage = Math.round(done / total * 100);
            }
        }
    }
</script>
<style>
    .tile.is-child {
        margin-right: 5px;
    }
</style>