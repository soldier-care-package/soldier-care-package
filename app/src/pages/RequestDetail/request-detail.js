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


export const RequestDetail = (props) => {

	const {match} = props;
	const item = useSelector(state => (state.item ? state.item : []));
	const profile =useSelector(state => (state.profile));
	// const [profile, setProfile] =useState(state.profile);
	console.log(profile)
	const filterItem = item.map(item => item.itemUrl);

	const items = filterItem, dispatch = useDispatch();
	const effects = () => {
		dispatch(getItemsByItemRequestId(match.params.requestId));
	};

	const inputs = [match.params.requestId];
	useEffect(effects, inputs);

	return (
		<>
			<Form className="m-5">
				<h1 className="m-4">Request Details</h1>
				<Container >
					<Row>
						<Col xs={6} md={4}>
							<Image src=" " roundedCircle />
						</Col>
					</Row>
					<Card>
						<Button variant="outline-primary" size="lg" disabled>
							Username
						</Button>{' '}
						<Button variant="outline-primary" size="lg" disabled>
							First Name
						</Button>{' '}
						<Button variant="outline-primary" size="lg" disabled>
							Last Name
						</Button>{' '}
						<Button variant="outline-primary" size="lg" disabled>
							Mailing Address
						</Button>{' '}
					</Card>
					<Card>
						<Form.Group controlId="exampleForm.ControlTextarea1">
							<h2 className="m-4">Bio</h2>
							<Form.Control as="Bio" rows="6" />
						</Form.Group>
					</Card>
					<Card>
						<ListGroup className="m-4">
							<h2 className="m-2">Items</h2>
							{items.map(item => <ListGroup.Item><a href={item}>{item}</a></ListGroup.Item>)}
						</ListGroup>
						<Button variant="outline-primary">Accept Whole List</Button>{' '}
					</Card>
				</Container>
			</Form>
		</>
	)
};
