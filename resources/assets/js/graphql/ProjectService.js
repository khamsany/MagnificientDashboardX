import AbstractService from "./AbstractService";
import {Schema} from "./Schema";

class ProjectService extends AbstractService {
    constructor() {
        super();
        this.projects = [];
    }

    /**
     *
     * @param repositoryName
     * @param projectNumber
     * @returns {*}
     */
    findAllProjectColumns(repositoryName, projectNumber) {
        let schema = Schema.VIEWER_PROJECT_COLUMNS;
        let variables = {repo_name: repositoryName, project_number: projectNumber};
        return this.query(schema, variables);
    }

    /**
     *
     * @param repository
     * @returns {*}
     */
    findAllRepositoryProjects(repository) {
        let schema = Schema.VIEWER_PROJECTS;
        let variables = {repo_name: repository.name};
        return this.query(schema, variables);

    }

    /**
     *
     * @param repo
     * @param repositories
     * @returns {Array}
     */
    syncProjectsData(repo, repositories) {
        let projects = [];
        if (repo && repo.projects.totalCount > 0) {
            _.each(repo.projects.nodes, function (project) {

                let match = _.find(repositories, function (search) {
                    return search.name === repo.name;
                });
                if (match) {

                    projects.push({
                        id: project.id,
                        name: project.name,
                        repository_id: repo.id,
                        repository_name: repo.name,
                        number: project.number,
                        client_id: match.owner.id,
                        client_name: match.owner.name,
                        role: match.owner.members[0].pivot.role,
                        description: project.body
                    });

                }
            })
        }

        return projects;
    }
}

export default ProjectService;