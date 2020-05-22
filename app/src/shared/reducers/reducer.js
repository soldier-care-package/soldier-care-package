import requestReducer from "./requestReducer";
import {combineReducers} from "redux";


export default combineReducers({
	request: requestReducer
})