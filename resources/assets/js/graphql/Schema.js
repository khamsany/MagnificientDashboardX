import gql from 'graphql-tag';

export const Schema = {
    VIEWER_PROJECTS: gql`
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
                            body
                        }
                    }
                }
            }
        }`,

    VIEWER_PROJECT_COLUMNS: gql`
        query ($repo_name: String!, $project_number: Int!) {
            viewer {
                repository(name: $repo_name) {
                    id
                    project(number: $project_number) {
                        pendingCards(last:1) {
                            totalCount 
                        }
                        columns(first: 10) {
                            totalCount
                            nodes {
                                resourcePath
                                id
                                name
                                cards(first:1){
                                  totalCount
                                }
                            }
                        }
                    }
                }
            }
        }
        `
};
