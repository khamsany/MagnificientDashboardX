import AbstractService from "./AbstractService";
import {Schema} from "./Schema";

class IssueService extends AbstractService {
    findAll(repoName) {
        let schema = Schema.VIEWER_REPO_ISSUES;
        let varibles = {repo_name: repoName};
        return this.query(schema, varibles);
    }
}

export default IssueService;