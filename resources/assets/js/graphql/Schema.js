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
                        }
                    }
                }
            }
        }`,
};
