class AbstractService {

    constructor() {
    }

    query(schema, variables) {
        if (variables === undefined) {
            variables = {};
        }

        return apollo.query({
            query: schema,
            variables: variables,
            fetchPolicy: 'network-only',
        });
    }

    getFromNow(date) {
        let mdate = moment(date);
        return mdate.tz('Asia/Kuala_Lumpur').fromNow();
    }

}

export default AbstractService;