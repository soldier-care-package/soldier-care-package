import React, {useEffect} from "react"
import {RequestCard} from "./Request-home";
import {useDispatch, useSelector} from "react-redux";
import {getAllRequests} from "../../shared/actions/request";


export const Home = () => {

	const request = useSelector(state => (state.request ? state.request : []));
	const dispatch = useDispatch();

	const profile = useSelector(state => (state.profile ? state.profile : []));


	 function effects() {
		dispatch(getAllRequests());
	};
	const inputs = [];

	useEffect(effects, inputs);

	return (
		<>
		<h1>Home</h1>
			{/*<Request/>*/}
			{request.map(request => <RequestCard key={request.requestId} request={request}/>
			)}
		</>
)
};