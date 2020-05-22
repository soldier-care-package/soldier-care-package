import requestReducer from "./requestReducer";
import {combineReducers} from "redux";
import profileReducer from "./profileReducer";


export default combineReducers({
	request: requestReducer,
	profile: profileReducer,
})