
import {httpConfig} from "../utils/http-config";

export const getRequestByRequestId = (id) => async (dispatch) => {
	const {data} =  await httpConfig.get(`/apis/request/${id}`);
	dispatch({type: "GET_REQUEST_BY_REQUEST_ID", payload : data })
};

export const getRequestByProfileId = () => async (dispatch) => {
	const {data} =  await httpConfig.get(`/apis/request/`);
	dispatch({type: "GET_REQUEST_BY_PROFILE_ID", payload : data })
};

export const getAllRequests = () => async (dispatch) => {
	const {data} = await httpConfig.get(`/apis/request/`);
	dispatch({type: "GET_ALL_REQUESTS", payload: data})
};