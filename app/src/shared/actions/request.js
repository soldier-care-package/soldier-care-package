
import {httpConfig} from "../utils/http-config";

export const getRequestByRequestId = () => async (dispatch) => {
	const payload =  await httpConfig.get("/apis/request/");
	dispatch({type: "GET_REQUEST_BY_REQUEST_ID", payload : payload.data });
};

export const getRequestByProfileId = () => async (dispatch) => {
	const payload =  await httpConfig.get("/apis/request/");
	dispatch({type: "GET_REQUEST_BY_PROFILE_ID", payload : payload.data });
};

export const getAllRequests = () => async (dispatch) => {
	const payload = await httpConfig(`/apis/request`);
	dispatch({type: "GET_ALL_REQUESTS", payload: payload.data})
};