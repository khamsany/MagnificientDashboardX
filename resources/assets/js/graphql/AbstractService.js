import {getFragmentDefinitions} from "apollo-client";

class AbstractService {

    constructor() {
    }

    query(schema, variables, fragments) {
        let conf = {
            query: schema,
        };

        if (variables !== undefined) {
            conf['variables'] = variables;
        }

        if (fragments !== undefined) {

            //conf['fragments'] = fragments;
            // _.each(fragments, function(fragment) {
            //     createFragmentMap(fragments);
            // });
            //console.log({conf: conf});
        }

        // if(fragments !== undefined) {
        //     console.log({fragments: fragments});
        //     //_.each(fragments, function(fragment) {
        //         createFragmentMap(fragments);
        //     //});
        // }

        return apollo.query(conf, fragments);
    }

    getFromNow(date) {
        let mdate = moment(date);
        return mdate.tz('Asia/Kuala_Lumpur').fromNow();
    }

}

export default AbstractService;