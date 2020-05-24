import requestReducer from "./requestReducer";
import {combineReducers} from "redux";
import profileReducer from "./profileReducer";
import itemReducer from "./itemReducer";


export default combineReducers({
	request: requestReducer,
	profile: profileReducer,
	item: itemReducer,
})