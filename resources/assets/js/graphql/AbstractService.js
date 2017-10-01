class AbstractService {

    constructor() {
    }

    query(schema, variables) {
        if (variables === undefined) {
            variables = {};
        }

        return apollo.query({
            query: schema,
            variables: variables
        });
    }


}

export default AbstractService;