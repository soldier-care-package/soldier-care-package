import {httpConfig} from "../utils/http-config";

export const getItemByItemId = (id) => async (dispatch) => {
	const {data} =  await httpConfig.get(`/apis/item/${id}`);
	dispatch({type: "GET_ITEM_BY_ITEM_ID", payload : data })
};

export const getItemsByItemRequestId = (id) => async (dispatch) => {
	const {data} =  await httpConfig.get(`/apis/item/?itemRequestId=${id}`);
	dispatch({type: "GET_ITEMS_BY_ITEM_REQUEST_ID", payload : data })
};

export const getAllItems = () => async (dispatch) => {
	const {data} = await httpConfig.get(`/apis/item/`);
	dispatch({type: "GET_ALL_ITEMS", payload: data})
};