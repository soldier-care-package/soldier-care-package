import React from "react"
import Card from "react-bootstrap/Card";
import Button from "react-bootstrap/Button";
import ListGroup from "react-bootstrap/ListGroup";
import {Route} from "react-router";
import CardDeck from "react-bootstrap/CardDeck";
import Container from "react-bootstrap/Container";
import Row from "react-bootstrap/Row";

export const RequestCard = ({request, profile}) => {
	return (
		<CardDeck className="m-3">
				<Card bg="primary" text="white"  border="dark" style={{ width: '25rem' }}>
					<Card.Img variant="top" src={request.profileAvatarUrl} alt="Profile picture"/>
					<Card.Body>
						<Card.Text>
							{request.profileBio}
						</Card.Text>
						<Card.Text>
							{request.requestContent}
						</Card.Text>
						{/*<Card.Text>*/}
						{/*<ListGroup>*/}
						{/*	<ListGroup.Item>No style</ListGroup.Item>*/}
						{/*	<ListGroup.Item variant="secondary">Item</ListGroup.Item>*/}
						{/*	<ListGroup.Item>Item</ListGroup.Item>*/}
						{/*	<ListGroup.Item variant="secondary">Item</ListGroup.Item>*/}
						{/*</ListGroup>*/}
						{/*</Card.Text>*/}
							<Button variant="light" size="lg" block>Request Details</Button>
					</Card.Body>
				</Card>
		</CardDeck>


	)
};