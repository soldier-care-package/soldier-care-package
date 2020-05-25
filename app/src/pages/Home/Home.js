
import React, {useEffect} from "react"
import {RequestCard} from "./RequestCard";
import {useDispatch, useSelector} from "react-redux";
import {getAllRequests} from "../../shared/actions/request";
import Row from "react-bootstrap/Row";
import Container from "react-bootstrap/Container";


export const Home = () => {

	const request = useSelector(state => (state.request ? state.request : []));
	const dispatch = useDispatch();

	const profile = useSelector(state => (state.profile ? state.profile : []));


	 function effects() {
		dispatch(getAllRequests());
	}
	const inputs = [];

	useEffect(effects, inputs);

	return (
		<>
		<Container>
			<Row className="justify-content-center m-4">
		<h1>All Open Request</h1>
			</Row>
		</Container>
			<Container>
				<Row className="justify-content-center">


			{request.map(request => <RequestCard key={request.requestId} request={request}/>
			)}

				</Row>
			</Container>
		</>

)

};


