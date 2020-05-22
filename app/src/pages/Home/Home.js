import React from "react"
import {Request} from "./Request-home";
import {useDispatch, useSelector} from "react-redux";
import {getAllRequests} from "../../shared/actions/request";


export const Home = () => {

	// const {match} =props;
	// const request = useSelector(state => (state.request));
	//
	// const dispatch = useDispatch();
	// const effects = () => {
	// 	dispatch(getAllRequests(match.params.));
	// }

	return (
		<>
		<h1>Home</h1>
			<Request/>
		</>
)
}