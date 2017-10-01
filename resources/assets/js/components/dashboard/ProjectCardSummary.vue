<template>
    <div class="tile">
        <div class="tile is-parent">
            <article class="tile is-child notification" v-if="pendingCards">
                <p class="title">Pending</p>
                <p class="subtitle" v-text="pendingCards.totalCount"></p>
            </article>
        </div>
        <div class="tile is-parent" v-for="column in columns">
            <article class="tile is-child notification">
                <p class="title">{{ column.name }}</p>
                <p class="subtitle"
                   v-text="column.name.toLowerCase() == 'done' ? `${donePercentage} %` : column.cards.totalCount"></p>
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

        ready() {
            console.log('hello');
        },

        created() {
            DJ.$on('projectInit', (event) => this.fetchProjectColumnsSummary(event[0]));
        },

        mounted() {
            console.log('hello');
        },

        methods: {
            fetchProjectColumnsSummary(data) {
                let project = data; //use the first project as default
                projectService.findAllProjectColumns(project.repository_name, project.number)
                    .then(data => {
                        this.columns = data.data.viewer.repository.project.columns.nodes;
                        this.pendingCards = data.data.viewer.repository.project.pendingCards;
                        this.computeCompletePercentage(this.columns);
                        console.log({columns: this.columns});
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