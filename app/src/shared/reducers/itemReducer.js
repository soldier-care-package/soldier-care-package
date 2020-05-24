export default (state = [], action) => {
	switch(action.type) {
		case "GET_ITEMS_BY_ITEM_REQUEST_ID":
			return action.payload;
		case "GET_ITEM_BY_ITEM_ID":
			return action.payload;
		case "GET_ALL_ITEMS":
			return action.payload;
		default:
			return state;
	}
}