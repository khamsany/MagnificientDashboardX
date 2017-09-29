class AbstractService {

    constructor() {
    }

    query(schema, variables) {
        return apollo.query({
            query: schema,
            variables: variables
        });
    }


}

export default AbstractService;