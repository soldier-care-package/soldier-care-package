import React, {useEffect} from "react"
import {Request} from "./Request-home";
import {useDispatch, useSelector} from "react-redux";
import {getAllRequests} from "../../shared/actions/request";


export const Home = ({Requests}) => {

	// const {match} =props;
	const requests = useSelector(state => (state.requests ? state.requests : []));
	const dispatch = useDispatch();

	 function effects() {
		dispatch(getAllRequests());
	};
	const inputs = [];

	useEffect(effects, inputs);

	return (
		<>
		<h1>Home</h1>
			{/*<Request/>*/}
			{requests.map(request => <Request key={request.requestId} request={request}/>
			)}
		</>
)
};