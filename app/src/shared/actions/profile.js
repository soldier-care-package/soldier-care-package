import {httpConfig} from "../utils/http-config";

// export const getAllSoldierProfiles = (type) => async (dispatch) => {
// 	const payload =  await httpConfig.get("/apis/profile/");
// 	dispatch({type: "GET_ALL_SOLDIER_PROFILES",payload : payload.data });
// };

export const getProfileByProfileEmail = (email) => async dispatch => {
	const payload = await httpConfig('apis/profile/?userEmail=${email}');
	dispatch({type: "GET_PROFILE_BY_PROFILE_EMAIL", payload: payload.data })
};

export const getProfileByProfileId = (id) => async dispatch => {
	const payload = await httpConfig('apis/profile/${id}');
	dispatch({type: "GET_PROFILE_BY_PROFILE_ID", payload: payload.data})
};

