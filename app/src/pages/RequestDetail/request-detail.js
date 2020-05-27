import React, {useEffect, useState} from "react";
import Form from "react-bootstrap/Form";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";
import Col from "react-bootstrap/Col";
import Image from "react-bootstrap/Image";
import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import ListGroup from "react-bootstrap/ListGroup";
import { getRequestByRequestId } from "../../shared/actions/request";
import { getItemsByItemRequestId } from "../../shared/actions/item";
import {useDispatch, useSelector} from "react-redux"
import {getProfileByProfileId} from "../../shared/actions/profile";


export const RequestDetail = (props) => {

	const {match} = props;
	const item = useSelector(state => (state.item ? state.item : []));
	const request = useSelector(state => (state.request ? state.request : []));
	const profile =useSelector(state => (state.profile ? state.profile : []));
	const filterItem = item.map(item => item.itemUrl);
	const items = filterItem, dispatch = useDispatch();
	const effects = () => {
		dispatch(getItemsByItemRequestId(match.params.requestId));
		dispatch(getProfileByProfileId(request.filter(requestElement=>requestElement.requestId===match.params.requestId)[0].requestProfileId))
	};

	const inputs = [match.params.requestId];
	useEffect(effects, inputs);
	return (
		<>
			<Form className="m-5">
				<Container>
					<Row className="justify-content-center m-4">
						<h1>Request Details</h1>
					</Row>
				</Container>

				<Container >
					<Row>
						<Col xs={6} md={4}>
							<Image src=" " roundedCircle />
						</Col>
					</Row>
					<Card>
						<Button className="m-2" variant="outline-primary" size="lg" disabled>
							Username: {profile.profileUsername}
						</Button>
						<Button className="m-2" variant="outline-primary" size="lg" disabled>
							Name: {profile.profileRank} {""} {profile.profileName}

						</Button>
						<Button className="m-2" variant="outline-primary" size="lg" disabled>
							Mailing Address: {profile.profileAddress} {profile.profileCity}, {profile.profileState} {profile.profileZip}
						</Button>
					</Card>
					<Card>
						<Container>
							<h2 className="m-4">Bio</h2>
							<div className="m-4">{profile.profileBio}</div>
						</Container>
					</Card>
					<Card>

						<ListGroup className="m-4">
							<h2 className="m-2">Items</h2>
							{items.map(item => <ListGroup.Item key={item.itemId}><a href={item}>{item}</a></ListGroup.Item>)}
						</ListGroup>
						<Button className="m-4" variant="outline-primary">Accept Whole List</Button>
					</Card>
				</Container>
			</Form>
		</>
	)
};
