import React, {useEffect} from "react"
import {useDispatch, useSelector} from "react-redux";
import {getRequestByRequestId} from "../../shared/actions/request";
import {getItemsByItemRequestId} from "../../shared/actions/item";

export const Request = ({match}) => {
	console.log(match.params.requestId);
	const dispatch = useDispatch();
	const sideEffects= () => {
		dispatch (getRequestByRequestId(match.params.requestId));
		dispatch(getItemsByItemRequestId(match.params.requestId))
	}
	const sideEffectInputs=[match.params.requestId]
	useEffect(sideEffects, sideEffectInputs);
	const request = useSelector(state=>(state.request ? state.request[0] : null))
	const items = useSelector(state=>(state.items ? state.items : []))
	console.log(request);
	console.log(items);
	return (
		<>
			<h1>request</h1>
		</>
	)
}