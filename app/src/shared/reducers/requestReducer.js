export default (state = [], action) => {
	switch(action.type) {
		case "GET_REQUEST_BY_REQUEST_ID":
			return action.payload;
		case "GET_REQUEST_BY_PROFILE_ID":
			return [...state, action.payload];
		case "GET_ALL_REQUESTS":
			return action.payload;
		default:
			return state;
	}
}