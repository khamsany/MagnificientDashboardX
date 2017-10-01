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
        }`,

    VIEWER_REPO_MILESTONES: gql `
        query Milestones ($repo_name: String!)   {
            viewer {
                repository(name: $repo_name) {
                    id
                    milestones (first: 100) {
                        nodes {
                            repository {
                                id
                                name
                                url
                            }
        	                id
                            title
                            description
                            dueOn
                            url
                            number
                            state
                        }
                    }
                }
            }
        }`,

    VIEWER_REPO_ISSUES: gql `
        query Issue($repo_name: String!) {
            viewer {
                repository(name: $repo_name) {
                    id
                    issues(first: 100, orderBy: { field: UPDATED_AT, direction: ASC }) {
                        totalCount
                        nodes {
                            id
                            number
                            title
                            body
                            state
                            createdAt
                            updatedAt
                            url
                            closed
                            assignees(first: 5) {
                                nodes {
                                    id
                                    name
                                    url
                                    avatarUrl
                                }
                            }
                            milestone {
                                id
                                title
                                number
                            }
                        }
                    },
                    pullRequests(first: 100, orderBy: { field: UPDATED_AT, direction: ASC }) {
                        totalCount
                        nodes {
                            id
                            number
                            title
                            body
                            state
                            createdAt
                            updatedAt
                            url
                            closed
                            assignees(first: 5) {
                                nodes {
                                    id
                                    name
                                    url
                                    avatarUrl
                                }
                            }
                            milestone {
                                id
                                title
                                number
                            }
                        }
                    }
                }
            }
        }`
};
