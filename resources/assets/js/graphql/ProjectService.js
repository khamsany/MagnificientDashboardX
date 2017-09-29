import AbstractService from "./AbstractService";
import {Schema} from "./Schema";

class ProjectService extends AbstractService {

    /**
     *
     * @param {id, name} repositories
     * @returns {*}
     */
    findAllProjects(repositories) {
        let projects = [];
        _.each(repositories, function (repository) {
            let schema = Schema.VIEWER_PROJECTS;
            let variables = {repo_name: repository.name};
            this.query(schema, variables)
                .then(data => {
                    this.syncProjectsData(repository, data.data);
                })
                .catch(error => console.log(error));
        }, this);

        return projects;
    }

    syncProjectsData(data) {

    }
}

export default;