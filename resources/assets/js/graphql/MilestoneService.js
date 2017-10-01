import AbstractService from "./AbstractService";
import {Schema} from "./Schema";

class MilestoneService extends AbstractService {

    findAll(repoName) {
        let schema = Schema.VIEWER_REPO_MILESTONES;
        let variables = {repo_name: repoName};
        return this.query(schema, variables);
    }

    mergeIssuesAndPullRequest(issues, pullRequests) {
        let merged = [];
        if (issues.length > 0) {
            _.each(issues, function (issue) {
                issue = Object.assign({}, issue);
                issue['type'] = 'issue';
                merged.push(issue);
            });
        }

        if (pullRequests.length > 0) {
            _.each(pullRequests, function (pullRequest) {
                pullRequest = Object.assign({}, pullRequest);
                pullRequest['type'] = 'pullRequest';
                merged.push(pullRequest);
            })
        }

        //sort base on update date
        return _.sortBy(merged, [function (o) {
            return o.updatedAt
        }]);

    }

    syncIssues(milestones, issues, pullRequests) {
        issues = this.mergeIssuesAndPullRequest(issues, pullRequests);

        let _milestones = [];
        _.each(milestones, function (milestone) {
            let matches = [];
            matches = _.filter(issues, function (issue) {
                return issue.milestone.id === milestone.id
            });


            milestone = Object.assign({}, milestone);
            if (!milestone.hasOwnProperty('issues')) {
                milestone['issues'] = [];
                milestone['openIssues'] = 0;
                milestone['closedIssues'] = 0;
                milestone['updatedAt'] = '';
            }

            if (matches.length > 0) {

                let last = matches[matches.length - 1];
                milestone.updatedAt = last.updatedAt;

                let totalClosed = _.filter(matches, function (issue) {
                    return issue.closed === true;
                });

                if (totalClosed) {
                    milestone.closedIssues = totalClosed.length;
                    milestone.openIssues = matches.length - totalClosed.length;
                }

                milestone.issues = matches;
            }
            _milestones.push(milestone);
        });

        return _milestones;
    }
}

export default MilestoneService;