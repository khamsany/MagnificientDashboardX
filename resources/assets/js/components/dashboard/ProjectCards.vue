<template>
    <div>
        <p>Project Cards</p>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                columns: {},
                selectedColumn: null
            }
        },

        created() {
            DJ.$on('projectInit', (event) => {
                this.fetchAll(event[0])
            })
        },

        methods: {
            fetchAll(project) {
                projectService.findAllCards(project.repository_name, project.number)
                    .then(data => {
                        let cards = projectService.organizeCards(data.data.viewer.repository.project);
                        if (this.selectedColumn === null) {
                            let selectedColumn = this.selectedColumn;
                            _.each(cards, function (card) {
                                selectedColumn = card;
                                return;
                            });
                            this.selectedColumn = selectedColumn;
                        }
                        console.log({cards: cards, data: data, selectedColumn: this.selectedColumn});
                    })
                    .catch(error => console.log(error));
            }
        }
    }
</script>