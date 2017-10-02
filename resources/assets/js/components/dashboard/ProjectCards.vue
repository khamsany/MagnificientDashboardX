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
                selectedColumn: {}
            }
        },

        created() {
            DJ.$on('projectInit', (event) => {
                this.fetchAll(event[0])
            })
        },

        methods: {
            fetchAll(data) {
                projectService.findAllCards(data.repository_name, data.number)
                    .then(data => {
                        console.log({cards: data});
                    })
                    .catch(error => console.log(error));
            }
        }
    }
</script>